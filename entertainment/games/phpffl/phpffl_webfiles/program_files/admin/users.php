<?php


$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="users" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			admin_user_main();
		break;
		case "add_new_user":
			display_add_user();
		break;
		case "view_user":
			$Username=$_REQUEST['username'];
			display_view_user($Username);
		break;
		case "reject_user_signup":
			$Signup_ID=$_REQUEST['Signup_ID'];
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
			echo "<form method='post' action='$PHP_SELF'>";
			echo "<tr><td colspan='2'><span class='table_row_title'>".REJECT_USER_SIGNUP."<span></td></tr>";
			echo "<tr><td><span class='table_row_title'>".COMMENTS."</span></td>";
			echo "<td><textarea name='Comments' rows='4' cols='40'></textarea></td>";
			echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
			echo "<input type=hidden name='Mode' value='$Mode'>";
			echo "<input type=hidden name='Signup_ID' value='$Signup_ID'>";
			echo "<input type=hidden name='Action' value='confirm_reject_user_signup'>";
			echo "</form>";
			echo "</table>";
			display_signup_user($Signup_ID);
		break;
		case "confirm_reject_user_signup":
			$Signup_ID=$_REQUEST['Signup_ID'];
			$Comments=$_REQUEST['Comments'];
			$sql="select status from users_signup where ID=$Signup_ID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$current_status=$rs->fields("status");
			}
			if($current_status=="New")
			{
				$sql="update users_signup set status='Rejected' where ID=$Signup_ID;";
				$DB->Execute($sql);
				$sql="select email_address from users_signup where ID=$Signup_ID;";
				$rs=$DB->Execute($sql);
				$Email_message=SORRY_ACCOUNT_REJECTED." \n\n";
				$Email_message=$Email_message."Comments:".$Comments;
				$Email_subject=NEW_USER_REGISTRATION_REJECTED;
				if(!($rs->EOF))
				{
					$users_email=$rs->fields("email_address");

					send_email($users_email, $Email_subject, $Email_message);
				}
			}
			admin_user_main();
		break;
		case "approve_user_signup":
			$Signup_ID=$_REQUEST['Signup_ID'];
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action='>".BACK."</a></td></tr>";
			echo "<form method='post' action='$PHP_SELF'>";
			echo "<tr><td colspan='2'><span class='table_row_title'>".APPROVE_USER_SIGNUP."<span></td></tr>";
			echo "<tr><td><span class='table_row_title'>".COMMENTS."</span></td>";
			echo "<td><textarea name='Comments' rows='4' cols='40'></textarea></td>";
			echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
			echo "<input type=hidden name='Mode' value='$Mode'>";
			echo "<input type=hidden name='Signup_ID' value='$Signup_ID'>";
			echo "<input type=hidden name='Action' value='confirm_approve_user_signup'>";
			echo "</form>";
			echo "</table>";
			display_signup_user($Signup_ID);
		break;
		case "confirm_approve_user_signup":
			$Signup_ID=$_REQUEST['Signup_ID'];
			$Comments=$_REQUEST['Comments'];
			$sql="select status from users_signup where ID=$Signup_ID;";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$current_status=$rs->fields("status");
			}
			if($current_status=="New")
			{
				$sql="update users_signup set status='Approved' where ID=$Signup_ID;";
				$DB->Execute($sql);
				$sql="select * from users_signup where ID=$Signup_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$username=$rs->fields("username");
					$first_name=addslashes($rs->fields("first_name"));
					$last_name=addslashes($rs->fields("last_name"));
					$password=$rs->fields("password");
					$insert_password=md5($password);
					$team_name=addslashes($rs->fields("team_name"));
					$gmt_offset=$rs->fields("gmt_offset");
					$email_address=$rs->fields("email_address");
					$telephone_number=$rs->fields("telephone_number");
					$sql="insert into users (username, password, is_superuser, first_name, last_name, email_address, telephone_number, leagues_ID, gmt_offset) values ('$username', '$insert_password', '0', '$first_name', '$last_name', '$email_address', '$telephone_number', '$LEAGUEID', '$gmt_offset');";
					$DB->Execute($sql);
					$sql="select ID from users where username='$username';";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
						$Users_ID=$rs->fields("ID");
					$sql="insert into teams (team_name, leagues_ID) values ('$team_name', '$LEAGUEID');";
					$DB->Execute($sql);
					$sql="select max(ID) as maxID from teams;";
					$rs=$DB->Execute($sql);
					if(!($rs->EOF))
						$Teams_ID=$rs->fields("maxID");

					$teams_ID=$DB->Insert_Id();
					set_team_autorank_players($Teams_ID, $LEAGUEID);
					if(strlen($Users_ID)>0 and strlen($Teams_ID)>0)
					{
						$sql="insert into users_teams (users_ID, teams_ID) values ('$Users_ID', '$Teams_ID');";
						$DB->Execute($sql);
					}
					$Email_message=CONGRATULATIONS_ACCOUNT_APPROVED." \n\n";
					$Email_message=$Email_message.LOGIN.": {$PHPFFL_WEB_ROOT}login.php \n";
					$Email_message=$Email_message.USERNAME.": $username \n";
					$Email_message=$Email_message.PASSWORD.": $password \n\m";
					$Email_message=$Email_message.COMMENTS.":".$Comments;
					$Email_subject=NEW_USER_REGISTRATION_APPROVED;
					send_email($email_address, $Email_subject, $Email_message);
				}
			}
			admin_user_main();
		break;
		case "password_update":
			$Username=$_REQUEST['username'];
			$Display_Update=1;
			if($ISSUPERUSER!=1)
			{
				$sql="select is_superuser from users where username='$Username';";
				$rs=$DB->Execute($sql);
				$is_superuser=$rs->fields("is_superuser");
				if($is_superuser==1)
				{
					$Display_Update=0;
					$errors=NOT_ALLOWED_TO_CHANGE_SUPERUSER_PASSWORD."<br>";
				}
			}
			if($Display_Update==1)
			{
				update_user_password($Username);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				admin_user_main();
			}

		break;

		case "confirm_password_update":
			$Username=$_REQUEST['username'];
			$Password=$_REQUEST['password'];
			$Allow_Update=1;
			if($ISSUPERUSER!=1)
			{
				$sql="select is_superuser from users where username='$Username';";
				$rs=$DB->Execute($sql);
				$is_superuser=$rs->fields("is_superuser");
				if($is_superuser==1)
				{
					$Allow_Update=0;
					$errors=NOT_ALLOWED_TO_CHANGE_SUPERUSER_PASSWORD."<br>";
				}
			}
			if($Allow_Update==1)
			{
				$InsertPassword=md5($Password);
				$sql="update users set password='$InsertPassword' where username='$Username';";
				$DB->Execute($sql);
				$Email_message=PASSWORD_UPDATED_BY_ADMINISTRATOR." \n\n";
				$Email_message=$Email_message.LOGIN.": {$PHPFFL_WEB_ROOT}login.php \n";
				$Email_message=$Email_message.USERNAME.": $Username \n";
				$Email_message=$Email_message.PASSWORD.": $Password \n\n";
				$Email_subject=PASSWORD_CHANGED;
				$sql="select email_address from users where username='$Username';";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$email_address=$rs->fields("email_address");
					if(strlen($email_address)>0)
					{
						send_email($email_address, $Email_subject, $Email_message);
					}
				}
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
			}
			admin_user_main();
		break;

		case "confirm_add_new_user":
			$Username=$_REQUEST['username'];
			$Gmt_Offset=$_REQUEST['Gmt_Offset'];
			$Password=$_REQUEST['Password'];
			$Team_ID=$_REQUEST['Team_ID'];
			$Is_Superuser=$_REQUEST['is_superuser'];
			$First_Name=$_REQUEST['first_name'];
			$Last_Name=$_REQUEST['last_name'];
			$Languages_ID=$_REQUEST['Languages_ID'];
			$Email_Address=$_REQUEST['email_address'];
			$Telephone_Number=$_REQUEST['telephone_number'];
			if(1)
			{
				$Username=addslashes($Username);
				$Team_Name=addslashes($Team_Name);
				$First_Name=addslashes($First_Name);
				$Last_Name=addslashes($Last_Name);
				$Email_Address=addslashes($Email_Address);
				$Telephone_Number=addslashes($Telephone_Number);
			}

			$errors="";
			if(strlen($Username)<1)
			{
				$errors=$errors.PLEASE_ENTER_USERNAME."<br>";
			}
			else
			{
				$sql="select username from users where username='$Username';";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$errors=$errors.USERNAME_EXISTS_PLEASE_CHOOSE_DIFFERENT_USERNAME."<br>";
				}
			}
			if(strlen($errors)<1)
			{
				if(strlen($Password)<1)
				{
					$Password= createRandomPassword();
				}
				$InsertPassword=md5($Password);
				$sql="insert into users (username,password,is_superuser,first_name,last_name,email_address,telephone_number,leagues_ID, gmt_offset, languages_ID) values ('$Username', '$InsertPassword','$Is_Superuser','$First_Name','$Last_Name','$Email_Address','$Telephone_Number','$LEAGUEID', '$Gmt_Offset', '$Languages_ID');";
				$DB->Execute($sql);
				$sql="select ID from users where username='$Username';";
				$rs=$DB->Execute($sql);
				$Users_ID=$rs->fields("ID");
				$sql="insert into users_teams (users_ID, teams_ID) values ('$Users_ID', '$Team_ID');";
				$DB->Execute($sql);
				admin_user_main();
				$Email_subject=NEW_USER_ACCOUNT;
				$Email_message=ADMINISTRATOR_CREATED_ACCOUNT."\n\n";
				$Email_message=$Email_message.LOGIN.": {$PHPFFL_WEB_ROOT}login.php \n";
				$Email_message=$Email_message.USERNAME.": $Username \n";
				$Email_message=$Email_message.PASSWORD.": $Password";
				if(strlen($Email_Address)>0)
				{
					send_email($Email_Address, $Email_subject, $Email_message);
				}
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$Username=stripslashes($Username);
				$Team_Name=stripslashes($Team_Name);
				$First_Name=stripslashes($First_Name);
				$Last_Name=stripslashes($Last_Name);
				$Email_Address=stripslashes($Email_Address);
				$Telephone_Number=stripslashes($Telephone_Number);
				display_add_user($Username,$Team_ID,$Is_Superuser,$First_Name,$Last_Name,$Email_Address,$Telephone_Number, $Gmt_Offset, $Password, $Languages_ID);
			}
		break;
		case "edit_user":
			$Username=$_REQUEST['username'];
			display_edit_user($Username);
		break;
		case "confirm_edit_user":
			$Users_ID=$_REQUEST['Users_ID'];
			$Username=$_REQUEST['username'];
			$Gmt_Offset=$_REQUEST['Gmt_Offset'];
			$New_Username=$_REQUEST['New_Username'];
			$Team_ID=$_REQUEST['Team_ID'];
			$Is_Superuser=$_REQUEST['is_superuser'];
			$First_Name=$_REQUEST['first_name'];
			$Last_Name=$_REQUEST['last_name'];
			$Languages_ID=$_REQUEST['Languages_ID'];
			$Email_Address=$_REQUEST['email_address'];
			$Telephone_Number=$_REQUEST['telephone_number'];
			$League_ID=$_REQUEST['leagues_ID'];
			$Previous_Team_ID=$_REQUEST['Previous_Team_ID'];
			$errors="";
			if(1)
			{
				$Username=addslashes($Username);
				$Team_Name=addslashes($Team_Name);
				$First_Name=addslashes($First_Name);
				$Last_Name=addslashes($Last_Name);
				$Email_Address=addslashes($Email_Address);
				$Telephone_Number=addslashes($Telephone_Number);
			}
			if(strlen($New_Username)<1)
			{
				$errors=$errors.PLEASE_ENTER_USERNAME."<br>";
			}
			else
			{
				$sql="select ID from users where username='$New_Username' and ID<>$Users_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$errors=$errors.USERNAME_EXISTS_PLEASE_CHOOSE_DIFFERENT_USERNAME."<br>";
				}
			}
			if(strlen($errors)<1)
			{
				$sql="update users set username='$New_Username', is_superuser='$Is_Superuser',first_name='$First_Name',last_name='$Last_Name',email_address='$Email_Address',telephone_number='$Telephone_Number', Gmt_Offset='$Gmt_Offset', languages_ID='$Languages_ID' where username='$Username';";
				$DB->Execute($sql);
				$sql="select ID from users where username='$New_Username';";
				$rs=$DB->Execute($sql);
				$Users_ID=$rs->fields("ID");
				if($Previous_Team_ID!=$Team_ID)
				{
					$sql="delete from users_teams where users_ID=$Users_ID and teams_ID=$Previous_Team_ID;";
					$DB->Execute($sql);
					$sql="insert into users_teams (users_ID, teams_ID) values ('$Users_ID', '$Team_ID');";
					$DB->Execute($sql);
				}
				admin_user_main();

			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_user($Username);
			}
		break;
		case "delete_user":
			$Users_ID=$_REQUEST['Users_ID'];
			$Display_Delete=1;
			if($ISSUPERUSER!=1)
			{
				$sql="select is_superuser from users where ID=$Users_ID;";
				$rs=$DB->Execute($sql);
				$is_superuser=$rs->fields("is_superuser");
				if($is_superuser==1)
				{
					$Display_Delete=0;
					$errors=NOT_ALLOWED_TO_DELETE_SUPERUSER."<br>";
				}
			}
			if($Display_Delete==1)
			{
				echo SURE_WANT_DELETE_USER." ".WARNING_DELETE_USER."<br><br>";
				echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_user&Users_ID=$Users_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				admin_user_main();
			}
		break;
		case "confirm_delete_user":
			$Users_ID=$_REQUEST['Users_ID'];
			$Allow_Delete=1;
			if($ISSUPERUSER!=1)
			{
				$sql="select is_superuser from users where ID=$Users_ID;";
				$rs=$DB->Execute($sql);
				$is_superuser=$rs->fields("is_superuser");
				if($is_superuser==1)
				{
					$Allow_Delete=0;
					$errors=NOT_ALLOWED_TO_DELETE_SUPERUSER."<br>";
				}
			}
			if($Allow_Delete==1)
			{
				$Users_ID=$_REQUEST['Users_ID'];
				$sql="delete from users where ID=$Users_ID;";
				$DB->Execute($sql);
				$sql="delete from users_teams where users_ID=$Users_ID;";
				$DB->Execute($sql);
				$sql="delete from admin_users_leagues where users_ID=$Users_ID;";
				$DB->Execute($sql);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
			}
			admin_user_main();
		break;
		case "remove_user":
			$Users_ID=$_REQUEST['Users_ID'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			echo SURE_WANT_REMOVE_USER_TEAM." ".NOTE_REMOVE_USER."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_remove_user&Users_ID=$Users_ID&Teams_ID=$Teams_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_remove_user":
			$Users_ID=$_REQUEST['Users_ID'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			$sql="delete from users_teams where users_ID=$Users_ID and teams_ID=$Teams_ID;";
			$DB->Execute($sql);
			admin_user_main();
		break;
		case "add_existing_user":
			display_add_existing_user($LEAGUEID);
		break;
		case "confirm_add_existing_user":
			$Users_ID=$_REQUEST['Users_ID'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			$sql="insert into users_teams (users_ID, teams_ID) values ('$Users_ID', '$Teams_ID');";
			$DB->Execute($sql);
			admin_user_main();
		break;
		case "view_login_log":
			$Users_ID=$_REQUEST['Users_ID'];
			$Username=$_REQUEST['Username'];
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=view_user&username=$Username'>".BACK."</a></td></tr>";
			echo "</table>";
			display_users_login_log($Users_ID, $Username);
		break;
	}
}



?>
<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="signup")
{
	Switch($Action)
	{
		default:
		case "signup_main":
			display_signup();
		break;
		case "confirm_signup":
			$Username=$_REQUEST['Username'];
			$Password=$_REQUEST['Password'];
			$Gmt_Offset=$_REQUEST['Gmt_Offset'];
			$Team_Name=$_REQUEST['Team_Name'];
			$League=$_REQUEST['League'];
			$First_Name=$_REQUEST['First_Name'];
			$Last_Name=$_REQUEST['Last_Name'];
			$Email=$_REQUEST['Email'];
			$Telephone=$_REQUEST['Telephone'];
			$Comments=$_REQUEST['Comments'];
			$errors="";
			if(1)
			{
				$Username=addslashes($Username);
				$Password=addslashes($Password);
				$Team_Name=addslashes($Team_Name);
				$First_Name=addslashes($First_Name);
				$Last_Name=addslashes($Last_Name);
				$Email=addslashes($Email);
				$Telephone=addslashes($Telephone);
				$Comments=addslashes($Comments);
			}
			if(strlen($Username)<1)
			{
				$errors=$errors.PLEASE_ENTER_USERNAME."<br>";
			}

			//Only check captcha image if gd is installed.
			if(extension_loaded('gd') && function_exists('imagettfbbox'))
			{
				if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) )
				{
				  // Insert you code for processing the form here, e.g emailing the submission, entering it into a database.
				  unset($_SESSION['security_code']);
			   } else {
				  // Insert your code for showing an error message here
				  $errors=$errors.ENTER_SECURITY_CODE."<br>";
			   }
			}

			$sql="select ID from users where username='$Username';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$errors=$errors.USERNAME_EXISTS_PLEASE_CHOOSE_DIFFERENT_USERNAME."<br>";
			}
			$sql="select ID from users_signup where status='Pending' and username='$Username';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$errors=$errors.USERNAME_EXISTS_PLEASE_CHOOSE_DIFFERENT_USERNAME."<br>";
			}
			if(strlen($Password)<4)
			{
				$errors=$errors.ENTER_PASSWORD_FOUR_DIGITS."<br>";
			}
			if(strlen($Team_Name)<1)
			{
				$errors=$errors.PLEASE_ENTER_TEAM_NAME."<br>";
			}
			if(strlen($First_Name)<1 || strlen($Last_Name)<1)
			{
				$errors=$errors.PLEASE_ENTER_FIRST_LAST_NAME."<br>";
			}
			if(strlen($Email)<1)
			{
				$errors=$errors.PLEASE_ENTER_EMAIL_ADDRESS."<br>";
			}
			if(strlen($errors)<1)
			{
				$current_date=gmdate("Y-m-d H:i:s");
				$sql="insert into users_signup (username, password, team_name, leagues_ID, gmt_offset, first_name, last_name, email_address, telephone_number, signup_date, user_comments) values ('$Username', '$Password', '$Team_Name', '$League', '$Gmt_Offset', '$First_Name', '$Last_Name', '$Email', '$Telephone', '$current_date', '$Comments');";
				$DB->Execute($sql);
				echo THANK_YOU_SIGNING_UP;
				$user_message=THANK_YOU_SIGNING_UP;
				$admin_message=NEW_USER_REGISTERED." \n ";
				$admin_message=str_replace("ACTUAL_FIRST_NAME_HERE", $First_Name, $admin_message);
				$admin_message=str_replace("ACTUAL_LAST_NAME_HERE", $Last_Name, $admin_message);
				send_email($Email, NEW_USER_REGISTRATION, $user_message);
				if($League==0)
				{
					$sql="select distinct(users_ID) from admin_users_leagues;";
				}
				else
				{
					$sql="select distinct(users_ID) from admin_users_leagues where leagues_ID=$League;";
				}
				$rs=$DB->Execute($sql);
				while(!($rs->EOF))
				{
					$admin_users_ID=$rs->fields("users_ID");
					$admin_users_email=get_users_email($admin_users_ID);
					if(strlen($admin_users_email)>0)
					{
						send_email($admin_users_email, NEW_USER_REGISTRATION, $admin_message);
					}
					$rs->MoveNext();
				}
			}
			else
			{

				echo "<span class='errors'>$errors</span>";
				$Username=stripslashes($Username);
				$Password=stripslashes($Password);
				$Team_Name=stripslashes($Team_Name);
				$First_Name=stripslashes($First_Name);
				$Last_Name=stripslashes($Last_Name);
				$Email=stripslashes($Email);
				$Telephone=stripslashes($Telephone);
				$Comments=stripslashes($Comments);
				display_signup($Username, $Password, $Team_Name, $League, $Gmt_Offset, $First_Name, $Last_Name, $Email, $Telephone, $Comments);
			}
		break;
		case "display_league_settings":
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			display_league_settings($Leagues_ID);
		break;
	}
}


?>
<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="myprofile")
{
	Switch($Action)
	{
		default:
		case "myprofile_main":
			$sql="select username from users where ID=$USERSID;";
			$rs=$DB->Execute($sql);
			$Username=$rs->fields("username");
			display_edit_profile($Username);
		break;
		case "confirm_edit_profile":
			$Users_ID=$_REQUEST['Users_ID'];
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Team_Name=$_REQUEST['Team_Name'];
			$Username=$_REQUEST['username'];
			$Gmt_Offset=$_REQUEST['Gmt_Offset'];
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
			if(strlen($errors)<1)
			{
				$sql="update users set first_name='$First_Name',last_name='$Last_Name',email_address='$Email_Address',telephone_number='$Telephone_Number', Gmt_Offset='$Gmt_Offset', languages_ID='$Languages_ID' where username='$Username';";
				$DB->Execute($sql);
				if(strlen($Teams_ID)>0)
				{
					$sql="update teams set team_name='$Team_Name' where ID=$Teams_ID;";
					$DB->Execute($sql);
				}
				display_edit_profile($Username);
			}
				
		break;
		case "change_password":
			display_change_password();
		break;
		case "confirm_change_password":
			
			$New_Password=$_REQUEST['New_Password'];
			$Confirm_New_Password=$_REQUEST['Confirm_New_Password'];
			$errors="";
			if(strlen($New_Password)<1)
			{
				$errors=$errors.PLEASE_ENTER_A_PASSWORD."<br>";
			}
			if($New_Password!=$Confirm_New_Password)
			{
				$errors=$errors.PASSWORDS_DIDNT_MATCH_TRY_AGAIN."<br>";
			}
			if(strlen($errors)<1)
			{
				$InsertPassword=md5($New_Password);
				$sql="update users set password='$InsertPassword' where ID=$USERSID;";
				$DB->Execute($sql);
				echo "<span class='table_row_title'>".PASSWORD_CHANGED."</span>";
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_change_password($USERSID);
			}
		break;
		case "update_teamlogo":
			display_update_teamlogo($Teams_ID);
		break;
		case "confirm_update_teamlogo":
			$errors="";
			$league_logo_array=get_league_logo_array();
			$sql="select team_logo_filename from teams where ID=$Teams_ID;";
			$teams_rs=$DB->Execute($sql);
			if(!($teams_rs->EOF))
			{
				$old_team_logo_filename=$teams_rs->fields("team_logo_filename");
			}
			$uploaddir = $PHPFFL_FILE_ROOT."images/team_logos/";
			$base_filename=basename($_FILES['logo_filename']['name']);
			$logo_filename=$Teams_ID."_".$base_filename;
			$uploadfile = $uploaddir . $logo_filename;
			if(strlen($base_filename)<1)
			{
				$errors=$errors.PLEASE_SELECT_LOGO."<br>";
			}
			elseif (move_uploaded_file($_FILES['logo_filename']['tmp_name'], $uploadfile)) {
				
				@$new_logo_information=getimagesize("{$PHPFFL_FILE_ROOT}images/team_logos/{$logo_filename}");
				$new_logo_width=$new_logo_information[0];
				$new_logo_height=$new_logo_information[1];
				if(!$new_logo_information)
				{
					$errors=$errors.INVALID_IMAGE_EXTENSION."<br>";
				}
				if($new_logo_height>$league_logo_array['max_logo_height'] || $new_logo_width>$league_logo_array['max_logo_width'])
				{
					$errors=$errors.IMAGE_DIMENSIONS.": $new_logo_height ".HEIGHT." X $new_logo_width ".WIDTH." (".PIXELS.")<br>";
				}
				if($new_logo_height>$league_logo_array['max_logo_height'])
				{
					$errors=$errors.RESIZE_LOGO_TOO_HEIGHT."<br>";
				}
				if($new_logo_width>$league_logo_array['max_logo_width'])
				{
					$errors=$errors.RESIZE_LOGO_TOO_WIDTH."<br>";
				}
				if(strlen($errors)<1)
				{
					$sql="update teams set team_logo_filename='$logo_filename' where ID=$Teams_ID;";
					$DB->Execute($sql);
					if(strlen($old_team_logo_filename)>0 && $old_team_logo_filename!=$logo_filename)
					{
						@unlink($uploaddir.$old_team_logo_filename);
					}
				}
				else
				{
					@unlink($uploadfile);
				}
				
			} else {
				
			   $errors=$errors.ERROR_UPLOADING_FILE."<br>";
			   if(!is_writable($uploaddir))
			   {
			   		$errors=$errors.DIRECTORY_NOT_WRITABLE_CONTACT_ADMIN."<br>";
			   		
			   }
			}
			if(strlen($errors)>0)
			{
				echo "<span class='errors'>$errors</span>";
			}
			display_update_teamlogo($Teams_ID);
		break;
		case "delete_logo":
			echo SURE_DELETE_LOGO."<br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_logo'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=update_teamlogo'>".NO."</a>";
		break;
		case "confirm_delete_logo":
			$team_logo_filename=get_team_logo($Teams_ID);
			if(strlen($team_logo_filename)>0)
			{
				@unlink("{$PHPFFL_FILE_ROOT}images/team_logos/{$team_logo_filename}");
				$sql="update teams set team_logo_filename='' where ID=$Teams_ID;";
				$DB->Execute($sql);
			}
			display_update_teamlogo($Teams_ID);
		break;
	}
}


?>
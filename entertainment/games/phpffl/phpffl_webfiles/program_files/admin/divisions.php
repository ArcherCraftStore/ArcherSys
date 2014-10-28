<?php

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php

if($Mode=="divisions" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			admin_divisions_main();
		break;
		case "add_new_division":
			display_add_division();
		break;
		case "confirm_add_new_division":
			$Division_Name=$_REQUEST['Division_Name'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$errors="";

			if(1)
			{
				$Division_Name=addslashes($Division_Name);
				$Leagues_ID=addslashes($Leagues_ID);
			}
			if(strlen($Division_Name)<1)
			{
				$errors=PLEASE_ENTER_NAME_FOR_DIVISION."<br>";
			}
			else
			{
				$sql="select ID from divisions where division_name='$Division_Name' and leagues_ID=$Leagues_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
					$errors=DIVISION_ALREADY_EXISTS_ENTER_NEW_NAME."<br>";
			}

			if(strlen($errors)<1)
			{
				$sql="select max(display_order) as max_order from divisions where leagues_ID=$Leagues_ID";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
					$display_order=$rs->fields("max_order")+1;
				else
					$display_order=0;
				$sql="insert into divisions (division_name, display_order, leagues_ID) values ('$Division_Name', '$display_order', '$Leagues_ID');";
				$DB->Execute($sql);
				admin_divisions_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$Division_Name=stripslashes($Division_Name);
				$Leagues_ID=stripslashes($Leagues_ID);
				display_add_division($Division_Name, $Leagues_ID);
			}
		break;
		case "update_divisions_main":
			$Display_Order=$_REQUEST['Display_Order'];
			$Divisions_ID=$_REQUEST['Divisions_ID'];
			if(is_array($Display_Order))
			{
				foreach($Display_Order as $key => $val)
				{
					if(strlen($val)>0)
					{
						$sql="update divisions set display_order=$val where ID=$key;";
						$DB->Execute($sql);
					}
				}
			}
			if(is_array($Divisions_ID))
			{
				foreach($Divisions_ID as $key => $val)
				{
					$sql="update teams set divisions_ID=$val where ID=$key;";
					$DB->Execute($sql);
				}
			}
			admin_divisions_main();
		break;
		case "edit_division":
			$Division_ID=$_REQUEST['Division_ID'];
			display_edit_division($Division_ID);
		break;
		case "confirm_edit_division":
			$Division_Name=$_REQUEST['Division_Name'];
			$Division_ID=$_REQUEST['Division_ID'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$errors="";
			if(1)
			{
				$Division_Name=addslashes($Division_Name);
				$Leagues_ID=addslashes($Leagues_ID);
			}
			if(strlen($Division_Name)<1)
			{
				$errors=PLEASE_ENTER_NAME_FOR_DIVISION."<br>";
			}
			else
			{
				$sql="select ID from divisions where division_name='$Division_Name' and ID<>$Division_ID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
					$errors=DIVISION_ALREADY_EXISTS_ENTER_NEW_NAME."<br>";
			}

			if(strlen($errors)<1)
			{
				$sql="update divisions set division_name='$Division_Name', leagues_ID=$Leagues_ID where ID=$Division_ID;";
				$DB->Execute($sql);
				admin_divisions_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_division($Division_ID);
			}
		break;
		case "delete_division":
			$Division_ID=$_REQUEST['Division_ID'];
			echo SURE_YOU_WANT_TO_DELETE_DIVISION."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_division&Division_ID=$Division_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_division":
			$Division_ID=$_REQUEST['Division_ID'];
			$sql="delete from divisions where ID=$Division_ID;";
			$DB->Execute($sql);
			$sql="update teams set divisions_ID=0 where divisions_ID=$Division_ID;";
			$DB->Execute($sql);
			admin_divisions_main();
		break;


		case "update_divisionlogo":
			$Division_ID=$_REQUEST['Division_ID'];
			display_update_divisionlogo($Division_ID);
		break;
		case "confirm_update_divisionlogo":
			$Division_ID=$_REQUEST['Division_ID'];
			$errors="";
			$league_logo_array=get_league_logo_array();
			$sql="select division_logo_filename from divisions where ID=$Division_ID;";
			$teams_rs=$DB->Execute($sql);
			if(!($teams_rs->EOF))
			{
				$old_division_logo_filename=$teams_rs->fields("division_logo_filename");
			}
			$uploaddir = $PHPFFL_FILE_ROOT."images/team_logos/";
			$base_filename=basename($_FILES['logo_filename']['name']);
			$logo_filename=$Division_ID."_".$base_filename;
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
					$sql="update divisions set division_logo_filename='$logo_filename' where ID=$Division_ID;";
					$DB->Execute($sql);
					if(strlen($old_division_logo_filename)>0 && $old_division_logo_filename!=$logo_filename)
					{
						@unlink($uploaddir.$old_division_logo_filename);
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
			display_update_divisionlogo($Division_ID);
		break;
		case "delete_logo":
			$Division_ID=$_REQUEST['Division_ID'];
			echo SURE_DELETE_LOGO."<br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_logo&Division_ID=$Division_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_logo":
			$Division_ID=$_REQUEST['Division_ID'];
			$division_logo_filename=get_division_logo($Division_ID);
			if(strlen($division_logo_filename)>0)
			{
				@unlink("{$PHPFFL_FILE_ROOT}images/team_logos/{$division_logo_filename}");
				$sql="update divisions set division_logo_filename='' where ID=$Division_ID;";
				$DB->Execute($sql);
			}
			display_update_divisionlogo($Division_ID);
		break;
	}
}


?>
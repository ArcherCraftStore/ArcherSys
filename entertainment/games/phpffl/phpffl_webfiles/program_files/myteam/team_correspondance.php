<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from admin.php
if($Mode=="team_correspondance")
{

	Switch($Action)
	{
		case "team_correspondance_main":
		default:
			display_email_team($Teams_ID);
		break;
		case "confirm_email_team":
			$Email_Teams_ID=$_REQUEST['Email_Teams_ID'];
			$Email_Message=$_REQUEST['Email_Message'];
			$Email_Subject=$_REQUEST['Email_Subject'];
			$CC_Myself=$_REQUEST['CC_Myself'];
			$errors="";
			if(strlen($Email_Message)<1)
			{
				$errors=$errors.PLEASE_ENTER_A_MESSAGE."<br>";
			}
			if(strlen($Email_Subject)<1)
			{
				$errors=$errors.PLEASE_ENTER_A_SUBJECT."<br>";
			}
			if(get_magic_quotes_gpc())
			{
				$Email_Subject=stripslashes($Email_Subject);
				$Email_Message=stripslashes($Email_Message);
			}
			if(strlen($errors)<1)
			{
				
				if($PHPFFL_SEND_EMAILS)
				{
					$from_email=get_users_email($USERSID);
					$team_sending_message=get_team_name($Teams_ID);
					$subject=TEAM_CORRESPONDANCE.": $Email_Subject";
					$message=YOU_HAVE_RECEIVED_AN_EMAIL_MESSAGE_FROM." $team_sending_message \n\n";
					$message=$message.$Email_Message;
					if($Email_Teams_ID=="All")
					{
						if(check_is_admin($USERSID, $LEAGUEID) )
						{
							$sql="select users_ID from users_teams, teams where teams.ID=teams_ID and leagues_ID=$LEAGUEID;";
							$rs=$DB->Execute($sql);
							while(!($rs->EOF))
							{
								$users_ID=$rs->fields("users_ID");
								$users_email=get_users_email($users_ID);
								if(strlen($users_email)>0)
								{
									if($CC_Myself==1)
									{
										$headers = "Cc: $from_email" . "\r\n";
									}
									else
									{
										$headers="";
									}
									send_email($users_email, $subject, $message, $from_email, $headers);
								}
								$rs->MoveNext();
							}
						}
					}
					else
					{
						$Users_Team=get_users_on_team($Email_Teams_ID);
						foreach($Users_Team as $key => $val)
						{
							$users_email=get_users_email($val);
							if(strlen($users_email)>0)
							{
								if($CC_Myself==1)
								{
									$headers = "Cc: $from_email" . "\r\n";
								}
								else
								{
									$headers="";
								}
								send_email($users_email, $subject, $message, $from_email, $headers);
									
							}			
						}
					}
					echo "<span class='table_row_title'>".EMAIL_SENT."</span><br>";
				}
				else
				{
					echo "<span class='table_row_title'>".EMAIL_DISABLED_IN_THIS_INSTALLATION."</span><br>";
				}
				display_email_team($Teams_ID);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_email_team($Teams_ID, $Email_Teams_ID, $Email_Subject, $Email_Message);
			}
		break;
	}
}


?>



<?php

function display_messages()
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $Teams_ID;


	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><a href='$PHP_SELF?Mode=private_message&Action=create_message_main'>".CREATE_MESSAGE."</a></td>";
	echo "<td><a href='$PHP_SELF?Mode=private_message&Action=view_sent_messages'>".VIEW_SENT_MESSAGES."</a></td>";
	echo "</tr>";
	echo "</table>";
	$usersArray=get_users_on_team($Teams_ID);
	$users_sql="";
	foreach($usersArray as $key => $val)
	{
		if(strlen($users_sql)>0)
		{
			$users_sql=$users_sql." or ";
		}
		$users_sql=$users_sql." user_to_ID=$val ";
	}
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$num_messages=get_num_messages($USERSID);
	$sql="select ID, message_subject, user_from_ID, message_read, sent_date, user_to_ID from private_message where ($users_sql) and user_to_deleted=0 order by sent_date DESC;";
	$rs=$DB->Execute($sql);
	if($rs->EOF)
	{
		echo "<tr><td colspan='4'><span class='table_data_bold_large'>".NO_MESSAGES."</span></td></tr>";
	}
	else
	{
		echo "<form method='post' action='$PHP_SELF'>";
		//echo "<tr><td>&nbsp;</td></tr>";

		echo "<tr><td><span class='table_row_title'>".FROM."</span></td><td><span class='table_row_title'>".TO."</span></td><td><span class='table_row_title'>".SUBJECT."</span></td><td><span class='table_row_title'>".SENT_DATE."</span></td><td><span class='table_row_title'>"."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$message_ID=$rs->fields("ID");
			$message_subject=$rs->fields("message_subject");
			$message_read=$rs->fields("message_read");
		    $user_from_ID=$rs->fields("user_from_ID");
		    $user_to_ID=$rs->fields("user_to_ID");

		    //From User
		    $username_from=get_users_username($user_from_ID);
			$username_from_array=get_users_data_array($user_from_ID);
			$users_first_name=$username_from_array['first_name'];
			$users_last_name=$username_from_array['last_name'];


			if(strlen($users_first_name)>0 || strlen($users_last_name)>0)
			{
				$username_from="{$users_first_name} {$users_last_name}";
			}

			//To User
			$username_to=get_users_username($user_to_ID);
			$username_to_array=get_users_data_array($user_to_ID);
			$users_first_name=$username_to_array['first_name'];
			$users_last_name=$username_to_array['last_name'];

			if(strlen($users_first_name)>0 || strlen($users_last_name)>0)
			{
				$username_to="{$users_first_name} {$users_last_name}";
			}

			 $teamname="";
			$sql="select teams_ID from users_teams, teams where users_ID=$user_from_ID and teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
			$teams_rs=$DB->Execute($sql);
			if(!($teams_rs->EOF))
			{
				$current_teams_ID=$teams_rs->fields("teams_ID");
				$teamname=get_team_name($current_teams_ID);
			}
			if(!($message_read))
			{
				$message_style="table_data_bold_large";
			}
			else
			{
				$message_style="table_data_large";
			}

		    $msgdate=$rs->fields("sent_date");
		    $msgdate_display=display_users_time($msgdate, 0, "F, d Y H:i");
			$pm_a_tag="<a href=\"$PHP_SELF?Mode=private_message&Action=read_message_main&Message_ID=$message_ID\">";
			echo "<tr bgcolor=\"$bg\">";
			echo "<td>{$pm_a_tag}<span class='$message_style'>{$teamname}: $username_from</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>{$username_to}</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>{$message_subject}</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>{$msgdate_display}</span></a></td>";
			echo "<td align=\"center\"><input type=\"checkbox\" name=\"delete[]\" value=\"$message_ID\"></td>";
			echo "</tr>";
			$rs->MoveNext();
		}
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" value=\"".DELETE."\"></td>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "<input type='hidden' name='Action' value='delete_message_main'>";
		echo "</form>";
	}
	echo "</table>";

}

function display_view_sent_messages()
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $Teams_ID;

	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr>";
	echo "<td><a href='$PHP_SELF?Mode=private_message&Action=private_message_main'>".BACK_TO_INBOX."</a></td>";
	echo "</tr>";
	echo "</table>";



	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	$usersArray=get_users_on_team($Teams_ID);
	$users_sql="";
	foreach($usersArray as $key => $val)
	{
		if(strlen($users_sql)>0)
		{
			$users_sql=$users_sql." or ";
		}
		$users_sql=$users_sql." user_from_ID=$val ";
	}
	$sql="select ID, message_subject, user_to_ID, message_read, sent_date, message_read_date, user_from_ID from private_message where ($users_sql) and user_from_deleted=0 order by sent_date DESC;";
	$rs=$DB->Execute($sql);

	if($rs->EOF)
	{
		echo "<tr><td colspan='4'><span class='table_data_bold_large'>".NO_MESSAGES."</span></td></tr>";
	}
	else
	{
		echo "<form method='post' action='$PHP_SELF'>";
		//echo "<tr><td>&nbsp;</td></tr>";

		echo "<tr><td><span class='table_row_title'>".FROM."</span></td><td><span class='table_row_title'>".TO."</span></td><td><span class='table_row_title'>".SUBJECT."</span></td><td><span class='table_row_title'>".SENT_DATE."</span></td><td><span class='table_row_title'>".STATUS."</span></td><td><span class='table_row_title'>"."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";

		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$message_ID=$rs->fields("ID");
			$message_subject=$rs->fields("message_subject");
			$message_read=$rs->fields("message_read");
		    $user_to_ID=$rs->fields("user_to_ID");
		    $user_from_ID=$rs->fields("user_from_ID");
		    $username_to=get_users_username($user_to_ID);
			$username_to_array=get_users_data_array($user_to_ID);
			$users_first_name=$username_from_array['first_name'];
			$users_last_name=$username_from_array['last_name'];


			if($message_read)
			{
				$message_read_date=$rs->Fields("message_read_date");
				$message_read_display=display_users_time($message_read_date, 0, "F, d Y H:i");
				$message_status=MESSAGE_READ;
				$message_style="table_data_large";
			}
			else
			{
				$message_status=MESSAGE_NOT_READ;
				$message_style="table_data_bold_large";
			}

			if(strlen($users_first_name)>0 || strlen($users_last_name)>0)
			{
				$username_to="{$users_first_name} {$users_last_name}";
			}

			//From User
		    $username_from=get_users_username($user_from_ID);
			$username_from_array=get_users_data_array($user_from_ID);
			$users_first_name=$username_from_array['first_name'];
			$users_last_name=$username_from_array['last_name'];


			if(strlen($users_first_name)>0 || strlen($users_last_name)>0)
			{
				$username_from="{$users_first_name} {$users_last_name}";
			}

			 $teamname="";
			$sql="select teams_ID from users_teams, teams where users_ID=$user_to_ID and teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
			$teams_rs=$DB->Execute($sql);
			if(!($teams_rs->EOF))
			{
				$current_teams_ID=$teams_rs->fields("teams_ID");
				$teamname=get_team_name($current_teams_ID);
			}

		    $msgdate=$rs->fields("sent_date");
		    $msgdate_display=display_users_time($msgdate, 0, "F, d Y H:i");
			$pm_a_tag="<a href=\"$PHP_SELF?Mode=private_message&Action=read_sent_message_main&Message_ID=$message_ID\">";
			echo "<tr bgcolor=\"$bg\">";
			echo "<td>{$pm_a_tag}<span class='$message_style'>$username_from</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>{$teamname}: $username_to</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>$message_subject</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>$msgdate_display</span></a></td>";
			echo "<td>{$pm_a_tag}<span class='$message_style'>$message_status</span></a></td>";
			echo "<td align=\"center\"><input type=\"checkbox\" name=\"delete[]\" value=\"$message_ID\"></td>";
			echo "</tr>";
			$rs->MoveNext();
		}
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" value=\"".DELETE."\"></td>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "<input type='hidden' name='Action' value='delete_outbox_message_main'>";
		echo "</form>";
	}
	echo "</table>";

}


function create_message($user_to="", $message_subject="", $message_body="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;


	echo "<form method='post' action='$PHP_SELF'>";
    echo "<table border=0 rows=4 cols=2 cellpading=4 cellspacing=3 width=55%>";
	echo "<tr>";
	echo "<td align=\"right\"><span class='table_row_title'>".MESSAGE_TO.":</span></td>";
	echo "<td align=\"left\"><select name=\"user_to\">";

	$sql="select ID from teams where leagues_ID=$LEAGUEID order by team_name ASC;;";
	$teams_rs=$DB->Execute($sql);
	while(!($teams_rs->EOF))
	{
		$current_teams_ID=$teams_rs->fields("ID");
		$teamname=get_team_name($current_teams_ID);
		$users_on_team=get_users_on_team($current_teams_ID);
		if(count($users_on_team)>0)
		{
			foreach($users_on_team as $key => $val)
			{
				if($val!=$USERSID)
				{
					$username_from_array=get_users_data_array($val);
					$users_first_name=$username_from_array['first_name'];
					$users_last_name=$username_from_array['last_name'];
					$username=$username_from_array['username'];
					if(strlen($users_first_name)>0 || strlen($users_last_name)>0)
					{
						$user_name="{$users_first_name} {$users_last_name}";
					}
					else
					{
						$user_name="$username";
					}

					$s="";
					if($val==$user_to)
					{
						$s="selected";
					}
					if(strlen($teamname)>1)
					{
						echo "<option value=\"$val\" $s>{$teamname}: $user_name</option>";
					}
				}
			}
		}
		$teams_rs->MoveNext();
	}



	echo "</select></td>";
	echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\"><span class='table_row_title'>".SUBJECT.":</span></td>";
    echo "<td align=\"left\"><input type=\"text\" name=\"message_subject\" value=\"".htmlentities($message_subject)."\" size='53'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td valign=\"top\" align=\"right\"><span class='table_row_title'>".MESSAGE_BODY.":</span></td>";
	echo "<td align=\"left\"><textarea name=\"message_body\" cols=40 rows=8 wrap=HARD>$message_body</textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>&nbsp;</td>";
	echo "<td align=\"right\"><input type=\"submit\" value=\"Submit\"></td>";
	echo "</tr>";
	echo "</table>";

    echo "<input type=\"hidden\" name=\"user_from\" value=\"$USERSID\">";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "<input type='hidden' name='Action' value='process_message_main'>";
	echo "</form>";
}

function process_message($message_subject,$message_body,$user_to,$user_from)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;

	$message_body=ereg_replace("\n","<br \/>",$message_body);

	if(1)
    {
        $message_body=addslashes($message_body);
        $message_subject=addslashes($message_subject);

    }
	$date=gmdate("Y-m-d H:i:s");
	$sql="insert into private_message (message_subject,message_body,user_to_ID,user_from_ID,message_read,sent_date) values ('$message_subject','$message_body','$user_to','$user_from','0','$date');";
    $rs=$DB->Execute($sql);

	//Send Notification Email
	$username_from_array=get_users_data_array($user_from);
	$users_first_name=$username_from_array['first_name'];
	$users_last_name=$username_from_array['last_name'];
	$username=$username_from_array['username'];
	if(strlen($users_first_name)>0 || strlen($users_last_name)>0)
	{
		$user__from_name="{$users_first_name} {$users_last_name}";
	}
	else
	{
		$user__from_name="$username";
	}

	$email_subject="phpFFL: ".NEW_PRIVATE_MESSAGE;
	$email_message=NEW_PRIVATE_MESSAGE_EMAIL_TEXT;
	$email_message=str_replace("ACTUAL_USERS_NAME_HERE",$user__from_name , $email_message);
	$users_to_email=get_users_email($user_to);
	if(strlen($users_to_email)>0)
	{
		send_email($users_to_email, $email_subject, $email_message);
	}

}


function read_message($message_id, $Viewing_Sent_Message=0)
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID;



    $sql="select message_subject, message_body, user_from_ID, user_to_ID from private_message where ID=$message_id";
    $rs=$DB->Execute($sql);
    $message_subject=$rs->fields("message_subject");
    $message_body=$rs->fields("message_body");
    $user_from=$rs->fields("user_from_ID");
	$user_to_ID=$rs->fields("user_to_ID");
    $username_from=get_users_username($user_from);
    $reply_subject=urlencode("Re: ".$message_subject);;
	if($Viewing_Sent_Message)
	{
		$reply_to_users_ID=$user_to_ID;
		$Delete_Action="delete_outbox_message_main";
	}
	else
	{
		$reply_to_users_ID=$user_from;
		$Delete_Action="delete_message_main";
	}
	if($user_to_ID==$USERSID)
	{
		$current_date=date("Y-m-d H:i:s");
		$sql="update private_message set message_read=1, message_read_date='$current_date' where ID=$message_id;";
		$rs=$DB->Execute($sql);
		$Logged_In_Display=get_users_display($USERSID);

		$num_new_messages = get_num_new_messages($USERSID);
		$num_new_messages_display= "&#8226;&nbsp; <a href='{$PHP_SELF}?Mode=private_message&Action=private_message_main' class='eleven'>".PRIVATE_MESSAGES;
		if($num_new_messages>0)
		{
			$num_new_messages_display= $num_new_messages_display." ($num_new_messages)";
		}
		$num_new_messages_display=$num_new_messages_display."</a>";
		?><script type="text/javascript">
			$("#Logged_In_Display").html("<?php echo $Logged_In_Display;?>");
			$("#PM_Leftnav").html("<?php echo $num_new_messages_display;?>");
		</script><?php

	}
	echo "<br>";
	echo "<table>";
	echo "<tr>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=reply_to_message&User_To=$reply_to_users_ID&Subject={$reply_subject}&Message_ID=$message_id'>".REPLY."</td>";
	echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	echo "<td><a href='$PHP_SELF?Mode=$Mode&Action={$Delete_Action}&delete[1]=$message_id'>".DELETE."</td>";
	echo "</tr>";
	echo "</table><br>";
    $sql="select teams_ID from users_teams, teams where users_ID=$user_from and teams_ID=teams.ID and leagues_ID=$LEAGUEID;";
    $rs=$DB->Execute($sql);
    if(!($rs->EOF))
    {
	    $Teams_ID=$rs->fields("teams_ID");
	    $teamname=get_team_name($Teams_ID);
    }

    echo "<table class='forumline' border='0' rows='2' cols='3' cellpadding='4' cellspacing='3' width='40%'>";
    echo "<tr><td bgcolor=\"#121055\"><b><font color=\"white\">".SUBJECT.":</font></b></td><td bgcolor=\"#E7EBF7\"><b>$message_subject</b></td></tr>";
    echo "<tr><td bgcolor=\"#121055\"><b><font color=\"white\">".FROM.":</font></b></td><td bgcolor=\"#E7EBF7\"><b>($teamname): $username_from</b></td></tr>";
    echo "<tr><td colspan=\"2\" bgcolor=\"#E7EBF7\">$message_body</td></tr>";
    echo "</table>";
    echo "<br />";
}

function delete_message($delete_array)
{
	global $PHP_SELF, $DB, $Mode, $USERSID;

	if(count($delete_array) > 0)
	{
	    foreach($delete_array as $message_ID)
	    {
		    $sql="update private_message set user_to_deleted=1 where ID=$message_ID;";
		    $rs=$DB->Execute($sql);
	    }
	}
}

function delete_outbox_message($delete_array)
{
	global $PHP_SELF, $DB, $Mode, $USERSID;

	if(count($delete_array) > 0)
	{
	    foreach($delete_array as $message_ID)
	    {
		    $sql="update private_message set user_from_deleted=1 where ID=$message_ID;";
		    $rs=$DB->Execute($sql);
	    }
	}
}
?>
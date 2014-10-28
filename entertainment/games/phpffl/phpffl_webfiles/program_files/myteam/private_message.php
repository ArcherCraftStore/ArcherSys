<?php 

$Action=$_REQUEST['Action'];
$Message_ID=$_REQUEST['Message_ID'];

if($Mode=="private_message")
{
	Switch($Action)
	{
		case "private_message_main":
		default:
			display_messages();
		break;
		case "create_message_main":
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr>";
			echo "<td><a href='$PHP_SELF?Mode=private_message&Action=private_message_main'>".BACK."</a></td>";
			echo "</tr>";
			echo "</table>";
			create_message();
		break;
		case "read_message_main":
			echo "<table><tr><td><a href='$PHP_SELF?Mode=private_message&Action=private_message_main'>".BACK."</a></td></tr></table>";
			read_message($Message_ID);
		break;
		case "read_sent_message_main":
			echo "<table><tr><td><a href='$PHP_SELF?Mode=private_message&Action=view_sent_messages'>".BACK."</a></td></tr></table>";
			read_message($Message_ID,1);
		break;
		case "delete_message_main":
			delete_message($_REQUEST['delete']);
			display_messages();
		break;
		case "delete_outbox_message_main":
			delete_outbox_message($_REQUEST['delete']);
			display_view_sent_messages();
		break;
		case "process_message_main":
			$subject=$_POST['message_subject'];
			$body=$_POST['message_body'];
			$to=$_POST['user_to'];
			$from=$_POST['user_from'];
			
			$errors="";
			if(strlen($subject)<1)
			{
				$errors=$errors.PLEASE_ENTER_A_SUBJECT."<br />";	
			}
			if(strlen($body)<1)
			{
				$errors=$errors.PLEASE_ENTER_A_MESSAGE."<br />";	
			}
			if(strlen($errors)<1)
			{
				process_message($subject,$body,$to,$from);
				display_messages();
			}
			else
			{
				if(get_magic_quotes_gpc())
    			{
    				$subject=stripslashes($subject);
    				$body=stripslashes($body);
    			}
				echo "<table border='0' cellpadding='4' cellspacing='3'>";
				echo "<tr>";
				echo "<td><a href='$PHP_SELF?Mode=private_message&Action=private_message_main'>".BACK."</a></td>";
				echo "</tr>";
				echo "</table>";
				create_message($to,$subject,$body);	
			}

		break;
		case "view_sent_messages":
			display_view_sent_messages();
		break;
		case "reply_to_message":
			$User_To=$_REQUEST['User_To'];
			$Subject=$_REQUEST['Subject'];
			echo "<table><tr><td><a href='$PHP_SELF?Mode=private_message&Action=read_sent_message_main&Message_ID=$Message_ID'>".BACK."</a></td></tr></table>";
			create_message($User_To,$Subject);	
		break;
	}
}
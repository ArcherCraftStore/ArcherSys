<?php 

function send_email($Email_to, $Email_subject, $Email_message, $Email_From="", $Headers="")
{
	global $PHPFFL_SENDMAIL_FROM, $PHPFFL_SEND_EMAILS;
	
	if(strlen($Email_From)<1)
	{
		$Email_From=$PHPFFL_SENDMAIL_FROM;
	}
	$Email_headers = "From: {$Email_From}" . "\r\n" .
   "Reply-To: {$Email_From}" . "\r\n" . $Headers .
   "X-Mailer: PHP/" . phpversion();
	
	if($PHPFFL_SEND_EMAILS)
	{
		@mail($Email_to, $Email_subject, $Email_message, $Email_headers);
	}
}

?>

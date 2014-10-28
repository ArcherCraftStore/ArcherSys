<?php 
include("program_files/config.php");

if(strlen($USERSID)>0)
{
	$sql="select ID from users where ID=$USERSID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		header("Location: {$PHPFFL_WEB_ROOT}my_team.php");
	}
	else
	{
		header("Location: {$PHPFFL_WEB_ROOT}login.php");
	}
}
elseif(strlen($LEAGUEID)>0 && $GO_TO_LOGIN!=1)
{
	
	$sql="select ID from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		header("Location: {$PHPFFL_WEB_ROOT}statistics.php");
	}
	else
	{
		header("Location: {$PHPFFL_WEB_ROOT}login.php");
	}

}
else
{
	header("Location: {$PHPFFL_WEB_ROOT}login.php");
}

?>

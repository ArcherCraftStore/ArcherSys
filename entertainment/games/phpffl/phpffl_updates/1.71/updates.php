<?php

$PHPFFL_UPDATES_SCRIPT=1;

include("program_files/config.php");

$sql="update config_global set value='1.71' where ID='Current_Version';";
$DB->Execute($sql);

$sql="select ID from config_global where ID='DST_Change_Date';";
$rs=$DB->Execute($sql);
if($rs->EOF)
{
	$sql="insert into config_global (ID, value, variable_name) values ('DST_Change_Date', '2013-11-03 01:00:00', 'PHPFFL_DST_CHANGE');";
	$DB->Execute($sql);
}
else
{
	$sql="update config_global set value='2013-11-03 01:00:00' where ID='DST_Change_Date';";
	$DB->Execute($sql);
}


$sql="SELECT ID FROM config_global WHERE ID='Stats_Base_URL';";
$rs=$DB->Execute($sql);
if($rs->EOF)
{
	$sql="INSERT INTO config_global (ID, value, variable_name) VALUES ('Stats_Base_URL', 'http://stats.myofl.com/stats/', 'PHPFFL_STATS_BASE_URL');";
	$DB->Execute($sql);
}

echo "Updates Completed";

?>
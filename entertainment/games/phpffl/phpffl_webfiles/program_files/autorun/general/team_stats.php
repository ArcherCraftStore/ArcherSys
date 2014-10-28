<?php 
@ini_set("max_execution_time", "180");

// Code to set PHP variables from command line arguments
// Runs only if not being called through web server
if (!isset($_SERVER['SERVER_PORT'])) {
// Change to script directory, just like web server does
   chdir(dirname($_SERVER['argv'][0]));
}

$config_path=realpath("../../config.php");
include($config_path);
include ("functions/team_stats_functions.php");


if(strlen($_SERVER['argv'][1])>0)
{

   $Autorun_Pin=$_SERVER['argv'][1];
}
else
{
   $Autorun_Pin=$_REQUEST['Autorun_Pin'];
}


if($PHPFFL_AUTORUN_PIN!=$Autorun_Pin)
{
	die("Invalid Autorun Pin");
}

$current_week=get_current_week(-5);
$sql="select ID from leagues;";
$rs=$DB->Execute($sql);
while(!($rs->EOF))
{	
	$leagues_ID=$rs->fields("ID");
	
	calculate_team_stats($current_week, $leagues_ID);
	$rs->MoveNext();
}

echo "Team Stats Updated: Week $current_week";
?>

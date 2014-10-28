<?php 
@ini_set("max_execution_time", "240");

// Code to set PHP variables from command line arguments
// Runs only if not being called through web server
if (!isset($_SERVER['SERVER_PORT'])) {
// Change to script directory, just like web server does
   chdir(dirname($_SERVER['argv'][0]));
}

$config_path=realpath("../../config.php");
include($config_path);
include ("functions/players_functions.php");


if(strlen($_SERVER['argv'][1])>0)
{

   $Autorun_Pin=$_SERVER['argv'][1];
}
else
{
   $Autorun_Pin=$_REQUEST['Autorun_Pin'];
}
if(strlen($_SERVER['argv'][2])>0)
{

   $Days=$_SERVER['argv'][2];
}
else
{
   $Days=$_REQUEST['Days'];
}

if($PHPFFL_AUTORUN_PIN!=$Autorun_Pin)
{
	die("Invalid Autorun Pin");
}


if(strlen($Days)<1)
{
	$Days=14;
}

$dataArray = fetchPlayerData( $Days );
update_players($dataArray);

?>




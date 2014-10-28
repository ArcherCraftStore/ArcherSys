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
include ("functions/schedules_functions.php");

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

   $Week=$_SERVER['argv'][2];
}
else
{
  $Week=$_REQUEST['Week'];
} 

//Year is Optional. If you don't pass year it default to the current year.
if(strlen($_SERVER['argv'][3])>0)
{

   $Year=$_SERVER['argv'][3];
}
else
{
  $Year=$_REQUEST['Year'];
} 

//Only set this to 1 if you are updating the schedule for a new season. This should always be set to off so that a game is not accidentally added to the schedule twice. 
if(strlen($_SERVER['argv'][4])>0)
{

   $Allow_Insert=$_SERVER['argv'][4];
}
else
{
  $Allow_Insert=$_REQUEST['Allow_Insert'];
} 


if($PHPFFL_AUTORUN_PIN!=$Autorun_Pin)
{
	die("Invalid Autorun Pin");
}


if(strlen($Week)<1)
{
	$Week=get_current_week(0);
}

if(strlen($Year)<1)
{
	$Year=date("Y");
}

if(strlen($Allow_Insert)<1)
{
	$Allow_Insert=0;
}
$dataArray = fetchScheduleData( $Week, $Year );
update_schedules($dataArray, $Allow_Insert);





?>
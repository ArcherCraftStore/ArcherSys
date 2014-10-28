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
include ("functions/statistics_functions.php");
include ($PHPFFL_FILE_ROOT."program_files/admin/functions/scoring_functions.php");

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

if(strlen($_SERVER['argv'][3])>0)
{

   $Process_All=$_SERVER['argv'][3];
}
else
{
  $Process_All=$_REQUEST['Process_All'];
}


if($PHPFFL_AUTORUN_PIN!=$Autorun_Pin)
{
	die("Invalid Autorun Pin");
}

$sql="select positionID, statistic_categories_group from players_positions;";
$rs=$DB->Execute($sql);
$position_group_array=array();
while(!($rs->EOF))
{
	$positionID=$rs->fields("positionID");
	$statistic_categories_group=$rs->fields("statistic_categories_group");
	$position_group_array[$positionID]=$statistic_categories_group;
	$rs->MoveNext();
}

if(strlen($Week)<1 || $Week<1)
{
	$current_week=get_current_week(-24);
}
else
{
	$current_week=$Week;
}

$players_statistics_categories_updated=array();


if($Process_All)
{
	//Update all games - not just games that are in progress
	$sql="select ID from league_schedules where week=$current_week and seasonID not like '%PRE%';";
}
else
{
	$current_EST_date_minus_four=get_current_EST_date(-4);
	$current_EST_date=get_current_EST_date();

	//Just update games that are in progress
	$sql="select ID from league_schedules where week=$current_week and seasonID not like '%PRE%' and (game_date>='$current_EST_date_minus_four' and game_date<='$current_EST_date') or status like '%progress%';";

}
$rs=$DB->Execute($sql);
$games_processed=array();
while(!($rs->EOF))
{
	$gameID=$rs->fields("ID");
	$games_processed[]=$gameID;
	$teams=substr($gameID, 9);
	$teams=explode("@", $teams);
	$home_team=$teams[1];
	$away_team=$teams[0];
	$dataArray = fetchGameData( $gameID );
	$game_data=$dataArray;
	process_game_array($game_data, $current_week, $home_team, $away_team, $position_group_array, $gameID);
	$rs->MoveNext();
}

//Display Games Not Processed if any
$sql="select ID from league_schedules where week=$current_week and seasonID not like '%PRE%';";
$rs=$DB->Execute($sql);
while(!($rs->EOF))
{
	$gameID=$rs->fields("ID");
	$teams=substr($gameID, 9);
	$teams=explode("@", $teams);
	$home_team=$teams[1];
	$away_team=$teams[0];
	if(!(in_array($gameID, $games_processed)))
	{
		echo "Not Processed: $away_team @ $home_team ";
		if(strlen($_SERVER['argv'][1])>0)
		{
			echo "\n";
		}
		else
		{
			echo "<br>";
		}
	}
	$rs->MoveNext();
}
/*
Remove statistics that were removed from the statistics feed.
Example: If a TD was awarded and then reversed this will remove it from the phpffl statistics table.
*/
foreach($players_statistics_categories_updated as $players_ID => $statistic_categories_array)
{
	$sql_where="";
	foreach($statistic_categories_array as $categories_ID => $games_ID)
	{
		if(strlen($sql_where)<1)
		{
			$sql_where=$sql_where." statistic_categories_ID<>$categories_ID";
		}
		else
		{
			$sql_where=$sql_where." and statistic_categories_ID<>$categories_ID";
		}
	}
	$sql="select ID from players_statistics_override where players_ID='$players_ID' and game_ID=$games_ID;";
	$override_rs=$DB->Execute($sql);
	if($override_rs->EOF)
	{
		$sql="update players_statistics_actuals set statistical_value=0 where (players_ID='$players_ID' and game_ID=$games_ID) and ($sql_where);";
		$DB->Execute($sql);
	}
}

/*
Uncomment below if you want to test stats importing on preseason games. After you run this code you will need to delete all records from the tables below.
delete from players_statistics_actuals;
delete from players_statistics_fantasy;

*/


/*
//Change this to whatever preseason week you want
$Pre_Season_Week=1;

$sql="select ID from league_schedules where week=$Pre_Season_Week and seasonID like '%PRE%';";
$rs=$DB->Execute($sql);
while(!($rs->EOF))
{
	$gameID=$rs->fields("ID");
	$teams=substr($gameID, 9);
	$teams=explode("@", $teams);
	$home_team=$teams[1];
	$away_team=$teams[0];
	$dataArray = fetchGameData( $gameID );
	$game_data=$dataArray;
	process_game_array($game_data, $current_week, $home_team, $away_team, $position_group_array, $gameID);
	$rs->MoveNext();
}
*/


//Calculate Fantasy Stats for each league
$sql="select ID from leagues;";
$rs=$DB->Execute($sql);
while(!($rs->EOF))
{
	$current_leagues_ID=$rs->fields("ID");
	calculate_stats($current_week, $current_leagues_ID);
	$rs->MoveNext();
}




?>

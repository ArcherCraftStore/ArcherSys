<?php


/**
 FUNCTION: ffl_HttpGet()
 * Perform a HTTP Get Request.
 *
 * ffl_HttpGet uses fsockopen() to request a given URL via HTTP
 * 1.0 GET and returns a three element array.  On success, array
 * key 'body' contains the body of the request's reply and key
 * 'header' contains the reply's headers.  On error, the keys
 * returned are 'errornumber' and 'errorstring' from
 * fsockopen()'s third and fourth arguments.  In either case,
 * key 'url' contains an array such as returned from parse_url()
 * after the input url has been massaged a bit.
 *
 * {@source }
 *
 * @param string $url URL to fetch.
 * @param boolean $followRedirects Optionally follow
 * 'location:' in header, default true.
 * @return array 'header', 'body', 'url' OR 'errorstring',
 * 'errornumber', 'url'.
 */
function ffl_HttpGet( $url, $followRedirects=true )
{
    $url_parsed = parse_url($url);
    if ( empty($url_parsed['scheme']) ) {
        $url_parsed = parse_url('http://'.$url);
    }
    $rtn['url'] = $url_parsed;

    $port = $url_parsed["port"];
    if ( !$port ) {
        $port = 80;
    }
    $rtn['url']['port'] = $port;

    $path = $url_parsed["path"];
    if ( empty($path) ) {
            $path="/";
    }
    if ( !empty($url_parsed["query"]) ) {
        $path .= "?".$url_parsed["query"];
    }
    $rtn['url']['path'] = $path;

    $host = $url_parsed["host"];
    $foundBody = false;

    $out = "GET $path HTTP/1.0\r\n";
    $out .= "Host: $host\r\n";
    $out .= "Connection: Close\r\n\r\n";

    if ( !$fp = @fsockopen($host, $port, $errno, $errstr, 30) ) {
        $rtn['errornumber'] = $errno;
        $rtn['errorstring'] = $errstr;
        return $rtn;
    }
    fwrite($fp, $out);
    while (!feof($fp)) {
        $s = fgets($fp, 128);
        if ( $s == "\r\n" ) {
            $foundBody = true;
            continue;
        }
        if ( $foundBody ) {
            $body .= $s;
        } else {
            if ( ($followRedirects) && (stristr($s, "location:") != false) ) {
                $redirect = preg_replace("/location:/i", "", $s);
                return ffl_HttpGet( trim($redirect) );
            }
            $header .= $s;
        }
    }
    fclose($fp);

    $rtn['header'] = trim($header);
    $rtn['body'] = trim($body);
    return $rtn;
}


function fetchGameData( $game )
{

    $myFFLurl = PHPFFL_STATS_BASE_URL;
    $myFFLquery = "gameStats.php?gameID=$game";
	echo  $myFFLurl.$myFFLquery." <br>";
    $httpQuery = ffl_HttpGet( $myFFLurl.$myFFLquery );
    $dataArray = unserialize( $httpQuery['body'] );
    return $dataArray;
}

function process_game_array( $game_data , $game_ID, $home_team, $away_team, $position_group_array, $nfl_gameID)
{
	global $DB, $players_statistics_categories_updated;


	$players=$game_data['players'];
	$game=$game_data['game'];


	if(is_array($players))
	{
		$current_game_status=$game['status'];
		$current_home_score=$game['homescore'];
		$current_away_score=$game['awayscore'];
		if(strlen($current_home_score)<1)
			$current_home_score=0;
		if(strlen($current_away_score)<1)
			$current_away_score=0;

		echo "Processed: $away_team ($current_away_score) @ $home_team ($current_home_score) - $current_game_status";
		if(strlen($_SERVER['argv'][1])>0)
		{
			echo "\n";
		}
		else
		{
			echo "<br>";
		}
		$sql="update league_schedules set status='$current_game_status', homescore=$current_home_score, awayscore=$current_away_score where ID='$nfl_gameID';";
		$DB->Execute($sql);
		//$teams=$game_data['teams'];

		foreach ( $players as $playerID => $playerArray )
		{
			//echo "The player ID is ".$playerID;
		  //  echo "The player name is ".$playerArray['name'];
		   // echo "The player has ".$playerArray['score']." fantasy points";
			//echo "The player has the following stats (listed by category):";
			foreach ( $playerArray as $category => $value )
			{
				$statistic_ID="";
				$insert_value="";
				if ( $category == 'id' || $category == 'name' | $category == 'score' )
				{
					 continue;
				}
				if($category =="RU Yds")
				{
					//Rushing Yards
					$statistic_ID=1;
					$insert_value=$value;
				}
				elseif($category =="PS Yds")
				{
					//Passing Yards
					$statistic_ID=2;
					$insert_value=$value;
				}
				elseif($category =="REC Yds")
				{
					//Receiving Yards
					$statistic_ID=3;
					$insert_value=$value;
				}
				elseif($category =="TD-Ru")
				{
					//Rushing TD
					$statistic_ID=4;
					$insert_value=$value;
				}
				elseif($category =="TD-P")
				{
					//Passing TD
					$statistic_ID=9;
					$insert_value=$value;
				}
				elseif($category =="TD-Re")
				{
					//Receiving TD
					$statistic_ID=8;
					$insert_value=$value;
				}
				elseif($category =="Int")
				{
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_offense")
					{
						$statistic_ID=5;
						$insert_value=$value;
					}
					elseif($position_group=="player_defense")
					{
						$statistic_ID=34;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=28;
						$insert_value=$value;
					}
				}
				elseif($category =="2-ptP")
				{
					//Passing 2pt Conv
					$statistic_ID=6;
					$insert_value=$value;
				}
				elseif($category =="2-ptR")
				{
					//Rush/Rec 2pt Conv
					$statistic_ID=41;
					$insert_value=$value;
				}
				elseif($category =="Fum")
				{
					//Fumbles Lost Individual
					//Fumbles Recivered Team Defense
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_offense")
					{
						$statistic_ID=7;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=27;
						$insert_value=$value;
					}
				}
				elseif($category =="FR")
				{
					//Fumbles Recivered Individual Defense
					$statistic_ID=33;
					$insert_value=$value;
				}
				elseif($category =="XP")
				{
					//Extra Points
					$statistic_ID=10;
					$insert_value=$value;
				}
				elseif($category =="XPM")
				{
					//Missed Extra Points
					$statistic_ID=11;
					$insert_value=$value;
				}
				elseif($category =="YA")
				{
					//Team Defense Total Yards Against
					$statistic_ID=12;
					$insert_value=$value;
				}
				elseif($category =="PA")
				{
					//Team Defense Total Points Against
					$statistic_ID=13;
					$insert_value=$value;
				}
				elseif($category =="Tm RU")
				{
					//Team Offense Total Rushing Yards
					$statistic_ID=14;
					$insert_value=$value;
				}
				elseif($category =="Tm PS")
				{
					//Team Offense Total Passing Yards
					$statistic_ID=15;
					$insert_value=$value;
				}
				elseif($category =="TD-S")
				{
					//Special Teams Touchdowns - Ind & Team
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_offense")
					{
						$statistic_ID=49;
						$insert_value=$value;
					}
					elseif($position_group=="player_defense")
					{
						$statistic_ID=46;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=37;
						$insert_value=$value;
					}
					elseif($position_group=="team_specialteams")
					{
						$statistic_ID=16;
						$insert_value=$value;
						$Team_Defense_Players_ID=str_replace("TST", "TDEF", $playerID);
						insert_statistic($Team_Defense_Players_ID, $game_ID, 37, $insert_value);
						$players_statistics_categories_updated[$Team_Defense_Players_ID][37]=$game_ID;

					}
				}
				elseif($category =="KR Yds")
				{
					//Kickoff Return Yards - Ind & Team
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_offense")
					{
						$statistic_ID=50;
						$insert_value=$value;
					}
					elseif($position_group=="player_defense")
					{
						$statistic_ID=47;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=53;
						$insert_value=$value;

					}
					elseif($position_group=="team_specialteams")
					{
						$statistic_ID=17;
						$insert_value=$value;
						$Team_Defense_Players_ID=str_replace("TST", "TDEF", $playerID);
						insert_statistic($Team_Defense_Players_ID, $game_ID, 53, $insert_value);
						$players_statistics_categories_updated[$Team_Defense_Players_ID][53]=$game_ID;
					}
				}
				elseif($category =="PR Yds")
				{
					//Punt Return Yards - Ind & Team
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_offense")
					{
						$statistic_ID=51;
						$insert_value=$value;
					}
					elseif($position_group=="player_defense")
					{
						$statistic_ID=48;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=54;
						$insert_value=$value;
					}
					elseif($position_group=="team_specialteams")
					{
						$statistic_ID=18;
						$insert_value=$value;
						$Team_Defense_Players_ID=str_replace("TST", "TDEF", $playerID);
						insert_statistic($Team_Defense_Players_ID, $game_ID, 54, $insert_value);
						$players_statistics_categories_updated[$Team_Defense_Players_ID][54]=$game_ID;

					}
				}
				elseif($category =="Tk")
				{
					//Defensive Player Tackles
					$statistic_ID=19;
					$insert_value=$value;
				}
				elseif($category =="Rec")
				{
					//Defensive Player Tackles
					$statistic_ID=20;
					$insert_value=$value;
				}
				elseif($category =="FG-20")
				{
					//Field Goal 10-24
					$statistic_ID=21;
					$insert_value=$value;
				}
				elseif($category =="FG-25")
				{
					//Field Goal 25-29
					$statistic_ID=22;
					$insert_value=$value;
				}
				elseif($category =="FG-30")
				{
					//Field Goal 30-34
					$statistic_ID=23;
					$insert_value=$value;
				}
				elseif($category =="FG-35")
				{
					//Field Goal 35-39
					$statistic_ID=24;
					$insert_value=$value;
				}
				elseif($category =="FG-40")
				{
					//Field Goal 40-44
					$statistic_ID=25;
					$insert_value=$value;
				}
				elseif($category =="FG-45")
				{
					//Field Goal 45-49
					$statistic_ID=26;
					$insert_value=$value;
				}
				elseif($category =="FG-50")
				{
					//Field Goal 50-54
					$statistic_ID=38;
					$insert_value=$value;
				}
				elseif($category =="FG-55")
				{
					//Field Goal 55+
					$statistic_ID=39;
					$insert_value=$value;
				}
				elseif($category =="Ms FG")
				{
					//Missed FG
					$statistic_ID=40;
					$insert_value=$value;
				}
				elseif($category =="Sck")
				{
					//Sacks - Player Defense & Team Defense
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_defense")
					{
						$statistic_ID=32;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=29;
						$insert_value=$value;
					}
				}
				elseif($category =="Sckd")
				{
					//Offense - Sacks Allowed
					$statistic_ID=30;
					$insert_value=$value;
				}
				elseif($category =="TD-D")
				{
					//Touchdowns - Player Defense & Team Defense
					$player_data=get_player_data_array($playerID);
					$player_position=$player_data["positionID"];
					$position_group=$position_group_array[$player_position];
					if($position_group=="player_defense")
					{
						$statistic_ID=35;
						$insert_value=$value;
					}
					elseif($position_group=="team_defense")
					{
						$statistic_ID=36;
						$insert_value=$value;
					}
				}
				elseif($category =="As")
				{
					//Tackle Assists
					$statistic_ID=43;
					$insert_value=$value;
				}
				elseif($category =="FF")
				{
					//Forced Fumbles Individual
					$statistic_ID=44;
					$insert_value=$value;
				}
				elseif($category =="Sfty")
				{
					//Safety - Team Defense
					$statistic_ID=55;
					$insert_value=$value;
				}
				elseif($category =="Cpl")
				{
					//Completions
					$statistic_ID=52;
					$insert_value=$value;
				}
				elseif($category =="TD-1")
				{
					//TD's By Distance - 1 Yard TD
					$statistic_ID=56;
					$insert_value=$value;
				}
				elseif($category =="TD-09")
				{
					//TD's By Distance - 2-9 Yard TD
					$statistic_ID=57;
					$insert_value=$value;
				}
				elseif($category =="TD-19")
				{
					//TD's By Distance - 10-19 Yard TD
					$statistic_ID=58;
					$insert_value=$value;
				}
				elseif($category =="TD-29")
				{
					//TD's By Distance - 20-29 Yard TD
					$statistic_ID=59;
					$insert_value=$value;
				}
				elseif($category =="TD-39")
				{
					//TD's By Distance - 30-39 Yard TD
					$statistic_ID=60;
					$insert_value=$value;
				}
				elseif($category =="TD-49")
				{
					//TD's By Distance - 40-49 Yard TD
					$statistic_ID=61;
					$insert_value=$value;
				}
				elseif($category =="TD-59")
				{
					//TD's By Distance - 50-59 Yard TD
					$statistic_ID=62;
					$insert_value=$value;
				}
				elseif($category =="TD-69")
				{
					//TD's By Distance - 60-69 Yard TD
					$statistic_ID=63;
					$insert_value=$value;
				}
				elseif($category =="TD-79")
				{
					//TD's By Distance - 70-79 Yard TD
					$statistic_ID=64;
					$insert_value=$value;
				}
				elseif($category =="TD-89")
				{
					//TD's By Distance - 80-89 Yard TD
					$statistic_ID=65;
					$insert_value=$value;
				}
				elseif($category =="TD-99")
				{
					//TD's By Distance - 90-99 Yard TD
					$statistic_ID=66;
					$insert_value=$value;
				}
				elseif($category =="TD-100")
				{
					//TD's By Distance -100 Yard TD
					$statistic_ID=67;
					$insert_value=$value;
				}

				if(strlen($statistic_ID)>0)
				{
					insert_statistic($playerID, $game_ID, $statistic_ID, $insert_value);
				}
			}
		}
	}
	else
	{
		echo COULDNT_RETREIVE_FEED;
		if(strlen($_SERVER['argv'][1])>0)
		{
			echo "\n";
		}
		else
		{
			echo "<br>";
		}
	}
    return;
}


function insert_statistic($players_ID, $game_ID, $statistic_ID, $statistic_value)
{
	global $DB, $players_statistics_categories_updated;

	$players_statistics_categories_updated[$players_ID][$statistic_ID]=$game_ID;

	$sql="select ID from players_statistics_override where players_ID='$players_ID' and game_ID=$game_ID;";
	$override_rs=$DB->Execute($sql);
	if($override_rs->EOF)
	{
		$sql="select ID from players_statistics_actuals where players_ID='$players_ID' and statistic_categories_ID=$statistic_ID and game_ID=$game_ID ;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$ID=$rs->fields("ID");
			$sql="update players_statistics_actuals set statistical_value=$statistic_value where players_ID='$players_ID' and statistic_categories_ID=$statistic_ID and game_ID=$game_ID;";
		}
		else
		{
			$sql="insert into players_statistics_actuals (players_ID, statistic_categories_ID, statistical_value, week_ID, game_ID) values ('$players_ID', '$statistic_ID', '$statistic_value', '$game_ID', '$game_ID');";
		}
		$DB->Execute($sql);
	}
	else
	{
		//Don't insert stats because override is set.
	}
}
?>

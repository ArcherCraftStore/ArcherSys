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
	$rtn['url'] = $url;
    $url_parsed = parse_url($url);
    if ( empty($url_parsed['scheme']) ) {
        $url_parsed = parse_url('http://'.$url);
    }
    
	
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



function fetchScheduleData( $Week, $Year ) 
{
	
    $myFFLurl = 'http://feeds.myffl.net/feed/scores/';
    $myFFLquery = "?{$Year}/{$Week}/php";
	$url= "{$myFFLurl}{$myFFLquery}";
	echo "$url";
    $httpQuery = ffl_HttpGet( $url , true);
    $dataArray = unserialize( $httpQuery['body'] );
    return $dataArray;
}

function update_schedules($dataArray, $Allow_Insert)
{
	global $DB;
	
	$feedinfo_array=$dataArray["args"];
	
	$seasonID=$feedinfo_array["season"];
	$week=$feedinfo_array["week"];
	
	$games_array=$dataArray["games"];
	
	if(is_array($games_array))
	{

		foreach($games_array as $key => $game_data)
		{
			$league_schedules_ID=$key;
			
			$home_team=$game_data["home"];
			$away_team=$game_data["away"];
			$kickoff=$game_data["kickoff"];
			$gamedate=substr($league_schedules_ID, 0, strpos($league_schedules_ID, '_'));
			$gamedate_timestamp=strtotime($gamedate);
			$game_date=date("Y-m-d", $gamedate_timestamp);
			$game_date=$game_date." ".$kickoff;
			$game_status=$game_data["status"];
			$game_status=$game_data["status"];
			$awayscore=$game_data["awayscore"];
			$homescore=$game_data["homescore"];
			
			$sql="select ID, game_date from league_schedules where seasonID='$seasonID' and week=$week and ID like '%_{$away_team}@{$home_team}'";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$current_game_ID=$rs->fields("ID");
				$current_gamedate=$rs->fields("game_date");
				if($current_gamedate!=$game_date)
				{
					$sql="update league_schedules set kickoff='$kickoff', game_date='$game_date' where ID='$current_game_ID';";
					$DB->Execute($sql);
					echo "Game Updated: {$away_team} @ {$home_team} - $game_date<br>";
				}
				
			}
			else
			{
				if($Allow_Insert)
				{
					$sql="insert into league_schedules (ID, seasonID, kickoff, week, status, awayscore, homescore, game_date) values ('$league_schedules_ID', '$seasonID' ,'$kickoff', '$week', '$game_status', '$awayscore', '$homescore', '$game_date');";
					$DB->Execute($sql);
					echo "Game Added: {$away_team} @ {$home_team} - $game_date<br>";
					//$DB->Execute($sql);
				}
			}
		}
	}
	else
	{
		echo COULDNT_RETREIVE_FEED;
	}

	echo "Schedule Update Completed - {$seasonID}: Week $week ";
}

?>
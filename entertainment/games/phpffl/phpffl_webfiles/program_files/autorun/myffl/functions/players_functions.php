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



function fetchPlayerData( $Days ) 
{
    $myFFLurl = 'http://feeds.myffl.net/feed/player/update/';
    $myFFLquery = "?$Days/php";
	$url= "{$myFFLurl}{$myFFLquery}";
    $httpQuery = ffl_HttpGet( $url , true);
    $dataArray = unserialize( $httpQuery['body'] );
    return $dataArray;
}

function update_players($dataArray)
{
	global $DB;
	
	$players_array=$dataArray["players"];
	
	if(is_array($players_array))
	{
		foreach($players_array as $key => $player_data)
		{
			$ID=$player_data['id'];
			$lastname=$player_data['lastname'];
			$firstname=$player_data['firstname'];
			$teamID=$player_data['teamID'];
			$positionID=$player_data['positionID'];
			$rank=$player_data['rank'];
			$active=$player_data['active'];
			$jersey=$player_data['jersey'];
			$height=$player_data['height'];
			$weight=$player_data['weight'];
			$birth=$player_data['birth'];
			$college=$player_data['college'];
			$nflexperience=$player_data['nflexperience'];
			$alt_id0=$player_data['alt_id0'];
			$alt_id1=$player_data['alt_id1'];
			$updated=$player_data['updated'];
			$scoreYTD=$player_data['scoreYTD'];
			
			$lastname=addslashes($lastname);
			$firstname=addslashes($firstname);
			$jersey=addslashes($jersey);
			$college=addslashes($college);
			
			$sql="select ID from players where ID='$ID';";
			$rs=$DB->Execute($sql);
			if($rs->EOF)
			{
				if(strlen($firstname)>0 && strlen($lastname)>0 )
				{
					$sql="insert into players (ID, lastname, firstname, teamID, positionID, rank, active, jersey, height, weight, birth, college, nflexperience, alt_id0, alt_id1, updated, scoreYTD) values ('$ID', '$lastname', '$firstname', '$teamID', '$positionID', '$rank', '$active', '$jersey', '$height', '$weight', '$birth', '$college', '$nflexperience', '$alt_id0', '$alt_id1', '$updated', '$scoreYTD');";
					$DB->Execute($sql);
					echo "Added: $firstname $lastname: $positionID -> $teamID";
					if(strlen($_SERVER['argv'][1])>0)
					{
						echo "\n";	
					}
					else
					{
						echo "<br>";
					}
				}
			}
			else
			{
				if(strlen($firstname)>0 && strlen($lastname)>0 )
				{
					$sql="update players set lastname='$lastname', firstname='$firstname', teamID='$teamID', positionID='$positionID', rank='$rank', active='$active', jersey='$jersey', height='$height', weight='$weight', birth='$birth', college='$college', nflexperience='$nflexperience', alt_id0='$alt_id0', alt_id1='$alt_id1', updated='$updated', scoreYTD='$scoreYTD' where ID='$ID';";
					$DB->Execute($sql);
					echo "Updated - $firstname $lastname: $positionID -> $teamID";
					if(strlen($_SERVER['argv'][1])>0)
					{
						echo "\n";	
					}
					else
					{
						echo "<br>";
					}
				}
			}
		}
	}
	else
	{
		echo COULDNT_RETREIVE_FEED;
	}
	//Make sure NFC/AFC Defenses doesn't get into the players table.
	//Make sure phantom Chris Brown doesn't get into the players table.
	$sql="delete from players where ID='TDEFST_AFC' or ID='TDEFST_NFC' or ID='TDEF_AFC' or ID='TDEF_NFC' or ID='395933';";
	$DB->Execute($sql);

}

?>

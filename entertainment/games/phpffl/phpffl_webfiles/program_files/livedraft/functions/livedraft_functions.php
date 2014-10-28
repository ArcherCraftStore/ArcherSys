<?php

function adminAutoDraft($leagueid){
	global $PHP_SELF, $DB, $Mode;
	// find next pick

	$nextpick = ssFindNextDraftPick("getcur",$leagueid);
	list($pick,$round,$teamid) = split(",",$nextpick);

	// parse next pick
	ssAutoDraft($leagueid,$teamid,$round,$pick);
}
function excludedPlayers($LEAGUEID){
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH;
	$returnString = '';
	$select = "select ex.players_id,p.lastname,p.firstname,p.teamID,p.positionID from draft_exclude_players ex, players p " .
		"  where ex.leagues_id=$LEAGUEID and ex.players_id = p.id";
	$rs = $DB->Execute($select);
	$count = 0;

	while (!($rs->EOF)){


		if ($count==0){
			$returnString .= "<table><tr><th>Player Name<th>Position<th>Team<th>Unexclude</tr>";
		}
		$count++;
		$name = $rs->fields("lastname") . ", " . $rs->fields("firstname");
		$pos = $rs->fields("positionID");
		$team = $rs->fields("teamID");
		$playerid = $rs->fields("players_id");

		$returnString .= "<tr><td>$name<td>$pos<td>$team<td><a onClick='unexcludePlayer(\"$playerid\")'><img src='{$PHPFFL_IMAGE_PATH}draft_unexclude.gif' border='0' ALIGN='top'/></a></tr>";
		$rs->MoveNext();
	}
	if ($count != 0){ $returnString .= "</table>";}
	return $returnString;
}

function unexcludePlayer($leagueid,$playerid){
	global $PHP_SELF, $DB, $Mode;
	$delete = "delete from draft_exclude_players where leagues_id=$leagueid and players_id='$playerid'";
	$DB->Execute($delete);
	//return $delete;
	$return = excludedPlayers($leagueid);
	return $return;
}

function excludePlayer($leagueid,$playerid){
	global $PHP_SELF, $DB, $Mode;
	$insert = "insert into draft_exclude_players (leagues_id,players_id) values ($leagueid,'$playerid')";
	$DB->Execute($insert);
	return "Player excluded";

}

function searchPlayers($leagueid,$search){
	global $PHP_SELF, $DB, $Mode, $PHPFFL_IMAGE_PATH;

	// get excluded players first
	$excludeArray = null;
	$select = "select players_id from draft_exclude_players where leagues_id = $leagueid and players_id is not null";

	$rs=$DB->Execute($select);

	while (!($rs->EOF)){

		$id=$rs->fields("players_id");
		$excludeArray["$id"] = 't';
		$rs->MoveNext();
	}

	$select = "select id,firstname,lastname,teamid,positionid from players where lastname like '$search'";

	$rs = $DB->Execute($select);
	$count = 0;
	while(!($rs->EOF)){
		if ($count==0){
			$returnString = "<table><tr><th>Name<th>Pos<th>Team<th>Exclude</tr>";
		}
		$count++;
		$id = $rs->fields("id");
		$name = $rs->fields("lastname") . ", " . $rs->fields("firstname");
		$team = $rs->fields("teamid");
		$pos = $rs->fields("positionid");

		if ($excludeArray[$id] != 't'){
			$returnString .= "<tr><td>$name<td>$pos<td>$team<td><a onClick='excludePlayer(\"$id\")'><img src='{$PHPFFL_IMAGE_PATH}draft_exclude.gif' border='0' ALIGN='top'/></a></tr>";
		}
		$rs->MoveNext();
	}
	if ($count == 0){
		$returnString="No results found";
	}
	else {
		$returnString .= "</table>";
	}
	return $returnString;
}


function undoLastPick($leagueid){
	global $PHP_SELF, $DB, $Mode;


	// find last pick
	$select = "select max(round) as round from draft where leagues_id=$leagueid and players_id is not null";
	//return $select;
	$rs=$DB->Execute($select);
	$round=$rs->fields("round");

	$select = "select max(pick) as pick from draft where leagues_id=$leagueid and players_id is not null and round=$round";
	//return $select;
	$rs=$DB->Execute($select);
	$pick=$rs->fields("pick");

	$select = "select id from draft where leagues_id=$leagueid and round=$round and pick=$pick";
	$rs=$DB->Execute($select);
	$id = $rs->fields("id");

	$select = "select players_id from draft where id=$id";
	//return $select;
	$rs=$DB->Execute($select);
	$players_id=$rs->fields("players_id");

	//null pick in draft table
	$update = "update draft set players_id = null where id = $id";
	$DB->Execute($update);

	//delete player from roster
	$delete = "delete from rosters where leagues_id=$leagueid and players_id='$players_id'";
	//return $delete;
	$DB->Execute($delete);

	$insert = "insert into draft_log(logtype,logvalue,ts,leagues_id) values('reset','UndoPick',CURRENT_TIMESTAMP(),$leagueid)";
	$DB->Execute($insert);

	$player_data=get_player_data_array($players_id);
	if(is_array($player_data))
	{
		$player_name=$player_data['firstname']." ".$player_data['lastname'];
	}
	$undo_text=DRAFT_PICK_UNDONE."- $player_name - ".ROUND.": $round ".PICK.": $pick";

	$sql = "insert into draft_log
(logtype,logvalue,ts,leagues_id) values ('Chat','Admin:
$undo_text',CURRENT_TIMESTAMP(),$leagueid)";
	$DB->Execute($sql);

	ssFindNextDraftPick("pickmade",$leagueid);
	return "Last Pick Undone";
}


function resetDraft($leagueid){
	global $PHP_SELF, $DB, $Mode;
	$update = "update draft_status set draftlive=0, next_pick_deadline=0 where leagues_ID=$leagueid";

	$DB->Execute($update);

	// remove drafted players from team rosters.
	$select = "select players_id from draft where leagues_id=$leagueid and players_id is not null";
	//return $select;
	$rs=$DB->Execute($select);
	$in = "(";
	while(!($rs->EOF)){

		$players_id=$rs->fields("players_id");
		//return "pid" . $players_id;
		//$delete = "delete from rosters where leagues_id=$leagueid and players_id='$players_id'";

		//$DB->Execute($delete);
		$in .= "'$players_id',";
		$rs->MoveNext();
	}

	$in = substr("$in", 0, -1);
	$in = $in .")";
	if ($in != "()"){
		$delete = "delete from rosters where leagues_id=$leagueid and players_id in $in";
		$DB->Execute($delete);
	}


	$delete = "delete from draft_log where leagues_id=$leagueid";

	$DB->Execute($delete);

	$update = "update draft set players_id=null where leagues_id=$leagueid";
	$DB->Execute($update);

	return "Completed";
}

function ssResetDraft($leagueid){
	global $PHP_SELF, $DB, $Mode;
	resetDraft($leagueid);
	return "draft reset";
}


function ssAutoDraft($leagueid,$teamid,$round,$pick){
	global $PHP_SELF, $DB, $Mode;
	$playerid = get_autodraft_playerID($teamid, $round, $pick, $leagueid);
	ssProcessDraftPick($playerid,$teamid,$round,$pick,$leagueid);
	return "$playerid";
}


function ssSuggestPlayer($teamid,$leagueid){
	global $PHP_SELF, $DB, $Mode;
	// Need to get round and pick for team's next pick
	$select = "select round,pick from draft where teams_id=$teamid order by display_order";
	$rs=$DB->Execute($select);
	$round=$rs->fields("round");
	$pick=$rs->fields("pick");
	$playerid=get_autodraft_playerID($teamid, $round, $pick, $leagueid);
	return $playerid;
}

function ssRefreshPlayerList($listtype,$order,$LEAGUEID,$teamid){
	global $PHP_SELF, $DB, $Mode;

 // get excluded players first
	$excludeArray = null;
	$select = "select players_id from draft_exclude_players where leagues_id = $LEAGUEID and players_id is not null";

	$rs=$DB->Execute($select);

	while (!($rs->EOF)){

		$id=$rs->fields("players_id");
		$excludeArray["$id"] = 't';
		$rs->MoveNext();
	}


    $returntext = '<table><tr><th>Player<th>Pos<th>Team</tr>';

    $select = "select players_id from draft where leagues_id = $LEAGUEID  union select players_id from rosters where leagues_id= $LEAGUEID";
    $rs=$DB->Execute($select);

	$takenids;
	while(!($rs->EOF)){

		$id=$rs->fields("players_id");

		$takenids[$id]=1;

		$rs->MoveNext();
	}


	$select = "select p.id,p.lastname,p.firstname,p.positionid,p.teamid,r.rank from players p,draft_rank_teams r
                 where p.id=r.players_id and p.active='yes' and r.teams_id=$teamid and r.leagues_id=$LEAGUEID";
    if($listtype != 'all'){
	   $select .= " and p.positionID='$listtype'";
    }
	else {
		$select2="select distinct players_positionid from positions p ,starting_lineup_requirements slr
                     where slr.positions_id=p.id and slr.leagues_id=$LEAGUEID";


		$rs=$DB->Execute($select2);
		$poslist="";
		while(!($rs->EOF)){
			$playersposid	= $rs->fields("players_positionid");
			$rs->MoveNext();
			$indpos = split(':',$playersposid);
			foreach($indpos as $pos){
				$poslist .= "'$pos',";
			}
		}
		$poslist = rtrim($poslist,',');
		$select .= " and p.positionid in ($poslist) ";
	}
      if ($order=="rank"){$order="r.rank,p.lastname,p.firstname ";}
      else {$order="p.lastname,p.firstname ";}
      $select .= "order by $order";
      $rs=$DB->Execute($select);

		while(!($rs->EOF)){
			$id=$rs->fields("id");
			$lastname=$rs->fields("lastname");
			$firstname=$rs->fields("firstname");
			$positionid=$rs->fields("positionid");
			$teamid=$rs->fields("teamid");




	     if ($takenids[$id] != 1 && $excludeArray["$id"] != 't'){
             $returntext .= "<tr id='$id'><td><a onclick=\"clickPlayer('$id')\">$lastname, $firstname</a></td><td>$positionid</td><td>$teamid</td>";
			}
			$rs->MoveNext();
         $i++;
	}
      return $returntext;
}

function ssGetRoster($selectid,$LEAGUEID){
	global $PHP_SELF, $DB, $Mode;

	if (preg_match("/_round/",$selectid)){
		$round = preg_split("/_round/",$selectid);
		$returntext = '<table><tr><th>Pick<th>FFL Team<th>Player<th>Pos<th>Team</tr>';
		#$select = "select players.lastname,players.firstname,players.positionid,players.teamid,draft.round,draft.pick,teams.team_name
        #       from players,draft,teams
		#	   where draft.round=$round[1] and draft.players_id=players.id and draft.teams_id=teams.id
		#	   order by round,pick";
		$select = "SELECT teams.team_name,players.lastname, players.firstname, players.positionid, players.teamid, draft.round, draft.pick
			       FROM teams, draft
                   LEFT JOIN players ON draft.players_id = players.id
                   WHERE draft.round =$round[1] and draft.leagues_id=$LEAGUEID
                   AND draft.teams_id = teams.id
                   ORDER BY round, pick";


		$rs=$DB->Execute($select);

		while(!($rs->EOF)){
			$id=$rs->fields("id");
			$lastname=$rs->fields("lastname");
			$firstname=$rs->fields("firstname");
			$positionid=$rs->fields("positionid");
			$teamid=$rs->fields("teamid");
			$round=$rs->fields("round");
			$pick=$rs->fields("pick");
			$fflteam=$rs->fields("team_name");
			$rs->MoveNext();
			$returntext .= "<tr><td>$pick</td><td>$fflteam</td><td>$lastname,$firstname</td><td>$positionid</td><td>$teamid</td></tr>";
		}

	}
    elseif(preg_match("/_last/",$selectid)){
		$returntext = '<table><tr><th>Round<th>Pick<th>FFL Team<th>Player<th>Pos<th>Team</tr>';
		$select = "select players.lastname,players.firstname,players.positionid,players.teamid,draft.round,draft.pick,teams.team_name
               from teams,draft,players
			   where  players_id is not null and draft.players_id=players.id and draft.teams_id=teams.id and draft.leagues_id=$LEAGUEID
			   order by round desc,pick desc limit 20";

		$rs=$DB->Execute($select);

		while(!($rs->EOF)){
			$id=$rs->fields("id");
			$lastname=$rs->fields("lastname");
			$firstname=$rs->fields("firstname");
			$positionid=$rs->fields("positionid");
			$teamid=$rs->fields("teamid");
			$round=$rs->fields("round");
			$pick=$rs->fields("pick");
			$fflteam=$rs->fields("team_name");
			$rs->MoveNext();
			$returntext .= "<tr><td>$round</td><td>$pick</td><td>$fflteam</td><td>$lastname,$firstname</td><td>$positionid</td><td>$teamid</td></tr>";
		}
	}
	elseif(preg_match("/_next/",$selectid)){
		$returntext = '<table><tr><th>Round<th>Pick<th>FFL Team</tr>';
		$select = "select draft.round,draft.pick,teams.team_name
               from draft,teams
			   where  players_id is null and draft.teams_id=teams.id and draft.leagues_id=$LEAGUEID
			   order by round asc,pick asc limit 20";

		$rs=$DB->Execute($select);

		while(!($rs->EOF)){
			$round=$rs->fields("round");
			$pick=$rs->fields("pick");
			$fflteam=$rs->fields("team_name");
			$rs->MoveNext();
			$returntext .= "<tr><td>$round</td><td>$pick</td><td>$fflteam</td></tr>";
		}
	}
	else {
		$returntext = '<table><tr><th>Round<th>Pick<th>Player<th>Pos<th>Team</tr>';
		$select = "select players.lastname,players.firstname,players.positionid,players.teamid,draft.round,draft.pick
               from draft left join players on draft.players_id=players.id
			   where draft.teams_id=$selectid
			   order by round,pick";

		$rs=$DB->Execute($select);

		while(!($rs->EOF)){
			$id=$rs->fields("id");
			$lastname=$rs->fields("lastname");
			$firstname=$rs->fields("firstname");
			$positionid=$rs->fields("positionid");
			$teamid=$rs->fields("teamid");
			$round=$rs->fields("round");
			$pick=$rs->fields("pick");
			$rs->MoveNext();
			$returntext .= "<tr><td>$round</td><td>$pick</td><td>$lastname,$firstname</td><td>$positionid</td><td>$teamid</td></tr>";
		}
	}

	$returntext .= "</table>";
	return $returntext;
}

function check_max_roster_requirements($LEAGUEID,$teamid,$playerid){
  	//Check to see if this waiver exceeds Max Player in Roster Requirements
  	$Teams_ID=$teamid;
	$errors="";
	$players_position_totals=get_players_position_totals_team($Teams_ID);
	$players_positions_ID=get_players_positions_ID($playerid);
	$players_position_totals[$pickup_players_positions_ID]++;
	$roster_requirements_array=get_roster_requirements_array($LEAGUEID);
	foreach($roster_requirements_array as $key => $val)
	{
		if($players_position_totals[$key] >= $roster_requirements_array[$key]['max_players'] && $roster_requirements_array[$key]['max_players']>0 && $key==$players_positions_ID)
		{
			$position_name=get_lineup_position_name($key, "long");
			return "Pick Rejected: You would exceed the maximum allowed number of players at this position. $position_name: $max_allowed";
		}
	}
	return 1;
}

function ssProcessDraftPick($playerid,$teamid,$roundid,$pickid,$LEAGUEID){
	global $PHP_SELF, $DB, $Mode;
	/// Check if valid draft pick
	//Make sure position is draft eligible.
	$validpick = check_max_roster_requirements($LEAGUEID,$teamid,$playerid);
	if ($validpick !== 1) { return $validpick;}


	// Make sure not already a pick entered
	$select = "select * from draft where players_id is not null and leagues_id=$LEAGUEID and round=$roundid and pick=$pickid";

	$rs=$DB->Execute($select);
	if (!($rs->EOF)){ return "Pick already taken\nMay be a duplicate\nPlease reload/refresh this page."; }

// Uncomment when autodraft function put in
	$select = "select ID from rosters where players_ID='$playerid' and leagues_id=$LEAGUEID;";
	$rs=$DB->Execute($select);
	if (!($rs->EOF)){ return "Player already drafted.\nPlease choose again."; }

	$update = "update draft set players_id='$playerid'
	           where leagues_id=$LEAGUEID
			   and pick=$pickid
			   and round=$roundid
			   and teams_id=$teamid";
	$DB->Execute($update);

	$insert = "insert into rosters (players_ID, current_teams_ID, round, pick, leagues_ID) values ('$playerid', '$teamid', '$roundid', '$pickid', '$LEAGUEID');";
	$DB->Execute($insert);

    $select = "select lastname,firstname from players where id='$playerid'";
	$rs=$DB->Execute($select);
	$lastname=$rs->fields("lastname");
	$firstname=$rs->fields("firstname");
    $lastname=addslashes($lastname);
	$firstname=addslashes($firstname);
      $insert = "insert into draft_log (logtype,logvalue,ts,leagues_id) values ('Draft','$teamid-$playerid-$lastname,$firstname',CURRENT_TIMESTAMP(),$LEAGUEID)";
      $DB->Execute($insert);
	  ssFindNextDraftPick("pickmade",$LEAGUEID);
	  //$values=split(",".$pick);

      return 1;


}


function ssChat($teamid,$text,$LEAGUEID){
	global $PHP_SELF, $DB, $Mode;
    $select = "select team_name from teams where id=$teamid";
	$rs=$DB->Execute($select);
	$teamname=$rs->fields("team_name");
      if(1)
	{
		$teamname=addslashes($teamname);
		$text=addslashes($text);
	}

	$insert = "insert into draft_log (logtype,logvalue,ts,leagues_id) values ('Chat','$teamname: $text',CURRENT_TIMESTAMP(),$LEAGUEID)";
	$DB->Execute($insert);
    return 1;
}

function ssStartDraft($LEAGUEID){
	global $PHP_SELF, $DB, $Mode;
	$update = "update draft_status set draftlive=1, next_pick_deadline=0 where leagues_id=$LEAGUEID";
	$DB->Execute($update);
	ssFindNextDraftPick("pickmade",$LEAGUEID);
	return 1;
}


function ssGetUpdate($id,$LEAGUEID,$round,$pick,$teamid){
	global $PHP_SELF, $DB, $Mode;
	$select = "select id,logtype,logvalue from draft_log where id>$id and leagues_id=$LEAGUEID";
	$rs=$DB->Execute($select);
	$dl_id=0;
	$datastring = "";
	$num=0;
	while(!($rs->EOF)){
		$dl_id=$rs->fields("id");
		$tag=$rs->fields("logtype");
		$value=$rs->fields("logvalue");
		$rs->MoveNext();
		$num += 1;
		$datastring .= $tag . "#--#" . $value . "#!!#";
	}
	if ($num >0){
		$datastring .= "logid#--#$dl_id" . "#!!#";
	}
	$select="select next_pick_deadline,(next_pick_deadline - UNIX_TIMESTAMP()) as timeleft,draftlive from draft_status where leagues_id=$LEAGUEID";
	$rs=$DB->Execute($select);
	$next_pick_deadline=$rs->fields("next_pick_deadline");

	$nextpicktime=$rs->fields("timeleft");
	$draftlive=$rs->fields("draftlive");
	if ($draftlive != 0){
		if ($next_pick_deadline == 0){
			// draft is untimed
			$nextpicktime="OFF";
		}
		elseif ($nextpicktime < 0) {
			//attempt to make an autopick here
			// first lock tables
			//$DB->Execute("Lock tables draft write");
			//$thispick = ssFindNextDraftPick("getcur",$LEAGUEID);
			//$values=split(",",$thispick);
			//$pick=$values[0];
			//$round=$values[1];
			//$teamid=$values[2];
			$select = "select * from draft where players_id is not null and round=$round and pick=$pick and leagues_id=$LEAGUEID";
			$rs=$DB->Execute($select);
			if (!($rs->EOF)){
				// found pick already made
			}
			else {
				// make an auto pick
				$draftplayerid = get_autodraft_playerID($teamid, $round, $pick, $LEAGUEID);
				ssProcessDraftPick($draftplayerid,$teamid,$round,$pick,$LEAGUEID);
			}
			//$DB->Execute("Unlock Tables");
			$rs=$DB->Execute("select (next_pick_deadline - UNIX_TIMESTAMP()) as timeleft from draft_status where leagues_id=$LEAGUEID");

			$nextpicktime=$rs->fields("timeleft");
		}
		$datastring .= "time#--#$nextpicktime" . "#!!#";
	}
	return $datastring;
}

function get_autodraft_playerID($teamid, $round, $pick, $LEAGUEID){

	global $PHP_SELF, $DB, $Mode;

	$sql="select rank from draft_rank_teams LEFT OUTER JOIN rosters on draft_rank_teams.players_ID=rosters.players_ID and rosters.leagues_ID=$LEAGUEID
where draft_rank_teams.teams_ID=$teamid and rosters.current_teams_ID IS NULL order by draft_rank_teams.rank ASC limit 0, 1 ";
	$rs=$DB->Execute($sql);
	$rank=$rs->fields("rank");

	$target_positions_ID=0;
	$sql="select positions_ID from draft_teams_target_position where teams_ID=$teamid and round=$round and pick=$pick and leagues_ID=$LEAGUEID;";
	$target_rs=$DB->Execute($sql);
	if(!($target_rs->EOF))
	{
		$target_positions_ID=$target_rs->fields("positions_ID");
	}
	//Check to make sure not over league max player restrictions
	$players_position_totals=get_players_position_totals_team($teamid);
	$roster_requirements_array=get_roster_requirements_array($LEAGUEID);
	$position_maxed_out_array=array();
	foreach($roster_requirements_array as $key => $val)
	{
		if($players_position_totals[$key] >= $roster_requirements_array[$key]['max_players'] && $roster_requirements_array[$key]['max_players']>0)
		{
			//echo "$key -> ".$players_position_totals[$key]." ----> ".$roster_requirements_array[$key]['max_players']."<br>";
			$position_maxed_out_array[]=$key;

		}
	}
	if(in_array($target_positions_ID, $position_maxed_out_array))
	{
		$target_positions_ID=0;
	}
	$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";
	$positions_rs=$DB->Execute($sql);
	$extra_logic=$extra_logic."and (0=1 ";
	$extra_logicNonTarget=$extra_logicNonTarget."and (0=1 ";
	while(!($positions_rs->EOF))
	{
		$positions_ID=$positions_rs->fields("ID");
		$positions_type=$positions_rs->fields("type");
		$players_positionID=$positions_rs->fields("players_positionID");
		$players_positionID_array=explode(":", $players_positionID);
		foreach($players_positionID_array as $key => $val)
		{
			$sql="select positions.ID from positions where (players_positionID like '$val' or players_positionID like '%:$val' or players_positionID like '$val:%' or players_positionID like '%:$val:%') and include_in_roster_requirements=1;";
			//echo "$sql<br>";
			$current_position_rs=$DB->Execute($sql);
			$current_position_ID=$current_position_rs->fields("ID");
			if(strlen($val)>0 && ($target_positions_ID==0 || $target_positions_ID==$positions_ID) && !(in_array($current_position_ID, $position_maxed_out_array)) )
			{
				//echo "$current_position_ID -->".$val."<br>";
				$extra_logic=$extra_logic."or players.positionID='$val'";
			}
			elseif(strlen($val)>0 && !(in_array($current_position_ID, $position_maxed_out_array)))
			{
				$extra_logicNonTarget=$extra_logicNonTarget."or players.positionID='$val'";
			}
		}
		$positions_rs->MoveNext();
	}
	$extra_logic=$extra_logic.") ";
	$extra_logicNonTarget=$extra_logicNonTarget.") ";

	$sql="select players_ID from rosters where leagues_ID=$LEAGUEID;";
	$rosters_rs=$DB->Execute($sql);
	$extra_players_logic="";
	while(!($rosters_rs->EOF))
	{
		$rosters_players_ID=$rosters_rs->fields("players_ID");
		$extra_players_logic=$extra_players_logic."and players.ID<>'$rosters_players_ID' ";

		$rosters_rs->MoveNext();
	}
	//$sql="select draft_rank_teams.players_ID, players.lastname from draft_rank_teams INNER JOIN players on players.ID=draft_rank_teams.players_ID where draft_rank_teams.teams_ID=$teamid and draft_rank_teams.leagues_ID=$LEAGUEID and draft_rank_teams.rank>=$rank $extra_logic $extra_players_logic order by draft_rank_teams.rank ASC limit 0,1;";
	//$sql="select draft_rank_teams.players_ID, players.lastname from draft_rank_teams INNER JOIN players on players.ID=draft_rank_teams.players_ID LEFT OUTER JOIN rosters on rosters.players_ID=players.ID where draft_rank_teams.teams_ID=$teamid and draft_rank_teams.leagues_ID=$LEAGUEID and draft_rank_teams.rank>=$rank and ((rosters.leagues_ID=$LEAGUEID and rosters.current_teams_ID IS NULL) or rosters.leagues_ID IS NULL) $extra_logic order by draft_rank_teams.rank ASC limit 0,1;";
	//Using Subquery - Much quicker than previous but not supported until mysql 4.1
	$sql="select draft_rank_teams.players_ID, players.lastname from draft_rank_teams, players where players.active='yes' and players.ID=draft_rank_teams.players_ID and draft_rank_teams.teams_ID=$teamid and draft_rank_teams.leagues_ID=$LEAGUEID and draft_rank_teams.rank>=$rank $extra_logic and players.ID NOT IN (select players_ID as ID from rosters where leagues_ID=$LEAGUEID) and players.ID NOT IN (select players_id as ID from draft_exclude_players where leagues_ID=$LEAGUEID) order by draft_rank_teams.rank ASC limit 0,1;";

	//echo "$target_positions_ID _> $sql<br>";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{

		$playerid=$rs->fields("players_ID");
		$lastname=$rs->fields("lastname");
		$firstname=$rs->fields("firstname");
		//echo "--> $firstname $lastname<br><br>";
	}
	else
	{

		$sql="select players.lastname, players.ID, players.firstname from players where players.active='yes' $extra_logicNonTarget $extra_players_logic and players.ID NOT IN (select players_id as ID from draft_exclude_players where leagues_ID=$LEAGUEID)  order by positionID ASC, ID ASC limit 0,1;";

		//echo "<br>$sql<br>";
		$rs=$DB->Execute($sql);
		$playerid=$rs->fields("ID");
		$lastname=$rs->fields("lastname");
		$firstname=$rs->fields("firstname");

		//echo "--> $firstname $lastname<br><br>";
	}
	return $playerid;
}


function get_round_pick_length_seconds($LEAGUEID,$roundnumber){

	$round_length_array=get_draft_length_round_array($LEAGUEID);
	$round_minutes=$round_length_array[$roundnumber]['length_minutes'];
	$round_seconds=$round_length_array[$roundnumber]['length_seconds'];
	$total_time=($round_minutes*60)+$round_seconds;
	return $total_time;

}


function ssFindNextDraftPick($from,$LEAGUEID){
	global $PHP_SELF, $DB, $Mode;
	$select = "select draftlive from draft_status where leagues_id=$LEAGUEID";
	$rs=$DB->Execute($select);
	$draftlive=$rs->fields("draftlive");
	if ($draftlive==1){
		$select = "select max(draft_position) as numteams from draft_order where leagues_id=$LEAGUEID";
		$rs=$DB->Execute($select);
		$numteams=$rs->fields("numteams");

		$select = "select round,pick,teams_id from draft where leagues_id=$LEAGUEID and players_id is null
	          order by round asc,pick asc limit 0, 1";
		$rs=$DB->Execute($select);

		if ($rs->EOF){
			// draft is over
			$insert = "insert into draft_log(logtype,logvalue,ts,leagues_id) values('NextPick','Draft Completed',CURRENT_TIMESTAMP(),$LEAGUEID)";
			$DB->Execute($insert);
			$update = "update draft_status set draftlive=0 where leagues_id=$LEAGUEID";
			$DB->Execute($update);
			return "Draft Completed";
		}
		else{
			$round=$rs->fields("round");
			$pick=$rs->fields("pick");
			$teams_id=$rs->fields("teams_id");
		}

		if ($from != "getcur"){
			$insert="insert into draft_log (logtype,logvalue,ts,leagues_id) values ('NextPick','$pick,$round,$teams_id',CURRENT_TIMESTAMP(),$LEAGUEID)";
			$DB->Execute($insert);
		}
		if ($from == "pickmade"){ // don't reset the pick clock is someone is just logging into the draft
			$seconds = get_round_pick_length_seconds($LEAGUEID,$round);
			if ($seconds == 0){
				$update="update draft_status set next_pick_deadline=0 where leagues_id=$LEAGUEID";
				$DB->Execute($update);
			}
			else {

				$update ="update draft_status set next_pick_deadline = UNIX_TIMESTAMP() + $seconds,draftlive=1 where leagues_id=$LEAGUEID";
				$DB->Execute($update);
			}
			email_next_pick($LEAGUEID,$teams_id,$round,$pick);
		}

		return "$pick,$round,$teams_id";
	}
	else {
		return "0,0,-1";
	}
}

function email_next_pick($LEAGUEID,$teams_id,$round,$pick){
	global $DB;
	$sql="select draft_email_notifications from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$draft_email_notifications=$rs->fields("draft_email_notifications");
	}
	if($draft_email_notifications=="Yes" && strlen($teams_id)>0)
	{
		$Users_Team=get_users_on_team($teams_id);
		$team_name=get_team_name($teams_id);
		$Email_subject="Draft: Round $round, Pick $pick";
		$Email_message="{$team_name}, it is now your turn to draft in round $round, pick $pick.";
		foreach($Users_Team as $key => $val)
		{
			$users_email=get_users_email($val);
			if(strlen($users_email)>0)
			{
				@send_email($users_email, $Email_subject, $Email_message);
			}
		}
	}
	return 1;
}



?>
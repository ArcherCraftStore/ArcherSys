<?php


function display_draft($Users_ID, $leagues_ID, $IsAdmin, $Style, $Current_Pick="", $called_from_js=0)
{
	global $PHP_SELF, $DB, $Mode, $PHPFFL_WEB_ROOT, $IsAjax;

	ob_start();

	$sql="select display_draft_timer from leagues where ID=$leagues_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$Display_Draft_Timer=$rs->fields("display_draft_timer");
	}
	$Draft_Over=false;
	if(strlen($Users_ID)>0)
	{
		$sql="select teams_ID from users_teams, teams where leagues_ID=$leagues_ID and users_teams.users_ID=$Users_ID;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$Users_Teams_ID=$rs->fields("teams_ID");
		}
	}
	if(strlen($Current_Pick)<1)
	{
		$sql="select max(display_order) as max_display_order from draft where leagues_ID=$leagues_ID and players_ID IS NOT NULL;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$last_pick=$rs->fields("max_display_order");
		}
		if(strlen($last_pick)<1)
		{
			$last_pick=0;
		}
		$Current_Pick=$last_pick+1;
	}
	$sql="select ID, round, pick, teams_ID from draft where leagues_ID=$leagues_ID and display_order>=$Current_Pick order by display_order ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$count=1;
		while(!($rs->EOF) && $count<=6)
		{
			$draft_ID=$rs->fields("ID");
			$draft_round=$rs->fields("round");
			$draft_pick=$rs->fields("pick");
			$draft_teams_ID=$rs->fields("teams_ID");
			$draft_order[$count]["ID"]=$draft_ID;
			$draft_order[$count]["round"]=$draft_round;
			$draft_order[$count]["pick"]=$draft_pick;
			$draft_order[$count]["teams_ID"]=$draft_teams_ID;
			$count++;
			$rs->MoveNext();
		}
		echo "<table border='0' cellpadding='2' cellspacing='2' width='100%' align='center'>";
		echo "<tr>";
		$Draft_ID=$draft_order[1]["ID"];
		$Draft_Round=$draft_order[1]["round"];
		$Draft_Pick=$draft_order[1]["pick"];
		$Draft_Teams_ID=$draft_order[1]["teams_ID"];
		$Draft_teams_name=get_team_name($Draft_Teams_ID);
		echo "<tr><td colspan='6' align='center'><span class='draft_main_title_{$Style}'>Round: $Draft_Round&nbsp;&nbsp;&nbsp;&nbsp;Pick: $Draft_Pick&nbsp;&nbsp;&nbsp;&nbsp;On The Clock: $Draft_teams_name</span></td></tr>";
		echo "<tr>";
		$on_deck=5;
		if($Display_Draft_Timer=="Yes" && $IsAdmin==1)
		{
			$round_length_array=get_draft_length_round_array($leagues_ID);
			$round_minutes=$round_length_array[$draft_round]['length_minutes'];
			$round_seconds=$round_length_array[$draft_round]['length_seconds'];
			$roundTimeIsSet=0;
			if($round_minutes>0 || $round_seconds>0)
			{
				$roundTimeIsSet=1;
			}
			$on_deck=3;
			echo "<td align='left' width='35%'>";
			?>
			<table id="CH_dtimer1" class="timer" width="100%">
			<tr>
			<td class="timer_pad" align="middle">
			<table>
			<tr><td>
			<span class="field_cont">
			   <label class="field">
				  <input id="CH_dtimer1_hours" class="hours"
						 type="hidden" size="2" disabled="disabled" />
			   </label>
			   <label class="field"><b>Minutes:</b>
				  <input id="CH_dtimer1_minutes" class="minutes"
						 type="text" size="2" disabled="disabled" />
			   </label>

			   <label class="field"><b>Seconds:</b>
				  <input id="CH_dtimer1_seconds" class="seconds"
						 type="text" size="2" disabled="disabled" />
			   </label>
			</span>
			</td></tr>
			<tr><td>
			&nbsp;&nbsp;<span id="CH_dtimer1_digits" class="digits_<?php echo "$Style";?>"></span>&nbsp;&nbsp;
			<span class="btn_cont">
			   <input id="CH_dtimer1_start" class="start"
					  type="button" value="Start" disabled="disabled" />
			   <input id="CH_dtimer1_pause" class="pause"
					  type="hidden" value="Pause" disabled="disabled" />
			   <input id="CH_dtimer1_resume" class="resume"
					  type="hidden" value="Resume" disabled="disabled" />
			   <input id="CH_dtimer1_reset"
					  type="button" value="Reset" disabled="disabled" />
			</span>
			</td></tr>
			</table>
			</td>
			</tr>
			</table>

			<script src="<?php echo "$PHPFFL_WEB_ROOT";?>program_files/draft/coolCount.js" type="text/javascript"></script>
			<?php
			echo "</td>";
		}
		for($i=2;$i<$on_deck+2;$i++)
		{
			$current_ID=$draft_order[$i]["ID"];
			$current_round=$draft_order[$i]["round"];
			$current_pick=$draft_order[$i]["pick"];
			$current_teams_ID=$draft_order[$i]["teams_ID"];
			$current_teams_name=get_team_name($current_teams_ID);
			if(strlen($current_ID)>0)
			{
				$j=$i-1;
				echo "<td align='center'><span class='draft_title_{$Style}'>$j: $current_teams_name</span></td>";
			}
		}
		if($Display_Draft_Timer=="Yes" && $IsAdmin==1)
		{
			echo "<td></td>";
		}
		echo "</tr>";
		echo "</table>";
	}
	else
	{
		$Draft_Over=true;
		echo "<table border='0' cellpadding='2' cellspacing='2' width='100%'>";
		echo "<tr><td>End of Draft</td></tr>";
		echo "</table>";
	}
	if($IsAdmin==1)
	{
		$Already_Drafted=false;
		$sql="select ID from draft where players_ID IS NULL and leagues_ID=$leagues_ID and display_order=$Current_Pick;";
		$drafted_rs=$DB->Execute($sql);
		if($drafted_rs->EOF)
		{
			$Already_Drafted=true;
		}
		echo "<table border='0' cellpadding='2' cellspacing='2' width='100%' align='center'>";
		echo "<form method='post' action='$PHP_SELF?' name='Draft_Form' id='Draft_Form'>";
		echo "<tr>";
		echo "<td align='center'>";
		echo "(<a href='#' id='suggestLink'>Suggest</a>) <a href='$PHP_SELF?Mode=$Mode&Action=confirm_draft_pick&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID&Autodraft_Player=Yes'>Autodraft Player</a>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<span class='draft_title_{$Style}'>Enter Next Pick:</span> ";
		if(!($Already_Drafted))
		{
			echo "<input type='text' name='Players_Search_Name' id='Players_Search_Name' value=''>&nbsp;&nbsp;&nbsp;";

		}
		else
		{
			echo "<input type='text' name='Players_Search_Name' value='Already Drafted' disabled>&nbsp;&nbsp;&nbsp;";
		}
		echo "<input type='Submit' name='Submit' value=\"".SEARCH."\">&nbsp;&nbsp;&nbsp;";
		if(!($Already_Drafted))
		{
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Find Player</a>";
		}
		echo "</td>";
		echo "</tr>";
		echo "<tr><td align='center'>";
		if($Current_Pick==1)
		{
			echo "Previous Pick";
		}
		else
		{
			$Previous_Pick=$Current_Pick-1;
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Style=$Style&Current_Pick=$Previous_Pick'>Previous</a>";
		}
		echo "&nbsp;&nbsp;&nbsp;";
		$Next_Pick=$Current_Pick+1;
		echo "<a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Style=$Style&Current_Pick=$Next_Pick'>Next</a>";
		echo "</td></tr>";
		echo "<input type='hidden' name='Draft_Round' value='$Draft_Round'>";
		echo "<input type='hidden' name='Draft_Pick' value='$Draft_Pick'>";
		echo "<input type='hidden' name='Draft_Teams_ID' value='$Draft_Teams_ID'>";
		echo "<input type='hidden' name='Style' value='$Style'>";
		echo "<input type='hidden' name='Action' value='player_search_byname'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";

	}
	echo "<br>";
	echo "<table border='0' cellpadding='2' cellspacing='2' width='100%' align='center'>";
	echo "<tr>";
	echo "<td width='60%' valign='top'>";
	echo "<table border='0' cellpadding='2' cellspacing='2' width='100%' align='center'>";
	echo "<tr><td colspan='6' align='center'><span class='draft_title_{$Style}'>Previous Picks</span></td></tr>";
	echo "<tr>";
	echo "<td><span class='draft_title_{$Style}'>Rd</span></td>";
	echo "<td><span class='draft_title_{$Style}'>Pk</span></td>";
	echo "<td><span class='draft_title_{$Style}'>Team</span></td>";
	echo "<td><span class='draft_title_{$Style}'>Player</span></td>";
	echo "<td><span class='draft_title_{$Style}'>Pos</span></td>";
	echo "<td><span class='draft_title_{$Style}'>NFL Team</span></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
	//Display last 20 picks
	$count=0;
	$sql="select ID, round, pick, teams_ID, players_ID from draft where leagues_ID=$leagues_ID and display_order<$Current_Pick order by display_order DESC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$bg="";
		while(!($rs->EOF) && $count<20)
		{
			$bg=get_row_bg($bg);
			$current_round=$rs->fields("round");
			$current_pick=$rs->fields("pick");
			$current_teams_ID=$rs->fields("teams_ID");
			$current_players_ID=$rs->fields("players_ID");
			$current_teams_name=get_team_name($current_teams_ID);
			$current_player_data=get_player_data_array($current_players_ID);
			$current_player_name="{$current_player_data['lastname']}, {$current_player_data['firstname']}";
			$current_player_team=$current_player_data["teamID"];
			$current_player_position=$current_player_data["positionID"];
			echo "<tr bgcolor='$bg'>";
			echo "<td><span class='draft_text_{$Style}'>$current_round</span></td>";
			echo "<td><span class='draft_text_{$Style}'>$current_pick</span></td>";
			echo "<td><span class='draft_text_{$Style}'>$current_teams_name</span></td>";
			echo "<td><span class='draft_text_{$Style}'>$current_player_name</span></td>";
			echo "<td><span class='draft_text_{$Style}'>$current_player_position</span></td>";
			echo "<td><span class='draft_text_{$Style}'>$current_player_team</span></td>";
			echo "</tr>";
			$count++;
			$rs->MoveNext();
		}
	}
	else
	{
		echo "<tr><td colspan='6' align='center'><span class='draft_text_{$Style}'>No previous picks to display.</span></td>";
	}
	echo "</table>";
	echo "</td>";
	echo "<td width='40%' valign='top'>";
	if($Draft_Over==false)
	{
		if($IsAdmin==1 || strlen($Users_Teams_ID)<1)
		{
			//Display Team for Team that is picking
			display_team_roster($Draft_Teams_ID, $Style);
		}
		else
		{
			//Display Team for User Logged In
			display_team_roster($Users_Teams_ID, $Style);
		}
	}
	echo "</td>";
	echo "</tr>";
	echo "</table>";

	if($IsAdmin && !($IsAjax))
	{
		?>
		<script type="text/javascript">
		$(document).ready(function() {

			<?php
			if($roundTimeIsSet)
			{
			?>
			$("#CH_dtimer1_minutes").val("<?php echo $round_minutes; ?>");
			$("#CH_dtimer1_seconds").val("<?php echo $round_seconds; ?>");
			$("#CH_dtimer1_start").click();
			<?php
			}
			?>
			$("#Players_Search_Name").focus();

		   	$("#suggestLink").click(function () {
		      	$.get("<?php echo $PHP_SELF; ?>", { Mode: "<?php echo $Mode; ?>", Action: "suggest_pick", Draft_Round: "<?php echo $Draft_Round; ?>",Draft_Pick: "<?php echo $Draft_Pick; ?>",Draft_Teams_ID: "<?php echo $Draft_Teams_ID; ?>", IsAjax: "1" },
				   function(data){
				     $("#Players_Search_Name").val(data);
			   });
			});



		});
		</script>
		<?php
	}

	$draft_html = ob_get_contents();
	ob_end_clean();



	return $draft_html;



}

function display_team_roster($Teams_ID, $Style)
{
	global $PHP_SELF, $DB;

	$Team_Name=get_team_name($Teams_ID);
	$sql="select positionID, display_order from players_positions";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$current_position_ID=$rs->fields("positionID");
		$current_display_order=$rs->fields("display_order");
		$players_position_array[$current_position_ID]=$current_display_order;
		$rs->MoveNext();
	}

	echo "<table border='0' cellpadding='2' cellspacing='2' width='100%' align='center'>";
	echo "<tr><td colspan='6' align='center'><span class='draft_title_{$Style}'>$Team_Name</span></td></tr>";
	echo "<tr>";
	echo "<td><span class='draft_title_{$Style}'>Player Name</span></td>";
	echo "<td><span class='draft_title_{$Style}'>Team</span></td>";
	echo "<td><span class='draft_title_{$Style}'>Position</span></td>";
	echo "<tr class='tablerowline' height='8'><td colspan='3'></td></tr>";
	$sql="select players_ID, lastname, firstname, teamID, positionID from rosters, players where players_ID=players.ID and current_teams_ID=$Teams_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		while(!($rs->EOF))
		{
			$current_players_ID=$rs->fields("players_ID");
			$current_lastname=$rs->fields("lastname");
			$current_firstname=$rs->fields("firstname");
			$current_teamID=$rs->fields("teamID");
			$current_positionID=$rs->fields("positionID");
			$player_data[$current_players_ID]["lastname"]=$current_lastname;
			$player_data[$current_players_ID]["firstname"]=$current_firstname;
			$player_data[$current_players_ID]["teamID"]=$current_teamID;
			$player_data[$current_players_ID]["positionID"]=$current_positionID;
			$position_display_order=$players_position_array[$current_positionID];
			$position_array[$position_display_order][$current_players_ID]=$current_lastname;
			$rs->MoveNext();
		}
		/*
		echo "<pre>";
		var_dump($player_data);
		var_dump($position_array);
		echo "</pre>";
		*/
		foreach($position_array as $key => $val)
		{
			asort($position_array[$key]);
		}
		ksort($position_array);
		$bg="";
		foreach($position_array as $key => $val)
		{
			foreach($position_array[$key] as $key2 => $val2)
			{
				$bg=get_row_bg($bg);
				$current_lastname=$player_data[$key2]["lastname"];
				$current_firstname=$player_data[$key2]["firstname"];
				$current_teamID=$player_data[$key2]["teamID"];
				$current_positionID=$player_data[$key2]["positionID"];
				echo "<tr bgcolor='$bg'>";
				echo "<td><span class='draft_text_{$Style}'>$current_lastname, $current_firstname</span></td>";
				echo "<td><span class='draft_text_{$Style}'>$current_teamID</span></td>";
				echo "<td><span class='draft_text_{$Style}'>$current_positionID</span></td>";
				echo "</tr>";
			}
		}


	}
	else
	{
	echo "<tr><td colspan='3'><span class='draft_text_{$Style}'>None</span></td></tr>";
	}
	echo "</table></td>";
	echo "</tr>";
	echo "</table>";
}


function display_player_lookup($Draft_Round, $Draft_Pick, $Draft_Teams_ID, $Style, $Search_Type="", $Search_Position="", $Current_Letter="", $OrderBy="", $SortBy="", $Players_Search_Name="")
{

	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT, $ISADMIN;

	if(strlen($Search_Type)<1)
		$Search_Type="Available";
	if(strlen($Search_Position)<1)
	{
		$Search_Position="All";
		/*
		$sql="select distinct(positions.ID), positions.type from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";
		$positions_rs=$DB->Execute($sql);
		if(!($positions_rs->EOF))
		{
			$Search_Position=$positions_rs->fields("ID");
		}
		else
		{
			$Search_Position="All";
		}
		*/
	}
	if(strlen($Current_Letter)<1)
		$Current_Letter="ALL";
	if(strlen($OrderBy)<1)
		$OrderBy="lastname";
	if(strlen($SortBy)<1)
		$SortBy="ASC";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><td colspan='4'><a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Style=$Style'>".BACK."</a></td></tr>";
	echo "<tr>";
	echo "<input type='hidden' name='Search_Type' value='Available'>";
	echo "<td><span class='table_row_title'>Position: </span></td>";
	echo "<td>";
	echo "<select name='Search_Position'>";
	echo "<option value='All'>All</option>";
	$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by type ASC";
	$positions_rs=$DB->Execute($sql);
	while(!($positions_rs->EOF))
	{
		$positions_type=$positions_rs->fields("type");
		$positions_ID=$positions_rs->fields("ID");
		$s="";
		if($Search_Position==$positions_ID)
			$s="selected";
		echo "<option value='$positions_ID' $s>$positions_type</option>";
		$positions_rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value='Search'></td>";
	echo "</tr>";
	echo "<input type='hidden' name='Draft_Round' value='$Draft_Round'>";
	echo "<input type='hidden' name='Draft_Pick' value='$Draft_Pick'>";
	echo "<input type='hidden' name='Draft_Teams_ID' value='$Draft_Teams_ID'>";
	echo "<input type='hidden' name='Style' value='$Style'>";
	echo "<input type='hidden' name='Action' value='player_lookup'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</table>";


	if(strlen($Current_Letter)<1)
		$Current_Letter="A";
	if(strlen($OrderBy)<1)
		$OrderBy="lastname";
	if(strlen($SortBy)<1)
		$SortBy="ASC";

	if($SortBy=="ASC")
	{
		$NewSort="DESC";
		$image="arrow_down.gif";
	}
	else
	{
		$NewSort="ASC";
		$image="arrow_up.gif";
	}
	$alphabet="A B C D E F G H I J K L M N O P Q R S T U V W X Y Z";
	$alphabet=explode(" ", $alphabet);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='5'>";
	foreach($alphabet as $key => $val)
	{
		if($Current_Letter==$val)
		{
			echo "&nbsp;<strong>{$val}</strong>&nbsp;";
		}
		else
		{
			echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$val&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>$val</a>&nbsp;";
		}
	}
	if($Current_Letter=="ALL")
	{
		echo "&nbsp;<strong>Show All</strong>&nbsp;";
	}
	else
	{
		echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=ALL&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Show All</a>&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr>";
	if($OrderBy=="lastname")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Name</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Name</a></td>";
	}
	if($OrderBy=="positionID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Position</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Position</a></td>";
	}
	if($OrderBy=="teamID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>NFL Team</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=player_lookup&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>NFL Team</a></td>";
	}

	echo "<td></td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";
	if($Current_Letter!="ALL")
	{
		$extra_logic=$extra_logic."and lastname like '$Current_Letter%'";
		//$sql="select * from players where active='yes' and lastname like '$Current_Letter%' order by $OrderBy $SortBy";
	}
	else
	{
		if(strlen($Players_Search_Name)>0)
		{

			$Players_Search_Name_Array=explode(" ", $Players_Search_Name);
			if(is_array($Players_Search_Name_Array))
			{
				foreach($Players_Search_Name_Array as $key => $val)
				{
					if(strlen($val)>0)
					{
						$val=addslashes($val);
						$extra_logic=$extra_logic."and (lastname like '%$val%' or firstname like '%$val%') ";
					}
				}
			}
		}
	}
	if($Search_Position=="All")
	{
		$positions_rs->MoveFirst();
		$extra_logic=$extra_logic."and (0=1 ";
		while(!($positions_rs->EOF))
		{
			$players_positionID=$positions_rs->fields("players_positionID");
			$positions_array=explode(":",  $players_positionID);
			if(is_array($positions_array))
			{
				foreach($positions_array as $key => $val)
				{
					$extra_logic=$extra_logic."or positionID='$val'";
				}
			}
			$positions_rs->MoveNext();
		}
		$extra_logic=$extra_logic.")";
	}
	else
	{
		$sql="select players_positionID from positions where ID='$Search_Position';";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$players_positionID=$rs->fields("players_positionID");
			$extra_logic=$extra_logic."and (0=1 ";
			$positions_array=explode(":",  $players_positionID);
			if(is_array($positions_array))
			{
				foreach($positions_array as $key => $val)
				{
					$extra_logic=$extra_logic."or positionID='$val'";
				}
			}
			$extra_logic=$extra_logic.")";
		}
	}
	if($Search_Type=="All")
	{
		$sql="select * from players where active='yes' $extra_logic";

	}
	elseif($Search_Type=="Available")
	{
		$sql="select players.* from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NULL $extra_logic";
	}
	elseif($Search_Type=="Owned")
	{
		$sql="select players.*, current_teams_ID from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NOT NULL $extra_logic";
	}
	if($OrderBy=="points" || $OrderBy=="current_teams_ID")
	{
		$sql=$sql." order by lastname DESC";

	}
	else
	{
		$sql=$sql." order by $OrderBy $SortBy";
	}

	$rs=$DB->Execute($sql);

	while(!($rs->EOF))
	{
		$players_ID=$rs->fields("ID");
		$players_array[$players_ID]="";
		$rs->MoveNext();
	}
	if(is_array($players_array))
	{
		foreach($players_array as $key => $val)
		{
			$sql="select * from players where ID='$key';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$bg=get_row_bg($bg);
				$players_ID=$rs->fields("ID");
				$lastname=$rs->fields("lastname");
				$firstname=$rs->fields("firstname");
				$team=$rs->fields("teamID");
				$sql="select sum(fantasy_value) as total_fantasy_points from players_statistics_fantasy where players_ID='$players_ID' and leagues_ID=$LEAGUEID group by players_ID;";
				$points_rs=$DB->Execute($sql);
				if(!($points_rs->EOF))
				{
					$total_fantasy_points=$points_rs->fields("total_fantasy_points");
				}
				else
				{
					$total_fantasy_points=0;
				}
				if(strlen($team)<1)
					$team="FA";
				$position=$rs->fields("positionID");
				echo "<tr bgcolor='$bg'>";
				echo "<td>$lastname, $firstname</td>";
				echo "<td>$position</td>";
				echo "<td>$team</td>";
				if($ISADMIN)
				{
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=confirm_draft_pick&Players_ID=$players_ID&Current_Letter=$Current_Letter&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Draft_Round=$Draft_Round&Draft_Pick=$Draft_Pick&Draft_Teams_ID=$Draft_Teams_ID'>Draft Player</a></td>";
				}
				echo "</tr>";
				$rs->MoveNext();
			}
		}
	}
	echo "</table>";
}


function display_players_search($Style, $Search_Type="", $Search_Position="", $Current_Letter="", $OrderBy="", $SortBy="")
{

	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT;

	if(strlen($Search_Type)<1)
		$Search_Type="Available";
	if(strlen($Search_Position)<1)
	{
		$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by ID ASC";
		$positions_rs=$DB->Execute($sql);
		if(!($positions_rs->EOF))
		{
			$Search_Position=$positions_rs->fields("ID");
		}
		else
		{
			$Search_Position="All";
		}
	}
	if(strlen($Current_Letter)<1)
		$Current_Letter="ALL";
	if(strlen($OrderBy)<1)
		$OrderBy="lastname";
	if(strlen($SortBy)<1)
		$SortBy="ASC";
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<input type='hidden' name='Search_Type' value='Available'>";
	echo "<td><span class='table_row_title'>Position: </span></td>";
	echo "<td>";
	echo "<select name='Search_Position'>";
	echo "<option value='All'>All</option>";
	$sql="select distinct(positions.ID), positions.type, positions.players_positionID from starting_lineup_requirements, positions where leagues_ID=$LEAGUEID and positions_ID=positions.ID order by type ASC";
	$positions_rs=$DB->Execute($sql);
	while(!($positions_rs->EOF))
	{
		$positions_type=$positions_rs->fields("type");
		$positions_ID=$positions_rs->fields("ID");
		$s="";
		if($Search_Position==$positions_ID)
			$s="selected";
		echo "<option value='$positions_ID' $s>$positions_type</option>";
		$positions_rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value='Search'></td>";
	echo "</tr>";
	echo "<input type='hidden' name='Style' value='$Style'>";
	echo "<input type='hidden' name='Action' value='players'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</table>";


	if(strlen($Current_Letter)<1)
		$Current_Letter="A";
	if(strlen($OrderBy)<1)
		$OrderBy="lastname";
	if(strlen($SortBy)<1)
		$SortBy="ASC";

	if($SortBy=="ASC")
	{
		$NewSort="DESC";
		$image="arrow_down.gif";
	}
	else
	{
		$NewSort="ASC";
		$image="arrow_up.gif";
	}
	$alphabet="A B C D E F G H I J K L M N O P Q R S T U V W X Y Z";
	$alphabet=explode(" ", $alphabet);
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='5'>";
	foreach($alphabet as $key => $val)
	{
		if($Current_Letter==$val)
		{
			echo "&nbsp;<strong>{$val}</strong>&nbsp;";
		}
		else
		{
			echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$val&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>$val</a>&nbsp;";
		}
	}
	if($Current_Letter=="ALL")
	{
		echo "&nbsp;<strong>Show All</strong>&nbsp;";
	}
	else
	{
		echo "&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=ALL&OrderBy=$OrderBy&SortBy=$SortBy&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>Show All</a>&nbsp;";
	}
	echo "</td></tr>";
	echo "<tr>";
	if($OrderBy=="lastname")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>Name</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=lastname&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>Name</a></td>";
	}
	if($OrderBy=="positionID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>Position</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>Position</a></td>";
	}
	if($OrderBy=="teamID")
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>NFL Team</a>";
		echo "<br><img src='{$PHPFFL_WEB_ROOT}images/{$image}'>";
		echo "</td>";
	}
	else
	{
		echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=teamID&SortBy=ASC&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>NFL Team</a></td>";
	}

	echo "<td>Player ID</td>";
	echo "</tr>";
	echo "<tr class='tablerowline' height='8'><td colspan='5'></td></tr>";
	if($Current_Letter!="ALL")
	{
		$extra_logic=$extra_logic."and lastname like '$Current_Letter%'";
		//$sql="select * from players where active='yes' and lastname like '$Current_Letter%' order by $OrderBy $SortBy";
	}
	if($Search_Position=="All")
	{
		$positions_rs->MoveFirst();
		$extra_logic=$extra_logic."and (0=1 ";
		while(!($positions_rs->EOF))
		{
			$positions_type=$positions_rs->fields("type");
			$players_positionsID=$positions_rs->fields("players_positionID");
			$players_positionsID_array=explode(":", $players_positionsID);
			foreach($players_positionsID_array as $key => $val)
			{
				if(strlen($val)>0)
				{
					$extra_logic=$extra_logic."or positionID='$val'";
				}
			}
			$positions_rs->MoveNext();
		}
		$extra_logic=$extra_logic.")";
	}
	else
	{
		$sql="select players_positionID from positions where ID='$Search_Position';";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$players_positionID=$rs->fields("players_positionID");
			$extra_logic=$extra_logic."and (0=1 ";
			$positions_array=explode(":",  $players_positionID);
			if(is_array($positions_array))
			{
				foreach($positions_array as $key => $val)
				{
					$extra_logic=$extra_logic."or positionID='$val'";
				}
			}
			$extra_logic=$extra_logic.")";
		}
	}
	if($Search_Type=="All")
	{
		$sql="select * from players where active='yes' $extra_logic";

	}
	elseif($Search_Type=="Available")
	{
		$sql="select players.* from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NULL $extra_logic";
	}
	elseif($Search_Type=="Owned")
	{
		$sql="select players.*, current_teams_ID from players left outer join rosters on (players.ID = rosters.players_ID and leagues_ID=$LEAGUEID) where active='yes' and rosters.players_ID IS NOT NULL $extra_logic";
	}
	if($OrderBy=="points" || $OrderBy=="current_teams_ID")
	{
		$sql=$sql." order by lastname DESC";

	}
	else
	{
		$sql=$sql." order by $OrderBy $SortBy";
	}
	$rs=$DB->Execute($sql);

	while(!($rs->EOF))
	{
		$players_ID=$rs->fields("ID");
		$players_array[$players_ID]="";
		$rs->MoveNext();
	}
	if(is_array($players_array))
	{
		foreach($players_array as $key => $val)
		{
			$sql="select * from players where ID='$key';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$bg=get_row_bg($bg);
				$players_ID=$rs->fields("ID");
				$lastname=$rs->fields("lastname");
				$firstname=$rs->fields("firstname");
				$team=$rs->fields("teamID");
				$sql="select sum(fantasy_value) as total_fantasy_points from players_statistics_fantasy where players_ID='$players_ID' and leagues_ID=$LEAGUEID group by players_ID;";
				$points_rs=$DB->Execute($sql);
				if(!($points_rs->EOF))
				{
					$total_fantasy_points=$points_rs->fields("total_fantasy_points");
				}
				else
				{
					$total_fantasy_points=0;
				}
				if(strlen($team)<1)
					$team="FA";
				$position=$rs->fields("positionID");
				echo "<tr bgcolor='$bg'>";
				echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=view_player_detail&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style&Players_ID=$players_ID&Printable=1&height=600&width=950' class='thickbox'>$lastname, $firstname</a></td>";
				echo "<td>$position</td>";
				echo "<td>$team</td>";
				echo "<td>$players_ID</td>";
				echo "</tr>";
				$rs->MoveNext();
			}
		}
	}
	echo "</table>";
}

function display_teams_search($Teams_ID, $Style)
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>Select Team: </span></td>";
		echo "<td>";
		echo "<select name='Teams_ID'>";
		while(!($rs->EOF))
		{
			$current_teams_ID=$rs->fields("ID");
			$current_teams_name=$rs->fields("team_name");
			$s="";
			if($current_teams_ID==$Teams_ID)
				$s="selected";
			echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
			$rs->MoveNext();
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "</tr>";
		echo "<input type='hidden' name='Style' value='$Style'>";
		echo "<input type='hidden' name='Action' value='teams'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</table>";
	}

}

function view_draft_order($Round="", $Style="", $Is_Admin="")
{
	global $PHP_SELF, $DB, $Mode, $USERSID, $LEAGUEID, $PHPFFL_WEB_ROOT;

	if(strlen($Round)<1)
	{
		$sql="select max(display_order) as max_display_order from draft where leagues_ID=$LEAGUEID and players_ID IS NOT NULL;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$last_pick=$rs->fields("max_display_order");
		}
		if(strlen($last_pick)<1)
		{
			$last_pick=0;
		}
		$sql="select round from draft where leagues_ID=$LEAGUEID and display_order=$last_pick;";
		$rs=$DB->Execute($sql);
		if(!($rs->EOF))
		{
			$Round=$rs->fields("round");
		}
	}
	$sql="select draft_date, draft_length_rounds from leagues where ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$draft_date=$rs->fields("draft_date");
		$draft_length_rounds=$rs->fields("draft_length_rounds");
		$draft_date_display=display_users_time($draft_date);
	}
	$sql="select sum(leagues_ID) as number_teams from teams where leagues_ID=$LEAGUEID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$number_teams=$rs->fields("number_teams");
	}
	if(strlen($Round)<1)
	{
		$Round=1;
	}
	$sql="select * from draft where leagues_ID=$LEAGUEID and round=$Round order by display_order ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><td><span class='table_row_title'>Round</span></td>";
		echo "<td>";
		echo "<select name='Round'>";
		for($i=1;$i<=$draft_length_rounds;$i++)
		{
			$s="";
			if($Round==$i)
				$s="selected";
			echo "<option value='$i' $s>$i</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
		echo "</tr>";
		echo "<input type='hidden' name='Style' value='$Style'>";
		echo "<input type='hidden' name='Action' value='draft_order'>";
		echo "<input type='hidden' name='Mode' value='$Mode'>";
		echo "</form>";
		echo "</table>";

		$sql="select ID, team_name from teams where leagues_ID=$LEAGUEID order by team_name ASC;";
		$teams_rs=$DB->Execute($sql);

		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		if($Is_Admin==1)
		{
			echo "<form method='post' action='$PHP_SELF?'>";
		}
		echo "<td><span class='table_row_title'>Pick</span></td>";
		echo "<td><span class='table_row_title'>Team</span></td>";
		echo "<td><span class='table_row_title'>Player</span></td>";
		if($Is_Admin==1)
		{
			echo "<td></td>";
		}
		echo "</tr>";
		echo "<tr class='tablerowline' height='3'><td colspan='4'></td></tr>";
		if(!($rs->EOF))
		{
			$bg="";
			while(!($rs->EOF))
			{
				$bg=get_row_bg($bg);
				$draft_ID=$rs->fields("ID");
				$pick=$rs->fields("pick");
				$teams_ID=$rs->fields("teams_ID");
				$display_order=$rs->fields("display_order");
				echo "<tr bgcolor='$bg'>";
				echo "<td>$pick</td>";

				$sql="select ID from draft where ID=$draft_ID and players_ID IS NULL;";
				$draft_rs=$DB->Execute($sql);
				if(!($draft_rs->EOF) && $Is_Admin==1)
				{
					echo "<td>";
					echo "<select name='Teams_Order[$pick]'>";
					$teams_rs->MoveFirst();
					while(!($teams_rs->EOF))
					{
						$current_teams_ID=$teams_rs->fields("ID");
						$current_teams_name=$teams_rs->fields("team_name");
						$s="";
						if($current_teams_ID==$teams_ID)
							$s="selected";
						echo "<option value='$current_teams_ID' $s>$current_teams_name</option>";
						$teams_rs->MoveNext();
					}
					echo "</td>";
					echo "<td></td>";
					echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=draft_main&Style=$Style&Current_Pick=$display_order'>Enter Pick</a></td>";
				}
				else
				{
					$current_teams_name=get_team_name($teams_ID);
					echo "<td>$current_teams_name</td>";
					$sql="select players_ID from draft where teams_ID=$teams_ID and leagues_ID=$LEAGUEID and pick=$pick and round=$Round;";
					$players_rs=$DB->Execute($sql);
					$current_players_name="";
					if(!($players_rs->EOF))
					{
						$current_players_ID=$players_rs->fields("players_ID");
						if(strlen($current_players_ID)>0)
						{
							$current_players_data=get_player_data_array($current_players_ID);
							$current_players_name="{$current_players_data['firstname']} {$current_players_data['lastname']}";
						}
					}

					echo "<td>$current_players_name</td>";
					if($Is_Admin==1)
					{
						echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=confirm_undo_pick&Style=$Style&Draft_Teams_ID=$teams_ID&Draft_Pick=$pick&Draft_Round=$Round&Players_ID=$current_players_ID'>Undo Pick</a></td>";
					}
				}
				echo "</tr>";
				$rs->MoveNext();
			}
		}
		if($Is_Admin==1)
		{
			echo "<tr><td colspan='2'><input type='Submit' name='Submit' value='Update Draft Order'></td></tr>";
			echo "<input type='hidden' name='Round' value='$Round'>";
			echo "<input type='hidden' name='Style' value='$Style'>";
			echo "<input type='hidden' name='Action' value='confirm_draft_order'>";
			echo "<input type='hidden' name='Mode' value='$Mode'>";
			echo "</form>";
		}
		echo "</table>";

	}
	else
	{
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td><span class='table_row_title'>No draft order exists for this league.</span></td></tr>";
		echo "</table>";
	}

}

function suggest_player($Draft_Round, $Draft_Pick, $Draft_Teams_ID)
{
	global $LEAGUEID;

	$Players_ID=get_autodraft_playerID($Draft_Teams_ID, $Draft_Round, $Draft_Pick, $LEAGUEID);
	$current_player_data=get_player_data_array($Players_ID);
	$current_player_name="{$current_player_data['firstname']} {$current_player_data['lastname']}";


	return $current_player_name;
}
?>
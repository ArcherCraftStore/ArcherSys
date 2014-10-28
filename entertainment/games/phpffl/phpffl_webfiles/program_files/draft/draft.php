<?php

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
?>
<?php
if($Mode=="draft")
{

	Switch($Action)
	{
		case "draft_main":
		default:
			if(strlen($Style)<1)
			{
				$Style="large";
			}
			if($ISADMIN==1)
			{
				$Current_Pick=$_REQUEST['Current_Pick'];
				$draft_html=display_draft($USERSID, $LEAGUEID, $ISADMIN, $Style, $Current_Pick);
				if(!($IsAjax))
				{
					echo "<div id='Draft_Main_Div' class='Draft_Main_Div'>";
				}
				echo $draft_html;
				if(!($IsAjax))
				{
					echo "</div>";
				}
				//suggest_player_js($Draft_Round, $Draft_Pick, $Draft_Teams_ID)
				//$Draft_Round, $Draft_Pick, $Draft_Teams_ID
			}
			else
			{
				$draft_html=display_draft($USERSID, $LEAGUEID, $ISADMIN, $Style);
				if(!($IsAjax))
				{
					echo "<div id='Draft_Main_Div' class='Draft_Main_Div'>";
				}
				echo $draft_html;
				if(!($IsAjax))
				{
					echo "</div>";
				}
			}
		break;
		case "confirm_draft_pick":
			if($ISADMIN==1)
			{
				$Draft_Round=$_REQUEST['Draft_Round'];
				$Draft_Pick=$_REQUEST['Draft_Pick'];
				$Draft_Teams_ID=$_REQUEST['Draft_Teams_ID'];
				$Players_ID=$_REQUEST['Players_ID'];
				$Draft_Round=$_REQUEST['Draft_Round'];
				$Autodraft_Player=$_REQUEST['Autodraft_Player'];
				if($Autodraft_Player=="Yes")
				{
					$Players_ID=get_autodraft_playerID($Draft_Teams_ID, $Draft_Round, $Draft_Pick, $LEAGUEID);
				}
				$errors="";

				//Check to see pick will not put team over max roster requirements
				$roster_requirements_array=get_roster_requirements_array($LEAGUEID);
				$players_position_totals=get_players_position_totals_team($Draft_Teams_ID);
				$draft_players_positions_ID=get_players_positions_ID($Players_ID);
				$players_position_totals[$draft_players_positions_ID]++;
				if($players_position_totals[$draft_players_positions_ID] > $roster_requirements_array[$draft_players_positions_ID]['max_players'] && $roster_requirements_array[$draft_players_positions_ID]['max_players']>0)
				{
					$max_allowed=$roster_requirements_array[$draft_players_positions_ID]['max_players'];
					$position_name=get_lineup_position_name($draft_players_positions_ID, "long");
					$errors=$errors."Draft Pick not submitted because you would exceed the maximum number of players for this position.<br>";
					$errors=$errors."$position_name: $max_allowed<br>";
				}

				$sql="select ID from rosters where players_ID='$Players_ID' and leagues_ID=$LEAGUEID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$Players_Data=get_player_data_array($Players_ID);
					$errors="Sorry, {$Players_Data['firstname']} {$Players_Data['lastname']} is not available.<br>";
				}
				$sql="select ID from players where ID='$Players_ID';";
				$rs=$DB->Execute($sql);
				if($rs->EOF)
				{
					$errors="Sorry, this player ID does not exist.<br>";
				}
				if(strlen($errors)<1)
				{
					//Enter Draft Pick
					$sql="insert into rosters (players_ID, current_teams_ID, round, pick, leagues_ID) values ('$Players_ID', '$Draft_Teams_ID', '$Draft_Round', '$Draft_Pick', '$LEAGUEID');";
					$DB->Execute($sql);
					$sql="update draft set players_ID='$Players_ID' where round=$Draft_Round and pick=$Draft_Pick and teams_ID=$Draft_Teams_ID and leagues_ID=$LEAGUEID;";
					$DB->Execute($sql);
				}
				else
				{
					echo "<span class='errors'>$errors</span>";
				}
			}
			else
			{
				//Doesn't have access to enter draft picks
			}
			$draft_html=display_draft($USERSID, $LEAGUEID, $ISADMIN, $Style);
			echo "<div id='Draft_Main_Div' class='Draft_Main_Div'>";
			echo $draft_html;
			echo "</div>";
		break;
		case "player_lookup":
			$Draft_Round=$_REQUEST['Draft_Round'];
			$Draft_Pick=$_REQUEST['Draft_Pick'];
			$Draft_Teams_ID=$_REQUEST['Draft_Teams_ID'];
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_player_lookup($Draft_Round, $Draft_Pick, $Draft_Teams_ID, $Style, $Search_Type, $Search_Position, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "players":
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_players_search($Style, $Search_Type, $Search_Position, $Current_Letter, $OrderBy, $SortBy);
		break;
		case "view_player_detail":
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			$Players_ID=$_REQUEST['Players_ID'];
			if(!($Printable))
			{
				echo "<table border='0' cellpadding='4' cellspacing='3'>";
				echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=players&Current_Letter=$Current_Letter&OrderBy=positionID&SortBy=$NewSort&Search_Type=$Search_Type&Search_Position=$Search_Position&Style=$Style'>".BACK."</a></td></tr>";
				echo "</table>";
			}
			display_player_detail($Players_ID, $LEAGUEID);
		break;
		case "teams":
			$Teams_ID=$_REQUEST['Teams_ID'];
			echo "<table border='0' cellpadding='4' cellspacing='3' width='55%'>";
			echo "<tr><td>";
			display_teams_search($Teams_ID, $Style);
			if(strlen($Teams_ID)>0)
			{
				display_team_roster($Teams_ID, $Style);
			}
			echo "</td></tr></table>";
		break;
		case "draft_order":
				$Round=$_REQUEST['Round'];
				view_draft_order($Round, $Style, $ISADMIN);
		break;
		case "confirm_draft_order":
			if($ISADMIN==1)
			{
				$Round=$_REQUEST['Round'];
				$Teams_Order=$_REQUEST['Teams_Order'];
				foreach($Teams_Order as $key => $val)
				{
					$sql="update draft set teams_ID=$val where leagues_ID=$LEAGUEID and round=$Round and pick=$key;";
					$DB->Execute($sql);
				}
				view_draft_order($Round, $Style, $ISADMIN);
			}
			else
			{
				$draft_html=display_draft($USERSID, $LEAGUEID, $ISADMIN, $Style);
				echo "<div id='Draft_Main_Div' class='Draft_Main_Div'>";
				echo $draft_html;
				echo "</div>";
			}
		break;
		case "confirm_undo_pick":
			if($ISADMIN==1)
			{
				$Draft_Round=$_REQUEST['Draft_Round'];
				$Draft_Pick=$_REQUEST['Draft_Pick'];
				$Draft_Teams_ID=$_REQUEST['Draft_Teams_ID'];
				$Players_ID=$_REQUEST['Players_ID'];
				$sql="delete from rosters where players_ID='$Players_ID' and current_teams_ID=$Draft_Teams_ID and leagues_ID=$LEAGUEID;";
				$DB->Execute($sql);
				$sql="update draft set players_ID=NULL where teams_ID=$Draft_Teams_ID and round=$Draft_Round and pick=$Draft_Pick and leagues_ID=$LEAGUEID;";
				$DB->Execute($sql);
				view_draft_order($Round, $Style, $ISADMIN);
			}
			else
			{
				$draft_html=display_draft($USERSID, $LEAGUEID, $ISADMIN, $Style);
				echo "<div id='Draft_Main_Div' class='Draft_Main_Div'>";
				echo $draft_html;
				echo "</div>";
			}
		break;
		case "player_search_byname":
			$Players_Search_Name=$_REQUEST['Players_Search_Name'];
			$Draft_Round=$_REQUEST['Draft_Round'];
			$Draft_Pick=$_REQUEST['Draft_Pick'];
			$Draft_Teams_ID=$_REQUEST['Draft_Teams_ID'];
			$Search_Type=$_REQUEST['Search_Type'];
			$Search_Position=$_REQUEST['Search_Position'];
			$Current_Letter=$_REQUEST['Current_Letter'];
			$OrderBy=$_REQUEST['OrderBy'];
			$SortBy=$_REQUEST['SortBy'];
			display_player_lookup($Draft_Round, $Draft_Pick, $Draft_Teams_ID, $Style, $Search_Type, $Search_Position, "ALL", $OrderBy, $SortBy, $Players_Search_Name);
		break;
		case "suggest_pick":
			$Draft_Round=$_REQUEST['Draft_Round'];
			$Draft_Pick=$_REQUEST['Draft_Pick'];
			$Draft_Teams_ID=$_REQUEST['Draft_Teams_ID'];
			echo suggest_player($Draft_Round, $Draft_Pick, $Draft_Teams_ID);
		break;
	}
	if(!$ISADMIN && !($IsAjax))
	{
		if($Action=="draft_main" || strlen($Action)<1 || $Action=="draft_home")
		{
			//Update Draft Every 15 seconds
			?><script type="text/javascript">
			setInterval('display_draft_js()',15000);

			function display_draft_js(){
				$.get("<?php echo $PHP_SELF; ?>", { Mode: "<?php echo $Mode; ?>", Action: "<?php echo $Action; ?>", Style: "<?php echo $Style; ?>", IsAjax: "1" },
			    function(data){
			      $("#Draft_Main_Div").html(data);
			    });
			}
			</script><?php
		}
	}
}

?>

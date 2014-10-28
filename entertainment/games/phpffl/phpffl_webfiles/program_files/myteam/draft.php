<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from admin.php
if($Mode=="draft")
{
	Switch($Action)
	{
		case "draft_main":
		default:
			$Position=$_REQUEST['Position'];
			$Page=$_REQUEST['Page'];
			display_draft_myteam_main($Teams_ID, $Page, $Position);
		break;
		case "view_draft_rank":
			$Position=$_REQUEST['Position'];
			$Page=$_REQUEST['Page'];
			display_draft_myteam_main($Teams_ID, $Page, $Position);
		break;
		case "update_draft_rank":
			$Page=$_REQUEST['Page'];
			$Players_ID=$_REQUEST['Players_ID'];
			$Move=$_REQUEST['Move'];
			$Move_Number=$_REQUEST['Move_Number'];
			$max_rank=check_draft_rank_sequence($Teams_ID);
			
			$sql="select rank from draft_rank_teams where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and players_ID='$Players_ID';";
			$rs=$DB->Execute($sql);
			if(!($rs->EOF))
			{
				$current_rank=$rs->fields("rank");
				if($Move=="up")
				{
					$new_rank=$current_rank-$Move_Number;
					if($new_rank<1)
					{
						$new_rank=1;
					}
					
					$sql="select ID, rank from draft_rank_teams where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and rank>=$new_rank and rank<$current_rank order by rank ASC limit 0, $Move_Number;";
					$rank_rs=$DB->Execute($sql);
					while(!($rank_rs->EOF))
					{
						$current_rank_ID=$rank_rs->fields("ID");
						$current_players_rank=$rank_rs->fields("rank");
						$new_players_rank=$current_players_rank+1;
						$sql="update draft_rank_teams set rank=$new_players_rank where ID=$current_rank_ID;";
						$DB->Execute($sql);
						$rank_rs->MoveNext();
					}
					$sql="update draft_rank_teams set rank=$new_rank where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and players_ID='$Players_ID';";
					$DB->Execute($sql);
					
				}
				else
				{	
					$new_rank=$current_rank+$Move_Number;
					if($new_rank>$max_rank)
					{
						$new_rank=$max_rank;
					}
					
					$sql="select ID, rank from draft_rank_teams where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and rank<=$new_rank and rank>$current_rank order by rank ASC limit 0, $Move_Number;";
					$rank_rs=$DB->Execute($sql);
					while(!($rank_rs->EOF))
					{
						$current_rank_ID=$rank_rs->fields("ID");
						$current_players_rank=$rank_rs->fields("rank");
						$new_players_rank=$current_players_rank-1;
						$sql="update draft_rank_teams set rank=$new_players_rank where ID=$current_rank_ID;";
						$DB->Execute($sql);
						$rank_rs->MoveNext();
					}
					$sql="update draft_rank_teams set rank=$new_rank where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID and players_ID='$Players_ID';";
					$DB->Execute($sql);
				}
			}
			
			display_draft_myteam_main($Teams_ID, $Page, "All");
		break;
		case "target_picks_position":
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=draft_main'>".BACK."</a></td></tr>";
			echo "</table>";
			display_target_picks_position($Teams_ID);
		break;
		case "update_target_picks_position":
			$Target_Position=$_REQUEST['Target_Position'];
			if(is_array($Target_Position))
			{
				$sql="delete from draft_teams_target_position where teams_ID=$Teams_ID and leagues_ID=$LEAGUEID;";
				$DB->Execute($sql);
				foreach($Target_Position as $key => $val)
				{
					$sql="select round, pick from draft where ID=$key";
					$draft_rs=$DB->Execute($sql);
					if(!($draft_rs->EOF))
					{
						$current_round=$draft_rs->fields("round");
						$current_pick=$draft_rs->fields("pick");
						$sql="insert into draft_teams_target_position (positions_ID, round, pick, teams_ID, leagues_ID) values ('$val', '$current_round', '$current_pick', '$Teams_ID', '$LEAGUEID');";
						$DB->Execute($sql);
					}
				}
			}
			echo "<table border='0' cellpadding='4' cellspacing='3'>";
			echo "<tr><td colspan='2'><a href='$PHP_SELF?Mode=$Mode&Action=draft_main'>".BACK."</a></td></tr>";
			echo "</table>";
			display_target_picks_position($Teams_ID);
		break;
		case "reset_player_ranking":
			echo SURE_YOU_WANT_TO_RESET_PLAYER_RANKING;
			echo "<br><a href='$PHP_SELF?Mode=$Mode&Action=confirm_reset_player_ranking'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_reset_player_ranking":
			set_team_autorank_players($Teams_ID, $LEAGUEID);
			display_draft_myteam_main($Teams_ID, $Page, $Position);
		break;
	}
}


?>
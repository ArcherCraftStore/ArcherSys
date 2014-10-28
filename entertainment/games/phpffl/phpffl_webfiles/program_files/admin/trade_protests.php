<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="trade_protests" && $ISADMIN==1)
{

	Switch($Action)
	{
		case "trade_protests_main":
		default:
			trade_protests_main();
		break;
		case "approve_protest":
			$Trades_ID=$_REQUEST['Trades_ID'];
			echo SURE_WANT_APPROVE_PROTEST." ".WARNING_APPROVE_PROTEST."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_approve_protest&Trades_ID=$Trades_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=trade_protests_main'>".NO."</a>";
			display_trade_detail($Trades_ID);
			
		break;
		case "confirm_approve_protest":
			$Trades_ID=$_REQUEST['Trades_ID'];
			$sql="update trade_protests set protest_status='Approved' where trades_ID=$Trades_ID;";
			$DB->Execute($sql);
			$sql="select * from trades_teams_players where trades_ID=$Trades_ID;";
			$trades_rs=$DB->Execute($sql);
			while(!($trades_rs->EOF))
			{
				$players_ID=$trades_rs->fields("players_ID");
				$draft_pick_round=$trades_rs->fields("draft_pick_round");
				$draft_pick_teams_ID=$trades_rs->fields("draft_pick_teams_ID");
				$draft_pick_year=$trades_rs->fields("draft_pick_year");
				$teams_trading_ID=$trades_rs->fields("teams_trading_ID");
				$teams_receiving_ID=$trades_rs->fields("teams_receiving_ID");
				if(strlen($players_ID)>0)
				{
					$sql="update rosters set current_teams_ID=$teams_trading_ID where players_ID='$players_ID' and current_teams_ID='$teams_receiving_ID';";
					$DB->Execute($sql);
				}
				else
				{
					$sql="delete from teams_traded_picks where traded_pick_teams_ID=$draft_pick_teams_ID and pick_round=$draft_pick_round and pick_year=$draft_pick_year and leagues_ID=$LEAGUEID;";
					$DB->Execute($sql);
					$sql="insert into teams_traded_picks (traded_pick_teams_ID, current_teams_ID, pick_round, pick_year, leagues_ID) values ('$draft_pick_teams_ID', '$teams_trading_ID', '$draft_pick_round', '$draft_pick_year', '$LEAGUEID');";
					$DB->Execute($sql);
				}
				$trades_rs->MoveNext();
			}
			echo "<span class='thirteen_title'>".TRADE_PROTEST_APPROVED."</span>";
			trade_protests_main();
		break;
		case "reject_protest":
			$Trades_ID=$_REQUEST['Trades_ID'];
			echo SURE_REJECT_PROTEST."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_reject_protest&Trades_ID=$Trades_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=trade_protests_main'>".NO."</a>";
			display_trade_detail($Trades_ID);
			
		break;
		case "confirm_reject_protest":
			$Trades_ID=$_REQUEST['Trades_ID'];
			$sql="update trade_protests set protest_status='Rejected' where trades_ID=$Trades_ID;";
			$DB->Execute($sql);
			echo "<span class='thirteen_title'>".TRADE_PROTEST_REJECTED."</span>";
			trade_protests_main();
		break;
		
	}
}



?>


<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from transactions.php
if($Mode=="trades")
{
	Switch($Action)
	{
		default:
		case "trades_main":
			$Order_By=$_REQUEST['Order_By'];
			display_leagues_trades_main($Order_By);
		break;
		case "protest_trade":
			$Trades_ID=$_REQUEST['Trades_ID'];
			display_protest_trade($Trades_ID);
		break;
		case "confirm_protest_trade":
			$Trades_ID=$_REQUEST['Trades_ID'];
			$Comments=$_REQUEST['Comments'];
			$Comments=nl2br($Comments);
			if(1)
			{
				$Comments=addslashes($Comments);
			}
			$current_date=gmdate("Y-m-d H:i:s");
			$sql="select ID from trade_protests where trades_ID=$Trades_ID and protest_users_ID=$USERSID;";
			$rs=$DB->Execute($sql);
			if($rs->EOF)
			{
				$sql="select teams.ID from users_teams, teams where teams.ID=teams_ID and users_teams.users_ID=$USERSID and leagues_ID=$LEAGUEID;";
				$teams_rs=$DB->Execute($sql);
				if(!($teams_rs->EOF))
				{
					$protest_teams_ID=$teams_rs->fields("ID");
				}
				$sql="insert into trade_protests (trades_ID, protest_users_ID, users_comments, protest_date, protest_teams_ID) values ('$Trades_ID', '$USERSID', '$Comments', '$current_date', '$protest_teams_ID');";
				$DB->Execute($sql);
				echo "<span class='thirteen_title'>".PROTEST_SUBMITTED."</span><br>";
			}
			else
			{
				echo "<span class='thirteen_title'>".PROTEST_ALREADY_SUBMITTED_FOR_THIS_TRADE."</span><br>";
			}
			display_leagues_trades_main();
		break;
	}
}


?>
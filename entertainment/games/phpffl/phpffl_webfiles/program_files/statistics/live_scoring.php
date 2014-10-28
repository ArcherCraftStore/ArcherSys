<?php

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="live_scoring")
{

	Switch($Action)
	{
		case "live_scoring_main":
		default:
			$Week_ID=$_REQUEST['Week_ID'];
			if(strlen($Week_ID)<1)
			{
				$Week_ID=get_current_week(-24);
			}
			if(!($IsAjax))
			{
				echo "<div id='Live_Scoring_Main_Div' class='Live_Scoring_Main_Div'>";
			}
			$live_scoring_html=display_live_scoring_main($Week_ID);
			echo $live_scoring_html;
			if(!($IsAjax))
			{
				echo "</div>";
			}

			if(!($IsAjax))
			{
				//Update Live Scoring Every 60 Seconds
				?><script type="text/javascript">
				setInterval('display_live_scoring_main_js()',60000);

				function display_live_scoring_main_js(){
					$.get("<?php echo $PHP_SELF; ?>", { Mode: "<?php echo $Mode; ?>", Action: "<?php echo $Action; ?>", Week_ID: "<?php echo $Week_ID; ?>", IsAjax: "1" },
				    function(data){
				      $("#Live_Scoring_Main_Div").html(data);
				    });
				}
				</script><?php
			}
		break;
		case "display_game_detail":
			$Team1_ID=$_REQUEST['Team1_ID'];
			$Team2_ID=$_REQUEST['Team2_ID'];
			$Leagues_ID=$_REQUEST['Leagues_ID'];
			$Week_ID=$_REQUEST['Week_ID'];
			if(!($IsAjax))
			{
				echo "<table>";
				echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=live_scoring_main&Week_ID=$Week_ID'>".BACK."</a></td></tr>";
				echo "</table>";
				echo "<br>";
				echo "<div id='Live_Scoring_Game_Div' class='Live_Scoring_Game_Div'>";
			}
			$live_scoring_game_html=display_game_detail($Team1_ID, $Team2_ID, $Leagues_ID, $Week_ID);
			echo $live_scoring_game_html;
			if(!($IsAjax))
			{
				echo "</div>";
			}

			if(!($IsAjax))
			{
				//Update Live Scoring Every 60 Seconds
				?><script type="text/javascript">
				setInterval('display_game_detail_js()',60000);

				function display_game_detail_js(){
					$.get("<?php echo $PHP_SELF; ?>", { Mode: "<?php echo $Mode; ?>", Action: "<?php echo $Action; ?>", Week_ID: "<?php echo $Week_ID; ?>", Team1_ID: "<?php echo $Team1_ID; ?>", Team2_ID: "<?php echo $Team2_ID; ?>", Leagues_ID: "<?php echo $Leagues_ID; ?>", IsAjax: "1" },
				    function(data){
				      $("#Live_Scoring_Game_Div").html(data);
				    });
				}

				</script><?php
			}
		break;
		case "display_team_detail":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Week_ID=$_REQUEST['Week_ID'];
			echo "<table>";
			echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=live_scoring_main&Week_ID=$Week_ID'>".BACK."</a></td></tr>";
			echo "</table>";
			echo "<br>";
			display_team_detail($Teams_ID);
		break;
		case "view_player_detail":
			$Week_ID=$_REQUEST['Week_ID'];
			$Players_ID=$_REQUEST['Players_ID'];
			if(!($Printable))
			{
				echo "<table>";
				echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Action=live_scoring_main&Week_ID=$Week_ID'>".BACK."</a></td></tr>";
				echo "</table>";
				echo "<br>";
			}
			display_player_detail($Players_ID, $LEAGUEID);
		break;
	}
}


?>
<?php

if(!(defined('PHPFFL_FILE_ROOT')))
{
	die("");
}

$Mode=$_REQUEST['Mode'];

$sajax_request_type = "GET";
sajax_init();
sajax_export("undoLastPick");
sajax_export("adminAutoDraft");
sajax_export("resetDraft");
sajax_export("ssSuggestPlayer");
sajax_export("unexcludePlayer");
sajax_export("searchPlayers");
sajax_export("excludePlayer");

sajax_handle_client_request();
?>
<html>
<head>
 <LINK REL=StyleSheet HREF="<?php echo $PHPFFL_WEB_ROOT;?>css/draft.css" TYPE="text/css" MEDIA=screen>
<title>PHPFFL Live Draft Administration</title>


<script>

<?php
sajax_show_javascript();

?>

function playerSearch(){
	leagueid = document.getElementById('leagues_id').value;
	var search = document.getElementById("searchPlayer").value;
	x_searchPlayers(leagueid,search,playerSearch_cb);
}

function playerSearch_cb(data){
	document.getElementById("playerListDiv").innerHTML = data;
}

function undoPick(){

    document.getElementById("undoPickDiv").innerHTML = "(loading...)";
	leagueid = document.getElementById('leagues_id').value;
	x_undoLastPick(leagueid,undoPick_cb);
}

function undoPick_cb(data){
	document.getElementById("undoPickDiv").innerHTML = data;
}

function autoDraft(){
	document.getElementById("autoDraftDiv").innerHTML = "(loading...)";
	leagueid = document.getElementById('leagues_id').value;
	x_adminAutoDraft(leagueid,autoDraft_cb);
}

function autoDraft_cb(data){
	document.getElementById("autoDraftDiv").innerHTML = "(Pick Autodrafted)";
}

function resetDraft(){
	document.getElementById("resetDraftDiv").innerHTML = "(loading...)";
	leagueid = document.getElementById('leagues_id').value;
	x_resetDraft(leagueid,resetDraft_cb);
}

function resetDraft_cb(data){
	document.getElementById("resetDraftDiv").innerHTML = data;
}

function unexcludePlayer(playerid){
	document.getElementById("excludedPlayersDiv").innerHTML = "(loading...)";
	leagueid = document.getElementById('leagues_id').value;
	x_unexcludePlayer(leagueid,playerid,unexcludePlayer_cb);
}

function unexcludePlayer_cb(data){
	document.getElementById("excludedPlayersDiv").innerHTML = data;
}


function excludePlayer(playerid){
	leagueid = document.getElementById('leagues_id').value;
	document.getElementById("playerListDiv").innerHTML = "loading";
	x_excludePlayer(leagueid,playerid,excludePlayer_cb);
	unexcludePlayer(0);
}

function excludePlayer_cb(data){
	document.getElementById("playerListDiv").innerHTML = data;
}


</script>
</head>
<body>
<strong>phpFFL Draft Adminstration</strong>- <a href="<?php echo "{$PHPFFL_WEB_ROOT}livedraft.php";?>">Back To Draft</a><br><br>
<?php
echo "<input type='hidden' id='leagues_id' value='$LEAGUEID' />";
echo "<a onClick='undoPick($LEAGUEID)'><img src='{$PHPFFL_IMAGE_PATH}undo_last_pick.gif' border='0'/></a><br>";
echo "<div id='undoPickDiv'></div><br>";
echo "<br><br>";
echo "<a onClick='autoDraft()'><img src='{$PHPFFL_IMAGE_PATH}autodraft_current_pick.gif' border='0'/></a><br>";
echo "<div id='autoDraftDiv'></div>";
echo "<br><br><br>";
echo "<strong>Search for player to make undraftable.</strong><br>Last Name: <input type='text' id='searchPlayer'>" .
     "&nbsp;<a onClick='playerSearch()'><img src='{$PHPFFL_IMAGE_PATH}draft_search.gif' border='0' ALIGN='top'/></a><br><br>";
echo "<div id='playerListDiv'></div>";
echo "<br><br><br>";

echo "<div id='excludedPlayersDiv'>" . excludedPlayers($LEAGUEID) . "</div>";

echo "<br><br><br>";
echo "<a onClick='resetDraft()'><img src='{$PHPFFL_IMAGE_PATH}reset_the_draft.gif' border='0'/></a><br>";
echo "<div id='resetDraftDiv'></div>";

?>

</body></html>



<?php

if(!(defined('PHPFFL_FILE_ROOT')))
{
	die("");
}
$Mode=$_REQUEST['Mode'];

$sajax_request_type = "GET";
sajax_init();
sajax_export("ssRefreshPlayerList");
sajax_export("ssProcessDraftPick");
sajax_export("ssChat");
sajax_export("ssGetUpdate");
sajax_export("ssGetRoster");
sajax_export("ssStartDraft");
sajax_export("ssSuggestPlayer");
sajax_export("ssAutoDraft");

if($ISADMIN)
{
	sajax_export("undoLastPick");
	sajax_export("adminAutoDraft");
	sajax_export("resetDraft");
	sajax_export("unexcludePlayer");
	sajax_export("searchPlayers");
	sajax_export("excludePlayer");
}

sajax_handle_client_request();

?>
<html>
<head>
 <LINK REL=StyleSheet HREF="<?php echo $PHPFFL_WEB_ROOT;?>css/draft.css" TYPE="text/css" MEDIA=screen>
<title>PHPFFL Live Draft</title>


<script>

<?php
sajax_show_javascript();

?>

function refreshPlayerList_cb(data){
    document.getElementById("availPlayersdiv").innerHTML = data;
    showRoster();
}

function processDraftPick_cb(data){
  if (data != "1"){ }
  return 1;
}

function refreshPlayerList(){
   document.getElementById("availPlayersdiv").innerHTML = "(loading...)";
   leagueid = document.getElementById('leagues_id').value;
   teamid = document.getElementById("chatteamid").value;
   filter=document.getElementById("chooseList").value;
   sort = document.getElementById("orderby").value;
   x_ssRefreshPlayerList(filter,sort,leagueid,teamid,refreshPlayerList_cb)
}

function showRoster(){
	var selectid = document.getElementById("viewrosterselect").value;
	var leagueid = document.getElementById('leagues_id').value;
	if (selectid == ""){
		document.getElementById("rostersdiv").innerHTML="";
	}
	else {
		x_ssGetRoster(selectid,leagueid,showRoster_cb);
	}
	selectid=null;
	leagueid=null;

}

function showRoster_cb(data){
	document.getElementById("rostersdiv").innerHTML=data;
}

function getUpdates_cb(data){
   var updaterosterview = 0;
     //document.getElementById("chatDisplaydiv").innerHTML = "callback\n" + document.getElementById("chatDisplaydiv").innerHTML;
	var reg1 = /#!!#/;
	var records = data.split(reg1);
	data=null;
	reg1=null;
	var parts;
	var autodraft="no";
	var reset="no";
	for (i=0; i<records.length; i++){
		var reg2 = /#--#/;
		parts = records[i].split(reg2);
		reg2=null;
		if (parts[0] == "Chat"){
			document.getElementById("chatDisplaydiv").innerHTML =  "<font color='blue'>" + parts[1] + "</font><br>" + document.getElementById("chatDisplaydiv").innerHTML;
		}
		if (parts[0] == "logid"){
		    var dlid = document.getElementById("draft_log_id");
			dlid.value = parts[1];
			dlid=null;
		}
		if (parts[0] == "time"){
			var t = document.getElementById("time");
			var timeleft=parts[1];
			if(timeleft<0)
			{
				timeleft=0;
			}
			t.innerHTML = timeleft;
			t=null;
		}
		if (parts[0] == "reset"){
			reset=="yes";
		}
		if (parts[0] == "Draft"){
			var playerparts = parts[1].split("-");
			var teamid=playerparts[0];
			var playerid=playerparts[1];
			var playername=playerparts[2];
			if(document.getElementById("viewrosterselect").value==teamid){
				updaterosterview=1;
			}
			var teamname = document.getElementById("draftlist_" + teamid).innerHTML;
			try {
			removePlayer(playerid);
			} catch(error){
				// get an error if player was already removed, should be safe to ignore
			}
			document.getElementById("chatDisplaydiv").innerHTML = "<font color='red'>" + teamname + " drafted " + playername + "</font><br>" + document.getElementById("chatDisplaydiv").innerHTML;
			teamname=null;
		}
		if (parts[0] == "Trade"){
			showRoster();
		}
		if (parts[0] == "NextPick"){
			if (parts[1] == 'Draft Completed'){
				document.getElementById("pickteam").value="-1";
				document.getElementById("picknumberdiv").innerHTML = "Over";
				document.getElementById("pickrounddiv").innerHTML = "Draft";
				document.getElementById("draftlink").innerHTML = '';
			}
		   else {
				try {
					var reg3 = /\,/;

					var pickparts = parts[1].split(reg3);

					document.getElementById("picknumber").value=pickparts[0];
					document.getElementById("pickround").value=pickparts[1];
					document.getElementById("pickteam").value=pickparts[2];
					document.getElementById("picknumberdiv").innerHTML = "Pick " + pickparts[0];
					document.getElementById("pickrounddiv").innerHTML = "Round " + pickparts[1];
					var re = new RegExp(" " + pickparts[2]+ " ");

					if(document.getElementById("team_ids").value.search(re) != -1){

						var selectbox = document.getElementById("userModeSelect");

						if (selectbox.value == "Away / Autodraft"){
							autodraft="yes";
						}
						document.getElementById("draftlink").innerHTML = "<a onClick='draftPlayer()'><img src='draft.png'></a>";
						document.getElementById("draftnowdiv").innerHTML = "<center>DRAFT<BR>NOW!!!</center>";
					}
					else {
						document.getElementById("draftlink").innerHTML = '';
						document.getElementById("draftnowdiv").innerHTML='';
					}
					re = null;
					var draftlist = document.getElementById("draftOrderList");
					var j=0;
					for(j=0; j<draftlist.childNodes.length; j++){
						var reglist = /draftlist/;
						if (reglist.test(draftlist.childNodes[j].id)){
							draftlist.childNodes[j].style.color='black';
						}
					}
					draftlist=null;
					document.getElementById("draftlist_" + pickparts[2]).style.color='red';
				} catch(error) {
					//alert(error.name + ":" + error.message);
				}
			}
			showRoster();
		}

	}
	if (updaterosterview==1){
		showRoster();
	}
	parts=null;
	records=null;
   var upd = document.getElementById("updaterunning");
   upd.value = "0";
   upd=null;

	if (autodraft=="yes"){

		autoDraft();
	}
	if (reset=="yes"){
		refreshPlayerList();
	}
}




function getUpdates(){
	if (document.getElementById("updaterunning").value == "0"){
		document.getElementById("updaterunning").value = "1";
		x_ssGetUpdate(document.getElementById('draft_log_id').value,document.getElementById('leagues_id').value,document.getElementById('pickround').value,document.getElementById('picknumber').value,document.getElementById('pickteam').value,getUpdates_cb);

	}
}

function removePlayer(id){
   tr = document.getElementById(id);
   tr.parentNode.removeChild(tr);
   // Another Player may have this player in the draft box.  Make sure to remove
   if (document.getElementById("selectPlayerId").value == id){
		document.getElementById("selectPlayerId").value = '';
		document.getElementById("selectPlayer").value = '';
	}
	//tr=null;

}
function startDraft(){
	x_ssStartDraft(document.getElementById('leagues_id').value,startDraft_cb);
}
function startDraft_cb(data){
	return 1;
}

function suggestPlayer(){

	leagueid = document.getElementById('leagues_id').value;
	teamid=document.getElementById("pickteam").value;
	x_ssSuggestPlayer(teamid,leagueid,suggestPlayer_cb);

}

function suggestPlayer_cb(data){
	// data contains the player id so just simulate clicking on the suggested player
	clickPlayer(data);
}

function autoDraft(){
	teamid=document.getElementById("pickteam").value;
	leagueid = document.getElementById('leagues_id').value;
	round=document.getElementById("pickround").value;
    pick=document.getElementById("picknumber").value;

	x_ssAutoDraft(leagueid,teamid,round,pick,autoDraft_cb);
}

function autoDraft_cb(data){

}


function draftPlayer(){
   selectedPlayer = document.getElementById("selectPlayer");
   selectedPlayerID = document.getElementById("selectPlayerId");
   leagueid = document.getElementById('leagues_id').value;
   playerid=selectedPlayerID.value;
   if (playerid != ''){
   selectedPlayer.value = '';
   selectedPlayerID.value='';
   teamid=document.getElementById("pickteam").value;
   round=document.getElementById("pickround").value;
   pick=document.getElementById("picknumber").value;
   //document.getElementById("draftlink").innerHTML = '';
   x_ssProcessDraftPick(playerid,teamid,round,pick,leagueid,processDraftPick_cb);
	}
}

function chat_cb(data){
   //document.getElementById("chatDisplaydiv").innerHTML = data + document.getElementById("chatDisplaydiv").innerHTML;
    document.getElementById('chat').value = "";
}

function chat(){
	chattext = document.getElementById('chat').value;
    chatteam = document.getElementById('chatteamid').value;
	leagueid = document.getElementById('leagues_id').value;
	//document.getElementById("chatDisplaydiv").innerHTML = chattext + "<br>" + document.getElementById("chatDisplaydiv").innerHTML;
	x_ssChat(chatteam,chattext,leagueid,chat_cb);
}


function clickPlayer(id){
tr = document.getElementById(id);
select = document.getElementById("selectPlayer");
selectid = document.getElementById("selectPlayerId");

select.value = tr.cells[0].firstChild.innerHTML + "     " + tr.cells[1].innerHTML + "     " + tr.cells[2].innerHTML;

selectid.value = id;

}
<?php
if($ISADMIN)
{
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

function admin_autoDraft(){
	document.getElementById("autoDraftDiv").innerHTML = "(loading...)";
	leagueid = document.getElementById('leagues_id').value;
	x_adminAutoDraft(leagueid,admin_autoDraft_cb);
}

function admin_autoDraft_cb(data){
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

<?php
}
?>
</script>
</head>
<body onload="setInterval(getUpdates,1000)">

<?php


$select = "select max(id) as id from draft_log where leagues_id=$LEAGUEID";
$rs=$DB->Execute($select);
if(!($rs->EOF))
{
	$draft_log_id=$rs->fields("id");
}
if ($draft_log_id==''){
	$draft_log_id='0';
}
echo "<input type='hidden' id='draft_log_id' value='$draft_log_id'>";
echo "<input type='hidden' id='leagues_id' value='$LEAGUEID'>";
echo "<input type='hidden' id='users_id' value='$USERSID'>";

$select="select teams_ID from users_teams, teams where users_ID=$USERSID and teams_ID=teams.ID and leagues_ID=$LEAGUEID";
$rs=$DB->Execute($select);
$teamid='';
$teamids = " ";
while(!($rs->EOF)){
	$teamid=$rs->fields("teams_ID");
	$rs->MoveNext();
	$teamids .= "$teamid ";
	//$i++;
}

echo "<input type='hidden' id='team_ids' value='$teamids'>";
// Just taking the last team for chat use in case of multiple teams
echo "<input type='hidden' id='chatteamid' value='$teamid'>";

?>

<div id='searchPlayersdiv'>

<select id='chooseList' onchange="refreshPlayerList();" class="pos">
<option value='all' selected>All Available Players</option>

<?php

$select="select distinct players_positionid from positions p ,starting_lineup_requirements slr
                     where slr.positions_id=p.id and slr.leagues_id=$LEAGUEID";


$rs=$DB->Execute($select);
$used_position_array=array();
while(!($rs->EOF)){
  $playersposid	= $rs->fields("players_positionid");
  $rs->MoveNext();
  $indpos = split(':',$playersposid);
  foreach($indpos as $pos){
  	if(!(in_array($pos, $used_position_array)))
	{
  		$used_position_array[]=$pos;
		echo "<option value='$pos'>$pos</option>";
	}
  }
}

?>
</select>
<select id='orderby' onchange="refreshPlayerList();" class="sort">
<option id='lastname' value='lastname'>Alphabetical</option>
<option id='rank' value='rank'>Rank</option>
</select>
</div>
<div id='availPlayersdiv'>
<table>
<?php

$playerlist = ssRefreshPlayerList('all','lastname',$LEAGUEID,$teamid);
echo "$playerlist";

?>
</table>
</div>
<div id='selectPlayerdiv'>
   <input type='text' onkeydown='blur()' id='selectPlayer'></input>
   <input type='hidden' id='selectPlayerId'></input>
   <br>
   <div id='draftlink'></div>
   <div id="suggestPlayerdiv">
         <a onClick='suggestPlayer()'><img src='<?php echo "{$PHPFFL_IMAGE_PATH}draft_get_suggestion.gif";?>' border='0'/></a><br></div>
         <br><div id="userMode">
	       My Status: <select id="userModeSelect">
		            <option value="Active" selected>Active</option>
		            <option value="Away / Autodraft">Away / Autodraft</option>
	                </select>
         </div>

</div>



<div id='leftborderdiv'>

<div id='clock'>

<?php

$pickstring = ssFindNextDraftPick("initialize",$LEAGUEID);
$pickinfo =split(',',$pickstring);
echo"<input type='hidden' id='picknumber' value='$pickinfo[0]'>";
echo"<input type='hidden' id='pickround' value='$pickinfo[1]'>";
echo"<input type='hidden' id='pickteam' value='$pickinfo[2]'>";
echo"<input type='hidden' id='updaterunning' value='0'>";
echo"<div id='pickrounddiv'>Round $pickinfo[1]</div>";
echo"<div id='picknumberdiv'>Pick $pickinfo[0]</div>";


?>

<div id='time'>Off</div>
</div>

<div id='draftOrderdiv'>
<ul id='draftOrderList'>

<?php

$select="select team_name, id from teams where leagues_id=$LEAGUEID
                           order by team_name";

$rs=$DB->Execute($select);
echo "<font color='white'>League Teams</font><br>";
while(!($rs->EOF)){
   $teamname=$rs->fields("team_name");
   $teamname=substr($teamname,0,12);
   $teamid = $rs->fields("id");
   echo"<li id='draftlist_$teamid'>$teamname</li>";
	$rs->MoveNext();
}
?>

</ul>
</div>


</div>


<div id='rostersSelectdiv'>
Info: <select id='viewrosterselect' onchange='showRoster()'>
<?php
$select = "select teams.team_name, teams.id from teams where teams.leagues_id=$LEAGUEID order by teams.team_name";
$rs=$DB->Execute($select);
while(!($rs->EOF)){
	$teamname=$rs->fields("team_name");
	$teamid=$rs->fields("id");
	$rs->MoveNext();
	echo"<option value='$teamid'>$teamname</option>";
}
$select = "select draft_length_rounds from leagues where id=$LEAGUEID";
$rs=$DB->Execute($select);
$numrounds=$rs->fields("draft_length_rounds");
for ($i=1; $i<=$numrounds; $i++){
	$selected="";
	if ($i==1){
		$selected = "selected";
	}
	echo"<option value='_round$i' $selected>Round $i</option>";
}
echo "<option value='_last'>Last 20</option>";
echo "<option value='_next'>Next 20</option>";


?>
</select>
</div>
<div id='rostersdiv'>
</div>
<div id='chatDisplaydiv'>
</div>
<div id='chatboxdiv'>
  <input type='text' id='chat'></input><a onclick='chat()'><img src='<?php echo $PHPFFL_WEB_ROOT;?>images/chat.png'></a>
</div>
<div id='queuediv'>
  <div id='queuelistdiv'>
  </div>
</div>
<div id='logodiv'>
<img src='<?php echo $PHPFFL_WEB_ROOT;?>images/phpffl_280.jpg'>
</div>
<div id='draftnowdiv'>
<?php
$select = "select users_id from admin_users_leagues where leagues_id=$LEAGUEID and users_id=$USERSID";
$rs=$DB->Execute($select);
if (!($rs->EOF)){
	// admin
	$select = "select draftlive from draft_status where leagues_id=$LEAGUEID";
	$rs2=$DB->Execute($select);
	$draftlive=$rs2->fields("draftlive");
	if ($draftlive == 0){
		echo "<a onclick='startDraft()'><img src='{$PHPFFL_WEB_ROOT}images/start.png'></a>";
	}
}
?>
</div>
<?php
if ($ISADMIN){

echo "<br><div id ='adminarea'>";
echo "<table width='100%'>";
echo "<tr><td><span class='main_title'>phpFFL Draft Adminstration</span></td></tr>";
echo "<tr class='tablerowline'><td height='4'></td></tr>";
echo "</table>";
echo "<table width='100%'>";
echo "<tr valign='top'>";
echo "<td width='210' align='left'><a onClick='undoPick($LEAGUEID)'><img src='{$PHPFFL_IMAGE_PATH}undo_last_pick.gif' border='0'/></a><br><div id='undoPickDiv'></div></td>";
echo "<td width='200'><a onClick='admin_autoDraft()'><img src='{$PHPFFL_IMAGE_PATH}autodraft_current_pick.gif' border='0'/></a><br><div id='autoDraftDiv'></div></td>";
echo "<td align='right'><a onClick='resetDraft()'><img src='{$PHPFFL_IMAGE_PATH}reset_the_draft.gif' border='0'/></a><br><div id='resetDraftDiv'></div></td>";
echo "</tr>";
echo "</table>";
echo "<br>";
echo "<span class='thirteen_title'>Search for player to make undraftable.</span><br><strong>Last Name:</strong> <input type='text' id='searchPlayer'>" .
     "&nbsp;<a onClick='playerSearch()'><img src='{$PHPFFL_IMAGE_PATH}draft_search.gif' border='0' ALIGN='top'/></a><br><br>";
echo "<div id='playerListDiv'></div>";
echo "<br><br><br>";

echo "<div id='excludedPlayersDiv'>" . excludedPlayers($LEAGUEID) . "</div>";

echo "</div>";
}
?>
</body>
</html>
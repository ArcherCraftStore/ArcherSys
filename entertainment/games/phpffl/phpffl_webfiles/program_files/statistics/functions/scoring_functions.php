<?php 

function display_league_scoring($Position_Description="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_IMAGE_PATH;
	
	if(strlen($Position_Description)<1)
	{
		$Position_Description="All";
	}
	$sql="select distinct(position_description) from scoring_categories order by position_description ASC;";
	$description_rs=$DB->Execute($sql);
	
	$sql="select distinct(scoring_categories_ID) as category_ID from scoring_categories_leagues_values where leagues_ID=$LEAGUEID";
	$rs=$DB->Execute($sql);
	$current_scoring_categories[]="";
	while(!($rs->EOF))
	{
		$categories_ID=$rs->fields("category_ID");
		$current_scoring_categories[]=$categories_ID;
		$rs->MoveNext();
	}
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr>";
	echo "<td><span class='table_row_title'>".POSITION.": </span></td>";
	echo "<td>";
	echo "<select name='Position_Description'>";
	$s="";
	if($Position_Description=="")
	{
		$s="selected";
	}
	echo "<option value='All' $s>".ALL."</option>";
	while(!($description_rs->EOF))
	{
		$current_position_description=$description_rs->fields("position_description");
		$s="";
		if($current_position_description==$Position_Description)
			$s="selected";
		$sql="select scoring_categories_ID from scoring_categories, scoring_categories_leagues_values where position_description='$current_position_description' and scoring_categories.ID=scoring_categories_ID and leagues_ID=$LEAGUEID;";
		$scoring_rs=$DB->Execute($sql);
		if(!($scoring_rs->EOF))
		{
			echo "<option value='$current_position_description' $s>$current_position_description</option>";
		}
		$description_rs->MoveNext();
	}
	echo "</select>";
	echo "</td>";
	echo "<td><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td>";
	echo "<td rowspan='2' valign='top'><a href='$PHP_SELF?Mode=$Mode&Action=scoring_main&Position_Description=$Position_Description&Printable=1' target='_blank'><img src='{$PHPFFL_IMAGE_PATH}printable.gif' /></a></td>";
	echo "</tr>";
	echo "<input type='hidden' name='Action' value='scoring_main'>";
	echo "<input type='hidden' name='Mode' value='$Mode'>";
	echo "</form>";
	echo "</table>";
	
	if($Position_Description=="All")
	{
		$sql="select distinct(position_description) from scoring_categories, scoring_categories_leagues_values where scoring_categories.ID=scoring_categories_ID and scoring_categories_leagues_values.leagues_ID=$LEAGUEID order by position_description ASC;";
		$scoring_rs=$DB->Execute($sql);
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='4'><span class='table_row_title'>".SCORING."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		while(!($scoring_rs->EOF))
		{
			$current_position_description=$scoring_rs->fields("position_description");
			$sql="select distinct(scoring_categories.ID) from scoring_categories, scoring_categories_leagues_values where position_description='$current_position_description' and scoring_categories.ID=scoring_categories_ID and leagues_ID=$LEAGUEID order by display_order ASC";
			$category_rs=$DB->Execute($sql);
			
			
			while(!($category_rs->EOF))
			{
				$categories_ID=$category_rs->fields("ID");
				display_scoring_category_detail($categories_ID, $LEAGUEID, $current_position_description, "table_row_title");
				$category_rs->MoveNext();
			}
			$scoring_rs->MoveNext();
		}
		echo "</table>";
	}
	else
	{
		$sql="select distinct(scoring_categories.ID) from scoring_categories, scoring_categories_leagues_values where position_description='$Position_Description' and scoring_categories.ID=scoring_categories_ID and leagues_ID=$LEAGUEID order by display_order ASC";
		$rs=$DB->Execute($sql);
		echo "<table border='0' cellpadding='4' cellspacing='3'>";
		echo "<tr><td colspan='4'><span class='table_row_title'>".SCORING."</span></td></tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='4'></td></tr>";
		while(!($rs->EOF))
		{
			$categories_ID=$rs->fields("ID");
			display_scoring_category_detail($categories_ID, $LEAGUEID, $Position_Description, "table_row_title");
			$rs->MoveNext();
		}
		echo "</table>";
	}



}


function display_scoring_category_detail($categories_ID, $leagues_ID, $Position_Description, $title_style="",  $style="")
{
	global $PHP_SELF, $DB, $Mode;
	
	if(strlen($style)<1)
	$sql="select * from scoring_categories where ID=$categories_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$category_title=$rs->fields("category_title");
		$category_type=$rs->fields("category_type");
		$category_description=$rs->fields("category_description");
	}
	$sql="select * from scoring_categories_leagues_values where scoring_categories_ID=$categories_ID and leagues_ID=$leagues_ID order by is_repeating ASC, value ASC, points ASC";
	$rs=$DB->Execute($sql);
	if($category_type=="Value")
	{
		$current_points=$rs->fields("points");
		if($current_points==1)
			$current_points=$current_points." ".POINT;
		else
			$current_points=$current_points." ".POINTS;
		echo "<tr>";
		echo "<td><span class='$title_style'>$category_title</span></td>";
		echo "<td><span class='$style'>$current_points</span></td>";
		echo "</tr>";
	}
	elseif($category_type=="Range")
	{
		echo "<tr><td><span class='$title_style'>$category_title</span></td>";
		echo "<td></td>";
		echo "</tr>";
		$previous_value=0;
		$bg="";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$current_value=$rs->fields("value");
			$current_points=$rs->fields("points");
			$is_repeating=$rs->fields("is_repeating");
			if($current_points==1)
				$current_points=$current_points." ".POINT;
			else
				$current_points=$current_points." ".POINTS;
			if(!$is_repeating)
			{
				echo "<tr bgcolor='$bg'>";
				echo "<td><span class='$style'>$previous_value - $current_value $category_description</span></td>";
				echo "<td colspan='3'><span class='$style'>$current_points</span></td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr bgcolor='$bg'>";
				echo "<td><span class='$style'>".EVERY_ADDITIONAL." $current_value $category_description</span></td>";
				echo "<td><span class='$style'>$current_points</span></td>";
				echo "</tr>";
			}
			$previous_value=$current_value+1;
			$rs->MoveNext();
		}
	}
}


?>

<?php 

function display_faq($Category_ID)
{
	global $PHP_SELF, $DB, $Mode;
	
	
	$sql="select category_name_english from faq_categories where ID=$Category_ID;";
	$rs=$DB->Execute($sql);
	$Category_Name=$rs->fields("category_name_english");
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td><span class='main_title'>$Category_Name</span></td></tr>";
	$sql="select * from faq_items where faq_categories_ID=$Category_ID order by display_order ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$items_ID=$rs->fields("ID");
		$items_title_english=$rs->fields("title_english");
		
		echo "<tr><td><a href='$PHP_SELF?Mode=$Mode&Category_ID=$Category_ID#$items_ID' class='table_row_title'>$items_title_english</a></td></tr>";
		$rs->MoveNext();
	}
	echo "<tr><td>&nbsp;</td></tr>";
	$rs->MoveFirst();
	while(!($rs->EOF))
	{
		$items_ID=$rs->fields("ID");
		$items_title_english=$rs->fields("title_english");
		$items_description=$rs->fields("description_english");
		$items_description=nl2br($items_description);
		echo "<tr><td><a name='$items_ID'><span class='table_row_title'>$items_title_english</span></a></td></tr>";
		echo "<tr><td>$items_description</td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		$rs->MoveNext();
	}
	echo "</table>";

}

?>

<?php

function custom_pages_main()
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;
	
	echo "<table border='0' cellpadding='4' cellspacing='3'>";
	echo "<tr><td colspan='5'><a href='$PHP_SELF?Mode=$Mode&Action=add_new_page'>".ADD_NEW_PAGE."</a>&nbsp;&nbsp;";
	echo "&nbsp;&nbsp;<a href='$PHP_SELF?Mode=$Mode&Action=add_new_link'>".ADD_NEW_LINK."</a></td></tr>";
	echo "<tr><td colspan='5'>&nbsp;</td></tr>";
	$sql="select ID, title, is_link, display_order, default_login_page from custom_pages where leagues_ID=$LEAGUEID order by display_order ASC;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr>";
		echo "<td><span class='table_row_title'>".TITLE."</span></td>";
		echo "<td><span class='table_row_title'>".TYPE."</span></td>";
		echo "<td></td><td></td><td><span class='table_row_title'>".DISPLAY_ORDER."</span></td><td><span class='table_row_title'>".DEFAULT_LOGIN_PAGE."</span></td>";
		echo "</tr>";
		echo "<tr class='tablerowline' height='8'><td colspan='6'></td></tr>";
		while(!($rs->EOF))
		{
			$bg=get_row_bg($bg);
			$pages_ID=$rs->fields("ID");
			$pages_title=$rs->fields("title");
			$pages_islink=$rs->fields("is_link");
			$pages_display_order=$rs->fields("display_order");
			$pages_type=CONTENT;
			$pages_default_login_page=$rs->fields("default_login_page");
			if($pages_islink==1)
			{
				$pages_type=LINK;
			}
			echo "<tr bgcolor='$bg'>";
			echo "<td>$pages_title</td>";
			echo "<td>$pages_type</td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=edit_custom_page&Pages_ID=$pages_ID'>".EDIT."</a></td>";
			echo "<td><a href='$PHP_SELF?Mode=$Mode&Action=delete_custom_page&Pages_ID=$pages_ID'>".DELETE."</a></td>";
			echo "<td><input type='text' name='Display_Order[$pages_ID]' value='$pages_display_order' size='2'></td>";
			$s="";
			if($pages_default_login_page==1)
				$s="checked=checked";
			echo "<td><input type='radio' name='Default_Login_Page' value='$pages_ID' $s></td>";
			echo "</tr>";
			$rs->MoveNext();
		}
		echo "<tr><td colspan='5'></td><td><input type='radio' name='Default_Login_Page' value='0'> ".NONE."</td></tr>";
		echo "<tr><td colspan='6'><input type='Submit' name='Submit' value='".UPDATE_CUSTOM_PAGES."'></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Action' value='update_custom_display_order'>";
		echo "</form>";
	}
	else
	{
		echo "<tr><td colspan='5'><span class='table_row_title'>".NO_CUSTOM_PAGES_EXIST_FOR_THIS_LEAGUE."</span></td></tr>";
	}
	
	echo "</table>";
}

function display_add_new_page($Page_Title="", $Page_Content="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT;

	echo "<table width='100%'>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_PAGE."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td width='20'><span class='table_row_title'>".PAGE_TITLE."</span></td><td><input type=\"text\" name=\"Page_Title\" value=\"$Page_Title\"></td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td colspan='2'>";
	$oFCKeditor = new FCKeditor('FCKeditor1') ;
	$oFCKeditor->BasePath	= "{$PHPFFL_WEB_ROOT}program_files/FCKeditor/" ;
	$oFCKeditor->Value		= $Page_Content;
	$oFCKeditor->Width = "100%";  
	$oFCKeditor->Height = 800; 

	$oFCKeditor->Create() ;
	echo "</td></tr>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_page'>";
	echo "</form></table>";	
}
function display_add_new_link($Link_Title="", $Link="", $New_Window="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID;

	echo "<table>";
	echo "<form method='post' action='$PHP_SELF?'>";
	echo "<tr><span class='main_title'>".ADD_NEW_LINK."</td></tr>";
	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
	echo "<tr><td><span class='table_row_title'>".LINK_TITLE."</span></td><td><input type=\"text\" name=\"Link_Title\" value=\"$Link_Title\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".LINK." (".ENTER_FULL_URL.")</span></td><td><input type=\"text\" name=\"Link\" value=\"$Link\" size=\"50\"></td></tr>";
	echo "<tr><td><span class='table_row_title'>".OPEN_NEW_WINDOW."</span></td>";
	echo "<td>";
	echo "<select name='New_Window'>";
	echo "<option value='0'>".NO."</option>";
	$s="";
	if($New_Window==1)
		$s="selected";
	echo "<option value='1' $s>".YES."</option>";
	echo "</select>";
	echo "</td>";
	echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
	echo "<input type=hidden name='Mode' value='$Mode'>";
	echo "<input type=hidden name='Action' value='confirm_add_new_link'>";
	echo "</form></table>";


}


function display_edit_custom_page($Pages_ID, $Page_Content="")
{
	global $PHP_SELF, $DB, $Mode, $LEAGUEID, $PHPFFL_WEB_ROOT;;

	$sql="select * from custom_pages where ID=$Pages_ID;";
	$rs=$DB->Execute($sql);
	if(!($rs->EOF))
	{
		$pages_title=$rs->fields("title");
		$pages_islink=$rs->fields("is_link");
		$pages_display_order=$rs->fields("display_order");
		$pages_new_window=$rs->fields("new_window");
		$pages_link=$rs->fields("link");
		$pages_page_content=$rs->fields("page_content");
	}
	if(strlen($Page_Content)>0)
		$pages_page_content=$Page_Content;
	if($pages_islink==1)
	{
		echo "<table>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><span class='main_title'>".EDIT_LINK."</td></tr>";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		echo "<tr><td><span class='table_row_title'>".LINK_TITLE."</span></td><td><input type=\"text\" name=\"Link_Title\" value=\"$pages_title\"></td></tr>";
		echo "<tr><td><span class='table_row_title'>".LINK." (".ENTER_FULL_URL.")</span></td><td><input type=\"text\" name=\"Link\" value=\"$pages_link\" size=\"50\"></td></tr>";
		echo "<tr><td><span class='table_row_title'>".OPEN_NEW_WINDOW."</span></td>";
		echo "<td>";
		echo "<select name='New_Window'>";
		echo "<option value='0'>".NO."</option>";
		$s="";
		if($pages_new_window==1)
			$s="selected";
		echo "<option value='1' $s>".YES."</option>";
		echo "</select>";
		echo "</td>";
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Pages_ID' value='$Pages_ID'>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Action' value='confirm_edit_custom_link'>";
		echo "</form></table>";
	}
	else
	{
		echo "<table width='100%'>";
		echo "<form method='post' action='$PHP_SELF?'>";
		echo "<tr><span class='main_title'>".EDIT_PAGE."</td></tr>";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		echo "<tr><td width='20'><span class='table_row_title'>".PAGE_TITLE."</span></td><td><input type=\"text\" name=\"Page_Title\" value=\"$pages_title\"></td></tr>";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		echo "<tr><td colspan='2'>";
		$oFCKeditor = new FCKeditor('FCKeditor1') ;
		$oFCKeditor->BasePath	= "{$PHPFFL_WEB_ROOT}program_files/FCKeditor/" ;
		$oFCKeditor->Value		= $pages_page_content;
		$oFCKeditor->Width = "100%";  
		$oFCKeditor->Height = 800; 
	
		$oFCKeditor->Create() ;
		echo "</td></tr>";
		echo "<tr><td colspan='2'><input type='Submit' name='Submit' value=\"".SUBMIT."\"></td></tr>";
		echo "<input type=hidden name='Mode' value='$Mode'>";
		echo "<input type=hidden name='Pages_ID' value='$Pages_ID'>";
		echo "<input type=hidden name='Action' value='confirm_edit_custom_page'>";
		echo "</form></table>";	
	}

}
?>

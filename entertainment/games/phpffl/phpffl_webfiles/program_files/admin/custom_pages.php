<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="custom_pages" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			custom_pages_main();
		break;
		case "add_new_page":
			display_add_new_page();
		break;
		case "confirm_add_new_page":
			//$Page_Content = stripslashes( $_POST['FCKeditor1'] ) ;
			$Page_Content = $_REQUEST['FCKeditor1'] ;
			$Page_Title=$_REQUEST['Page_Title'];
			if(1)
			{
				$Page_Content=addslashes($Page_Content);
				$Page_Title=addslashes($Page_Title);
			}
			$errors="";
			if(strlen($Page_Title)<1)
			{
				$errors=$errors.MUST_ENTER_TITLE_FOR_PAGE."<br>";
			}
			if(strlen($errors)<1)
			{
				$sql="select max(display_order) as max from custom_pages where leagues_ID=$LEAGUEID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$display_order=$rs->fields("max");
					$display_order++;
				}
				else
				{
					$display_order=1;
				}
				$sql="insert into custom_pages (title, page_content, is_link,leagues_ID, display_order) values ('$Page_Title', '$Page_Content', '0', '$LEAGUEID', '$display_order');";
				$DB->Execute($sql);
				custom_pages_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$Page_Content=stripslashes($Page_Content);
				$Page_Title=stripslashes($Page_Title);
				display_add_new_page($Page_Title, $Page_Content);
			}
		break;
		

		case "add_new_link":
			display_add_new_link();
		break;
		case "confirm_add_new_link":
			$Link_Title=$_REQUEST['Link_Title'];
			$Link=$_REQUEST['Link'];
			$New_Window=$_REQUEST['New_Window'];
			$errors="";
			if(strlen($Link_Title)<1)
			{
				$errors=$errors.MUST_ENTER_TITLE_FOR_LINK."<br>";
			}
			if(strlen($Link)<1)
			{
				$errors=$errors.MUST_ENTER_LINK."<br>";
			}
			if(strlen($errors)<1)
			{
				$sql="select max(display_order) as max from custom_pages where leagues_ID=$LEAGUEID;";
				$rs=$DB->Execute($sql);
				if(!($rs->EOF))
				{
					$display_order=$rs->fields("max");
					$display_order++;
				}
				else
				{
					$display_order=1;
				}
				$sql="insert into custom_pages (title, is_link, link, new_window, leagues_ID, display_order) values ('$Link_Title', '1', '$Link', '$New_Window', '$LEAGUEID', '$display_order');";
				$DB->Execute($sql);
				custom_pages_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$Link_Title=stripslashes($Link_Title);
				$Link=stripslashes($Link);
				display_add_new_link($Link_Title, $Link, $New_Window);
			}
		break;
		case "update_custom_display_order":
			$Display_Order=$_REQUEST['Display_Order'];
			$Default_Login_Page=$_REQUEST['Default_Login_Page'];
			if(is_array($Display_Order))
			{
				foreach($Display_Order as $key => $val)
				{
					$default_login_page=0;
					if($Default_Login_Page==$key)
					{
						$default_login_page=1;
					}
					if(strlen($val)<1)
						$val=0;
					$sql="update custom_pages set display_order=$val, default_login_page=$default_login_page where ID=$key;";
					$DB->Execute($sql);
				}
			}
			custom_pages_main();
		break;
		case "delete_custom_page":
			$Pages_ID=$_REQUEST['Pages_ID'];
			echo SURE_YOU_WANT_TO_DELETE_PAGE."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_delete_custom_page&Pages_ID=$Pages_ID'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action='>".NO."</a>";
		break;
		case "confirm_delete_custom_page":
			$Pages_ID=$_REQUEST['Pages_ID'];
			$sql="delete from custom_pages where ID=$Pages_ID;";
			$DB->Execute($sql);
			custom_pages_main();
		break;
		case "edit_custom_page":
			$Pages_ID=$_REQUEST['Pages_ID'];
			display_edit_custom_page($Pages_ID);
		break;
		case "confirm_edit_custom_link":
			$Pages_ID=$_REQUEST['Pages_ID'];
			$Link_Title=$_REQUEST['Link_Title'];
			$Link=$_REQUEST['Link'];
			$New_Window=$_REQUEST['New_Window'];
			$errors="";
			if(strlen($Link_Title)<1)
			{
				$errors=$errors.MUST_ENTER_TITLE_FOR_LINK."<br>";
			}
			if(strlen($Link)<1)
			{
				$errors=$errors.MUST_ENTER_LINK."<br>";
			}
			if(strlen($errors)<1)
			{
				$sql="update custom_pages set title='$Link_Title', link='$Link', new_window=$New_Window where ID=$Pages_ID;";
				$DB->Execute($sql);
				custom_pages_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				display_edit_custom_page($Pages_ID);
			}
		break;
		case "confirm_edit_custom_page":
			$Pages_ID=$_REQUEST['Pages_ID'];
			$Page_Content = $_REQUEST['FCKeditor1'] ;
			$Page_Title=$_REQUEST['Page_Title'];
			if(1)
			{
				$Page_Content=addslashes($Page_Content);
				$Page_Title=addslashes($Page_Title);
			}
			$errors="";
			if(strlen($Page_Title)<1)
			{
				$errors=$errors.MUST_ENTER_TITLE_FOR_PAGE."<br>";
			}
			if(strlen($errors)<1)
			{
				$sql="update custom_pages set title='$Page_Title', page_content='$Page_Content' where ID=$Pages_ID;";
				$DB->Execute($sql);
				custom_pages_main();
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				$Page_Content=stripslashes($Page_Content);
				$Page_Title=stripslashes($Page_Title);
				display_edit_custom_page($Pages_ID, $Page_Content);
			}
		break;
	}
}



?>
<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="draft")
{
	Switch($Action)
	{
		default:
		case "draft_main":
			$Round=$_REQUEST['Round'];
			display_draft_order($Round);
		break;
		case "view_future_draft_info":
			$Teams_ID=$_REQUEST['Teams_ID'];
			$Draft_Year=$_REQUEST['Draft_Year'];
			display_view_future_draft_info($Teams_ID);
		break;
	}
}


?>


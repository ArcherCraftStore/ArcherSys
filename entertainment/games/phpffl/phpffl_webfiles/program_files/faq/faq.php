<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from statistics.php
if($Mode=="faq")
{
	Switch($Action)
	{
		default:
		case "view_faq":
			$Category_ID=$_REQUEST['Category_ID'];
			if(strlen($Category_ID)<1)
				$Category_ID=1;
			display_faq($Category_ID);
		break;
	}
}


?>


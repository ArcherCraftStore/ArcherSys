<?php 

$Action=$_REQUEST['Action'];

//To verify this page is included from transactions.php
if($Mode=="waiver_wire")
{
	Switch($Action)
	{
		default:
		case "waiver_wire_main":
			$Order_By=$_REQUEST['Order_By'];
			display_waiver_wire_main($Order_By);
		break;
	}
}


?>


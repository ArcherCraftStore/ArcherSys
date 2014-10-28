<?php 

$Action=$_REQUEST['Action'];
//To verify this page is included from admin.php
if($Mode=="automated_scripts" && $ISSUPERUSER==1)
{

	Switch($Action)
	{
		case "automated_scripts_main":
		default:
			display_automated_scripts_main();
		break;
	}
}

?>
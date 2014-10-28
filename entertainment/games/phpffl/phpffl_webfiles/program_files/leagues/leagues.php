<?php 

$Action=$_REQUEST['Action'];



Switch($Action)
{
	case "set_leagueid":
	default:
		select_leagues_main();
	break;
	
}

?>

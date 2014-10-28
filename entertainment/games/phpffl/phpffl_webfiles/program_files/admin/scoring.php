<?php 

$Action=$_REQUEST['Action'];
$ISADMIN=check_is_admin($USERSID, $LEAGUEID);
//To verify this page is included from admin.php
if($Mode=="scoring" && $ISADMIN==1)
{

	Switch($Action)
	{
		default:
			$Position_Description=$_REQUEST['Position_Description'];
			admin_scoring_main($Position_Description);
		break;
		case "add_scoring_category":
		case "edit_scoring_category":
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$Position_Description=$_REQUEST['Position_Description'];
			edit_scoring_category($Scoring_Category_ID, $Position_Description);
		break;
		case "confirm_edit_scoring_category":
			$Position_Description=$_REQUEST['Position_Description'];
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$sql="select category_type from scoring_categories where ID=$Scoring_Category_ID;";
			$rs=$DB->Execute($sql);
			$category_type=$rs->fields("category_type");
			$errors="";
			if($category_type=="Value")
			{
				$Points=$_REQUEST['Points'];
				if(!is_numeric($Points))
				{
					$errors=$errors.ENTER_NUMERIC_VALUE."<br>";
				}
				if(strlen($errors)<1)
				{
					$sql="delete from scoring_categories_leagues_values where scoring_categories_ID=$Scoring_Category_ID and leagues_ID=$LEAGUEID;";
					$DB->Execute($sql);
					$sql="insert into scoring_categories_leagues_values (scoring_categories_ID, leagues_ID, points) values ('$Scoring_Category_ID', '$LEAGUEID', '$Points');";
					$DB->Execute($sql);
					admin_scoring_main($Position_Description);
				}
				else
				{
					echo "<span class='errors'>$errors</span>";
					edit_scoring_category($Scoring_Category_ID, $Position_Description);
				}
			}
			elseif($category_type=="Range")
			{
			
			}
			
		break;
		case "remove_scoring_category":
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$Position_Description=$_REQUEST['Position_Description'];
			echo SURE_DELETE_SCORING_CATEGORY."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_remove_scoring_category&Scoring_Category_ID=$Scoring_Category_ID&Position_Description=$Position_Description'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=&Position_Description=$Position_Description'>".NO."</a>";
		break;
		case "confirm_remove_scoring_category":
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$Position_Description=$_REQUEST['Position_Description'];
			$sql="delete from scoring_categories_leagues_values where scoring_categories_ID=$Scoring_Category_ID and leagues_ID=$LEAGUEID;";
			$DB->Execute($sql);
			admin_scoring_main($Position_Description);
		break;
		case "confirm_add_new_scoring_range":
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$Position_Description=$_REQUEST['Position_Description'];
			$New_Points=$_REQUEST['New_Points'];
			$New_Value=$_REQUEST['New_Value'];
			$Is_Repeating=$_REQUEST['Is_Repeating'];
			$errors="";
			if(!is_numeric($New_Points) || !is_numeric($New_Value))
			{
				$errors=$errors.ENTER_NUMERIC_VALUES."<br>";
			}
			if(strlen($errors)<1)
			{
				$sql="insert into scoring_categories_leagues_values (scoring_categories_ID, leagues_ID, points, value, is_repeating) values ('$Scoring_Category_ID', '$LEAGUEID', '$New_Points', '$New_Value', '$Is_Repeating');";
				$DB->Execute($sql);
				edit_scoring_category($Scoring_Category_ID, $Position_Description);
			}
			else
			{
				echo "<span class='errors'>$errors</span>";
				edit_scoring_category($Scoring_Category_ID, $Position_Description);
			}
		break;
		case "remove_scoring_range":
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$Scoring_Range_ID=$_REQUEST['Scoring_Range_ID'];
			$Position_Description=$_REQUEST['Position_Description'];
			echo SURE_DELETE_SCORING_RANGE."<br><br>";
			echo "<a href='$PHP_SELF?Mode=$Mode&Action=confirm_remove_scoring_range&Scoring_Category_ID=$Scoring_Category_ID&Scoring_Range_ID=$Scoring_Range_ID&Position_Description=$Position_Description'>".YES."</a> | <a href='$PHP_SELF?Mode=$Mode&Action=edit_scoring_category&Scoring_Category_ID=$Scoring_Category_ID&Position_Description=$Position_Description'>".NO."</a>";
		break;
		case "confirm_remove_scoring_range":
			$Scoring_Category_ID=$_REQUEST['Scoring_Category_ID'];
			$Scoring_Range_ID=$_REQUEST['Scoring_Range_ID'];
			$Position_Description=$_REQUEST['Position_Description'];
			$sql="delete from scoring_categories_leagues_values where ID=$Scoring_Range_ID;";
			$DB->Execute($sql);
			edit_scoring_category($Scoring_Category_ID, $Position_Description);
		break;
		case "calculate_fantasy_stats":
			$Week_ID=$_REQUEST['$Week_ID'];
			display_calculate_fantasy_stats($Week_ID);
		break;
		case "confirm_calculate_fantasy_stats":
			$Week_ID=$_REQUEST['Week_ID'];
			calculate_stats($Week_ID, $LEAGUEID);
			admin_scoring_main();
		break;
		case "copy_scoring":
			display_copy_scoring();
		break;
		case "confirm_copy_scoring":
			$Copy_League_ID=$_REQUEST['Copy_League_ID'];
			$sql="delete from scoring_categories_leagues_values where leagues_ID=$LEAGUEID;";
			$DB->Execute($sql);
			if(strlen($Copy_League_ID)>0)
			{
				$sql="select * from scoring_categories_leagues_values where leagues_ID=$Copy_League_ID;";
				$rs=$DB->Execute($sql);
				while(!($rs->EOF))
				{
					$scoring_categories_ID=$rs->fields("scoring_categories_ID");
					$value=$rs->fields("value");
					$points=$rs->fields("points");
					$is_repeating=$rs->fields("is_repeating");
					$sql="insert into scoring_categories_leagues_values (leagues_ID, scoring_categories_ID, value, points, is_repeating) values ('$LEAGUEID', '$scoring_categories_ID', '$value', '$points', '$is_repeating');";
					$DB->Execute($sql);
					$rs->MoveNext();
				}
			}
			admin_scoring_main();
		break;
		
	}
}



?>

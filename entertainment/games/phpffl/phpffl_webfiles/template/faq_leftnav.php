<table style="width: 100%;" border="0" cellspacing="5" cellpadding="5">
<tr>
<td style="vertical-align: top; width: 20%;">

<table border="0" cellpadding="5" cellspacing="5" width="100%" align="center">
	<tbody>
		<tr>
			<td valign="top">
			<table class="forumline" border="0" cellpadding="3" cellspacing="1" width="100%">
				<tbody>
					<tr>
<th><?php echo FAQ;?></th>
					</tr>
					<tr>
						<td>
							<table cellpadding="3" cellspacing="3">
								<tr>
									<td>
										<table>
<?php
$sql="select * from faq_categories where is_admin_category<>1 order by display_order ASC;";
$rs=$DB->Execute($sql);
while(!($rs->EOF))
{
	$category_ID=$rs->fields("ID");
	$category_name_english=$rs->fields("category_name_english");
?>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=faq&Action=view_faq&Category_ID=<?php echo "$category_ID";?>" class="eleven"><?php echo "$category_name_english";?></a>
												</td>
											</tr>
<?php
	$rs->MoveNext();
}
?>
<?php
if($ISADMIN==1)
{
?>
<tr>
												<td>
									<span class='eleven_title'>Administration</span>
												</td>
											</tr>
<?php
	$sql="select * from faq_categories where is_admin_category=1 order by display_order ASC;";
	$rs=$DB->Execute($sql);
	while(!($rs->EOF))
	{
		$category_ID=$rs->fields("ID");
		$category_name_english=$rs->fields("category_name_english");
?>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=faq&Action=view_faq&Category_ID=<?php echo "$category_ID";?>" class="eleven"><?php echo "$category_name_english";?></a>
												</td>
											</tr>
<?php
		$rs->MoveNext();
	}
}
?>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
				
			</table>
		</td>
		<td style="vertical-align: top; width: 80%; text-align: left;">
		
		
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
<tbody><tr>
<td valign="top"><table class="forumline" border="0" cellpadding="3" cellspacing="1" width="100%">
<tbody><tr>
<th><?php echo "$Page_Title";?></th>
</tr>
<tr>

<td><table cellpadding="3" cellspacing="3" width="100%"><tr><td>

									


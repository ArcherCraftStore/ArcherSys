<?php

$sql="select ID, title, is_link, link, new_window from custom_pages where leagues_ID=$LEAGUEID order by display_order ASC;";
$rs=$DB->Execute($sql);
?>

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
<th><?php echo CUSTOM_PAGES;?></th>
					</tr>
					<tr>
						<td>
							<table cellpadding="3" cellspacing="3">
								<tr>
									<td>
										<table>
										<?php
										while(!($rs->EOF))
										{
											$pages_title=$rs->fields("title");
											$current_pages_ID=$rs->fields("ID");
											$is_link=$rs->fields("is_link");
											$new_window_display="";
											if($is_link==1)
											{
												$display_link=$rs->fields("link");
												$new_window=$rs->fields("new_window");
												if($new_window==1)
													$new_window_display="target='_blank'";
											}
											else
											{
												$display_link="{$PHPFFL_WEB_ROOT}custom_pages.php?Pages_ID=$current_pages_ID";
											}
										?>											
										<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$display_link";?>" class="eleven" <?php echo "$new_window_display";?>><?php echo "$pages_title";?></a>
												</td>
											</tr>
										<?php
											$rs->MoveNext();
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
<th>
<?php echo "$Page_Title";?></th>
</tr>
<tr>

<td><table cellpadding="3" cellspacing="3" width="100%"><tr><td>

									

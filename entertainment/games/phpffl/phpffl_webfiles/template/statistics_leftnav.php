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
<th><?php echo STATISTICS;?></th>
					</tr>
					<tr>
						<td>
							<table cellpadding="3" cellspacing="3">
								<tr>
									<td>
										<table>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=standings&Action=standings_main" class="eleven"><?php echo STANDINGS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=teams&Action=teams_main" class="eleven"><?php echo TEAMS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=players&Action=players_main" class="eleven"><?php echo PLAYERS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=live_scoring&Action=live_scoring_main" class="eleven"><?php echo LIVE_SCORING;?></a>
												</td>
											</tr>
<?php
//Only Display Schedule if one exists
$sql="select schedules_type_ID from leagues, schedules_type where schedules_type_ID=schedules_type.ID and leagues.ID=$LEAGUEID;";
$rs=$DB->Execute($sql);
if(!($rs->EOF))
{
?>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=schedules&Action=schedules_main" class="eleven"><?php echo SCHEDULE_RESULTS;?></a>
												</td>
											</tr>
<?php
}
?>	

											<tr>
													<td>
										&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=scoring&Action=scoring_main" class="eleven"><?php echo SCORING;?></a>
													</td>
											</tr>
											<tr>
													<td>
										&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=draft&Action=draft_main" class="eleven"><?php echo DRAFT;?></a>
													</td>
											</tr>
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

									

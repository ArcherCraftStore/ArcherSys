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
<th><?php echo ADMIN;?></th>
					</tr>
					<tr>
						<td>
							<table cellpadding="3" cellspacing="3">
								<tr>
									<td>
										<table><?php
										if($ISSUPERUSER==1)
										{
											?><tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=config_global&Action=config_global_main" class="eleven"><?php echo CONFIGURATION;?></a>
												</td>
											</tr><?php
										}
										if($ISSUPERUSER==1)
										{
											?><tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=automated_scripts&Action=automated_scripts_main" class="eleven"><?php echo AUTOMATED_SCRIPTS;?></a>
												</td>
											</tr><?php
										}
											?><tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=leagues&Action=leagues_main" class="eleven"><?php echo LEAGUES;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=teams&Action=teams_main" class="eleven"><?php echo TEAMS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=divisions&Action=divisions_main" class="eleven"><?php echo DIVISIONS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=users&Action=users_main" class="eleven"><?php echo USERS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=rosters&Action=rosters_main" class="eleven"><?php echo ROSTERS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=starting_lineups&Action=starting_lineups_main" class="eleven"><?php echo STARTING_LINEUPS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=schedules_templates&Action=schedules_templates_main" class="eleven"><?php echo SCHEDULE_TEMPLATES;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=schedules&Action=schedules_main" class="eleven"><?php echo SCHEDULE;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=scoring&Action=scoring_main" class="eleven"><?php echo SCORING;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=players&Action=players_main" class="eleven"><?php echo PLAYERS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=waiver_wire&Action=waiver_wire_main" class="eleven"><?php echo WAIVER_WIRE;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=trades&Action=trades_main" class="eleven"><?php echo TRADES;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=trade_protests&Action=trade_protests_main" class="eleven"><?php echo TRADE_PROTESTS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=standings&Action=standings_main" class="eleven"><?php echo STANDINGS;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=draft&Action=draft_main" class="eleven"><?php echo DRAFT;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=custom_pages&Action=custom_pages_main" class="eleven"><?php echo CUSTOM_PAGES;?></a>
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

									
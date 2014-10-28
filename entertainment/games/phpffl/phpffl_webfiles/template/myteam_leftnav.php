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
<th><?php echo MY_TEAM;?></th>
					</tr>
					<tr>
						<td>
							<table cellpadding="3" cellspacing="3">
								<tr>
									<td>
										<table>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=myteam&Action=myteam_main" class="eleven"><?php echo "".get_team_name($Teams_ID);?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=starting_lineup&Action=starting_lineup_main" class="eleven"><?php echo STARTING_LINEUP;?></a>
												</td>
											</tr>
											<tr>
												<td>
									<div id="PM_Leftnav">&#8226;&nbsp; <a href="my_team.php?Mode=private_message&Action=private_message_main" class="eleven"><?php
									echo PRIVATE_MESSAGES;
									$num_new_messages = get_num_new_messages($USERSID);
									if($num_new_messages>0)
									{
										echo " ($num_new_messages)";
									}
									?></a></div>
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
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=draft&Action=draft_main" class="eleven"><?php echo DRAFT;?></a>
												</td>
											</tr>
											<?php
											if($ISADMIN)
											{
											?>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=team_correspondance&Action=team_correspondance_main" class="eleven"><?php echo CORRESPONDANCE;?></a>
												</td>
											</tr>
											<?php
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




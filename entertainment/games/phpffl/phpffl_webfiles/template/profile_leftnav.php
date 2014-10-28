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
<th><?php echo PROFILE;?></th>
					</tr>
					<tr>
						<td>
							<table cellpadding="3" cellspacing="3">
								<tr>
									<td>
										<table>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=myprofile&Action=myprofile_main" class="eleven"><?php echo MY_PROFILE;?></a>
												</td>
											</tr>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=myprofile&Action=change_password" class="eleven"><?php echo CHANGE_PASSWORD;?></a>
												</td>
											</tr>
											<?php
												$league_logo_array=get_league_logo_array();
												if($league_logo_array['display_team_logos']=="Yes" && strlen($Teams_ID)>0 && $Teams_ID!=0)
												{
												?>
											<tr>
												<td>
									&#8226;&nbsp; <a href="<?php echo "$PHP_SELF";?>?Mode=myprofile&Action=update_teamlogo" class="eleven"><?php echo UPDATE_TEAM_LOGO;?></a>
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

									


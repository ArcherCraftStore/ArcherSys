<h2><?php echo __('Autoresponder Settings'); ?></h2>
<form action="settings.php?t=autoresp" method="post" id="save">
<?php csrf_token(); ?>
<input type="hidden" name="t" value="autoresp" >
<table class="form_table settings_table" width="940" border="0" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <th colspan="2">
                <h4><?php echo __('Autoresponder Setting'); ?></h4>
                <em><?php echo __('Global setting - can be disabled at department or email level.'); ?></em>
            </th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td width="160"><?php echo __('New Ticket'); ?>:</td>
            <td>
                <input type="checkbox" name="ticket_autoresponder" <?php
echo $config['ticket_autoresponder'] ? 'checked="checked"' : ''; ?>/>
                <?php echo __('Ticket Owner'); ?>&nbsp;
                <i class="help-tip icon-question-sign" href="#new_ticket"></i>
            </td>
        </tr>
        <tr>
            <td width="160"><?php echo __('New Ticket by Agent'); ?>:</td>
            <td>
                <input type="checkbox" name="ticket_notice_active" <?php
echo $config['ticket_notice_active'] ? 'checked="checked"' : ''; ?>/>
                <?php echo __('Ticket Owner'); ?>&nbsp;
                <i class="help-tip icon-question-sign" href="#new_ticket_by_staff"></i>
            </td>
        </tr>
        <tr>
            <td width="160" rowspan="2"><?php echo __('New Message'); ?>:</td>
            <td>
                <input type="checkbox" name="message_autoresponder" <?php
echo $config['message_autoresponder'] ? 'checked="checked"' : ''; ?>/>
                <?php echo __('Submitter: Send receipt confirmation'); ?>&nbsp;
                <i class="help-tip icon-question-sign" href="#new_message_for_submitter"></i>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="message_autoresponder_collabs" <?php
echo $config['message_autoresponder_collabs'] ? 'checked="checked"' : ''; ?>/>
                <?php echo __('Participants: Send new activity notice'); ?>&nbsp;
                <i class="help-tip icon-question-sign" href="#new_message_for_participants"></i>
                </div>
            </td>
        </tr>
        <tr>
            <td width="160"><?php echo __('Overlimit Notice'); ?>:</td>
            <td>
                <input type="checkbox" name="overlimit_notice_active" <?php
echo $config['overlimit_notice_active'] ? 'checked="checked"' : ''; ?>/>
                <?php echo __('Ticket Submitter'); ?>&nbsp;
                <i class="help-tip icon-question-sign" href="#overlimit_notice"></i>
            </td>
        </tr>
    </tbody>
</table>
<p style="padding-left:200px;">
    <input class="button" type="submit" name="submit" value="<?php echo __('Save Changes'); ?>">
    <input class="button" type="reset" name="reset" value="<?php echo __('Reset Changes'); ?>">
</p>
</form>

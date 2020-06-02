<div class="table-responsive">
    <table id="appointments_table" class="table table-bordered table-striped no-margin">
        <tr>
            <th>&nbsp;</th>
            <th><?php echo lang('project_name'); ?></th>
            <th><?php echo lang('appointment_name'); ?></th>
            <th><?php echo lang('appointment_date'); ?></th>
            <th><?php echo lang('appointment_description'); ?></th>
            <th class="text-right">
                <?php echo lang('appointment_price'); ?></th>
        </tr>

        <?php foreach ($appointments as $appointment) { ?>
            <tr class="appointment-row">
                <td class="text-left">
                    <input type="checkbox" class="modal-appointment-id" name="appointment_ids[]"
                           id="appointment-id-<?php echo $appointment->appointment_id ?>" value="<?php echo $appointment->appointment_id; ?>">
                </td>
                <td nowrap class="text-left">
                    <b><?php echo isset($appointment->project_name) ? htmlsc($appointment->project_name) : ''; ?></b>
                </td>
                <td>
                    <b><?php _htmlsc($appointment->appointment_name); ?></b>
                </td>
                <td>
                    <b><?php echo date_from_mysql($appointment->appointment_finish_date); ?></b>
                </td>
                <td>
                    <?php echo nl2br(htmlsc($appointment->appointment_description)); ?>
                </td>
                <td class="amount">
                    <?php
                    if ($this->session->userdata('user_type') == TYPE_ADMIN) {
                        echo format_amount($appointment->appointment_price);
                    }
                    else
                    {
                        echo format_amount($appointment->hour_rate * $appointment->total_hours_spent);
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>
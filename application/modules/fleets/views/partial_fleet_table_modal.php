<div class="table-responsive">
    <table id="tasks_table" class="table table-bordered table-striped no-margin">
        <tr>
            <th>&nbsp;</th>
            <th><?php echo lang('project_name'); ?></th>
            <th><?php echo lang('notes_title'); ?></th>

            <th><?php echo lang('notes_description'); ?></th>
        </tr>

        <?php foreach ($notes as $note) { ?>
            <tr class="task-row">
                <td class="text-left">
                    <input type="checkbox" class="modal-task-id" name="notes_ids[]"
                           id="notes-id-<?php echo $note->notes_id ?>" value="<?php echo $note->notes_id; ?>">
                </td>
                <td nowrap class="text-left">
                    <b><?php echo isset($note->project_name) ? htmlsc($note->project_name) : ''; ?></b>
                </td>
                <td>
                    <b><?php _htmlsc($note->notes_title); ?></b>
                </td>
              <td>
                    <b><?php echo date_from_mysql($note->notes_datestamp); ?></b>
                </td>
                <td>
                    <?php echo nl2br(htmlsc($note->notes_description)); ?>
                </td>
                <td class="amount">
                    <?php echo format_currency($note->notes_price); ?>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>

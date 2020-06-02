<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><a <?= orderableTH($this->input->get(), 'project_name', 'ip_projects'); ?>><?php _trans('project'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'created_date', 'ip_projects'); ?>><?php _trans('notes_number'); ?></a></th>
            <th><?php _trans('last_note'); ?></th>
            <?php if($this->session->userdata('user_type') != TYPE_ADMINISTRATOR):?>
                <th><?php _trans('Url'); ?></th>
            <?php endif; ?>
            <th><a <?= orderableTH($this->input->get(), 'created_date', 'ip_projects'); ?>><?php _trans('note_date'); ?></a></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($notes as $note) { ?>
            <tr>
                <td>
                    <?=anchor('notes/project_notes/' . $note->project_id, htmlsc($note->project_name))?>
                </td>
                <td>
                    <?=$note->total_notes?>
                </td>

                <td>
                    <?=htmlspecialchars($note->last_note)?>

                </td>
                <?php if($this->session->userdata('user_type') != TYPE_ADMINISTRATOR):?>
                    <td>
                        <?=anchor(site_url('guest/view/project_notes/' .$note->project_notes_key), htmlsc('Show')) ?>
                    </td>
                <?php endif; ?>

                <td>
                    <?php if (isset($note->is_overdue)) { ?>
                        <div class="text-danger">

                        </div>
                    <?php }else{ ?>
                        <?=$note->created_date;?>
                    <?php }?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>
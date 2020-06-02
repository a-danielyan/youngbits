<div id="headerbar">
    <h1 class="headerbar-title"><?=$project_name?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('notes/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('notes/index'), 'mdl_notes'); ?>
    </div>


</div>

<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php _trans('status'); ?></th>
                <th><?php _trans('note_date'); ?></th>
                <th><?php _trans('note_time'); ?></th>
                <th><?php _trans('note_category'); ?></th>
                <th><?php _trans('note_title'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($notes as $note) { ?>
                <tr>
                    <td>
                        <span class="label <?php echo $notes_statuses["$note->note_status"]['class']; ?>">
                            <?php echo $notes_statuses["$note->note_status"]['label']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if (isset($note->is_overdue)) { ?>
                            <div class="text-danger">
                                <?=$note->created_date;?>
                            </div>
                        <?php }else{
                            echo $note->created_date;
                        } ?>

                    </td>
                   <td>
                       <?=$note->created_time;?>
                   </td>

                   <td>
                       <?=$note->notes_category;?>
                   </td>
                    <td>
                        <?php echo htmlspecialchars($note->notes_title); ?>
                    </td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('notes/form/' . $note->notes_id); ?>" title="<?php _trans('edit'); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('notes/delete/' . $note->notes_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_note_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

</div>



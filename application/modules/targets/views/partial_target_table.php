<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'target_active', 'ip_targets'); ?>><?php _trans('active'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'target_name', 'ip_targets'); ?>><?php _trans('target_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'target_email', 'ip_targets'); ?>><?php _trans('email_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'target_phone', 'ip_targets'); ?>><?php _trans('phone_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'target_mobile', 'ip_targets'); ?>><?php _trans('mobile_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'group_name', 'ip_users_groups'); ?>><?php _trans("group_name"); ?></a></th>
            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS){ ?>
                <th><?php _trans('options'); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $target) : ?>
            <tr>
                <td><input type="checkbox" value="<?= $target->target_email ?>" class="sel"></td>
                <td><?php echo ($target->target_active) ? trans('yes') : trans('no'); ?></td>
                <td><?php echo anchor('targets/view/' . $target->target_id, htmlsc(format_target($target))); ?></td>
                <td><?php _htmlsc($target->target_email); ?></td>
                <td><?php _htmlsc($target->target_phone ? $target->target_phone :  ''); ?></td>
                <td><?php _htmlsc($target->target_mobile ? $target->target_mobile : ''); ?></td>
                <td><?php _htmlsc($target->group_name); ?></td>

                <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS|| $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){ ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('targets/view/' . $target->target_id); ?>">
                                        <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('targets/form/' . $target->target_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('targets/delete/' . $target->target_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_target_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

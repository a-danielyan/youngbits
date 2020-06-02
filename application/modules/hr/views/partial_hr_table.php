<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'hr_active', 'ip_hrs'); ?>><?php _trans('active'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'hr_name', 'ip_hrs'); ?>><?php _trans('name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'hr_email', 'ip_hrs'); ?>><?php _trans('email_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'hr_phone', 'ip_hrs'); ?>><?php _trans('phone_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'hr_followers', 'ip_hrs'); ?>><?php _trans('hr_followers'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'hr_language', 'ip_hrs'); ?>><?php _trans('language'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'hr_social_link', 'ip_hrs'); ?>><?php _trans('hr_social_link'); ?></a></th>
        <?php
        if ($hr_type == "all")
        {
        ?>
            <th><?php _trans('group_name'); ?></th>
        <?php
        }
        ?>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $hr) : ?>
            <tr>
                <td><input type="checkbox" value="<?= $hr->hr_email ?>" class="sel"></td>
                <td><?php echo ($hr->hr_active) ? trans('yes') : trans('no'); ?></td>
                <td><?php echo anchor('hr/view/' . $hr->hr_id, htmlsc(format_hr($hr))); ?></td>
                <td><?php _htmlsc($hr->hr_email); ?></td>
                <td><?php _htmlsc($hr->hr_phone ? $hr->hr_phone : ''); ?></td>
                <td><?php _htmlsc($hr->hr_followers ? $hr->hr_followers : ''); ?></td>
                <td><?php _htmlsc($hr->hr_language ? $hr->hr_language : ''); ?></td>
                <td><?php _htmlsc($hr->hr_social_link ? $hr->hr_social_link : ''); ?></td>
            <?php
            if ($hr_type == "all") {
            ?>
                <td><?php
                switch ($hr->hr_type) {
                    case '1':
                        _trans('administrator');
                        break;
                    case TYPE_PROMOTERS:
                        _trans('promoters');
                        break;
                    case TYPE_ADMINISTRATOR:
                        _trans('other_users');
                        break;
                    case TYPE_MANAGERS:
                        _trans('managers');
                        break;
                    case TYPE_FREELANCERS:
                        _trans('freelancers');
                        break;
                    case TYPE_EMPLOYEES:
                        _trans('employees');
                        break;
                    case TYPE_ACCOUNTANT:
                        _trans('accountant');
                        break;
                    default:
                        break;
                }?></td>
            <?php
            }
            ?>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('hr/view/' . $hr->hr_id); ?>">
                                    <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                </a>
                            </li>
                            <?php if($this->session->userdata('user_type') == TYPE_ADMIN ){ ?>
                                <li>
                                    <a href="<?php echo site_url('hr/form/' . $hr->hr_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('hr/delete/' . $hr->hr_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_hr_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

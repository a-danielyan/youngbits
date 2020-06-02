<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('appointments_templates'); ?></h1>
    <div class="headerbar-item pull-right">
        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN   || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('appointments_templates/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>





    </div>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('appointments_templates/index'), 'mdl_appointments_templates'); ?>
    </div>
</div>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php _trans('status'); ?></th>
                    <th><?php _trans('appointment_title'); ?></th>
                    <th><?php _trans('appointment_date'); ?></th>
                    <th><?php _trans('appointment_total_time_of'); ?></th>
                    <th><?php _trans('appointment_kilometers'); ?></th>
                    <th><?php _trans('project'); ?></th>
                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
                        <th><?php _trans('options'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $appointment) { ?>
                <tr>
                    <td>
                        <span class="label <?php echo $appointment_statuses["$appointment->appointment_status"]['class']; ?>">
                            <?php echo $appointment_statuses["$appointment->appointment_status"]['label']; ?>
                        </span>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($appointment->appointment_title); ?>
                    </td>
                    <td>
                        <div class="<?php if ($appointment->is_overdue) { ?>text-danger<?php } ?>">
                            <?php echo date_from_mysql($appointment->appointment_date); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($appointment->appointment_total_time_of); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($appointment->appointment_kilometers); ?>
                    </td>
                    <td>
                        <?php echo !empty($appointment->project_id) ? anchor('projects/view/' . $appointment->project_id, $appointment->project_name) : ''; ?>
                    </td>
                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('appointments_templates/form/' . $appointment->appointment_id); ?>"
                                           title="<?php _trans('edit'); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <?php if (!($appointment->appointment_status == 4 && $this->config->item('enable_invoice_deletion') !== true)) : ?>
                                        <li>
                                            <a href="<?php echo site_url('appointments_templates/delete/' . $appointment->appointment_id); ?>" title="<?php _trans('delete'); ?>"
                                               onclick="return confirm('<?php echo $appointment->appointment_status == 4 ? trans('alert_appointment_delete') : trans('delete_record_warning') ?>')">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

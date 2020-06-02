<!-- appointments -->
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('appointments'); ?></h1>
    <div class="headerbar-item pull-right">
        <?php if ( $this->session->userdata('user_type') != TYPE_ACCOUNTANT ): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('appointments/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>





    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('appointments/index'), 'mdl_appointments'); ?>
    </div>

    <div class="btn-group btn-group-sm index-options total_kilometer_content pull-right row" style="margin-right: 2%;">
        <span class="sel_kilometer" style="padding: 0 10px;margin: 5px 0;    display: inline-block"></span>
        <span class="total_kilometers" style="padding: 0 10px;margin: 5px 0;display: inline-block;"> <?_trans('kilometers')?>: <?=$total_kl?></span>

        <!--            <span class="total_amt">--><?php //echo _trans('total_kilometers'); ?><!-- : $ --><?//=$sum['dollar']; ?><!--</span>-->
        <!--            <span class="total_amt">--><?php //echo _trans('total'); ?><!-- : --><?//=format_currency($sum['euro']); ?><!--</span>-->
    </div>
</div>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" class="checkAllSelKilometer"></th>
                    <th><?php _trans('status'); ?></th>
                    <th><?php _trans('appointment_title'); ?></th>
                    <th><a <?= orderableTH($this->input->get(), 'appointment_date', 'ip_appointments'); ?>><?= _trans('appointment_date'); ?></a></th>
                    <th><?php _trans('appointment_total_time_of'); ?></th>
                    <th><?php _trans('appointment_kilometers'); ?></th>
                    <th><?php _trans('kilometers_car'); ?></th>
                    <th><?php _trans('project'); ?></th>
                    <th><?php _trans('url'); ?></th>
                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
                        <th><?php _trans('options'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $appointment) { ?>
                <tr>
                    <td>
                        <input type="checkbox" value="<?= $appointment->appointment_id ?>" class="selAppointmentKilometers" data-kilometer="<?=$appointment->appointment_kilometers; ?>">
                    </td>
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
                      &nbsp
                    </td>
                    <td>
                        <?php echo !empty($appointment->project_id) ? anchor('projects/view/' . $appointment->project_id, $appointment->project_name) : ''; ?>
                    </td>
                    <td>
                        <a href="<?=site_url('guest/view/appointment/' .$appointment->appointment_url_key)?>"><?=site_url('guest/view/appointment/' .$appointment->appointment_url_key)?></a>
                    </td>
                    <?php if(in_array($this->session->userdata('user_type'),[TYPE_ADMIN,TYPE_MANAGERS,TYPE_FREELANCERS,TYPE_EMPLOYEES,TYPE_SALESPERSON])): ?>

                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('appointments/form/' . $appointment->appointment_id); ?>"
                                           title="<?php _trans('edit'); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <?php if (!($appointment->appointment_status == 4 && $this->config->item('enable_invoice_deletion') !== true)) : ?>
                                        <li>
                                            <a href="<?php echo site_url('appointments/delete/' . $appointment->appointment_id); ?>" title="<?php _trans('delete'); ?>"
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

<input type="hidden" name="url" value="<?=base_url().'index.php/appointments'?>">
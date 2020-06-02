<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('fleets'); ?></h1>
    <?php if (in_array($this->session->userdata('user_type'), array(TYPE_ADMIN , TYPE_MANAGERS, TYPE_ADMINISTRATOR))): ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('fleets/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php endif; ?>



    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('fleets/index'), 'mdl_fleets'); ?>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th><?php _trans('fleet_make_car'); ?></th>
                    <th><?php _trans('fleet_model_car'); ?></th>
                    <th><?php _trans('fleet_first_registration'); ?></th>
                    <th><?php _trans('fleet_starting_mileage'); ?></th>
                    <th><?php _trans('fleet_current_mileage'); ?></th>
                    <th><?php _trans('fleet_last_service_data'); ?></th>
                    <th><?php _trans('fleet_buying_price'); ?></th>
                    <th><?php _trans('fleet_maintenance_costs'); ?></th>
                    <th><?php _trans('fleet_default_car'); ?></th>
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <th><?php _trans('option'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody>


            <?php foreach ($fleets as $fleet) { ?>
                <tr>

                    <td>
                        <?php echo htmlspecialchars($fleet->fleet_make_car); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($fleet->fleet_model_car); ?>
                    </td>
                    <td>
                        <?php echo $fleet->fleet_first_registration; ?>
                    </td>
                    <td>
                        <?php echo $fleet->fleet_starting_mileage; ?>
                    </td>
                    <td>
                        <?php echo $fleet->fleet_current_mileage; ?>
                    </td>
                    <td>
                        <div class="col-md-5">
                            <?php echo $fleet->fleet_last_service_data; ?>
                        </div>
                        <div class="col-md">
                            <?php echo $fleet->fleet_mileage_car; ?>
                        </div>
                    </td>
                    <td>
                        <?php echo '$'.format_amount($fleet->fleet_buying_price); ?>
                    </td>
                    <td>
                        <?php echo '$'.format_amount($fleet->fleet_maintenance_costs); ?>
                    </td>
                    <td>
                        <?php if($fleet->fleet_default_car  == 1){ echo 'Yes';}else{echo 'No';} ?>
                    </td>
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('fleets/form/' . $fleet->fleet_id); ?>" title="<?php _trans('edit'); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('fleets/delete/' . $fleet->fleet_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_note_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
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

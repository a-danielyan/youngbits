<form method="post" id="notes-form">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('fleet_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if ($this->mdl_fleets->form_value('fleet_id')) : ?>
                            #<?php echo $this->mdl_fleets->form_value('fleet_id'); ?>&nbsp;
                        <?php else : ?>
                            <?php _trans('fleet_new'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="fleet_make_car"><?php _trans('fleet_make_car'); ?></label>
                            <input type="text" name="fleet_make_car" id="fleet_make_car" class="form-control"
                                   value="<?php echo $this->mdl_fleets->form_value('fleet_make_car', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="fleet_model_car"><?php _trans('fleet_model_car'); ?></label>
                            <input type="text" name="fleet_model_car" id="fleet_model_car" class="form-control"
                                   value="<?php echo $this->mdl_fleets->form_value('fleet_model_car', true); ?>">
                        </div>


                        <div class="form-group has-feedback">
                            <label for="fleet_first_registration"><?php _trans('fleet_first_registration'); ?></label>
                            <div class="input-group">
                                <input name="fleet_first_registration" id="fleet_first_registration" class="form-control datepicker"
                                       value="<?php echo date_from_mysql($this->mdl_fleets->form_value('fleet_first_registration')); ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="fleet_starting_mileage"><?php _trans('fleet_starting_mileage'); ?></label>
                            <input type="number" name="fleet_starting_mileage" id="fleet_starting_mileage" class="form-control"
                                   value="<?php echo $this->mdl_fleets->form_value('fleet_starting_mileage', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="fleet_current_mileage"><?php _trans('fleet_current_mileage'); ?></label>
                            <input type="number" name="fleet_current_mileage" id="fleet_current_mileage" class="form-control"
                                   value="<?php echo $this->mdl_fleets->form_value('fleet_current_mileage', true); ?>">
                        </div>





                </div>
            </div>

        </div>
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('extra_information'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="fleet_last_service_data"><?php _trans('fleet_last_service_data'); ?></label>
                                <div class="input-group">
                                    <input name="fleet_last_service_data" id="fleet_last_service_data" class="form-control datepicker"
                                           value="<?php echo date_from_mysql($this->mdl_fleets->form_value('fleet_last_service_data')); ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="fleet_mileage_car">&nbsp;</label>
                                <input type="number" name="fleet_mileage_car" id="fleet_mileage_car" class="form-control"
                                       value="<?php echo $this->mdl_fleets->form_value('fleet_mileage_car'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fleet_buying_price"><?php _trans('fleet_buying_price'); ?></label>
                            <div class="input-group">
                                <input type="number" name="fleet_buying_price" id="fleet_buying_price" class="amount form-control"
                                       value="<?php echo $this->mdl_fleets->form_value('fleet_buying_price', true); ?>">
                                <div class="input-group-addon">
                                    <?php echo get_setting('currency_symbol') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fleet_maintenance_costs"><?php _trans('fleet_maintenance_costs'); ?></label>
                            <div class="input-group">
                                <input type="number" name="fleet_maintenance_costs" id="fleet_maintenance_costs" class="amount form-control"
                                       value="<?php echo $this->mdl_fleets->form_value('fleet_maintenance_costs', true); ?>">
                                <input type="hidden" name="fleet_mileage_car_total" id="fleet_mileage_car_total" class="amount form-control"
                                       value="<?= $this->mdl_fleets->form_value('fleet_mileage_car_total', true); ?>">
                                <div class="input-group-addon">
                                    <?php echo get_setting('currency_symbol') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fleet_default_car"><?php _trans('fleet_default_car'); ?> &nbsp;&nbsp;</label>
                            <input type="checkbox" name="fleet_default_car" id="fleet_default_car" value="1" <?php if($this->mdl_fleets->form_value('fleet_default_car') == 1){echo 'checked';} ?>>
                        </div>


                    </div>
                </div>
            </div>

    </div>

</form>

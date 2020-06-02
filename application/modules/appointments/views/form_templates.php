

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <div class="row">
            <label for="appointment_templates" class="col-sm-1 col-form-label"><?php _trans('appointments_form'); ?>:</label>


               <div class="col-md-2">
                   <select name="appointment_templates" id="appointment_templates" class="form-control simple-select">
                       <option value="default"><?php _trans('appointments_select_template'); ?></option>
                       <?php foreach ($appointment_templates as $appointment_template) { ?>
                           <option value="<?=$appointment_template->appointment_id; ?>" >
                               <?=htmlspecialchars($appointment_template->appointment_title); ?>
                           </option>
                       <?php } ?>
                   </select>

               </div>

            <?php $this->layout->load_view('layout/header_buttons'); ?>

        </div>

    </div>



    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if ($appointments->appointment_id) : ?>
                            #<?php echo $appointments->appointment_id; ?>&nbsp;
                            <?php echo $appointments->appointment_title; ?>
                        <?php else : ?>
                            <?php _trans('new_appointment'); ?>
                        <?php endif; ?>
                    </div>

                    <div class="panel-body">



                        <div class="form-group">
                            <label for="appointment_title"><?php _trans('appointment_title'); ?></label>
                            <input type="text" name="appointment_title" id="appointment_title" class="form-control"
                                   value="<?php echo $appointments->appointment_title; ?>">
                        </div>

                        <div class="form-group">
                            <label for="appointment_description"><?php _trans('appointment_description'); ?></label>
                            <textarea name="appointment_description" id="appointment_description" class="form-control" rows="3"
                            ><?=$appointments->appointment_description; ?></textarea>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5">
                                <label for="appointment_recurring"><?php _trans('appointment_recurring'); ?></label>
                            </div>
                            <div class="col-md-2">
                                <label><?php _trans('no'); ?> &nbsp
                                    <input type="radio" class="appointment_recurring_checked" name="appointment_recurring_checked" value="0" <?php if($appointments->appointment_recurring_checked == 0){ echo 'checked';}; ?>>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label><?php _trans('yes'); ?> &nbsp
                                    <input type="radio" class="appointment_recurring_checked" name="appointment_recurring_checked" value="1" <?php if($appointments->appointment_recurring_checked == 1){ echo 'checked';}; ?>>
                                </label>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="recuring-period recurring_checked <?= ($appointments->appointment_recurring_checked == 0) ? 'hidden' : '' ?>">
                                <div class="col-md-5">
                                    <label for="appointment_recurring"><?php _trans('every'); ?></label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <select name="appointment_recurring" id="appointment_recurring" class="form-control simple-select">
                                            <?php foreach ($recur_frequencies as $key => $lang) { ?>

                                                <?php if($key == $appointments->appointment_recurring){
                                                    ?>
                                                    <option value="<?php echo $key; ?>" selected > <?php _trans($lang); ?></option>
                                                    <?php
                                                }?>
                                                <option value="<?php echo $key; ?>"><?php _trans($lang); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class=" form-group">
                                <div class="recuring-period  <?= ($appointments->appointment_recurring_checked == 0) ? 'hidden' : '' ?>">
                                    <div class="col-md-6">
                                        <label for="appointments_recur_start_date"><?php _trans('start_date'); ?></label>
                                        <div class="input-group">
                                            <input name="appointments_recur_start_date" id="appointments_recur_start_date" class="form-control datepicker"
                                                   value="<?=$appointments->appointments_recur_start_date; ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="appointments_recur_end_date"><?php _trans('end_date'); ?></label>
                                        <div class="input-group">
                                            <input name="appointments_recur_end_date" id="appointments_recur_end_date" class="form-control datepicker"
                                                   value="<?php echo $appointments->appointments_recur_end_date; ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="recuring-period  <?= ($appointments->appointment_recurring_checked == 0) ? 'hidden' : '' ?>">
                                <div class="week_checkbox">
                                    <label for="monday"><?php _trans('monday'); ?>
                                        <input type="checkbox"  name="appointment_wek[1]" id="monday" value="1" <?php if(!empty($appointment_wek['monday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                                <div class="week_checkbox">
                                    <label for="tuesday"><?php _trans('tuesday'); ?>
                                        <input type="checkbox" name="appointment_wek[2]" id="tuesday" value="2"  <?php if(!empty($appointment_wek['tuesday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                                <div class="week_checkbox">
                                    <label for="wednesday"><?php _trans('wednesday'); ?>
                                        <input type="checkbox"  name="appointment_wek[3]" id="wednesday" value="3"  <?php if(!empty($appointment_wek['wednesday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                                <div class="week_checkbox">
                                    <label for="thursday"><?php _trans('thursday'); ?>
                                        <input type="checkbox"  name="appointment_wek[4]" id="thursday" value="4"  <?php if(!empty($appointment_wek['thursday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                                <div class="week_checkbox">
                                    <label for="friday"><?php _trans('friday'); ?>
                                        <input type="checkbox" name="appointment_wek[5]" id="friday" value="5"  <?php if(!empty($appointment_wek['friday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                                <div class="week_checkbox">
                                    <label for="saturday"><?php _trans('saturday'); ?>
                                        <input type="checkbox" name="appointment_wek[6]" id="saturday" value="6"  <?php if(!empty($appointment_wek['saturday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                                <div class="week_checkbox">
                                    <label for="sunday"><?php _trans('sunday'); ?>
                                        <input type="checkbox" name="appointment_wek[7]" id="sunday" value="7"  <?php if(!empty($appointment_wek['sunday'])){echo 'checked';}?> >
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="appointment_address"><?php _trans('appointment_address'); ?></label>
                            <input type="text" name="appointment_address" id="appointment_address" class="form-control"
                                   value="<?=$appointments->appointment_address; ?>">

                        </div>

                        <div class="form-group has-feedback">
                            <label for="appointment_date"><?php _trans('appointment_date'); ?></label>
                            <div class="input-group">
                                <input name="appointment_date" id="appointment_date" class="form-control datepicker"
                                       value="<?= date('d-M-Y',strtotime($appointments->appointment_date)); ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="appointment_starting_time"><?php _trans('appointment_starting_time'); ?></label>
                                <div class="input-group">
                                    <input type="time" name="appointment_starting_time" id="appointment_starting_time" class="form-control"
                                           value="<?php echo $appointments->appointment_starting_time; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="appointment_end_time"><?php _trans('appointment_end_time'); ?></label>
                                <div class="input-group">
                                    <input type="time" name="appointment_end_time" id="appointment_end_time" class="form-control"
                                           value="<?php echo $appointments->appointment_end_time; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="appointment_total_time_of"><?php _trans('appointment_total_time_of'); ?></label>
                            <div class="input-group">
                                <input type="text" name="appointment_total_time_of" readonly id="appointment_total_time_of" class="form-control text-right"
                                       value="<?php echo $appointments->appointment_total_time_of; ?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o fa-fw"></i>
                                </div>
                            </div>
                        </div>



                        <div class="row form-group" style="margin: 15px 0 15px">
                            <label for="appointment_url_document"><?php _trans('attachments'); ?></label>
                            <div class="col-md">
                                <div class="col-sm-10 no-padding">
                                    <input type="text" name="appointment_url_document" id="appointment_url_document" class="form-control" readonly
                                           value="<?php echo $appointments->appointment_url_document; ?>">
                                </div>
                                <div class="col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                    <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('attachments'); ?>" onclick="document.getElementById('appointment_file').click();" />
                                    <input type="file" style="display:none;" id="appointment_file" name="appointment_file" accept=".jpeg, .jpg, .png, .pdf" onchange="document.getElementById('appointment_url_document').value=this.files.item(0).name;"/>
                                </div>
                            </div>

                        </div>







                        <div class="row form-group">
                            <div class="col-md-5">
                                <label for="appointment_recurring"><?php _trans('appointment_invoice'); ?></label>
                            </div>
                            <div class="col-md-2">
                                <label><?php _trans('no'); ?> &nbsp
                                    <input type="radio" class="appointment_invoice_checked" name="appointment_invoice_checked" value="0"  <?php if($appointments->appointment_invoice_checked == 0){ echo 'checked';}; ?>>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label><?php _trans('yes'); ?> &nbsp
                                    <input type="radio" class="appointment_invoice_checked" name="appointment_invoice_checked" value="1"  <?php if($appointments->appointment_invoice_checked == 1){ echo 'checked';}; ?>>
                                </label>
                            </div>
                        </div>

                        <div class="form-group sel <?php if($appointments->appointment_invoice_checked == 0){ echo 'hidden';}; ?> ">
                            <label for="appointment_recurring"><?php _trans('appointment_select_product_services'); ?></label>
                            <select name="appointment_product_id" id="appointment_recurring" class="form-control simple-select">

                                <?php foreach ($products as $product) { ?>
                                    <option value="<?=$product->product_id; ?>"
                                        <?php check_select($appointments->appointment_product_id, $product->product_id); ?>
                                    ><?php echo $product->product_name ?></option>
                                <?php } ?>




                            </select>
                        </div>


                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('extra_information'); ?>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="project_id"><?php _trans('project'); ?>: </label>
                                    <select name="project_id" id="project_id" class="form-control simple-select">
                                        <option <?= !isset($appointments->project_id) ? 'selected' :''  ?> value=""><?php _trans('select_project'); ?></option>
                                        <?php foreach ($projects as $project) { ?>

                                            <option <?= $appointments->project_id == $project->project_id ? 'selected' :'' ?> value="<?=$project->project_id; ?>" >
                                                <?=htmlspecialchars($project->project_name); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="appointment_status"><?php _trans('status'); ?></label>
                                    <select name="appointment_status" id="appointment_status" class="form-control simple-select">
                                        <?php foreach ($appointment_statuses as $key => $status) {
                                            if ($appointments->appointment_status != 4 && ($key == 4 || $key == 5)) {
                                                continue;
                                            } ?>
                                            <option value="<?php echo $key; ?>" <?php check_select($key, $appointments->appointment_status); ?>>
                                                <?php echo $status['label']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-6 ">


                <?php if (!is_null($appointments->appointment_url_key) && !empty($appointments->appointment_url_key)) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"> Guest URL</div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="appointment_url_key"><?php _trans('appointment_option_to_view_appointment'); ?></label>
                                <div class="input-group">
                                    <input type="text" name="appointment_url_key" readonly id="appointment_url_key" class="form-control"
                                           value="<?php echo site_url('guest/view/appointment/' .$appointments->appointment_url_key) ?>">
                                    <span class="input-group-addon to-clipboard cursor-pointer"
                                          data-clipboard-target="#appointment_url_key">
                                          <i class="fa fa-clipboard fa-fw"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <div class="row form-group">
                    <div class="col-md-5">
                        <label><?php _trans('appointment_carpool_checked'); ?></label>
                    </div>
                    <div class="col-md-2">
                        <label><?php _trans('no'); ?> &nbsp
                            <input type="radio" name="appointment_carpool_checked" value="0" <?php if($appointments->appointment_carpool_checked == 0){ echo 'checked';}; ?>>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label><?php _trans('yes'); ?> &nbsp
                            <input type="radio" name="appointment_carpool_checked" value="1" <?php if($appointments->appointment_carpool_checked == 1){ echo 'checked';}; ?>>
                        </label>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="form-group  appointment_carpool_checked recuring-period <?= ($appointments->appointment_carpool_checked == 0) ? 'hidden' : '' ?>"">
                    <div class="panel-heading">
                        <div class="col text-right">
                            <button type="button" class="btn btn-info" name="add_stop_during" <?php if(!empty($appointments->appointment_pickup_stop_time)){ echo 'disabled'; } ?>>+ Add stop during ride</button>
                        </div>
                    </div>
                    <div class="panel-body">



                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="appointment_departure_location"><?php _trans('appointment_departure_location'); ?></label>
                                <div class="input-group">
                                    <input type="text" name="appointment_departure_location" id="appointment_departure_location" class="form-control"
                                           value="<?php echo $appointments->appointment_departure_location; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="appointment_pickup_start_time"><?php _trans('appointment_pickup_start_time'); ?></label>
                                <div class="input-group">
                                    <input type="time" name="appointment_pickup_start_time" id="appointment_pickup_start_time" class="form-control"
                                           value="<?php echo $appointments->appointment_pickup_start_time; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="stop_during_ride">
                            <?php if(!empty($appointments->appointment_pickup_stop_time)){ ?>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="appointment_stop_during_ride"><?php _trans('appointment_stop_during_ride'); ?></label>
                                        <div class="input-group">
                                            <input type="text" name="appointment_stop_during_ride" id="stop_during_ride" class="form-control"
                                                   value="<?php echo $appointments->appointment_stop_during_ride; ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-plane" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="appointment_pickup_stop_time"><?php _trans('appointment_pickup_stop_time'); ?></label>
                                        <div class="input-group">
                                            <input type="time" name="appointment_pickup_stop_time" id="appointment_pickup_stop_time" class="form-control"
                                                   value="<?php echo $appointments->appointment_pickup_stop_time; ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <?php } ?>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="appointment_departure_end_location"><?php _trans('appointment_departure_end_location'); ?></label>
                                <div class="input-group">
                                    <input type="text" name="appointment_departure_end_location" id="appointment_departure_end_location" class="form-control"
                                           value="<?php echo $appointments->appointment_departure_end_location; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="appointment_pickup_end_time"><?php _trans('appointment_pickup_end_time'); ?></label>
                                <div class="input-group">
                                    <input type="time" name="appointment_pickup_end_time" id="appointment_pickup_end_time" class="form-control"
                                           value="<?php echo $appointments->appointment_pickup_end_time; ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="appointment_kilometers"><?php _trans('appointment_kilometers'); ?></label>
                <input type="number" name="appointment_kilometers" id="appointment_kilometers" class="form-control change"
                       value="<?php echo $appointments->appointment_kilometers; ?>" min = '0'>
            </div>

            <div class="row form-group">
                <div class="col-md-5">
                    <label for="appointment_recurring"><?php _trans('appointment_invoice_kilometer'); ?></label>
                </div>
                <div class="col-md-2">
                    <label><?php _trans('no'); ?> &nbsp
                        <input type="radio" name="appointment_invoice_kilometer_checked" value="0" <?php if($appointments->appointment_invoice_kilometer_checked == 0){ echo 'checked';}; ?>>
                    </label>
                </div>
                <div class="col-md-3">
                    <label><?php _trans('yes'); ?> &nbsp
                        <input type="radio" name="appointment_invoice_kilometer_checked" value="1" <?php if($appointments->appointment_invoice_kilometer_checked == 1){ echo 'checked';}; ?>>
                    </label>
                </div>
            </div>

            <div class="form-group  kilometer_checked recuring-period <?= ($appointments->appointment_invoice_kilometer_checked == 0) ? 'hidden' : '' ?>"">
            <label for="appointment_price_per_kilometer"><?php _trans('appointment_price_per_kilometer'); ?></label>
            <div class="input-group">
                <input type="number" name="appointment_price_per_kilometer" step="0.01" min="0" id="appointment_price_per_kilometer" class="form-control change"
                       value="<?php echo $appointments->appointment_price_per_kilometer; ?>">
                <div class="input-group-addon">
                    <?php echo get_setting('currency_symbol') ?>
                </div>
            </div>
            <input type="hidden" name="appointment_price_kilometor_total" value="<?php echo $appointments->appointment_total_price_kilometer; ?>">
        </div>

        <div class="row form-group">
            <div class="col-md-5">
                <label for="appointment_stayawaykey"><?php _trans('appointment_stayawaykey'); ?></label>
            </div>
            <div class="col-md-2">
                <label><?php _trans('no'); ?> &nbsp
                    <input type="radio" name="appointment_stayawaykey_checked" value="0" <?php if($appointments->appointment_stayawaykey_checked == 0){ echo 'checked';}; ?>>
                </label>
            </div>
            <div class="col-md-3">
                <label><?php _trans('yes'); ?> &nbsp
                    <input type="radio" name="appointment_stayawaykey_checked" value="1" <?php if($appointments->appointment_stayawaykey_checked == 1){ echo 'checked';}; ?>>
                </label>
            </div>
        </div>

        <div class="row form-group stayawaykey_checked <?php if($appointments->appointment_stayawaykey_checked == 0){ echo 'hidden';}; ?>">
            <div class="col-md-6">
                <label for="appointment_starting_price_per_kilometer"><?php _trans('appointment_starting_price_per_kilometer'); ?></label>
                <div class="input-group">
                    <input type="number" name="appointment_starting_price_per_kilometer" step="0.01" min="0" id="appointment_starting_price_per_kilometer" class="change form-control"
                           value="<?php echo $appointments->appointment_starting_price_per_kilometer; ?>">
                    <div class="input-group-addon">
                        €
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="appointment_stayawaykey_price_per_kilometer"><?php _trans('appointment_price_per_kilometer'); ?></label>
                <div class="input-group">
                    <input type="number" name="appointment_stayawaykey_price_per_kilometer" step="0.01" min="0" id="appointment_stayawaykey_price_per_kilometer" class="form-control change"
                           value="<?php echo $appointments->appointment_stayawaykey_price_per_kilometer; ?>">
                    <div class="input-group-addon">
                        €
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group stayawaykey_checked  <?php if($appointments->appointment_stayawaykey_checked == 0){ echo 'hidden';}; ?>">
            <label for="appointment_how_many_seats_can_you_offer"><?php _trans('appointment_how_many_seats_can_you_offer'); ?></label>

            <input type="number" name="appointment_how_many_seats_can_you_offer"  min="0" id="appointment_how_many_seats_can_you_offer" class="form-control change"
                   value="<?php echo $appointments->appointment_how_many_seats_can_you_offer; ?>">

            <!--                    <input type="hidden" name="user_tax_rate" class="change" value="--><?//=$user->user_price_per_kilometer?><!--">-->
            <input type="hidden" name="appointment_price_kilometor_total" value="<?php echo $appointments->appointment_total_price_kilometer; ?>">
            <input type="hidden" name="appointment_stayawaykey_price_kilometor_total" value="<?php echo $appointments->appointment_stayawaykey_price_kilometor_total; ?>">
        </div>


        <?php if(empty($appointments->default_hour_rate) || $appointments->default_hour_rate == 0){
            ?>
            <input type="hidden" name="default_hour_rate" id="default_hour_rate" class="amount form-control"
                   value="<?php echo $appointments->default_hour_rate; ?>">
        <?php }else{?>
            <input type="hidden" name="default_hour_rate" id="default_hour_rate" class="form-control"
                   value="<?php echo $appointments->default_hour_rate; ?>">
        <?php }?>

        <div class="panel panel-default">
            <div class="panel-heading"> Add people attending the appointment</div>
            <div class="panel-body appointment_visiting_people">
                <div class="col text-right">
                    <button type="button" class="btn btn-success" name="add_appointment">+ Add Person</button>
                </div>
            </div>
        </div>




        <div id="appointment_add_people">
            <?php
            if (!empty($data)){
                foreach ($data as $key => $appointment_add_people){ ?>
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="appointment"><?php _trans('appointment_name'); ?></label>
                                <div class="input-group">
                                    <input name="appointment[<?=$key;?>][name]" id="appointment_name" class="form-control appointment_name"
                                           value="<?=$appointment_add_people->name;?>" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-user fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="appointment_email"><?php _trans('appointment_email'); ?></label>
                                <div class="input-group">
                                    <input type="email" name="appointment[<?=$key;?>][email]" id="appointment_email" class="form-control"
                                           value="<?=$appointment_add_people->email;?>" required>
                                    <div class="input-group-addon">@</div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger delete_person" name="delete">Delete</button>
                            <button type="button" class="btn btn-success send_email" name="send_email">Email</button>
                        </div>



                    </div>

                <?php } ?>
            <?php } ?>
            <input type="hidden" value="<?=$count; ?>" name="appointment_id">
        </div>
        <input type="hidden" name="appointment_price" value="<?=$appointments->appointment_price; ?>">
        <input type="hidden" name="appointment_user_id" value="<?=$this->session->userdata('user_id'); ?>">

    </div>

    <script>

        $('input[name="appointment_recurring_checked"').on('click', function() {
            $('input[name="appointment_recurring_checked"').not(this).prop('checked', false);
        });
        $('input[name="appointment_invoice_checked"').on('click', function() {
            $('input[name="appointment_invoice_checked"').not(this).prop('checked', false);
        });

        $(document).on('click', 'input[name="appointment_invoice_kilometer_checked"]', function() {
            $('input[name="appointment_invoice_kilometer_checked"').not(this).prop('checked', false);
        });

        $('input[name="appointment_carpool_checked"').on('click', function() {
            $('input[name="appointment_carpool_checked"').not(this).prop('checked', false);
        });

        $('input[name="appointment_stayawaykey_checked"').on('click', function() {
            $('input[name="appointment_stayawaykey_checked"').not(this).prop('checked', false);
        });


        $(document).on('click', 'button[name="add_stop_during"]', function (){
            $(this).prop('disabled','disabled');
            $('.stop_during_ride').html('<div class="row form-group">\n'+
                '                                <div class="col-md-6">\n'+
                '                                    <label for="appointment_stop_during_ride">Stop during ride</label>\n'+
                '                                    <div class="input-group">\n'+
                '                                        <input type="text" name="appointment_stop_during_ride" id="stop_during_ride" class="form-control"\n'+
                '                                               value="">\n'+
                '                                        <div class="input-group-addon">\n'+
                '                                            <i class="fa fa-plane" aria-hidden="true"></i>\n'+
                '                                        </div>\n'+
                '                                    </div>\n'+
                '                                </div>\n'+
                '                                <div class="col-md-6">\n'+
                '                                    <label for="appointment_pickup_stop_time">Stop time</label>\n'+
                '                                    <div class="input-group">\n'+
                '                                        <input type="time" name="appointment_pickup_stop_time" id="appointment_pickup_stop_time" class="form-control"\n'+
                '                                               value="">\n'+
                '                                        <div class="input-group-addon">\n'+
                '                                            <i class="fa fa-clock-o fa-fw"></i>\n'+
                '                                        </div>\n'+
                '                                    </div>\n'+
                '                                </div>\n'+
                '                            </div>')
        })

        var i=1;
        var appointment_id=$('input[name="appointment_id"]').val();


        var xz = $('.appointment_name');
        var num = 0;
        for (var j = 0; j <xz.length ; j++) {
            num = +$(xz[j]).attr('name').replace(/[^\d;]/g, '');
        }



        if(appointment_id != null){
            i=(+Math.max(appointment_id,num));
            i++
        }
        $(document).on('click', 'button[name="delete"]', function (){
            $(this).parent().remove();
        });



        $(document).on('change','input[name="appointment_starting_time"]', function () {
            var start_time = $(this).val().split(':');
            var end_time = $('input[name="appointment_end_time"]').val().split(':');

            if(start_time[0] < end_time[0]){
                time_calculation(start_time,end_time)
            }else if(start_time[0] == end_time[0]){
                if(start_time[1] < end_time[1]){
                    $('input[name="appointment_end_time"]').removeClass('.error_time')
                    time_calculation(start_time,end_time)
                }
                time_calculation(start_time,end_time)
            }else{
                $('input[name="appointment_end_time"]').addClass('error_time')
                return false;
            }
        });

        $(document).on('change','input[name="appointment_end_time"]', function () {
            var end_time = $(this).val().split(':');
            var start_time = $('input[name="appointment_starting_time"]').val().split(':');

            if(start_time[0] < end_time[0]){
                time_calculation(start_time,end_time);

            }else if(start_time[0] == end_time[0]){
                if(start_time[1] < end_time[1]){
                    $('input[name="appointment_end_time"]').removeClass('.error_time')
                    time_calculation(start_time,end_time)

                }
                time_calculation(start_time,end_time)
            }else{
                $('input[name="appointment_end_time"]').addClass('error_time')
                return false;
            }
        });

        function time_calculation(start_time,end_time){
            start_time_minute = start_time[0]*60+(+start_time[1]);
            end_time_minute = end_time[0]*60+(+end_time[1]);
            var res_time = end_time_minute-start_time_minute;
            var hours = (res_time / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            $('input[name="appointment_total_time_of"]').attr('value', pad(rhours)+':'+pad(rminutes));

            var hour_rate=$('input[name="default_hour_rate"]').val();
            var hhour_rate=(hour_rate/60);
            var price=res_time*hhour_rate;

            $('input[name="appointment_price"]').val(price.toFixed(2));


        }

        $(document).on('input','.change', function () {
            //var kilometor = $(this).val()
            var kilometor = +$('input[name="appointment_kilometers"]').val();
            //var price = +$('input[name="appointment_price_per_kilometer"]').val()
            var stayawaykey_price_per_kilometer = +$('input[name="appointment_stayawaykey_price_per_kilometer"]').val()
            var total = count_kilometer(stayawaykey_price_per_kilometer,kilometor);

            var price_per_ride = +$('input[name="appointment_starting_price_per_kilometer"]').val()
            var how_many_seats_can = +$('input[name="appointment_how_many_seats_can_you_offer"]').val()

            total+=price_per_ride

            //total=total+stayawaykey_price_per_kilometer

            if(how_many_seats_can > 0){
                total=total*how_many_seats_can;
                console.log(total);
            }


            $('input[name="appointment_stayawaykey_price_kilometor_total"]').val(total)
        });

        $(document).on('change','.change', function () {
            var kilometor = $('input[name="appointment_kilometers"]').val()
            var price = $('input[name="appointment_price_per_kilometer"]').val()
            var tax = +$('input[name="user_tax_rate"]').val();
            var total;
            if(price > 0 && kilometor > 0){
                total = count_kilometer(price,kilometor);
            }

            /* if(total > 0 && tax > 0){
                  total = count_kilometer(tax,total);
             }*/

            $('input[name="appointment_price_kilometor_total"]').val(total)
        });

        function count_kilometer(price,kilometor){
            return kilometor*price;
        }

        function pad(d) {
            return (d < 10) ? '0' + d.toString() : d.toString();
        }

        // NEW CHANGE

        $(document).on('click','.add_new_person',function(){


            var name =  $(this).parent().find('#appointment_name').val()
            var email =  $(this).parent().find('#appointment_email').val()
            var json_id =  $(this).parent().find('#appointment_name').attr('name')
            json_id = parseInt(json_id.replace(/\D+/g,""));
            var _this = this;
            $.ajax({
                url:base_url+'index.php/appointments/add_new_person',
                type:'post',
                data:{
                    'appointment_id':appointment_id,
                    'name':name,
                    'email':email,
                    'json_id':json_id
                },success:function(response){
                    var div = $(
                        '<div class="panel panel-default">'+
                        '<div class="panel-body">'+
                        '<div class="form-group">'+
                        '<label for="appointment">'+name+'</label>'+
                        '<div class="input-group">'+
                        '<input name="appointment['+json_id+'][name]" id="appointment_name" class="form-control" value="'+name+'" required="">'+
                        '<div class="input-group-addon">'+
                        '<i class="fa fa-user fa-fw"></i>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label for="appointment_email">E-mail</label>'+
                        '<div class="input-group">'+
                        '<input type="email" name="appointment['+json_id+'][email]" id="appointment_email" class="form-control" value="'+email+'" required="">'+
                        '<div class="input-group-addon">@</div>'+
                        '</div>'+
                        '</div>'+
                        '<button type="button" class="btn btn-danger delete_person" name="delete">Delete</button>'+
                        '<button type="button" class="btn btn-success send_email" name="send_email">Email</button>'+
                        '</div>'+

                        '<input type="hidden" value="3" name="appointment_id">'+

                        '</div>'
                    );
                    $("#appointment_add_people").append(div);
                }
            })
        })



        $(document).on('click','.delete_person',function(){
            var _this = this;
            var name =  $(this).parent().find('#appointment_name').val();
            var email =  $(this).parent().find('#appointment_email').val();

            var json_id =  $(this).parent().find('#appointment_name').attr('name');
            json_id = parseInt(json_id.replace(/\D+/g,""));
            $.ajax({
                type:'post',
                url:base_url+'index.php/appointments/delete_person',
                data:{
                    'appointment_id':appointment_id,
                    'json_id':json_id,
                    'name':name,
                    'email':email
                },
                success:function(response){
                    $(_this).parents(".panel-default").remove();
                }
            })
        });


        $(document).on('click','.send_email',function(){
            var _this = this;
            var name =  $(this).parent().find('#appointment_name').val();
            var email =  $(this).parent().find('#appointment_email').val();
            var appoinment_name=  $('#appointment_title').val();
            var appoinment_url=  $('#appointment_url_key').val();

            var json_id =  $(this).parent().find('#appointment_name').attr('name');
            json_id = parseInt(json_id.replace(/\D+/g,""));
            $.ajax({
                type:'post',
                url:base_url+'index.php/appointments/send_email',
                data:{
                    'appointment_id':appointment_id,
                    'json_id':json_id,
                    'name':name,
                    'email':email,
                    'appoinment_url':appoinment_url,
                    'appoinment_name':appoinment_name
                },
                success:function(response){
                    $(this).attr('disabled',true);
                }
            })
        })






        $(document).on('change','#appointment_templates',function(e){
            var template_id = $(this).val();
            $.ajax({
                type:'post',
                url:base_url+'/index.php/appointments/select_templates',
                data:{
                    'template_id':template_id,
                },
                cache: false,
                async: false,
                success:function(data){

                    $('#appointment-form').html(data)
                }
            })

        })






    </script>
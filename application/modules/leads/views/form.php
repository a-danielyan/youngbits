<script type="text/javascript">
    $(function () {
        $("#lead_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
    $(function () {
        $("#lead_country_delivery").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('lead_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_leads->form_value('is_update')) {
                echo 'value="1"';
            } else {
                echo 'value="0"';
            } ?>
        >

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading form-inline clearfix">
                        <?php _trans('personal_information'); ?>

                        <div class="pull-right">
                            <label for="lead_active" class="control-label">
                                <?php _trans('active_lead'); ?>
                                <input id="lead_active" name="lead_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_leads->form_value('lead_active') == 1
                                        || !is_numeric($this->mdl_leads->form_value('lead_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="lead_number_id">
                                <?php _trans('id'); ?>
                            </label>
                            <input id="lead_number_id" name="lead_number_id" type="number" min="0" class="form-control"
                                   autofocus
                                   value="<?php echo $this->mdl_leads->form_value('lead_number_id', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lead_name">
                                <?php _trans('lead_name'); ?>
                            </label>
                            <input id="lead_name" name="lead_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_leads->form_value('lead_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lead_surname">
                                <?php _trans('lead_surname_optional'); ?>
                            </label>
                            <input id="lead_surname" name="lead_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_leads->form_value('lead_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lead_surname_contactperson">
                                <?php _trans('lead_surname_contactperson'); ?>
                            </label>
                            <input id="lead_surname_contactperson" name="lead_surname_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_leads->form_value('lead_surname_contactperson', true); ?>">
                        </div>


                        <div class="form-group">
                            <label for="lead_function_contactperson">
                                <?php _trans('lead_function_contactperson'); ?>
                            </label>
                            <input id="lead_function_contactperson" name="lead_function_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_leads->form_value('lead_function_contactperson', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lead_responsible"><?php _trans('responsibles'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_responsible" id="lead_responsible" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_responsible', true); ?>">
                            </div>
                        </div>

                        <div class="form-group no-margin">
                            <label for="target_group_id">
                                <?php _trans('group'); ?>
                            </label>
                            <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR) { ?>
                            <select name="lead_group_id[]" id="lead_group_id" class="form-control simple-select" multiple>

                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <option value="<?=$user_group->group_id; ?>"
                                            <?php if(is_array(json_decode($this->mdl_leads->form_value('lead_group_id')))){
                                                foreach (json_decode($this->mdl_leads->form_value('lead_group_id')) as $key){
                                                    check_select($key, $user_group->group_id);
                                                }
                                            }else{
                                                 check_select($this->mdl_leads->form_value('lead_group_id'), $user_group->group_id);
                                            } ?>>

                                            <?=$user_group->group_name; ?>
                                        </option>
                                    <?php } ?>
                            </select>
                            <?php }else{ ?>
                            <select name="lead_group_id[]" id="lead_group_id" class="form-control simple-select" multiple disabled>
                                <?php foreach ($user_groups as $user_group) { ?>
                                    <?php if($this->session->userdata('user_group_id') == $user_group->group_id){ ?>
                                        <option value="<?=$user_group->group_id; ?>"
                                            <?php check_select($this->session->userdata('user_group_id'), $user_group->group_id); ?>>
                                            <?=$user_group->group_name?>

                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="lead_category"><?php _trans('category'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_category" id="lead_category" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_category', true); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="lead_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_city" id="lead_city" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="lead_country" id="lead_country" class="form-control">
                                    <option value=""><?php _trans('none'); ?></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                            <?php check_select($selected_country, $cldr); ?>
                                        ><?php echo $country ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_sector"><?php _trans('sector'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_sector" id="lead_sector" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_sector', true); ?>">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('contact_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="lead_phone"><?php _trans('phone_number'); ?></label>
                            <div class="controls">
                                <input type="text" name="lead_phone" id="lead_phone" class="form-control" value="<?php echo $this->mdl_leads->form_value('lead_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_email"><?php _trans('email_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="lead_email" id="lead_email" class="form-control" value="<?php echo $this->mdl_leads->form_value('lead_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_email2"><?php _trans('email_address'); ?> 2</label>
                            <div class="controls">
                                <input type="text" name="lead_email2" id="lead_email2" class="form-control" value="<?php echo $this->mdl_leads->form_value('lead_email2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_mobile"><?php _trans('phone_number'); ?> 2 / <?php _trans('fax_number'); ?> </label>
                            <div class="controls">
                                <input type="text" name="lead_mobile" id="lead_mobile" class="form-control" value="<?php echo $this->mdl_leads->form_value('lead_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_web"><?php _trans('web_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="lead_web" id="lead_web" class="form-control" value="<?php echo $this->mdl_leads->form_value('lead_web', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_sell_services_products"><?php _trans('sell_services_products'); ?></label>
                            <div class="controls">
                                <input type="text" name="lead_sell_services_products" id="lead_sell_services_products" class="form-control" value="<?php echo $this->mdl_leads->form_value('lead_sell_services_products', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_email_sent" class="control-label"><?php _trans('email_sent'); ?>
                                <input type="checkbox" name="lead_email_sent" id="lead_email_sent"  value="1"  <?=($this->mdl_leads->form_value('lead_email_sent') == 1)?  ' checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('personal_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="lead_gender"><?php _trans('gender'); ?></label>

                            <div class="controls">
                                <select name="lead_gender" id="lead_gender" class="form-control simple-select">
                                    <?php
                                    $genders = array(
                                        trans('gender_male'),
                                        trans('gender_female'),
                                        trans('gender_other'),
                                    );
                                    foreach ($genders as $key => $val) { ?>
                                        <option value=" <?php echo $key; ?>" <?php check_select($key, $this->mdl_leads->form_value('lead_gender')) ?>>
                                            <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="lead_birthdate"><?php _trans('birthdate'); ?></label>
                            <?php
                            $bdate = $this->mdl_leads->form_value('lead_birthdate');
                            if ($bdate && $bdate != "0000-00-00") {
                                $bdate = date_from_mysql($bdate);
                            } else {
                                $bdate = '';
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" name="lead_birthdate" id="lead_birthdate"
                                       class="form-control datepicker"
                                       value="<?php _htmlsc($bdate); ?>">
                                <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="form-group">
                                <label for="lead_avs"><?php _trans('sumex_ssn'); ?></label>
                                <?php $avs = $this->mdl_leads->form_value('lead_avs'); ?>
                                <div class="controls">
                                    <input type="text" name="lead_avs" id="lead_avs" class="form-control"
                                           value="<?php echo htmlspecialchars(format_avs($avs)); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lead_insurednumber"><?php _trans('sumex_insurednumber'); ?></label>
                                <?php $insuredNumber = $this->mdl_leads->form_value('lead_insurednumber'); ?>
                                <div class="controls">
                                    <input type="text" name="lead_insurednumber" id="lead_insurednumber"
                                           class="form-control"
                                           value="<?php echo htmlentities($insuredNumber); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lead_veka"><?php _trans('sumex_veka'); ?></label>
                                <?php $veka = $this->mdl_leads->form_value('lead_veka'); ?>
                                <div class="controls">
                                    <input type="text" name="lead_veka" id="lead_veka" class="form-control"
                                           value="<?php echo htmlentities($veka); ?>">
                                </div>
                            </div>

                        <?php endif; ?>


                        <div class="form-group">
                            <label for="lead_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="lead_language" id="lead_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php foreach ($languages as $language) {
                                    $lead_lang = $this->mdl_leads->form_value('lead_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($lead_lang, $language) ?>>
                                        <?php echo ucfirst($language); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>







        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('address'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="lead_address_1"><?php _trans('street_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="lead_address_1" id="lead_address_1" class="form-control"  value="<?php echo $this->mdl_leads->form_value('lead_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_state" id="lead_state" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_zip" id="lead_zip" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_zip', true); ?>">
                            </div>
                        </div>


                    </div>

                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('delivery_address'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="lead_address_1_delivery"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_address_1_delivery" id="lead_address_1_delivery" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_address_1_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_state_delivery"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_state_delivery" id="lead_state_delivery" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_state_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_zip_delivery"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_zip_delivery" id="lead_zip_delivery" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_zip_delivery', true); ?>">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('client_additional_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group no-margin">
                            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                <label for="lead_file"><?php _trans('file'); ?></label>
                                <input type="text" name="lead_file" id="lead_file" class="form-control" readonly
                                       value="<?php echo $this->mdl_leads->form_value('lead_file'); ?>">
                            </div>
                            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                <label for="lead_file_test">&nbsp;</label>
                                <br />
                                <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('add_file'); ?>" onclick="document.getElementById('attached_lead_file').click();" />
                                <input type="file" style="display:none;" id="attached_lead_file" name="attached_lead_file" accept=".doc,.docx,.pdf" onchange="document.getElementById('lead_file').value=this.value;"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                <label for="lead_tax_code"><?php _trans('client_additional_information'); ?></label>
                                <textarea name="lead_additional_information" rows="10" class="form-control"><?=$this->mdl_leads->form_value('lead_additional_information', true); ?></textarea>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('tax_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="lead_vat_id"><?php _trans('vat_id'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_vat_id" id="lead_vat_id" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_vat_id', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lead_tax_code"><?php _trans('tax_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="lead_tax_code" id="lead_tax_code" class="form-control"
                                       value="<?php echo $this->mdl_leads->form_value('lead_tax_code', true); ?>">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('commission_rates'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">

                            <div class="controls">
                                <select name="commission_rate_id" id="commission_rate_id" class="form-control">
                                    <option value=""><?php _trans('none'); ?></option>
                                    <?php foreach($commission_rates as $commission_rate){  ?>
                                        <option value="<?=$commission_rate->commission_rate_id; ?>"
                                            <?php check_select($commission_rate->commission_rate_id, $this->mdl_clients->form_value('commission_rate_id')); ?>
                                        ><?=$commission_rate->commission_rate_name.' - '.$commission_rate->commission_rate_percent ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>


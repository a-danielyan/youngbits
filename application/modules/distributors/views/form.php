<script type="text/javascript">
    $(function () {
        $("#distributor_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
    $(function () {
        $("#distributor_country_delivery").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('distributor_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_distributors->form_value('is_update')) {
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
                            <label for="distributor_active" class="control-label">
                                <?php _trans('active_distributor'); ?>
                                <input id="distributor_active" name="distributor_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_distributors->form_value('distributor_active') == 1
                                        || !is_numeric($this->mdl_distributors->form_value('distributor_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="distributor_number_id">
                                <?php _trans('id'); ?>
                            </label>
                            <input id="distributor_number_id" name="distributor_number_id" type="number" min="0" class="form-control"
                                   autofocus
                                   value="<?php echo $this->mdl_distributors->form_value('distributor_number_id', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="distributor_name">
                                <?php _trans('distributor_name'); ?>
                            </label>
                            <input id="distributor_name" name="distributor_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_distributors->form_value('distributor_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="distributor_surname">
                                <?php _trans('distributor_surname_optional'); ?>
                            </label>
                            <input id="distributor_surname" name="distributor_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_distributors->form_value('distributor_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="distributor_surname_contactperson">
                                <?php _trans('distributor_surname_contactperson'); ?>
                            </label>
                            <input id="distributor_surname_contactperson" name="distributor_surname_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_distributors->form_value('distributor_surname_contactperson', true); ?>">
                        </div>


                        <div class="form-group">
                            <label for="distributor_function_contactperson">
                                <?php _trans('distributor_function_contactperson'); ?>
                            </label>
                            <input id="distributor_function_contactperson" name="distributor_function_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_distributors->form_value('distributor_function_contactperson', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="distributor_responsible"><?php _trans('responsibles'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_responsible" id="distributor_responsible" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_responsible', true); ?>">
                            </div>
                        </div>

                        <div class="form-group no-margin">
                            <label for="target_group_id">
                                <?php _trans('group'); ?>
                            </label>
                            <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR) { ?>
                            <select name="distributor_group_id[]" id="distributor_group_id" class="form-control simple-select" multiple>

                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <option value="<?=$user_group->group_id; ?>"
                                            <?php if(is_array(json_decode($this->mdl_distributors->form_value('distributor_group_id')))){
                                                foreach (json_decode($this->mdl_distributors->form_value('distributor_group_id')) as $key){
                                                    check_select($key, $user_group->group_id);
                                                }
                                            }else{
                                                 check_select($this->mdl_distributors->form_value('distributor_group_id'), $user_group->group_id);
                                            } ?>>

                                            <?=$user_group->group_name; ?>
                                        </option>
                                    <?php } ?>
                            </select>
                            <?php }else{ ?>
                            <select name="distributor_group_id[]" id="distributor_group_id" class="form-control simple-select" multiple disabled>
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
                            <label for="distributor_category"><?php _trans('category'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_category" id="distributor_category" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_category', true); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="distributor_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_city" id="distributor_city" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="distributor_country" id="distributor_country" class="form-control">
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
                            <label for="distributor_sector"><?php _trans('sector'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_sector" id="distributor_sector" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_sector', true); ?>">
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
                            <label for="distributor_phone"><?php _trans('phone_number'); ?></label>
                            <div class="controls">
                                <input type="text" name="distributor_phone" id="distributor_phone" class="form-control" value="<?php echo $this->mdl_distributors->form_value('distributor_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_email"><?php _trans('email_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="distributor_email" id="distributor_email" class="form-control" value="<?php echo $this->mdl_distributors->form_value('distributor_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_email2"><?php _trans('email_address'); ?> 2</label>
                            <div class="controls">
                                <input type="text" name="distributor_email2" id="distributor_email2" class="form-control" value="<?php echo $this->mdl_distributors->form_value('distributor_email2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_mobile"><?php _trans('phone_number'); ?> 2 / <?php _trans('fax_number'); ?> </label>
                            <div class="controls">
                                <input type="text" name="distributor_mobile" id="distributor_mobile" class="form-control" value="<?php echo $this->mdl_distributors->form_value('distributor_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_web"><?php _trans('web_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="distributor_web" id="distributor_web" class="form-control" value="<?php echo $this->mdl_distributors->form_value('distributor_web', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_sell_services_products"><?php _trans('sell_services_products'); ?></label>
                            <div class="controls">
                                <input type="text" name="distributor_sell_services_products" id="distributor_sell_services_products" class="form-control" value="<?php echo $this->mdl_distributors->form_value('distributor_sell_services_products', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_email_sent" class="control-label"><?php _trans('email_sent'); ?>
                                <input type="checkbox" name="distributor_email_sent" id="distributor_email_sent"  value="1"  <?=($this->mdl_distributors->form_value('distributor_email_sent') == 1)?  ' checked' : ''; ?>>
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
                            <label for="distributor_gender"><?php _trans('gender'); ?></label>

                            <div class="controls">
                                <select name="distributor_gender" id="distributor_gender" class="form-control simple-select">
                                    <?php
                                    $genders = array(
                                        trans('gender_male'),
                                        trans('gender_female'),
                                        trans('gender_other'),
                                    );
                                    foreach ($genders as $key => $val) { ?>
                                        <option value=" <?php echo $key; ?>" <?php check_select($key, $this->mdl_distributors->form_value('distributor_gender')) ?>>
                                            <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="distributor_birthdate"><?php _trans('birthdate'); ?></label>
                            <?php
                            $bdate = $this->mdl_distributors->form_value('distributor_birthdate');
                            if ($bdate && $bdate != "0000-00-00") {
                                $bdate = date_from_mysql($bdate);
                            } else {
                                $bdate = '';
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" name="distributor_birthdate" id="distributor_birthdate"
                                       class="form-control datepicker"
                                       value="<?php _htmlsc($bdate); ?>">
                                <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="form-group">
                                <label for="distributor_avs"><?php _trans('sumex_ssn'); ?></label>
                                <?php $avs = $this->mdl_distributors->form_value('distributor_avs'); ?>
                                <div class="controls">
                                    <input type="text" name="distributor_avs" id="distributor_avs" class="form-control"
                                           value="<?php echo htmlspecialchars(format_avs($avs)); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="distributor_insurednumber"><?php _trans('sumex_insurednumber'); ?></label>
                                <?php $insuredNumber = $this->mdl_distributors->form_value('distributor_insurednumber'); ?>
                                <div class="controls">
                                    <input type="text" name="distributor_insurednumber" id="distributor_insurednumber"
                                           class="form-control"
                                           value="<?php echo htmlentities($insuredNumber); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="distributor_veka"><?php _trans('sumex_veka'); ?></label>
                                <?php $veka = $this->mdl_distributors->form_value('distributor_veka'); ?>
                                <div class="controls">
                                    <input type="text" name="distributor_veka" id="distributor_veka" class="form-control"
                                           value="<?php echo htmlentities($veka); ?>">
                                </div>
                            </div>

                        <?php endif; ?>


                        <div class="form-group">
                            <label for="distributor_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="distributor_language" id="distributor_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php foreach ($languages as $language) {
                                    $distributor_lang = $this->mdl_distributors->form_value('distributor_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($distributor_lang, $language) ?>>
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
                            <label for="distributor_address_1"><?php _trans('street_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="distributor_address_1" id="distributor_address_1" class="form-control"  value="<?php echo $this->mdl_distributors->form_value('distributor_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_state" id="distributor_state" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_zip" id="distributor_zip" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_zip', true); ?>">
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
                            <label for="distributor_address_1_delivery"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_address_1_delivery" id="distributor_address_1_delivery" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_address_1_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_state_delivery"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_state_delivery" id="distributor_state_delivery" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_state_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_zip_delivery"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_zip_delivery" id="distributor_zip_delivery" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_zip_delivery', true); ?>">
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
                                <label for="distributor_file"><?php _trans('file'); ?></label>
                                <input type="text" name="distributor_file" id="distributor_file" class="form-control" readonly
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_file'); ?>">
                            </div>
                            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                <label for="distributor_file_test">&nbsp;</label>
                                <br />
                                <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('add_file'); ?>" onclick="document.getElementById('attached_distributor_file').click();" />
                                <input type="file" style="display:none;" id="attached_distributor_file" name="attached_distributor_file" accept=".jpeg, .jpg, .png,.doc,.docx,.pdf" onchange="document.getElementById('distributor_file').value=this.value;"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                <label for="distributor_tax_code"><?php _trans('client_additional_information'); ?></label>
                                <textarea name="distributor_additional_information" rows="10" class="form-control"><?=$this->mdl_distributors->form_value('distributor_additional_information', true); ?></textarea>
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
                            <label for="distributor_vat_id"><?php _trans('vat_id'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_vat_id" id="distributor_vat_id" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_vat_id', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distributor_tax_code"><?php _trans('tax_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="distributor_tax_code" id="distributor_tax_code" class="form-control"
                                       value="<?php echo $this->mdl_distributors->form_value('distributor_tax_code', true); ?>">
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


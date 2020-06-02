<script type="text/javascript">
    $(function () {
        $("#supplier_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
    $(function () {
        $("#supplier_country_delivery").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('supplier_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_suppliers->form_value('is_update')) {
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
                            <label for="supplier_active" class="control-label">
                                <?php _trans('active_supplier'); ?>
                                <input id="supplier_active" name="supplier_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_suppliers->form_value('supplier_active') == 1
                                        || !is_numeric($this->mdl_suppliers->form_value('supplier_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="supplier_number_id">
                                <?php _trans('id'); ?>
                            </label>
                            <input id="supplier_number_id" name="supplier_number_id" type="number" min="0" class="form-control"
                                   autofocus
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_number_id', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="supplier_name">
                                <?php _trans('supplier_name'); ?>
                            </label>
                            <input id="supplier_name" name="supplier_name" type="text" class="form-control"
                                   autofocus
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="supplier_surname">
                                <?php _trans('supplier_surname_optional'); ?>
                            </label>
                            <input id="supplier_surname" name="supplier_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="supplier_surname_contactperson">
                                <?php _trans('supplier_surname_contactperson'); ?>
                            </label>
                            <input id="supplier_surname_contactperson" name="supplier_surname_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_surname_contactperson', true); ?>">
                        </div>


                        <div class="form-group">
                            <label for="supplier_function_contactperson">
                                <?php _trans('supplier_function_contactperson'); ?>
                            </label>
                            <input id="supplier_function_contactperson" name="supplier_function_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_function_contactperson', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="supplier_responsible"><?php _trans('responsibles'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_responsible" id="supplier_responsible" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_responsible', true); ?>">
                            </div>
                        </div>

                        <div class="form-group no-margin">
                            <label for="target_group_id">
                                <?php _trans('group'); ?>
                            </label>
                            <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR) { ?>
                            <select name="supplier_group_id[]" id="supplier_group_id" class="form-control simple-select" multiple>

                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <option value="<?=$user_group->group_id; ?>"
                                            <?php if(is_array(json_decode($this->mdl_suppliers->form_value('supplier_group_id')))){
                                                foreach (json_decode($this->mdl_suppliers->form_value('supplier_group_id')) as $key){
                                                    check_select($key, $user_group->group_id);
                                                }
                                            }else{
                                                 check_select($this->mdl_suppliers->form_value('supplier_group_id'), $user_group->group_id);
                                            } ?>>

                                            <?=$user_group->group_name; ?>
                                        </option>
                                    <?php } ?>
                            </select>
                            <?php }else{ ?>
                            <select name="supplier_group_id[]" id="supplier_group_id" class="form-control simple-select" multiple disabled>
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
                            <label for="supplier_category"><?php _trans('category'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_category" id="supplier_category" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_category', true); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="supplier_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_city" id="supplier_city" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="supplier_country" id="supplier_country" class="form-control">
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
                            <label for="supplier_sector"><?php _trans('sector'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_sector" id="supplier_sector" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_sector', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_id">
                                <?php _trans('product'); ?>
                            </label>


                            <select name="supplier_id" id="supplier_id" class="form-control simple-select" >
                                <option value="0"><?php _trans('select_product'); ?></option>
                                <?php foreach ($products as $product) { ?>
                                    <option value="<?php echo $product->product_id; ?>"
                                        <?php ($product->supplier_id != null)?check_select($product->supplier_id, $this->mdl_suppliers->form_value('supplier_id')): '' ;?>>
                                        <?php echo $product->product_name;?>
                                    </option>
                                <?php } ?>
                            </select>
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
                            <label for="supplier_phone"><?php _trans('phone_number'); ?></label>
                            <div class="controls">
                                <input type="text" name="supplier_phone" id="supplier_phone" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_email"><?php _trans('email_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="supplier_email" id="supplier_email" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_email2"><?php _trans('email_address'); ?> 2</label>
                            <div class="controls">
                                <input type="text" name="supplier_email2" id="supplier_email2" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_email2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_mobile"><?php _trans('phone_number'); ?> 2 / <?php _trans('fax_number'); ?> </label>
                            <div class="controls">
                                <input type="text" name="supplier_mobile" id="supplier_mobile" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_web"><?php _trans('web_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="supplier_web" id="supplier_web" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_web', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_sell_services_products"><?php _trans('sell_services_products'); ?></label>
                            <div class="controls">
                                <input type="text" name="supplier_sell_services_products" id="supplier_sell_services_products" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_sell_services_products', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_email_sent" class="control-label"><?php _trans('email_sent'); ?>
                                <input type="checkbox" name="supplier_email_sent" id="supplier_email_sent"  value="1"  <?=($this->mdl_suppliers->form_value('supplier_email_sent') == 1)?  ' checked' : ''; ?>>
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
                            <label for="supplier_gender"><?php _trans('gender'); ?></label>

                            <div class="controls">
                                <select name="supplier_gender" id="supplier_gender" class="form-control simple-select">
                                    <?php
                                    $genders = array(
                                        trans('gender_male'),
                                        trans('gender_female'),
                                        trans('gender_other'),
                                    );
                                    foreach ($genders as $key => $val) { ?>
                                        <option value=" <?php echo $key; ?>" <?php check_select($key, $this->mdl_suppliers->form_value('supplier_gender')) ?>>
                                            <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="supplier_birthdate"><?php _trans('birthdate'); ?></label>
                            <?php
                            $bdate = $this->mdl_suppliers->form_value('supplier_birthdate');
                            if ($bdate && $bdate != "0000-00-00") {
                                $bdate = date_from_mysql($bdate);
                            } else {
                                $bdate = '';
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" name="supplier_birthdate" id="supplier_birthdate"
                                       class="form-control datepicker"
                                       value="<?php _htmlsc($bdate); ?>">
                                <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="form-group">
                                <label for="supplier_avs"><?php _trans('sumex_ssn'); ?></label>
                                <?php $avs = $this->mdl_suppliers->form_value('supplier_avs'); ?>
                                <div class="controls">
                                    <input type="text" name="supplier_avs" id="supplier_avs" class="form-control"
                                           value="<?php echo htmlspecialchars(format_avs($avs)); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="supplier_insurednumber"><?php _trans('sumex_insurednumber'); ?></label>
                                <?php $insuredNumber = $this->mdl_suppliers->form_value('supplier_insurednumber'); ?>
                                <div class="controls">
                                    <input type="text" name="supplier_insurednumber" id="supplier_insurednumber"
                                           class="form-control"
                                           value="<?php echo htmlentities($insuredNumber); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="supplier_veka"><?php _trans('sumex_veka'); ?></label>
                                <?php $veka = $this->mdl_suppliers->form_value('supplier_veka'); ?>
                                <div class="controls">
                                    <input type="text" name="supplier_veka" id="supplier_veka" class="form-control"
                                           value="<?php echo htmlentities($veka); ?>">
                                </div>
                            </div>

                        <?php endif; ?>


                        <div class="form-group">
                            <label for="supplier_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="supplier_language" id="supplier_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php foreach ($languages as $language) {
                                    $supplier_lang = $this->mdl_suppliers->form_value('supplier_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($supplier_lang, $language) ?>>
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
                            <label for="supplier_address_1"><?php _trans('street_address'); ?></label>
                            <div class="controls">
                                <input type="text" name="supplier_address_1" id="supplier_address_1" class="form-control"  value="<?php echo $this->mdl_suppliers->form_value('supplier_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_state" id="supplier_state" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_zip" id="supplier_zip" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_zip', true); ?>">
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
                            <label for="supplier_address_1_delivery"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_address_1_delivery" id="supplier_address_1_delivery" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_address_1_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_state_delivery"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_state_delivery" id="supplier_state_delivery" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_state_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_zip_delivery"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_zip_delivery" id="supplier_zip_delivery" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_zip_delivery', true); ?>">
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
                                <label for="supplier_file"><?php _trans('file'); ?></label>
                                <input type="text" name="supplier_file" id="supplier_file" class="form-control" readonly
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_file'); ?>">
                            </div>
                            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                <label for="supplier_file_test">&nbsp;</label>
                                <br />
                                <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('add_file'); ?>" onclick="document.getElementById('attached_supplier_file').click();" />
                                <input type="file" style="display:none;" id="attached_supplier_file" name="attached_supplier_file" accept=".jpeg, .jpg, .png,.doc,.docx,.pdf" onchange="document.getElementById('supplier_file').value=this.value;"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                <label for="supplier_tax_code"><?php _trans('client_additional_information'); ?></label>
                                <textarea name="supplier_additional_information" rows="10" class="form-control"><?=$this->mdl_suppliers->form_value('supplier_additional_information', true); ?></textarea>
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
                            <label for="supplier_vat_id"><?php _trans('vat_id'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_vat_id" id="supplier_vat_id" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_vat_id', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_tax_code"><?php _trans('tax_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_tax_code" id="supplier_tax_code" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_tax_code', true); ?>">
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


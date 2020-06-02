<?php
$cv = $this->controller->view_data['custom_values'];
?>
<?php if($this->session->userdata('user_type') !== TYPE_ADMINISTRATOR){ ?>
<script type="text/javascript">
    $(function () {
        $("#client_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
    $(function () {
        $("#client_country_delivery").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">

        <h1 class="headerbar-title"><?php _trans('client_form'); ?></h1>

        <?php if(!empty($groups) && count($groups) == 1  && $this->session->userdata('user_type') != TYPE_ADMIN){
            $this->layout->load_view('layout/header_buttons');
        }else{
            $this->layout->load_view('layout/header_buttons');
        }
        ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_clients->form_value('is_update')) {
                    echo 'value="1"';
                } else {
                    echo 'value="0"';
                }
            ?> >

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading form-inline clearfix">
                        <?php _trans('personal_information'); ?>

                        <div class="pull-right">
                            <label for="client_active" class="control-label">
                                <?php _trans('active_client'); ?>
                                <input id="client_active" name="client_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_clients->form_value('client_active') == 1
                                        || !is_numeric($this->mdl_clients->form_value('client_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="client_name">
                                <?php _trans('client_name'); ?>
                            </label>
                            <input id="client_name" name="client_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_clients->form_value('client_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="client_first_name">
                                <?php _trans('client_first_name'); ?>
                            </label>
                            <input id="client_first_name" name="client_first_name" type="text" class="form-control"
                                   value="<?php echo $this->mdl_clients->form_value('client_first_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="client_surname">
                                <?php _trans('client_surname'); ?>
                            </label>
                            <input id="client_surname" name="client_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_clients->form_value('client_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="client_function_contactperson">
                                <?php _trans('client_function_contactperson'); ?>
                            </label>
                            <input id="client_function_contactperson" name="client_function_contactperson" type="text" class="form-control"
                                   value="<?php echo $this->mdl_clients->form_value('client_function_contactperson', true); ?>">
                        </div>


                        <div class="form-group">
                            <label for="client_responsible">
                                <?php _trans('responsibles'); ?>
                            </label>
                            <input id="client_responsible" name="client_responsible" type="text" class="form-control" value="<?php echo $this->mdl_clients->form_value('client_responsible', true); ?>">
                        </div>




                        <?php if($this->session->userdata('user_type') == TYPE_ADMIN){ ?>
                            <div class="form-group no-margin">
                                <label for="client_group_id">
                                    <?php _trans('group'); ?>
                                </label>
                                <select name="client_group_id[]" id="client_group_id" class="form-control simple-select" multiple>
                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <option value="<?php echo $user_group->group_id; ?>"
                                            <?php
                                            foreach ($client_groups as $client_group){
                                                if ($client_group["group_id"] == $user_group->group_id)
                                                {
                                                    check_select($user_group->group_id, $user_group->group_id);
                                                    break;
                                                }
                                            }?>>
                                            <?php echo $user_group->group_name;?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else{ ?>
                            <div class="form-group no-margin">
                                <label for="client_group_id">
                                    <?php _trans('group'); ?>

                                </label>
                                <select name="client_group_id[]" id="client_group_id" class="form-control simple-select">
                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <?php if($user_group->group_id == $this->session->userdata('user_group_id')){ ?>
                                            <option value="<?=$user_group->group_id; ?>"
                                                <?php check_select(+$this->session->userdata('user_group_id'), $user_group->group_id); ?>>

                                                    <?=$user_group->group_name?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>


                        <div class="form-group">
                            <label for="client_category">
                                <?php _trans('category'); ?>
                            </label>
                            <input id="client_category" name="client_category" type="text" class="form-control"
                                   value="<?php echo $this->mdl_clients->form_value('client_category', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="client_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_city" id="client_city" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_city', true); ?>">
                            </div>
                        </div>

                        <!-- country_code -->

                        <div class="form-group">
                            <label for="client_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="client_country" id="client_country" class="form-control">
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
                            <label for="client_sector"><?php _trans('sector'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_sector" id="client_sector" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_sector', true); ?>">
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
                            <label for="client_phone"><?php _trans('phone_number'); ?></label>

                            <div class="controls">
                                <input name="client_phone" id="client_phone" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_email"><?php _trans('email_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_email" id="client_email" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_email2"><?php _trans('email_address'); ?>2</label>

                            <div class="controls">
                                <input type="text" name="client_email2" id="client_email2" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_email2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_fax"><?php _trans('phone_number'); ?> 2 / <?php _trans('fax_number'); ?> </label>

                            <div class="controls">
                                <input  name="client_mobile" id="client_mobile" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_web"><?php _trans('web_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_web" id="client_web" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_web', true); ?>">
                            </div>
                        </div>

                        <!-- Custom fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 2) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>


                    </div>

                </div>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('personal_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="client_gender"><?php _trans('gender'); ?></label>

                            <div class="controls">
                                <select name="client_gender" id="client_gender" class="form-control simple-select">
                                    <?php
                                    $genders = array(
                                        trans('gender_male'),
                                        trans('gender_female'),
                                        trans('gender_other'),
                                    );
                                    foreach ($genders as $key => $val) { ?>
                                        <option value=" <?php echo $key; ?>" <?php check_select($key, $this->mdl_clients->form_value('client_gender')) ?>>
                                            <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="client_birthdate"><?php _trans('birthdate'); ?></label>
                            <?php
                            $bdate = $this->mdl_clients->form_value('client_birthdate');
                            if ($bdate && $bdate != "0000-00-00") {
                                $bdate = date_from_mysql($bdate);
                            } else {
                                $bdate = '';
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" name="client_birthdate" id="client_birthdate"
                                       class="form-control datepicker"
                                       value="<?php _htmlsc($bdate); ?>">
                                <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="form-group">
                                <label for="client_avs"><?php _trans('sumex_ssn'); ?></label>
                                <?php $avs = $this->mdl_clients->form_value('client_avs'); ?>
                                <div class="controls">
                                    <input type="text" name="client_avs" id="client_avs" class="form-control"
                                           value="<?php echo htmlspecialchars(format_avs($avs)); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_insurednumber"><?php _trans('sumex_insurednumber'); ?></label>
                                <?php $insuredNumber = $this->mdl_clients->form_value('client_insurednumber'); ?>
                                <div class="controls">
                                    <input type="text" name="client_insurednumber" id="client_insurednumber"
                                           class="form-control"
                                           value="<?php echo htmlentities($insuredNumber); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_veka"><?php _trans('sumex_veka'); ?></label>
                                <?php $veka = $this->mdl_clients->form_value('client_veka'); ?>
                                <div class="controls">
                                    <input type="text" name="client_veka" id="client_veka" class="form-control"
                                           value="<?php echo htmlentities($veka); ?>">
                                </div>
                            </div>

                        <?php endif; ?>

                        <!-- Custom fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 3) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>


                        <div class="form-group">
                            <label for="client_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="client_language" id="client_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php foreach ($languages as $language) {
                                    $client_lang = $this->mdl_clients->form_value('client_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($client_lang, $language) ?>>
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
                            <label for="client_address_1"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_address_1" id="client_address_1" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_address_1', true); ?>">
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="client_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_state" id="client_state" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_zip" id="client_zip" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_zip', true); ?>">
                            </div>
                        </div>



                        <!-- Custom Fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 1) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>
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
                            <label for="client_address_1_delivery"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_address_1_delivery" id="client_address_1_delivery" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_address_1_delivery', true); ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="client_state_delivery"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_state_delivery" id="client_state_delivery" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_state_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_zip_delivery"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_zip_delivery" id="client_zip_delivery" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_zip_delivery', true); ?>">
                            </div>
                        </div>



                        <!-- Custom Fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 1) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>
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
                                <label for="client_file"><?php _trans('file'); ?></label>
                                <input type="text" name="client_file" id="client_file" class="form-control" readonly
                                       value="<?php echo $this->mdl_clients->form_value('client_file'); ?>">
                            </div>
                            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                <label for="lead_file_test">&nbsp;</label>
                                <br />
                                <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('add_file'); ?>" onclick="document.getElementById('attached_client_file').click();" />
                                <input type="file" style="display:none;" id="attached_client_file" name="attached_client_file" accept=".doc,.docx,.pdf" onchange="document.getElementById('client_file').value=this.value;"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for=""><?php _trans('client_additional_information'); ?></label>
                            <div class="controls">
                                <textarea name="client_additional_information" id="client_additional_information" cols="118" rows="10"><?= $this->mdl_clients->form_value('client_additional_information'); ?></textarea>
                            </div>
                        </div>

                        <?php if (!is_null($this->mdl_clients->form_value('client_url_key', false)) && !empty($this->mdl_clients->form_value('client_url_key', false))) { ?>
                            <div class="form-group">
                                <label for="client_url_key"><?php _trans('guest_url'); ?></label>
                                <div class="input-group">
                                    <input type="text" id="client_url_key" name="notes_url_key" readonly class="form-control"
                                           value="<?php echo site_url('guest/view/client/' .$this->mdl_clients->form_value('client_url_key', false)) ?>">
                                    <span class="input-group-addon to-clipboard cursor-pointer"
                                          data-clipboard-target="#client_url_key">
                                          <i class="fa fa-clipboard fa-fw"></i>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
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
                            <label for="client_vat_id"><?php _trans('vat_id'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_vat_id" id="client_vat_id" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_vat_id', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_tax_code"><?php _trans('tax_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_tax_code" id="client_tax_code" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_tax_code', true); ?>">
                            </div>
                        </div>

                        <!-- Custom fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 4) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>
                    </div>

                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('commission_rates'); ?> & <?php _trans('client_password'); ?>
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

                        <div class="form-group has-feedback">
                            <label for="client_guest_pass"><?php _trans('password'); ?></label>
                            <div class="input-group">
                                <input type="password" name="client_guest_pass" min="4" id="client_guest_pass"
                                       class="form-control"
                                       value="<?=$this->mdl_clients->form_value('client_guest_pass', true); ?>">
                                <span class="input-group-addon show_pass">
                                       <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <?php if ($custom_fields): ?>
            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <?php _trans('custom_fields'); ?>
                        </div>

                        <div class="panel-body">
                            <?php foreach ($custom_fields as $custom_field): ?>
                                <?php if ($custom_field->custom_field_location != 0) {
                                    continue;
                                }
                                print_field($this->mdl_clients, $custom_field, $cv);
                                ?>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</form>


<script>
    $(document).on('click', '.show_pass', function () {
        $('#client_guest_pass').attr('type','text')
        $(this).removeClass('show_pass')
        $(this).addClass('hidden_pass')

    } )
    $(document).on('click', '.hidden_pass', function () {
        $('#client_guest_pass').attr('type','password')
        $(this).removeClass('hidden_pass')
        $(this).addClass('show_pass')
    } )
</script>
<?php }else{
    redirect('/');
}
?>
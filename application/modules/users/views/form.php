<?php
$cv = $this->controller->view_data["custom_values"];
?>
<script>
    $(function () {
        show_fields();

        $('#user_type').change(function () {
            show_fields();
        });

        function show_fields() {
            $('#administrator_fields').hide();
            $('#guest_fields').hide();

            var user_type = $('#user_type').val();

            // if (user_type === '1') {
                $('#administrator_fields').show();
            // } else 
            if (user_type === '2') {
                $('#guest_fields').show();
            }
        }

        $("#user_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });

        $('#add-user-client-modal').click(function () {
            <?php $user_id = isset($id) ? $id : ''; ?>
            $('#modal-placeholder').load("<?php echo site_url('users/ajax/modal_add_user_client/' . $user_id); ?>");
        });
    });
</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('user_form'); ?></h1>
        <?php echo $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">

                <?php echo $this->layout->load_view('layout/alerts'); ?>

                <div id="userInfo">

                    <div class="panel panel-default">
                        <div class="panel-heading"><?php _trans('account_information'); ?></div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="user_name">
                                    <?php _trans('name'); ?>
                                </label>
                                <input type="text" name="user_name" id="user_name" class="form-control"
                                       value="<?php echo $this->mdl_users->form_value('user_name', true); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="user_company">
                                    <?php _trans('company'); ?>
                                </label>
                                <input type="text" name="user_company" id="user_company" class="form-control"
                                       value="<?php echo $this->mdl_users->form_value('user_company', true); ?>" <?= !$allow_edit ? 'readonly' : '' ; ?>>
                            </div>

                            <div class="form-group">
                                <label for="user_commerce_number">
                                    <?php _trans('chamber_of_commerce_number'); ?>
                                </label>
                                <input type="number" name="user_commerce_number" min='0' id="user_commerce_number" class="form-control"
                                       value="<?php echo $this->mdl_users->form_value('user_commerce_number', true); ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_email">
                                    <?php _trans('email_address'); ?>
                                </label>
                                <input type="text" name="user_email" id="user_email" class="form-control"
                                       value="<?php echo $this->mdl_users->form_value('user_email', true); ?>" <?=($allow_edit ==  false )? 'readonly' : '' ; ?>>
                            </div>

                            <?php if (!$id) { ?>
                                <div class="form-group">
                                    <label for="user_password">
                                        <?php _trans('password'); ?>
                                    </label>
                                    <input type="password" name="user_password" id="user_password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="user_password">
                                        <?php _trans('verify_password'); ?>
                                    </label>
                                    <input type="password" name="user_passwordv" id="user_passwordv"
                                           class="form-control">
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <a href="<?php echo site_url('users/change_password/' . $id); ?>"
                                       class="btn btn-default">
                                        <?php _trans('change_password'); ?>
                                    </a>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label for="default_hour_rate">
                                    <?php _trans('default_hour_rate'); ?>
                                </label>
                                <input type="text" name="default_hour_rate" id="default_hour_rate" class="form-control"
                                       value="<?php echo $this->mdl_users->form_value('default_hour_rate', true); ?>" <?=($allow_edit ==  false )? 'readonly' : '' ; ?>>
                            </div>


                            <?php if($allow_edit && in_array($this->session->userdata('user_type'), array(TYPE_ADMIN))){ ?>
                            <div class="form-group">
                                <label for="multiplier">
                                    <?php _trans('multiplier'); ?>
                                </label>
                                <input type="text" name="multiplier" id="multiplier" class="form-control"
                                       value="<?php echo $this->mdl_users->form_value('multiplier', true); ?>">
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <label for="default_tax_rate_id">
                                    <?php _trans('default_tax_rate'); ?>
                                </label>
                                <select name="default_tax_rate_id" id="default_tax_rate_id" class="form-control simple-select" <?=($allow_edit ==  false )? 'disabled' : '' ; ?>>
                                    <option value="0"><?php _trans('none'); ?></option>
                                    <?php foreach ($tax_rates as $tax_rate) { ?>
                                        <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                            <?php check_select($this->mdl_users->form_value('default_tax_rate_id'), $tax_rate->tax_rate_id); ?>>
                                            <?php echo $tax_rate->tax_rate_name
                                                . ' (' . format_amount($tax_rate->tax_rate_percent) . '%)'; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_group_id">
                                    <?php _trans('user_group'); ?>
                                </label>
                                <select name="user_group_id" id="user_group_id" class="form-control simple-select" <?=($allow_edit ==  false )? 'disabled' : '' ; ?>>
                                    <option value="0"><?php _trans('none'); ?></option>
                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <option value="<?php echo $user_group->group_id; ?>"
                                            <?php check_select($this->mdl_users->form_value('user_group_id'), $user_group->group_id); ?>>
                                            <?php echo $user_group->group_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_language">
                                    <?php _trans('language'); ?>
                                </label>
                                <select name="user_language" id="user_language" class="form-control simple-select" <?=($allow_edit ==  false )? 'disabled' : '' ; ?>>
                                    <option value="system">
                                        <?php echo trans('use_system_language') ?>
                                    </option>
                                    <?php foreach ($languages as $language) {
                                        $usr_lang = $this->session->userdata('user_language');
                                        ?>
                                        <option value="<?php echo $language; ?>"
                                            <?php check_select($usr_lang, $language); ?>>
                                            <?php echo ucfirst($language); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group no-margin">
                                <label for="user_expertises_id">
                                    <?php _trans('expertises'); ?>
                                </label>
                                <select name="user_expertises_id[]" id="user_expertises_id" class="form-control simple-select" multiple>
                                    <?php foreach ($expertises as $expertise) { ?>
                                        <option value="<?= $expertise->expertise_id; ?>"
                                            <?php
                                            if(!empty($user_expertises))
                                            foreach ($user_expertises as $user_expertise){
                                                check_select($user_expertise,$expertise->expertise_id);
                                            }
                                            ?>>
                                            <?=$expertise->expertise_name;?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="user_type">
                                    <?php _trans('user_type'); ?>
                                </label>
                                <select name="user_type" id="user_type" class="form-control simple-select" <?=($allow_edit ==  false )? 'disabled' : '' ; ?>>
                                    <?php foreach ($user_types as $key => $type) { ?>
                                        <option value="<?php echo $key; ?>"
                                            <?php check_select($this->mdl_users->form_value('user_type'), $key); ?>>
                                            <?php echo $type; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                           <!-- <div class="form-group no-margin">
                                <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                    <label for="user_nda_file"><?php /*_trans('nda'); */?></label>
                                    <input type="text" name="user_nda_file" id="user_nda_file" class="form-control" readonly
                                           value="<?php /*echo $this->mdl_users->form_value('user_nda_file' , true); */?>">
                                </div>
                                <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                    <label>&#160;</label>
                                    <br />
                                    <input type="button"  class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php /*echo _trans('choose_file'); */?>" onclick="document.getElementById('nda_load_file').click();" />
                                    <input type="file" style="display:none;" id="nda_load_file" name="user_nda_file_post" accept=".doc,.docx,.pdf" onchange="document.getElementById('user_nda_file').value=this.value;"/>
                                </div>
                            </div>

                            <div class="form-group no-margin">
                                <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                    <label for="user_file"><?php /*_trans('contract'); */?></label>
                                    <input type="text" name="user_file" id="user_file" class="form-control" readonly
                                           value="<?php /*echo $this->mdl_users->form_value('user_file' , true); */?>">
                                </div>
                                <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                    <label>&#160;</label>
                                    <br />
                                    <input type="button"  class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php /*echo _trans('choose_file'); */?>" onclick="document.getElementById('user_file_post').click();" />
                                    <input type="file" style="display:none;" id="user_file_post" name="user_file_post" accept=".doc,.docx,.pdf" onchange="document.getElementById('user_file').value=this.value;"/>
                                </div>
                            </div>-->





                            <?php if($allow_edit ==  TRUE ) { ?>
                                <div class="form-group">
                                    <hr>
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_attachments'); ?></button>
                                    </div>
                                </div>
                            <?php  } else { ?>
                                 <div class="form-group">
                                    <hr>
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary disabled" type="button">+ <?php _trans('add_attachments'); ?></button>
                                    </div>
                                </div>
                            <?php  } ?>



                            <div class="form-group attachments">


                                <?php if(isset($upload_files) && is_array($upload_files) && !empty($upload_files)):?>
                                    <?php foreach ($upload_files as $file):?>
                                        <div class="form-group user_file "  >
                                            <div class="col-md-12 text-left no-padding" style="margin-top: 2%">
                                                <label for="user_document_link"><?php _trans('user_document_link'); ?></label>
                                            </div>
                                            <div class="col-md-12 no-padding" >
                                                <div class="col-md-11 no-padding" >
                                                    <input type="text" id="user_document_link" class="form-control" readonly value="<?=$file; ?>">
                                                    <input type="hidden" name="user_files[]" value="<?=$file; ?>">
                                                </div>
                                                <div class="form-inline col-md-1" style="padding-right:0 !important" >
                                                    <button  class="btn btn-danger user_delete" >
                                                        <i class="fa fa-trash-o fa-margin"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="form-group user_file" >
                                        <div class="col-md-12 text-left">
                                            <label for="user_document_link"><?php _trans('user_document_link'); ?></label>
                                        </div>

                                        <div class="col-md-12 no-padding">
                                            <div class="col-xs-8 col-sm-8 no-padding">
                                                <input type="text" name="user_document_link[]" id="user_document_link" class="form-control user_document_link" readonly >
                                            </div>
                                            <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                                                <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" <?=($allow_edit ==  false )? 'disabled' : '' ; ?> />
                                                <input type="file" style="display:none;"  id="user_file" name="user_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                                                <button class="btn btn-danger user_delete" style="cursor:pointer;margin-left:5px"  <?=($allow_edit ==  false )? 'disabled' : '' ; ?>>  <i class="fa fa-trash-o fa-margin"></i>  </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>








<!--                            <div class="form-group">-->
<!--                                <label for="nda_file" class="btn btn-success">-->
<!--                                    --><?php //_trans('nda_file'); ?>
<!--                                </label>-->
<!--                                <input type="file" name="user_nda_file" id="nda_file" style="display: none" accept=".doc , .docx"-->
<!--                                       value="--><?php //echo $this->mdl_users->form_value('user_nda_file', true); ?><!--">-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="normal_file" class="btn btn-success">-->
<!--                                    --><?php //_trans('normal_file'); ?>
<!--                                </label>-->
<!--                                <input type="file" name="user_normal_file" id="normal_file" style="display: none" accept=".doc , .docx"-->
<!--                                       value="--><?php //echo $this->mdl_users->form_value('user_normal_file', true); ?><!--">-->
<!--                            </div>-->
<!--                        </div>-->

                    </div>

                    <div id="administrator_fields">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php _trans('address'); ?></div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="user_address_1">
                                        <?php _trans('street_address'); ?>
                                    </label>
                                    <input type="text" name="user_address_1" id="user_address_1" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_address_1', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_address_2">
                                        <?php _trans('street_address_2'); ?>
                                    </label>
                                    <input type="text" name="user_address_2" id="user_address_2" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_address_2', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_city">
                                        <?php _trans('city'); ?>
                                    </label>
                                    <input type="text" name="user_city" id="user_city" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_city', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_state">
                                        <?php _trans('state'); ?>
                                    </label>
                                    <input type="text" name="user_state" id="user_state" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_state', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_zip">
                                        <?php _trans('zip_code'); ?>
                                    </label>
                                    <input type="text" name="user_zip" id="user_zip" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_zip', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_country">
                                        <?php _trans('country'); ?>
                                    </label>
                                    <select name="user_country" id="user_country" class="form-control">
                                        <option value=""><?php _trans('none'); ?></option>
                                        <?php foreach ($countries as $cldr => $country) { ?>
                                            <option value="<?php echo $cldr; ?>"
                                                <?php check_select($selected_country, $cldr); ?>>
                                                <?php echo $country ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Custom fields -->
                                <?php foreach ($custom_fields as $custom_field): ?>
                                    <?php if ($custom_field->custom_field_location != 2) {
                                        continue;
                                    } ?>
                                    <?php
                                    print_field(
                                        $this->mdl_users,
                                        $custom_field,
                                        $cv
                                    );
                                    ?>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><?php _trans('tax_information'); ?></div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="user_vat_id">
                                        <?php _trans('vat_id'); ?>
                                    </label>
                                    <input type="text" name="user_vat_id" id="user_vat_id" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_vat_id', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_tax_code">
                                        <?php _trans('tax_code'); ?>
                                    </label>
                                    <input type="text" name="user_tax_code" id="user_tax_code" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_tax_code', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_iban">
                                        <?php _trans('user_iban'); ?>
                                    </label>
                                    <input type="text" name="user_iban" id="user_iban" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_iban', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_subscribernumber">
                                        <?php _trans('user_subscriber_number'); ?>
                                    </label>
                                    <input type="text" name="user_subscribernumber" id="user_subscribernumber"
                                           class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_subscribernumber', true); ?>">
                                </div>

                                <!-- Custom fields -->
                                <?php foreach ($custom_fields as $custom_field): ?>
                                    <?php if ($custom_field->custom_field_location != 3) {
                                        continue;
                                    } ?>
                                    <?php
                                    print_field(
                                        $this->mdl_users,
                                        $custom_field,
                                        $cv
                                    );
                                    ?>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="panel panel-default">
                                <div class="panel-heading"><?php _trans('sumex_information'); ?></div>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="user_gln">
                                            <?php _trans('gln'); ?>
                                        </label>
                                        <input type="text" name="user_gln" id="user_gln" class="form-control"
                                               value="<?php echo $this->mdl_users->form_value('user_gln', true); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="user_rcc">
                                            <?php _trans('sumex_rcc'); ?>
                                        </label>
                                        <input type="text" name="user_rcc" id="user_rcc" class="form-control"
                                               value="<?php echo $this->mdl_users->form_value('user_rcc', true); ?>">
                                    </div>
                                </div>

                            </div>

                        <?php endif; ?>

                        <div class="panel panel-default">

                            <div class="panel-heading"><?php _trans('contact_information'); ?></div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="user_phone">
                                        <?php _trans('phone_number'); ?>
                                    </label>
                                    <input type="text" name="user_phone" id="user_phone" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_phone', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_fax">
                                        <?php _trans('fax_number'); ?>
                                    </label>
                                    <input type="text" name="user_fax" id="user_fax" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_fax', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_mobile">
                                        <?php _trans('mobile_number'); ?>
                                    </label>
                                    <input type="text" name="user_mobile" id="user_mobile" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_mobile', true); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="user_web">
                                        <?php _trans('web_address'); ?>
                                    </label>
                                    <input type="text" name="user_web" id="user_web" class="form-control"
                                           value="<?php echo $this->mdl_users->form_value('user_web', true); ?>">
                                </div>

                                <!-- Custom fields -->
                                <?php foreach ($custom_fields as $custom_field): ?>
                                    <?php if ($custom_field->custom_field_location != 4) {
                                        continue;
                                    } ?>
                                    <?php
                                    print_field(
                                        $this->mdl_users,
                                        $custom_field,
                                        $cv
                                    );
                                    ?>
                                <?php endforeach; ?>
                            </div>

                        </div>
                        <?php if ($custom_fields) : ?>
                            <div class="panel panel-default">
                                <div class="panel-heading"><?php _trans('custom_fields'); ?></div>

                                <div class="panel-body">
                                    <?php
                                    $cv = $this->controller->view_data["custom_values"];
                                    foreach ($custom_fields as $custom_field) {
                                        if ($custom_field->custom_field_location != 0) {
                                            continue;
                                        }
                                        print_field(
                                            $this->mdl_users,
                                            $custom_field,
                                            $cv
                                        );
                                    } ?>
                                </div>

                            </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>
        </div>
    </div>

</form>



<script>


    function get_file_url(_this = null){
        $(_this).parents('.user_file').find('#user_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.user_file').find('.user_document_link').val(pdf_url)
    }


    $(document).on('click', '.add_attachments', function () {
        var elm_amount = `<div class="form-group user_file" >


            <div class="col-md-12 no-padding" style='margin-top:2%'>
                <div class="col-md-9 no-padding">
                    <input type="text" name="user_document_link[]" id="user_document_link" class="form-control user_document_link" readonly
                         >
                </div>
                <div class="col-md-3" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='inventory2' id="user_file" name="user_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger user_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

        $('.attachments').prepend(elm_amount);

    })


    $(document).on('click', '.user_delete', function () {
        $(this).parents('.user_file').remove();
    })


</script>
<script type="text/javascript">
    $(function () {
        $("#target_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
    $(function () {
        $("#target_country_delivery").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('target_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_targets->form_value('is_update')) {
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
                            <label for="target_active" class="control-label">
                                <?php _trans('active_target'); ?>
                                <input id="target_active" name="target_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_targets->form_value('target_active') == 1
                                        || !is_numeric($this->mdl_targets->form_value('target_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="target_name">
                                <?php _trans('target_name'); ?>
                            </label>
                            <input id="target_name" name="target_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_targets->form_value('target_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="target_surname">
                                <?php _trans('target_surname_optional'); ?>
                            </label>
                            <input id="target_surname" name="target_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_targets->form_value('target_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="target_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="target_language" id="target_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php foreach ($languages as $language) {
                                    $target_lang = $this->mdl_targets->form_value('target_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($target_lang, $language) ?>>
                                        <?php echo ucfirst($language); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>



                            <div class="form-group no-margin">
                                <label for="target_group_id">
                                    <?php _trans('group_name'); ?>
                                </label>
                                <select name="target_group_id" id="target_group_id" class="form-control simple-select">
                                    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) {?>
                                        <option value="0"><?php _trans('none'); ?></option>
                                        <?php foreach ($user_groups as $user_group) { ?>
                                            <option value="<?php echo $user_group->group_id; ?>"
                                                <?php check_select($this->mdl_targets->form_value('target_group_id'), $user_group->group_id); ?>>
                                                <?php echo $user_group->group_name; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <?php if(+$this->session->userdata('user_group_id') == $user_group->group_id){ ?>
                                            <option value="<?=$user_group->group_id; ?>"
                                                <?php check_select(+$this->session->userdata('user_group_id'), $user_group->group_id); ?>>
                                                <?=$user_group->group_name?>

                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>


                        <div class="form-group no-margin">

                            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                <label for="target_file"><?php _trans('file'); ?></label>
                                <input type="text" name="target_file" id="target_file" class="form-control" readonly
                                       value="<?php echo $this->mdl_targets->form_value('target_file'); ?>">
                            </div>
                            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                <label for="target_file_test">&nbsp;</label>
                                <br />
                                <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('add_file'); ?>" onclick="document.getElementById('attached_target_file').click();" />
                                <input type="file" style="display:none;" id="attached_target_file" name="attached_target_file" accept=".doc,.docx,.pdf" onchange="document.getElementById('target_file').value=this.value;"/>
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
                        <?php _trans('address'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="target_address_1"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_address_1" id="target_address_1" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_city" id="target_city" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_state" id="target_state" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_zip" id="target_zip" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_zip', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="target_country" id="target_country" class="form-control">
                                    <option value=""><?php _trans('none'); ?></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                            <?php check_select($selected_country, $cldr); ?>
                                        ><?php echo $country ?></option>
                                    <?php } ?>
                                </select>
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
                            <label for="target_address_1_delivery"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_address_1_delivery" id="target_address_1_delivery" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_address_1_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_city_delivery"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_city_delivery" id="target_city_delivery" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_city_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_state_delivery"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_state_delivery" id="target_state_delivery" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_state_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_zip_delivery"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_zip_delivery" id="target_zip_delivery" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_zip_delivery', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_country_delivery"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="target_country_delivery" id="target_country_delivery" class="form-control">
                                    <option value=""><?php _trans('none'); ?></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                            <?php check_select($delivery_selected_country, $cldr); ?>
                                        ><?php echo $country ?></option>
                                    <?php } ?>
                                </select>
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
                        <?php _trans('contact_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="target_phone"><?php _trans('phone_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_phone" id="target_phone" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_fax"><?php _trans('fax_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_fax" id="target_fax" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_fax', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_mobile"><?php _trans('mobile_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_mobile" id="target_mobile" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_email"><?php _trans('email_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_email" id="target_email" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_email2"><?php _trans('email_address'); ?> 2</label>

                            <div class="controls">
                                <input type="text" name="target_email2" id="target_email2" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_email2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_web"><?php _trans('web_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_web" id="target_web" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_web', true); ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xs-12 col-sm-6">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('personal_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="target_gender"><?php _trans('gender'); ?></label>

                            <div class="controls">
                                <select name="target_gender" id="target_gender" class="form-control simple-select">
                                    <?php
                                    $genders = array(
                                        trans('gender_male'),
                                        trans('gender_female'),
                                        trans('gender_other'),
                                    );
                                    foreach ($genders as $key => $val) { ?>
                                        <option value=" <?php echo $key; ?>" <?php check_select($key, $this->mdl_targets->form_value('target_gender')) ?>>
                                            <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="target_birthdate"><?php _trans('birthdate'); ?></label>
                            <?php
                            $bdate = $this->mdl_targets->form_value('target_birthdate');
                            if ($bdate && $bdate != "0000-00-00") {
                                $bdate = date_from_mysql($bdate);
                            } else {
                                $bdate = '';
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" name="target_birthdate" id="target_birthdate"
                                       class="form-control datepicker"
                                       value="<?php _htmlsc($bdate); ?>">
                                <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="form-group">
                                <label for="target_avs"><?php _trans('sumex_ssn'); ?></label>
                                <?php $avs = $this->mdl_targets->form_value('target_avs'); ?>
                                <div class="controls">
                                    <input type="text" name="target_avs" id="target_avs" class="form-control"
                                           value="<?php echo htmlspecialchars(format_avs($avs)); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="target_insurednumber"><?php _trans('sumex_insurednumber'); ?></label>
                                <?php $insuredNumber = $this->mdl_targets->form_value('target_insurednumber'); ?>
                                <div class="controls">
                                    <input type="text" name="target_insurednumber" id="target_insurednumber"
                                           class="form-control"
                                           value="<?php echo htmlentities($insuredNumber); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="target_veka"><?php _trans('sumex_veka'); ?></label>
                                <?php $veka = $this->mdl_targets->form_value('target_veka'); ?>
                                <div class="controls">
                                    <input type="text" name="target_veka" id="target_veka" class="form-control"
                                           value="<?php echo htmlentities($veka); ?>">
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>

                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('tax_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="target_vat_id"><?php _trans('vat_id'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_vat_id" id="target_vat_id" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_vat_id', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="target_tax_code"><?php _trans('tax_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="target_tax_code" id="target_tax_code" class="form-control"
                                       value="<?php echo $this->mdl_targets->form_value('target_tax_code', true); ?>">
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</form>

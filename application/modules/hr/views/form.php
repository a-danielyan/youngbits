<script type="text/javascript">
    $(function () {
        $("#hr_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
    $(function () {
        $("#hr_country_delivery").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post" enctype="multipart/form-data" >

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('hr_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_hr->form_value('is_update')) {
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
                            <label for="hr_active" class="control-label">
                                <?php _trans('active_hr'); ?>
                                <input id="hr_active" name="hr_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_hr->form_value('hr_active') == 1
                                        || !is_numeric($this->mdl_hr->form_value('hr_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                                <label for="hr_profile_picture"><?php _trans('profile_picture'); ?></label>
                            </div>

                            <div class="col-xs-12 col-sm-8">
                                <div class="col-xs-8 col-sm-10 no-padding">
                                    <input type="text" name="hr_profile_picture" id="hr_profile_picture" class="form-control" readonly
                                           value="<?php echo $this->mdl_hr->form_value('hr_profile_picture'); ?>">
                                </div>
                                <div class="col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                    <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('upload'); ?>" onclick="document.getElementById('hr_profile_picture_file').click();" />
                                    <input type="file" style="display:none;" id="hr_profile_picture_file" name="hr_profile_picture_file" accept=".jpeg, .jpg, .png, .pdf" onchange="document.getElementById('hr_profile_picture').value=this.value;"/>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>




                        <div class="form-group">
                            <label for="hr_name">
                                <?php _trans('hr_name'); ?>
                            </label>
                            <input id="hr_name" name="hr_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_hr->form_value('hr_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="hr_surname">
                                <?php _trans('hr_surname_optional'); ?>
                            </label>
                            <input id="hr_surname" name="hr_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_hr->form_value('hr_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="hr_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="hr_language" id="hr_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php foreach ($languages as $language) {
                                    $hr_lang = $this->mdl_hr->form_value('hr_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($hr_lang, $language) ?>>
                                        <?php echo ucfirst($language); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group no-margin">
                            <label for="hr_type">
                                <?php _trans('group_name'); ?>
                            </label>
                            <select name="hr_type" id="hr_type" class="form-control simple-select">
                                <option value="<?php echo TYPE_FREELANCERS; ?>"
                                    <?php check_select($this->mdl_hr->form_value('hr_type'), TYPE_FREELANCERS); ?>>
                                    <?php _trans('freelancer')?>
                                </option>
                                <option value="<?php echo TYPE_EMPLOYEES; ?>"
                                    <?php check_select($this->mdl_hr->form_value('hr_type'), TYPE_EMPLOYEES); ?>>
                                    <?php _trans('employee')?>
                                </option>

                                <option value="<?php echo TYPE_MANAGERS; ?>"
                                    <?php check_select($this->mdl_hr->form_value('hr_type'), TYPE_MANAGERS); ?>>
                                    <?php _trans('manager')?>
                                </option>
                                <option value="<?php echo TYPE_ADMINISTRATOR; ?>"
                                    <?php check_select($this->mdl_hr->form_value('hr_type'), TYPE_ADMINISTRATOR); ?>>
                                    <?php _trans('other_user')?>
                                </option>
                                <option value="<?php echo TYPE_PROMOTERS; ?>"
                                    <?php check_select($this->mdl_hr->form_value('hr_type'), TYPE_PROMOTERS); ?>>
                                    <?php _trans('Influencers')?>
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!--Extra information-->
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading form-inline clearfix">
                        <?php _trans('extra_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="hr_followers">
                                <?php _trans('hr_followers'); ?>
                            </label>
                            <input id="hr_followers" name="hr_followers" type="number" class="form-control"
                                   value="<?php echo $this->mdl_hr->form_value('hr_followers', true); ?>">
                        </div>


                        <div class="form-group">
                            <label for="hr_social_link">
                                <?php _trans('hr_social_link'); ?>
                            </label>
                            <input id="hr_social_link" name="hr_social_link" type="text" class="form-control"
                                   value="<?php echo $this->mdl_hr->form_value('hr_social_link', true); ?>">
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
                            <label for="hr_address_1"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_address_1" id="hr_address_1" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_address_2"><?php _trans('street_address_2'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_address_2" id="hr_address_2" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_address_2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_city" id="hr_city" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_state" id="hr_state" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_zip" id="hr_zip" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_zip', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="hr_country" id="hr_country" class="form-control">
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

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('tax_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="hr_vat_id"><?php _trans('vat_id'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_vat_id" id="hr_vat_id" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_vat_id', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_tax_code"><?php _trans('tax_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_tax_code" id="hr_tax_code" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_tax_code', true); ?>">
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
                            <label for="hr_gender"><?php _trans('gender'); ?></label>

                            <div class="controls">
                                <select name="hr_gender" id="hr_gender" class="form-control simple-select">
                                    <?php
                                    $genders = array(
                                        trans('gender_male'),
                                        trans('gender_female'),
                                        trans('gender_other'),
                                    );
                                    foreach ($genders as $key => $val) { ?>
                                        <option value=" <?php echo $key; ?>" <?php check_select($key, $this->mdl_hr->form_value('hr_gender')) ?>>
                                            <?php echo $val; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="hr_birthdate"><?php _trans('birthdate'); ?></label>
                            <?php
                            $bdate = $this->mdl_hr->form_value('hr_birthdate');
                            if ($bdate && $bdate != "0000-00-00") {
                                $bdate = date_from_mysql($bdate);
                            } else {
                                $bdate = '';
                            }
                            ?>
                            <div class="input-group">
                                <input type="text" name="hr_birthdate" id="hr_birthdate"
                                       class="form-control datepicker"
                                       value="<?php _htmlsc($bdate); ?>">
                                <span class="input-group-addon">
                                <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>

                            <div class="form-group">
                                <label for="hr_avs"><?php _trans('sumex_ssn'); ?></label>
                                <?php $avs = $this->mdl_hr->form_value('hr_avs'); ?>
                                <div class="controls">
                                    <input type="text" name="hr_avs" id="hr_avs" class="form-control"
                                           value="<?php echo htmlspecialchars(format_avs($avs)); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hr_insurednumber"><?php _trans('sumex_insurednumber'); ?></label>
                                <?php $insuredNumber = $this->mdl_hr->form_value('hr_insurednumber'); ?>
                                <div class="controls">
                                    <input type="text" name="hr_insurednumber" id="hr_insurednumber"
                                           class="form-control"
                                           value="<?php echo htmlentities($insuredNumber); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hr_veka"><?php _trans('sumex_veka'); ?></label>
                                <?php $veka = $this->mdl_hr->form_value('hr_veka'); ?>
                                <div class="controls">
                                    <input type="text" name="hr_veka" id="hr_veka" class="form-control"
                                           value="<?php echo htmlentities($veka); ?>">
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>
                </div>
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('contact_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="hr_phone"><?php _trans('phone_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_phone" id="hr_phone" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_fax"><?php _trans('fax_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_fax" id="hr_fax" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_fax', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_mobile"><?php _trans('mobile_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_mobile" id="hr_mobile" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_email"><?php _trans('email_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_email" id="hr_email" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hr_web"><?php _trans('web_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="hr_web" id="hr_web" class="form-control"
                                       value="<?php echo $this->mdl_hr->form_value('hr_web', true); ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>


<script>

    function get_file_url(_this = null){
        $(_this).parents('.hr_profile_picture_file').find('#hr_profile_picture_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.hr_profile_picture_file').find('.hr_profile_picture').val(pdf_url)
    }

</script>
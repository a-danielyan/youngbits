<div class="col-xs-12 col-md-8 col-md-offset-2">

    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('offers'); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>
                            <?php _trans('offer_logo'); ?>
                        </label>
                        <?php if (get_setting('offer_logo')) { ?>
                            <br/>
                            <img class="personal_logo"
                                 src="<?php echo base_url(); ?>uploads/<?php echo get_setting('offer_logo'); ?>">
                            <br>
                            <?php echo anchor('settings/remove_logo/offer', trans('remove_logo')); ?><br/>
                        <?php } ?>
                        <input type="file" name="offer_logo" size="40" class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="settings[offer_pre_password]">
                            <?php _trans('offer_pre_password'); ?>
                        </label>
                        <input type="text" name="settings[offer_pre_password]" id="settings[offer_pre_password]"
                               class="form-control"
                               value="<?php echo get_setting('offer_pre_password', '', true); ?>">
                    </div>

                </div>
                <div class="col-xs-12 col-md-6">
                    
                    <div class="form-group">
                        <label for="settings[default_offer_terms]">
                            <?php _trans('default_terms'); ?>
                        </label>
                        <textarea name="settings[default_offer_terms]" id="settings[default_offer_terms]"
                                  class="form-control"
                                  rows="3"><?php echo get_setting('default_offer_terms', '', true); ?></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="panel panel-default">
        <div class="panel-heading">
            <?php _trans('offer_template'); ?>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="settings[pdf_offer_template]">
                            <?php _trans('default_pdf_template'); ?>
                        </label>
                        <select name="settings[pdf_offer_template]" id="settings[pdf_offer_template]"
                                class="form-control simple-select">
                            <option value=""><?php _trans('none'); ?></option>
                            <?php foreach ($pdf_offer_templates as $offer_template) { ?>
                                <option value="<?php echo $offer_template; ?>"
                                    <?php check_select(get_setting('pdf_offer_template'), $offer_template); ?>>
                                    <?php echo $offer_template; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="settings[public_offer_template]">
                            <?php _trans('default_public_template'); ?>
                        </label>
                        <select name="settings[public_offer_template]" id="settings[public_offer_template]"
                                class="form-control simple-select">
                            <option value=""><?php _trans('none'); ?></option>
                            <?php foreach ($public_offer_templates as $offer_template) { ?>
                                <option value="<?php echo $offer_template; ?>"
                                    <?php check_select(get_setting('public_offer_template'), $offer_template); ?>>
                                    <?php echo $offer_template; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="settings[email_offer_template]">
                            <?php _trans('default_email_template'); ?>
                        </label>
                        <select name="settings[email_offer_template]" id="settings[email_offer_template]"
                                class="form-control simple-select">
                            <option value=""><?php _trans('none'); ?></option>
                            <?php foreach ($email_templates_offer as $email_template) { ?>
                                <option value="<?php echo $email_template->email_template_id; ?>"
                                    <?php check_select(get_setting('email_offer_template'), $email_template->email_template_id); ?>>
                                    <?php echo $email_template->email_template_title; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

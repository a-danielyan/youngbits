<form method="post" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($subscriptions_id) { ?>
        <input type="hidden" name="subscriptions_id" value="<?php echo $subscriptions_id; ?>">
    <?php } ?>

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('subscriptions_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_name" class="control-label"><?php _trans('name'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="subscriptions_name" id="subscriptions_name" class="form-control"
                       value="<?php echo $this->mdl_subscriptions->form_value('subscriptions_name'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_category" class="control-label"><?php _trans('category'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="subscriptions_category" id="subscriptions_category" class="form-control"
                       value="<?php echo $this->mdl_subscriptions->form_value('subscriptions_category'); ?>">
            </div>
        </div>


        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="subscriptions_date" id="subscriptions_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_subscriptions->form_value('subscriptions_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_amount" class="control-label"><?php _trans('amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6 ">
                <div class="input-group">
                    <input type="number" min="0" step="0.01" name="subscriptions_amount" id="subscriptions_amount" class="form-control"
                           value="<?php echo format_amount($this->mdl_subscriptions->form_value('subscriptions_amount')); ?>">
                    <div class="input-group-addon">
                        <?php echo get_setting('currency_symbol') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_start_date" class="control-label"><?php _trans('start_date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="subscriptions_start_date" id="subscriptions_start_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_subscriptions->form_value('subscriptions_start_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_end_date" class="control-label"><?php _trans('end_date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="subscriptions_end_date" id="subscriptions_end_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_subscriptions->form_value('subscriptions_end_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_end_date" class="control-label"><?php _trans('every'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <select name="subscriptions_frequency" id="subscriptions_frequency" class="form-control simple-select">
                        <?php foreach ($recur_frequencies as $key => $lang) { ?>
                            <option <?= $key === $this->mdl_subscriptions->form_value('subscriptions_frequency') ? 'selected' : '' ?> value="<?php echo $key; ?>">
                                <?php _trans($lang); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_contact" class="control-label"><?php _trans('subscriptions_contact'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="subscriptions_contact" id="subscriptions_contact" class="form-control"
                       value="<?php echo $this->mdl_subscriptions->form_value('subscriptions_contact'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_username" class="control-label"><?php _trans('subscriptions_username'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="subscriptions_username" id="subscriptions_username" class="form-control"
                       value="<?php echo $this->mdl_subscriptions->form_value('subscriptions_username'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_document_link"><?php _trans('subscriptions_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-10 no-padding">
                    <input type="text" name="subscriptions_document_link" id="subscriptions_document_link" class="form-control" readonly
                           value="<?php echo $this->mdl_subscriptions->form_value('subscriptions_document_link'); ?>">
                </div>
                <div class="col-xs-4 col-sm-2" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('attachments'); ?>" onclick="document.getElementById('subscriptions_file').click();" />
                    <input type="file" style="display:none;" id="subscriptions_file" name="subscriptions_file" accept=".jpeg, .jpg, .png, .pdf" onchange="document.getElementById('subscriptions_document_link').value=this.value;"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="subscriptions_note" class="control-label"><?php _trans('note'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="subscriptions_note"
                          class="form-control"><?php echo $this->mdl_subscriptions->form_value('subscriptions_note', true); ?></textarea>
            </div>

        </div>

    </div>

</form>

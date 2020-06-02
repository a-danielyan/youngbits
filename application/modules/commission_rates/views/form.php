<form method="post" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('commission_rate_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label class="control-label">
                    <?php _trans('commission_rate_name'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="commission_rate_name" id="commission_rate_name" class="form-control"
                       value="<?php echo $this->mdl_commission_rates->form_value('commission_rate_name', true); ?>">
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label class="control-label">
                    <?php _trans('commission_rate_percent'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="number" min="0" step="0.01" name="commission_rate_percent" id="commission_rate_percent" class="form-control"
                       value="<?php echo format_amount($this->mdl_commission_rates->form_value('commission_rate_percent')); ?>">
                <span class="form-control-feedback">%</span>
            </div>
        </div>


        <div class="form-group">

            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label class="control-label" for="commission_rate_default">
                    <?php _trans('commission_rate_default'); ?>&nbsp
                </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="checkbox" name="commission_rate_default" id="commission_rate_default" style="margin-top: 10px;" value="1" <?=($this->mdl_commission_rates->form_value('commission_rate_default')==1)? 'checked' : '' ;?>>
            </div>
        </div>

    </div>

</form>

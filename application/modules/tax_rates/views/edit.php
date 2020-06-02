<form method="post" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('tax_rates_mobility'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>


        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label class="control-label">
                    <?php _trans('appointment_price_per_kilometer'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="user_price_per_kilometer" id="user_price_per_kilometer" class="form-control"
                       value="<?php echo format_amount($this->mdl_tax_rates_user->form_value('user_price_per_kilometer')); ?>">
                <span class="form-control-feedback">$</span>
            </div>
        </div>

    </div>

</form>

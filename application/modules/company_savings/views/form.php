<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('add_company_saving'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">

                <?php $this->layout->load_view('layout/alerts'); ?>
                <div class="form-group">
                    <label for="company_saving_text">
                        <?php _trans('company_saving_text'); ?>
                    </label>
                    <input type="number" name="company_saving_text" min="0" id="company_saving_text" class="form-control"
                           value="<?=$this->mdl_company_savings->form_value('company_saving_text', true); ?>">
                </div>
            </div>
        </div>

    </div>

</form>

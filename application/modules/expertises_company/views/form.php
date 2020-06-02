<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('expertises_company'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content" class="row">

        <div class="col-xs-12 col-md-6 col-md-offset-3">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="form-group">
                <label for="expertises_company_name"><?php _trans('expertise_name'); ?></label>
                <input type="text" name="expertises_company_name" id="expertises_company_name" class="form-control"
                       value="<?php echo $this->mdl_expertises->form_value('expertises_company_name', true); ?>">
            </div>



        </div>

    </div>

</form>

<form method="post" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('user_group_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label class="control-label">
                    <?php _trans('group_name'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="group_name" id="group_name" class="form-control"
                       value="<?php echo $this->mdl_user_groups->form_value('group_name', true); ?>">
            </div>
        </div>

    </div>

</form>

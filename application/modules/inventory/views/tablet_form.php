<form method="post"  enctype="multipart/form-data" class="form-horizontal inventory_form">
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">
    <div id="headerbar">
        <div class="col-md-1">
            <h1 class="headerbar-title"><?php _trans('inventory_form'); ?></h1>
        </div>

        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>



        <div class="text-center d-flex m-auto justify-content-center aligncenter">
            <div class="col-md-3 p-5 bg-success mr-5 check_upload_file_btn"><a href="drag_and_drop"><?php _trans('drag_and_drop'); ?></a></div>
            <div class="col-md-3 p-5 bg-info check_upload_file_btn"><a href="manually_add"><?php _trans('manually_add'); ?></a></div>
            <div class="clear"></div>
        </div>
    </div>

</form>
<form  class="dropzone" id="dZUpload" enctype="multipart/form-data" >
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php $this->layout->load_view('layout/alerts'); ?>
    <div id="headerbar">
        <div class="col-md-1">
            <h1 class="headerbar-title"><?php _trans('expenses_form'); ?></h1>
        </div>

        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>


    <div class="col text-center ">
        <i class="fa fa-cloud-download" style="color: #0a6aa1; font-size: 56px; padding-top:2% " aria-hidden="true"></i>
    </div>

</form>

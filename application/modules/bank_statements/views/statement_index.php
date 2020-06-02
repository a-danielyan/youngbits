<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('import_data'); ?></h1>
</div>

<div id="content">

    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5><?php _trans('import_from_csv'); ?></h5>
                </div>

                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url($this->uri->uri_string()); ?>">

                        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                               value="<?php echo $this->security->get_csrf_hash() ?>">

                        <input type="file" name="import_statement">
                        
                        <input type="submit" class="btn btn-default" name="btn_submit"
                               value="<?php _trans('import'); ?>">
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

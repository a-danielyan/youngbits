<form method="post" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('add_quote'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">

                <?php $this->layout->load_view('layout/alerts'); ?>
                <div class="form-group">
                    <label for="quote_text">
                        <?php _trans('quote_text'); ?>
                    </label>
                    <input type="text" name="quote_text" id="quote_text" class="form-control"
                           value="<?=$this->mdl_login_quotes->form_value('quote_text', true); ?>">
                </div>
                <div class="form-group">
                    <label for="quote_document_link"><?php _trans('img'); ?> (max height 200px)</label>


                    <div class="col">
                        <div class="col-xs-8 col-sm-10 no-padding">
                            <input type="text" name="quote_document_link" id="quote_document_link" class="form-control" readonly
                                   value="<?php echo $this->mdl_login_quotes->form_value('quote_document_link'); ?>">
                        </div>
                        <div class="col-xs-4 col-sm-2" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php echo _trans('attachments'); ?>" onclick="document.getElementById('quote_file').click();" />
                            <input type="file" style="display:none;" id="quote_file" name="quote_file" accept=".jpeg, .jpg, .png, .pdf" onchange="document.getElementById('quote_document_link').value=this.value;"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>

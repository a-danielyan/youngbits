<form method="post" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($legal_issues_id) { ?>
        <input type="hidden" name="legal_issues_id" value="<?php echo $legal_issues_id; ?>">
    <?php } ?>

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('legal_issues_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_german_title" class="control-label"><?php _trans('legal_issues_german_title'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="legal_issues_german_title" id="legal_issues_german_title" class="form-control"
                       value="<?php echo $this->mdl_legal_issues->form_value('legal_issues_german_title'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_dutch_title" class="control-label"><?php _trans('legal_issues_dutch_title'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="legal_issues_dutch_title" id="legal_issues_dutch_title" class="form-control"
                       value="<?php echo $this->mdl_legal_issues->form_value('legal_issues_dutch_title'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_engilsh_title" class="control-label"><?php _trans('legal_issues_engilsh_title'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="legal_issues_engilsh_title" id="legal_issues_engilsh_title" class="form-control"
                       value="<?php echo $this->mdl_legal_issues->form_value('legal_issues_engilsh_title'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_category" class="control-label"><?php _trans('legal_issues_category'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="legal_issues_category" id="legal_issues_category" class="form-control"
                       value="<?php echo $this->mdl_legal_issues->form_value('legal_issues_category'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_company_name" class="control-label"><?php _trans('legal_issues_company_name'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="legal_issues_company_name" id="legal_issues_company_name" class="form-control"
                       value="<?php echo $this->mdl_legal_issues->form_value('legal_issues_company_name'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_location_address" class="control-label"><?php _trans('legal_issues_location_address'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="legal_issues_location_address" id="legal_issues_location_address" class="form-control"
                       value="<?php echo $this->mdl_legal_issues->form_value('legal_issues_location_address'); ?>">
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="legal_issues_date" id="legal_issues_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_legal_issues->form_value('legal_issues_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_amount" class="control-label"><?php _trans('amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="number" name="legal_issues_amount" id="legal_issues_amount" class="form-control"
                       value="<?php echo format_amount($this->mdl_legal_issues->form_value('legal_issues_amount')); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_note_german" class="control-label"><?php _trans('legal_issues_note_german'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="legal_issues_note_german"
                          class="form-control"><?php echo $this->mdl_legal_issues->form_value('legal_issues_note_german', true); ?></textarea>
            </div>

        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_note_dutch" class="control-label"><?php _trans('legal_issues_note_dutch'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="legal_issues_note_dutch"
                          class="form-control"><?php echo $this->mdl_legal_issues->form_value('legal_issues_note_dutch', true); ?></textarea>
            </div>

        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_note_engilsh" class="control-label"><?php _trans('legal_issues_note_engilsh'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="legal_issues_note_engilsh"
                          class="form-control"><?php echo $this->mdl_legal_issues->form_value('legal_issues_note_engilsh', true); ?></textarea>
            </div>

        </div>

        <div class="form-group">
            <hr>
            <div class="col-xs-12 col-sm-8 text-right text-left-xs">
                <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_attachments'); ?></button>
            </div>
        </div>


        <div class="form-group attachments">


            <?php if(isset($upload_files) && is_array($upload_files) && !empty($upload_files)):?>
                <?php foreach ($upload_files as $file):?>
                    <div class="form-group legal_issues_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="legal_issues_document_link"><?php _trans('legal_issues_document_link'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="legal_issues_document_link" class="form-control" readonly value="<?=$file; ?>">
                                <input type="hidden" name="legal_issues_files[]" value="<?=$file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger legal_issues_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group legal_issues_file" >
                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                        <label for="legal_issues_document_link"><?php _trans('legal_issues_document_link'); ?></label>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-8 col-sm-8 no-padding">
                            <input type="text" name="legal_issues_document_link[]" id="legal_issues_document_link" class="form-control legal_issues_document_link" readonly >
                        </div>
                        <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                            <input type="file" style="display:none;"  id="legal_issues_file" name="legal_issues_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                            <button class="btn btn-danger legal_issues_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>



    </div>

</form>


<script>


    function get_file_url(_this = null){
        $(_this).parents('.legal_issues_file').find('#legal_issues_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.legal_issues_file').find('.legal_issues_document_link').val(pdf_url)
    }


    $(document).on('click', '.add_attachments', function () {
        var elm_amount = `<div class="form-group legal_issues_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="legal_issues_document_link"><?php _trans('legal_issues_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="legal_issues_document_link[]" id="legal_issues_document_link" class="form-control legal_issues_document_link" readonly
                         >
                </div>
                <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='legal_issues2' id="legal_issues_file" name="legal_issues_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger legal_issues_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

        $('.attachments').prepend(elm_amount);

    })


    $(document).on('click', '.legal_issues_delete', function () {
        $(this).parents('.legal_issues_file').remove();
    })


</script>
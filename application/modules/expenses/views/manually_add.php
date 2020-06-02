

<form method="post"  enctype="multipart/form-data" action="tablet_form" class="form-horizontal expenses_form">
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">
    <div id="headerbar">
        <div class="col-md-1">
            <h1 class="headerbar-title"><?php _trans('expenses_form'); ?></h1>
        </div>

        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <hr>
            <div class="col-xs-12 col-sm-8 text-right text-left-xs">
                <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_attachments'); ?></button>
            </div>
        </div>

        <div class="form-group attachments">
            <div class="form-group expenses_file" >
                <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                    <label for="expenses_documents"><?php _trans('expenses_document_link'); ?></label>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="col-xs-8 col-sm-8 no-padding">
                        <input type="text" name="expenses_documents[]" id="expenses_documents" class="form-control expenses_documents" readonly >
                    </div>
                    <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                        <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                        <input type="file" style="display:none;"  id="expenses_file" name="expenses_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                        <button class="btn btn-danger expenses_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<script>

    $( ".expenses_form" ).submit(function(e) {
        $("#dZUpload").remove();
    });

    function get_file_url(_this = null){
        $(_this).parents('.expenses_file').find('#expenses_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.expenses_file').find('.expenses_documents').val(pdf_url)
    }


    $(document).on('click', '.add_attachments', function () {
        var elm_amount = `<div class="form-group expenses_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_documents"><?php _trans('expenses_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="expenses_documents[]" id="expenses_documents" class="form-control expenses_documents" readonly
                         >
                </div>
                <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='expenses2' id="expenses_file" name="expenses_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger expenses_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

        $('.attachments').prepend(elm_amount);

    })


    $(document).on('click', '.expenses_delete', function () {
        $(this).parents('.expenses_file').remove();
    })



</script>

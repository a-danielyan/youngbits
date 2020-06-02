<form method="post" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($upfront_payments_id) { ?>
        <input type="hidden" name="upfront_payments_id" value="<?php echo $upfront_payments_id; ?>">
    <?php } ?>

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('upfront_payments_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>





        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_name" class="control-label"><?php _trans('name'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="upfront_payments_name" id="upfront_payments_name" class="form-control"
                       value="<?php echo $this->mdl_upfront_payments->form_value('upfront_payments_name'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_category" class="control-label"><?php _trans('category'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="upfront_payments_category" id="upfront_payments_category" class="form-control"
                       value="<?php echo $this->mdl_upfront_payments->form_value('upfront_payments_category'); ?>">
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="upfront_payments_date" id="upfront_payments_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_upfront_payments->form_value('upfront_payments_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_amount" class="control-label"><?php _trans('amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input type="number" min="0" step="0.01" name="upfront_payments_amount" id="upfront_payments_amount" class="form-control"
                           value="<?php echo format_amount($this->mdl_upfront_payments->form_value('upfront_payments_amount')); ?>">
                    <div class="input-group-addon">
                        €
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_discount" class="control-label"><?php _trans('upfront_payments_discount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input type="number" min="0" step="0.01" name="upfront_payments_discount" id="upfront_payments_discount" class="form-control"
                           value="<?php echo format_amount($this->mdl_upfront_payments->form_value('upfront_payments_discount')); ?>">
                    <div class="input-group-addon">
                       %
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_discount_total" class="control-label"><?php _trans('upfront_payments_discount_total'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input type="number" min="0" step="0.01" name="upfront_payments_discount_total" id="upfront_payments_discount_total" class="form-control"
                           value="<?php echo format_amount($this->mdl_upfront_payments->form_value('upfront_payments_discount_total')); ?>">
                    <div class="input-group-addon">
                       =%
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_description" class="control-label"><?php _trans('upfront_payments_description'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="upfront_payments_description"
                          class="form-control"><?php echo $this->mdl_upfront_payments->form_value('upfront_payments_description', true); ?></textarea>
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
                    <div class="form-group upfront_payments_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="upfront_payments_document_link"><?php _trans('upfront_payments_document_link'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="upfront_payments_document_link" class="form-control" readonly value="<?=$file; ?>">
                                <input type="hidden" name="upfront_payments_files[]" value="<?=$file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger upfront_payments_delete" >
                                         <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group upfront_payments_file" >
                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                        <label for="upfront_payments_document_link"><?php _trans('upfront_payments_document_link'); ?></label>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-8 col-sm-8 no-padding">
                            <input type="text" name="upfront_payments_document_link[]" id="upfront_payments_document_link" class="form-control upfront_payments_document_link" readonly >
                        </div>
                        <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                            <input type="file" style="display:none;"  id="upfront_payments_file" name="upfront_payments_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                            <button class="btn btn-danger upfront_payments_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</form>
<script>


        function get_file_url(_this = null){
            $(_this).parents('.upfront_payments_file').find('#upfront_payments_file').click()
        }

        function save_url(_this = null){

            var pdf_url = $(_this).val();
            $(_this).parents('.upfront_payments_file').find('.upfront_payments_document_link').val(pdf_url)
        }


        $(document).on('click', '.add_attachments', function () {
            var elm_amount = `<div class="form-group upfront_payments_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="upfront_payments_document_link"><?php _trans('upfront_payments_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="upfront_payments_document_link[]" id="upfront_payments_document_link" class="form-control upfront_payments_document_link" readonly
                         >
                </div>
                <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='expenses2' id="upfront_payments_file" name="upfront_payments_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger upfront_payments_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

            $('.attachments').prepend(elm_amount);

        })


        $(document).on('click', '.upfront_payments_delete', function () {
            $(this).parents('.upfront_payments_file').remove();
        })


</script>
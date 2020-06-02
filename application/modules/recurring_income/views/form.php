<form method="post" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($recurring_income_id) { ?>
        <input type="hidden" name="recurring_income_id" value="<?php echo $recurring_income_id; ?>">
    <?php } ?>



    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('recurring_income_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_name" class="control-label"><?php _trans('name'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="recurring_income_name" id="recurring_income_name" class="form-control"
                       value="<?php echo $this->mdl_recurring_income->form_value('recurring_income_name'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_category" class="control-label"><?php _trans('category'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="recurring_income_category" id="recurring_income_category" class="form-control"
                       value="<?php echo $this->mdl_recurring_income->form_value('recurring_income_category'); ?>">
            </div>
        </div>


        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="recurring_income_date" id="recurring_income_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_recurring_income->form_value('recurring_income_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_amount" class="control-label"><?php _trans('amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input type="number" name="recurring_income_amount" min='0' id="recurring_income_amount" class="form-control"
                           value="<?= format_amount($this->mdl_recurring_income->form_value('recurring_income_amount')); ?>">
                    <div class="input-group-addon">
                        <?php echo get_setting('currency_symbol') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_outstanding_amount" class="control-label"><?php _trans('total_outstanding_amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="recurring_income_outstanding_amount" step="0.01" id="recurring_income_outstanding_amount" class="form-control"
                           value="<?= format_amount($this->mdl_recurring_income->form_value('recurring_income_outstanding_amount')); ?>">
                    <div class="input-group-addon">
                        <?php echo get_setting('currency_symbol') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_start_date" class="control-label"><?php _trans('start_date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="recurring_income_start_date" id="recurring_income_start_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_recurring_income->form_value('recurring_income_start_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_end_date" class="control-label"><?php _trans('end_date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="recurring_income_end_date" id="recurring_income_end_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_recurring_income->form_value('recurring_income_end_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_end_date" class="control-label"><?php _trans('every'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <select name="recurring_income_frequency" id="recurring_income_frequency" class="form-control simple-select">
                        <?php foreach ($recur_frequencies as $key => $lang) { ?>
                            <option <?= $key === $this->mdl_recurring_income->form_value('recurring_income_frequency') ? 'selected' : '' ?> value="<?=$key?>">
                                <?php _trans($lang); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_contact" class="control-label"><?php _trans('recurring_income_contact'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="recurring_income_contact" id="recurring_income_contact" class="form-control"
                       value="<?php echo $this->mdl_recurring_income->form_value('recurring_income_contact'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_username" class="control-label"><?php _trans('recurring_income_username'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="recurring_income_username" id="recurring_income_username" class="form-control"
                       value="<?php echo $this->mdl_recurring_income->form_value('recurring_income_username'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_note" class="control-label"><?php _trans('note'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="recurring_income_note"
                          class="form-control"><?php echo $this->mdl_recurring_income->form_value('recurring_income_note', true); ?></textarea>
            </div>
        </div>

        <hr class="border-white">
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_contactperson_name" class="control-label"><?php _trans('recurring_income_contactperson_name'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="recurring_income_contactperson_name" id="recurring_income_contactperson_name" class="form-control"
                       value="<?php echo $this->mdl_recurring_income->form_value('recurring_income_contactperson_name'); ?>">
            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_contactperson_email" class="control-label"><?php _trans('recurring_income_contactperson_email'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="email" name="recurring_income_contactperson_email" id="recurring_income_contactperson_email" class="form-control"
                       value="<?php echo $this->mdl_recurring_income->form_value('recurring_income_contactperson_email'); ?>">
            </div>
        </div>

        <?php if (!is_null($this->mdl_recurring_income->form_value('recurring_income_url_key')) && !empty($this->mdl_recurring_income->form_value('recurring_income_url_key'))) { ?>
            <div class="form-group">
                <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                    <label for="recurring_income_url_key"><?php _trans('guest_url'); ?></label>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="input-group">
                        <input type="text" name="recurring_income_url_key" readonly id="recurring_income_url_key" class="form-control"
                               value="<?php echo site_url('guest/view/recurring_income/' .$this->mdl_recurring_income->form_value('recurring_income_url_key', false)) ?>">
                        <span class="input-group-addon to-clipboard cursor-pointer"
                              data-clipboard-target="#recurring_income_url_key">
                                          <i class="fa fa-clipboard fa-fw"></i>
                                    </span>
                    </div>
                </div>

            </div>
        <?php } ?>



        <hr class="border-white">





        <div class="form-group">

            <div class="col-xs-12 col-sm-8 text-right text-left-xs">

                <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_attachments'); ?></button>
            </div>
        </div>

        <div class="form-group attachments">

            <?php if(isset($upload_files) && is_array($upload_files) && !empty($upload_files)):?>
                <?php foreach ($upload_files as $file):?>
                    <div class="form-group recurring_income_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="recurring_income_document_link"><?php _trans('recurring_income_document_link'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="recurring_income_document_link" class="form-control" readonly value="<?=$file; ?>">
                                <input type="hidden" name="recurring_income_files[]" value="<?=$file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger recurring_income_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group recurring_income_file" >
                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                        <label for="recurring_income_document_link"><?php _trans('recurring_income_document_link'); ?></label>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-8 col-sm-8 no-padding">
                            <input type="text" name="recurring_income_document_link[]" id="recurring_income_document_link" class="form-control recurring_income_document_link" readonly >
                        </div>
                        <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                            <input type="file" style="display:none;"  id="recurring_income_file" name="recurring_income_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                            <button class="btn btn-danger recurring_income_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <?php if(isset($tablet_files) && is_array($tablet_files) && !empty($tablet_files)){ ?>
                <?php foreach ($tablet_files as $tablet_file):?>
                    <div class="form-group recurring_income_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="recurring_income_document_link"><?php _trans('recurring_income_document_link'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="recurring_income_document_link" class="form-control" readonly value="<?=$tablet_file; ?>">
                                <input type="hidden" name="recurring_income_files[]" value="<?=$tablet_file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger recurring_income_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php } ?>
        </div>


    </div>

</form>
<script>


    function get_file_url(_this = null){
        $(_this).parents('.recurring_income_file').find('#recurring_income_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.recurring_income_file').find('.recurring_income_document_link').val(pdf_url)
    }


    $(document).on('click', '.add_attachments', function () {
        var elm_amount = `<div class="form-group recurring_income_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="recurring_income_document_link"><?php _trans('recurring_income_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="recurring_income_document_link[]" id="recurring_income_document_link" class="form-control recurring_income_document_link" readonly
                         >
                </div>
                <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='expenses2' id="recurring_income_file" name="recurring_income_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger recurring_income_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

        $('.attachments').prepend(elm_amount);

    })


    $(document).on('click', '.recurring_income_delete', function () {
        $(this).parents('.recurring_income_file').remove();
    })




</script>
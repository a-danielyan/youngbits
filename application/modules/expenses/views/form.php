<form method="post" enctype="multipart/form-data" class="form-horizontal"  id="expenses-form">


    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($expenses_id) { ?>
        <input type="hidden" name="expenses_id" value="<?php echo $expenses_id; ?>">
    <?php } ?>

    <div id="headerbar">
        <div class="col-md-1">        <h1 class="headerbar-title"><?php _trans('expenses_form'); ?></h1>
        </div>
        <?php if(!empty($expenses_templates)): ?>
            <div class="col-md-2">
                <select name="expenses_templates" id="expenses_templates" class="form-control simple-select">
                    <option value=""><?php _trans('expenses_select_template'); ?></option>
                    <?php foreach ($expenses_templates as $expenses_template) { ?>
                        <option value="<?=$expenses_template->expenses_id; ?>" >
                            <?=htmlspecialchars($expenses_template->expenses_name); ?>
                        </option>
                    <?php } ?>
                </select>

            </div>
        <?php endif; ?>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_name" class="control-label"><?php _trans('name'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="expenses_name" id="expenses_name" class="form-control"
                       value="<?php echo $this->mdl_expenses->form_value('expenses_name'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_category" class="control-label"><?php _trans('category'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="expenses_category" id="expenses_category" class="form-control"
                       value="<?php echo $this->mdl_expenses->form_value('expenses_category'); ?>">
            </div>
        </div>










        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_project_id"><?php _trans('project'); ?>: </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="expenses_project_id" id="expenses_project_id" class="form-control simple-select">
                    <option value=""><?php _trans('select_project'); ?></option>
                    <?php foreach ($projects as $project) { ?>
                        <option value="<?=$project->project_id; ?>"
                            <?php check_select($this->mdl_expenses->form_value('expenses_project_id'), $project->project_id); ?>>
                            <?=htmlspecialchars($project->project_name); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_user_id">
                    <?php _trans('user'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="expenses_user_id" id="expenses_user_id" class="form-control simple-select" >
                    <option value="" >
                        <?= _trans('no_selected')?>
                    </option>

                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user->user_id; ?>"
                            <?php check_select($user->user_id, $this->mdl_expenses->form_value('expenses_user_id'));?>>
                            <?=$user->user_name;?>
                        </option>
                    <?php } ?>
                </select>
            </div>


        </div>
        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="expenses_date" id="expenses_date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_expenses->form_value('expenses_date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_currency"><?php _trans('currency'); ?>: </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="expenses_currency" id="expenses_currency" class="form-control simple-select">


                    <option value="dollar"  <?=($this->mdl_expenses->form_value('expenses_currency') == 'dollar')? 'selected' : '' ;?> >$  <?php _trans('dollar'); ?></option>
                    <option value="euro" <?=($this->mdl_expenses->form_value('expenses_currency') == 'euro')? 'selected' : '' ;?> >€ <?php _trans('euro'); ?></option>

                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_amount" class="control-label"><?php _trans('amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input  min="0" step="0.01" name="expenses_amount" id="expenses_amount" class="form-control"
                           value="<?php echo format_amount($this->mdl_expenses->form_value('expenses_amount')); ?>">
                    <div class="input-group-addon">
                      $
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_amount_euro" class="control-label"><?php _trans('amount'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input min="0" step="0.01" name="expenses_amount_euro" id="expenses_amount_euro" class="form-control"
                           value="<?php echo format_amount($this->mdl_expenses->form_value('expenses_amount_euro')); ?>">
                    <div class="input-group-addon">
                        <?php echo get_setting('currency_symbol') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_notes" class="control-label"><?php _trans('notes'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="expenses_notes"
                          class="form-control"><?php echo $this->mdl_expenses->form_value('expenses_notes', true); ?></textarea>
            </div>

        </div>




        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_parent_id"><?php _trans('parent_expenses'); ?>: </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="expenses_parent_id" id="expenses_parent_id" class="form-control simple-select" >
                    <option value="" >
                        <?= _trans('no_selected_expenses')?>
                    </option>

                    <?php foreach ($expenses as $expens) { ?>
                        <option value="<?=$expens->expenses_id; ?>"
                            <?php check_select($expens->expenses_id, $this->mdl_expenses->form_value('expenses_parent_id'));?>>
                            <?=$expens->expenses_id;?> - <?=$expens->expenses_name;?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_cash_bank" class="control-label"><?php _trans('cash_bank'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <select name="expenses_cash_bank" id="expenses_cash_bank" class="form-control simple-select" >
                    <?php foreach ($cash_banks as $key => $cash_bank) { ?>
                        <option value="<?=$key; ?>"
                            <?php check_select($key, $this->mdl_expenses->form_value('expenses_cash_bank'));?>>
                            <?=$cash_bank;?>
                        </option>
                    <?php } ?>
                </select>


            </div>
        </div>
        <!--        TAXES SECTION      -->
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_taxes" class="control-label"><?php _trans('expenses_taxes'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="expenses_taxes" id="expenses_taxes" class="form-control"
                       value="<?php echo $this->mdl_expenses->form_value('expenses_taxes'); ?>">
            </div>
        </div>
        <!--    END TAXES SECTION      -->

        <!--        Eclude from total amount SECTION      -->
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_taxes" class="control-label"><?php _trans('exclude_from_total'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6 text-left">
                <input type="checkbox" name="exclude_from_total" id="exclude_from_total" style="width: 30px; height: 30px"
                      <?php echo $this->mdl_expenses->form_value('exclude_from_total') ? 'checked' : '' ?>>
            </div>
        </div>






        <!--    END Eclude from total amount SECTION      -->



        <!--UPLOAD FILES DRAG AND DROP-->
        <div class="form-group">
            <hr>
            <div class="col-xs-12 col-sm-8 text-right text-left-xs">
                <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_attachments'); ?></button>
            </div>
        </div>
        <div class="form-group attachments">








            <?php if(isset($upload_files) && is_array($upload_files) && !empty($upload_files)):?>
                <?php foreach ($upload_files as $file):?>
                    <div class="form-group expenses_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="expenses_document_link"><?php _trans('expenses_document_link'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="expenses_document_link" class="form-control" readonly value="<?=$file; ?>">
                                <input type="hidden" name="expenses_files[]" value="<?=$file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger expenses_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group expenses_file" >
                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                        <label for="expenses_document_link"><?php _trans('expenses_document_link'); ?></label>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-8 col-sm-8 no-padding">
                            <input type="text" name="expenses_document_link[]" id="expenses_document_link" class="form-control expenses_document_link" readonly >
                        </div>
                        <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                            <input type="file" style="display:none;"  id="expenses_file" name="expenses_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                            <button class="btn btn-danger expenses_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <?php if(isset($tablet_files) && is_array($tablet_files) && !empty($tablet_files)){ ?>
                <?php foreach ($tablet_files as $tablet_file):?>
                    <div class="form-group expenses_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="expenses_document_link"><?php _trans('expenses_document_link'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="expenses_document_link" class="form-control" readonly value="<?=$tablet_file; ?>">
                                <input type="hidden" name="expenses_files[]" value="<?=$tablet_file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger expenses_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php } ?>
        </div>


        <!--UPLOAD FILES Manually Add-->
    <!--    <?php /*if(!empty($tablet_files_session)){  */?>

            <div class="dropzone dropzone_load_files" id="dZUpload"></div>

        --><?php /*} */?>


    </div>

</form>
<script>


        function get_file_url(_this = null){
            $(_this).parents('.expenses_file').find('#expenses_file').click()
        }

        function save_url(_this = null){

            var pdf_url = $(_this).val();
            $(_this).parents('.expenses_file').find('.expenses_document_link').val(pdf_url)
        }


        $(document).on('click', '.add_attachments', function () {
            var elm_amount = `<div class="form-group expenses_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_document_link"><?php _trans('expenses_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="expenses_document_link[]" id="expenses_document_link" class="form-control expenses_document_link" readonly
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


        $(document).on('change','#expenses_templates',function(){
            var template_id = $(this).val();

            var _this = $(this);
            $.ajax({
                type:'post',
                url:base_url+'/index.php/expenses/select_templates',
                data:{
                    'template_id':template_id,
                },
                cache: false,
                async: false,
                success:function(data){
                    $('#expenses-form').html(data)
                }
            })

        })

</script>
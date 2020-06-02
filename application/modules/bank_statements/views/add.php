<form method="post" enctype="multipart/form-data" class="form-horizontal"  id="statements-form">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <div class="col-md-1">        
            <h1 class="headerbar-title"><?php _trans('statement_form'); ?></h1>
        </div>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="bank_account" class="control-label"><?php _trans('bank_account'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="bank_account" id="bank_account" class="form-control"
                       value="<?php echo $this->mdl_statements->form_value('bank_account'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="amount" class="control-label"><?php _trans('amount'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="amount" id="amount" class="form-control"
                       value="<?php echo $this->mdl_statements->form_value('amount'); ?>">
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="date" id="date"
                           class="form-control datepicker"
                           value="<?php echo date_from_mysql($this->mdl_statements->form_value('date')); ?>">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="offset" class="control-label"><?php _trans('offset'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type = "text" name="offset" id="offset" class="form-control" value="<?php echo $this->mdl_statements->form_value('offset'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="account_name" class="control-label"><?php _trans('account_name'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type = "text" name="account_name" id="account_name" class="form-control" value="<?php echo $this->mdl_statements->form_value('account_name'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="type" class="control-label"><?php _trans('type'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="type" id="type" class="form-control simple-select">
                    <option value = "bank" <?= 'bank' === $this->mdl_statements->form_value('type') ? 'selected' : '' ?> >Bank</option>
                    <option value = "paypal" <?= 'paypal' === $this->mdl_statements->form_value('type') ? 'selected' : '' ?> >Paypal</option>
                    <option value = "cash" <?= 'cash' === $this->mdl_statements->form_value('type') ? 'selected' : '' ?>>Cash</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="user_id" class="control-label"><?php _trans('user'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="user_id" id="user_id" class="form-control simple-select">
                    <option value=""></option>
                    <?php foreach ($users as $user) { ?>
                        <option <?= $user->user_id === $this->mdl_statements->form_value('user_id') ? 'selected' : '' ?> value="<?php echo $user->user_id; ?>">
                            <?php echo $user->user_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="project_id" class="control-label"><?php _trans('project'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="project_id" id="project_id" class="form-control simple-select">
                    <option value="0"></option>
                    <?php foreach ($projects as $project) { ?>
                        <option <?= $project->project_id === $this->mdl_statements->form_value('project_id') ? 'selected' : '' ?> value="<?php echo $project->project_id; ?>">
                            <?php echo $project->project_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="parent_id" class="control-label"><?php _trans('parent'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="parent_id" id="parent_id" class="form-control simple-select">
                    <option value="0"></option>
                    <?php foreach ($statements as $stat) { ?>
                        <option <?= $stat->id === $this->mdl_statements->form_value('parent_id') ? 'selected' : '' ?> value="<?php echo $stat->id; ?>">
                            <?php echo $stat->id; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="category" class="control-label"><?php _trans('category'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type = "text" name="category" id="category" class="form-control" value="<?php echo $this->mdl_statements->form_value('category'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="organization" class="control-label"><?php _trans('organization'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type = "text" name="organization" id="organization" class="form-control" value="<?php echo $this->mdl_statements->form_value('organization'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="description" class="control-label"><?php _trans('description'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="description" class="form-control"><?php echo $this->mdl_statements->form_value('description', true); ?></textarea>
            </div>

        </div>

        <!-- ----------------------------------- -->
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="currency"><?php _trans('currency'); ?>: </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="currency" id="currency" class="form-control simple-select">
                    <option value="dollar"  <?=($this->mdl_statements->form_value('currency') == 'dollar')? 'selected' : '' ;?> >$  <?php _trans('dollar'); ?></option>
                    <option value="euro" <?=($this->mdl_statements->form_value('currency') == 'euro')? 'selected' : '' ;?> >€ <?php _trans('euro'); ?></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="taxes" class="control-label"><?php _trans('taxes'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="taxes" id="taxes" class="form-control"
                       value="<?php echo $this->mdl_statements->form_value('taxes'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="expenses_taxes" class="control-label"><?php _trans('exclude_from_total'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6 text-left">
                <input type="checkbox" name="exclude_from_total" id="exclude_from_total" style="width: 30px; height: 30px"
                      <?php echo $this->mdl_statements->form_value('exclude_from_total') ? 'checked' : '' ?>>
            </div>
        </div>

        <!-- Attachments -->

        <div class="form-group">
            <hr>
            <div class="col-xs-12 col-sm-8 text-right text-left-xs">
                <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_attachments'); ?></button>
            </div>
        </div>

        <div class="form-group attachments">
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

        </div>




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

</script>
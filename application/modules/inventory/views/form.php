<form method="post" enctype="multipart/form-data" class="form-horizontal" id="inventory-form">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <?php if ($inventory_id) { ?>
        <input type="hidden" name="inventory_id" value="<?php echo $inventory_id; ?>">
    <?php } ?>

    <div id="headerbar">
        <div class="col-md-1">        <h1 class="headerbar-title"><?php _trans('inventory_form'); ?></h1>
        </div>
        <?php if(!empty($inventory_templates)): ?>
            <div class="col-md-2">
                <select name="inventory_templates" id="inventory_templates" class="form-control simple-select">
                    <option value=""><?php _trans('select_template'); ?></option>
                    <?php foreach ($inventory_templates as $inventory_template) { ?>
                        <option value="<?=$inventory_template->inventory_id; ?>" >
                            <?=htmlspecialchars($inventory_template->inventory_post_title); ?>
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
                <label for="inventory_post_title" class="control-label"><?php _trans('inventory_post_title'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="inventory_post_title" id="inventory_post_title" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_post_title'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_post_content" class="control-label"><?php _trans('inventory_post_content'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <textarea name="inventory_post_content"
                          class="form-control"><?php echo $this->mdl_inventory->form_value('inventory_post_content', true); ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_sale_price" class="control-label"><?php _trans('inventory_sale_price'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input type="number" name="inventory_sale_price" id="inventory_sale_price" class="form-control"
                           value="<?php echo format_amount($this->mdl_inventory->form_value('inventory_sale_price')); ?>">
                    <div class="input-group-addon">
                        <?php echo get_setting('currency_symbol') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_regular_price" class="control-label"><?php _trans('inventory_regular_price'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input type="number" name="inventory_regular_price" id="inventory_regular_price" class="form-control"
                           value="<?php echo format_amount($this->mdl_inventory->form_value('inventory_regular_price')); ?>">
                    <div class="input-group-addon">
                        <?php echo get_setting('currency_symbol') ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_size" class="control-label"><?php _trans('inventory_size'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="inventory_size" id="inventory_size" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_size'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_weight" class="control-label"><?php _trans('inventory_weight'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="inventory_weight" id="inventory_weight" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_weight'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_length" class="control-label"><?php _trans('inventory_length'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="number" name="inventory_length" id="inventory_length" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_length'); ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_width" class="control-label"><?php _trans('inventory_width'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="number" name="inventory_width" id="inventory_width" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_width'); ?>">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_manage_stock"><?php _trans('inventory_manage_stock'); ?></label>
            </div>
            <div class="col-md-1">
                <label><?php _trans('enable'); ?> &nbsp
                    <input type="checkbox" class="inventory_manage_stock" name="inventory_manage_stock" value="yes" <?php if($this->mdl_inventory->form_value('inventory_manage_stock') == 'yes'){ echo 'checked';}; ?>>
                </label>
            </div>
        </div>

        <div class="inventory_stock_quantity  <?php if($this->mdl_inventory->form_value('inventory_manage_stock') != 'yes'){ echo 'd-none';}; ?> ">
            <div class="form-group">
                <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                    <label for="inventory_stock_quantity" class="control-label"><?php _trans('inventory_stock_quantity'); ?></label>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <input type="number" name="inventory_stock_quantity" id="inventory_stock_quantity" class="form-control"
                           value="<?php echo $this->mdl_inventory->form_value('inventory_stock_quantity'); ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_product_url" class="control-label"><?php _trans('inventory_product_url'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input type="text" name="inventory_product_url" id="inventory_product_url" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_product_url'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_category" class="control-label">
                    <?php _trans('categories'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6 payment-method-wrapper">
                <select id="inventory_category" name="inventory_category" class="form-control simple-select">
                    <?php foreach ($categories as $key => $category) { ?>
                        <option value="<?=$key; ?>"
                                <?php if ($this->mdl_inventory->form_value('inventory_category') == $key) { ?>selected="selected"<?php } ?>>
                            <?=$category; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_percentage_user" class="control-label">
                    <?php _trans('percentage_for_user'); ?>
                </label>
            </div>
            <div class="col-xs-12 col-sm-6 payment-method-wrapper">
                <select id="inventory_percentage_user" name="inventory_percentage_user" class="form-control simple-select">
                    <?php foreach ($percentage_users as $key => $percentage_user) { ?>
                        <option value="<?=$key; ?>"
                                <?php if ($this->mdl_inventory->form_value('inventory_percentage_user') == $key) { ?>selected="selected"<?php } ?>>
                            <?=$percentage_user; ?> %
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_status"><?php _trans('status'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="inventory_status" id="inventory_status" class="form-control simple-select" >
                    <?php foreach ($inventory_statuses as $key => $status) {
                        ?>
                        <option value="<?php echo $key; ?>" <?php check_select($key, $this->mdl_inventory->form_value('inventory_status')); ?>>
                            <?php echo $status['label']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_project_id"><?php _trans('project'); ?>: </label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <select name="inventory_project_id" id="inventory_project_id" class="form-control simple-select">
                    <option value=""><?php _trans('select_project'); ?></option>
                    <?php foreach ($projects as $project) { ?>
                        <option value="<?=$project->project_id; ?>"
                            <?php check_select($this->mdl_inventory->form_value('inventory_project_id'), $project->project_id); ?>>
                            <?=htmlspecialchars($project->project_name); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_location" class="control-label"><?php _trans('inventory_location'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="inventory_location" id="inventory_location" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_location'); ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_country" class="control-label"><?php _trans('inventory_country'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" name="inventory_country" id="inventory_country" class="form-control"
                       value="<?php echo $this->mdl_inventory->form_value('inventory_country'); ?>">
            </div>
        </div>

        <div class="form-group has-feedback">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_date" class="control-label"><?php _trans('date'); ?></label>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                    <input name="inventory_date" id="inventory_date" class="form-control" value="<?php echo date_from_mysql($this->mdl_inventory->form_value('inventory_date')); ?>" readonly>
                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                </div>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_sold"><?php _trans('inventory_sold'); ?></label>
            </div>
            <div class="col-md-1">
                <label><?php _trans('no'); ?> &nbsp
                    <input type="radio" class="inventory_sell_product_now" name="inventory_sold" value="no" <?php if($this->mdl_inventory->form_value('inventory_sold') == 'no'){ echo 'checked';}; ?>>
                </label>
            </div>
            <div class="col-md-1">
                <label><?php _trans('yes'); ?> &nbsp
                    <input type="radio" class="inventory_sell_product_now" name="inventory_sold" value="yes" <?php if($this->mdl_inventory->form_value('inventory_sold') == 'yes'){ echo 'checked';}; ?>>
                </label>
            </div>
        </div>




        <!--ADD ATTACHMENTS-->

        <div class="form-group">
            <hr>
            <div class="col-xs-12 col-sm-8 text-right text-left-xs">
                <button class="btn btn-primary add_attachments" type="button">+ <?php _trans('add_image'); ?></button>
            </div>
        </div>

        <div class="form-group attachments">


            <?php if(isset($upload_files) && is_array($upload_files) && !empty($upload_files)):?>
                <?php foreach ($upload_files as $file):?>
                    <div class="form-group inventory_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="inventory_document_link"><?php _trans('inventory_image'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="inventory_document_link" class="form-control" readonly value="<?=$file; ?>">
                                <input type="hidden" name="inventory_files[]" value="<?=$file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger inventory_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group inventory_file" >
                    <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                        <label for="inventory_document_link"><?php _trans('inventory_image'); ?></label>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="col-xs-8 col-sm-8 no-padding">
                            <input type="text" name="inventory_document_link[]" id="inventory_document_link" class="form-control inventory_document_link" readonly >
                        </div>
                        <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                            <input type="file" style="display:none;"  id="inventory_file" name="inventory_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                            <button class="btn btn-danger inventory_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(isset($tablet_files) && is_array($tablet_files) && !empty($tablet_files)){ ?>
                <?php foreach ($tablet_files as $tablet_file):?>
                    <div class="form-group inventory_file" >
                        <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                            <label for="inventory_document_link"><?php _trans('inventory_image'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="col-xs-8 col-sm-10 no-padding">
                                <input type="text" id="inventory_document_link" class="form-control" readonly value="<?=$tablet_file; ?>">
                                <input type="hidden" name="inventory_files[]" value="<?=$tablet_file; ?>">
                            </div>
                            <div class="form-inline col-xs-4 col-sm-2" style="padding-right:0 !important" >
                                <button  class="btn btn-danger inventory_delete" >
                                    <i class="fa fa-trash-o fa-margin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php } ?>


        </div>


        <?php if($this->mdl_inventory->form_value('inventory_created_user') == 0){
            ?>
            <input type="hidden" name="inventory_created_user" value="<?= $this->session->userdata('user_id') ?>">
        <?php } ?>

    </div>

</form>


<script>


    function get_file_url(_this = null){
        $(_this).parents('.inventory_file').find('#inventory_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.inventory_file').find('.inventory_document_link').val(pdf_url)
    }


    $(document).on('click', '.add_attachments', function () {
        var elm_amount = `<div class="form-group inventory_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="inventory_document_link"><?php _trans('inventory_image'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="inventory_document_link[]" id="inventory_document_link" class="form-control inventory_document_link" readonly
                         >
                </div>
                <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='inventory2' id="inventory_file" name="inventory_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger inventory_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

        $('.attachments').prepend(elm_amount);

    })


    $(document).on('click', '.inventory_delete', function () {
        $(this).parents('.inventory_file').remove();
    })

    $(document).on('click', '.inventory_manage_stock', function () {
        if($(this). is(":checked")){
            $('.inventory_stock_quantity').removeClass('d-none')
        }else{
            $('.inventory_stock_quantity').addClass('d-none')
        }
    })


    $(document).on('change','#inventory_templates',function(){
        var template_id = $(this).val();
        var _this = $(this);
        $.ajax({
            type:'post',
            url:base_url+'/index.php/inventory/select_templates',
            data:{
                'template_id':template_id,
            },
            cache: false,
            async: false,
            success:function(data){
                $('#inventory-form').html(data)
            }
        })

    })


</script>

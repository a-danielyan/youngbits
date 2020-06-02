
<style>
    /* The container */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        /*margin-bottom: 12px;*/
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
    }

    .container-checkbox label {
        margin-bottom: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #5cb85c;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>


<div id="headerbar">
    <h1 class="headerbar-title"><?= $title_quarter ; ?></h1>
</div>


<div id="content">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('total_numbers'); ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 pr-0"><b><?_trans('total_invoices')?></b>:</div>
                        <div class="col-md-8 p-0"> €<?=$invoices_quarter_amount?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pr-0"><b><?_trans('total_expenses_dollar')?></b>:</div>
                        <div class="col-md-8 p-0"> $<?=$dollar_expenses_quarter_amount?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pr-0"><b><?_trans('total_expenses_euro')?></b>:</div>
                        <div class="col-md-8 p-0"> €<?=$euro_expenses_quarter_amount?></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default ">
                <div class="panel-heading">
                    <?php _trans('attachment'); ?>
                </div>
                <div class="panel-body">

                    <form method="post" action="<?= base_url('/index.php/invoices/quarter_attachment')?>" enctype="multipart/form-data" class="form-horizontal" id="quarter-form">
                        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                               value="<?php echo $this->security->get_csrf_hash() ?>">


                        <div class="form-group attachments">


                            <div class="quarter_file" >

                                <div class="col">
                                    <div class="col-md-8">
                                        <input type="text" name="quarter_document_link[]" id="quarter_document_link" class="form-control quarter_document_link" readonly >
                                    </div>
                                    <div class="col-md-4" style="padding-right:0 !important" >
                                        <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                                        <input type="file" style="display:none;"  id="quarter_file" name="quarter_file[]" accept=".jpeg, .jpg, .png, .pdf, .csv, .xlsx, .xml " onchange="save_url(this)"/>
                                        <button class="btn btn-danger quarter_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"  style="color: #fff"></i>  </button>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="mt-3" >
                            <div class="col-md-12 text-center" >
                                <button class="btn btn-primary add_quarter_attachment">+ Add</button>
                            </div>
                        </div>

                        <input type="hidden" name="quarter_year" value="<?= $year?>">
                        <input type="hidden" name="quarter_month" value="<?= $month?>">
                    </form>

                </div>
            </div>


            <div class="panel panel-default ">
                <div class="panel-heading">
                    <?php _trans('attachments'); ?>
                </div>
                <div class="panel-body">
                    <?php if(isset($quarter_files) && is_array($quarter_files) && !empty($quarter_files)):?>
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th class="text-center"><?php _trans('attachments'); ?></th>
                                <th class="text-center"><?php _trans('option'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($quarter_files as $file):?>
                                <tr>
                                    <td>
                                        <?= $file->quarter_id?>
                                    </td>
                                    <td >
                                        <label class="container-checkbox">
                                            <?php
                                            $file_info = pathinfo($file->quarter_attachment);
                                                    if(in_array($file_info['extension'],$file_types)){
                                            ?>
                                                        <a href="<?=base_url() . "uploads/quarter/" .$file->quarter_attachment; ?>" download target="_blank">
                                                            <?=$file->quarter_attachment; ?>
                                                        </a>
                                            <?php
                                                    }else{
                                            ?>
                                                        <a href="<?=base_url() . "uploads/quarter/" .$file->quarter_attachment; ?>" target="_blank">
                                                            <?=$file->quarter_attachment; ?>
                                                        </a>
                                            <?php
                                                    }
                                            ?>

                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger quarter_delete" data-quarter-id=" <?=$file->quarter_id; ?>" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin" style="color: #fff"></i>  </a>
                                    </td>
                                </tr>


                            <?php endforeach; ?>


                        </tbody>
                    </table>
                    <?php else: ?>
                        <div class="text-center" >
                            <h2>No attachment</h2>
                        </div>
                    <?php endif; ?>

                </div>
            </div>


        </div>


        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('invoices'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th><?php _trans('invoice_number'); ?></th>
                                <th><?php _trans('amount'); ?></th>
                                <th><?php _trans('balance'); ?></th>
                                <th><?php _trans('created'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($invoices as $invoice) { ?>

                                <tr>
                                    <td>
                                        <label><?= htmlsc($invoice->invoice_id)?></label>
                                    </td>
                                    <td>
                                        <label class="container-checkbox">
                                            <a href="<?=site_url('invoices/view/' . $invoice->invoice_id); ?>"
                                               title="<?php _trans('edit'); ?>" class="inv_number">
                                                <?=($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id); ?>
                                            </a>
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo format_currency($invoice->invoice_total); ?>
                                    </td>
                                    <td>
                                        <?php echo format_currency($invoice->invoice_balance); ?>
                                    </td>
                                    <td>
                                        <label> <?=date_from_mysql($invoice->invoice_date_created); ?></label>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!--Expenses dollar-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('expenses_dollar'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th><?php _trans('expenses_name'); ?></th>
                                <th><?php _trans('user'); ?></th>
                                <th><?php _trans('expenses_category'); ?></th>
                                <th><?php _trans('date'); ?></th>
                                <th><?php _trans('expenses_amount'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($expenses_dollar as $expense) { ?>
                                <tr>
                                    <td>
                                        <label><?= htmlsc($expense->expenses_id)?></label>
                                    </td>
                                    <td>
                                        <?= htmlsc($expense->expenses_name)?>
                                    </td>
                                    <td>
                                        <label><?= htmlsc($expense->user_name)?></label>
                                    </td>
                                    <td>
                                        <label><?= $expense->expenses_category?></label>
                                    </td>
                                    <td>
                                        <label><?= htmlsc($expense->expenses_date)?></label>
                                    </td>
                                    <td>
                                        <label>  <?='$'.format_amount($expense->expenses_amount); ?></label>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

            <!-- Expenses euro -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('expenses_euro'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th><?php _trans('expenses_name'); ?></th>
                                <th><?php _trans('user'); ?></th>
                                <th><?php _trans('expenses_category'); ?></th>
                                <th><?php _trans('date'); ?></th>
                                <th><?php _trans('expenses_amount'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($expenses_euro as $expense) { ?>
                                <tr>
                                    <td>
                                        <label><?= htmlsc($expense->expenses_id)?></label>
                                    </td>
                                    <td>
                                        <?= htmlsc($expense->expenses_name)?>
                                    </td>
                                    <td>
                                        <label><?= htmlsc($expense->user_name)?></label>
                                    </td>
                                    <td>
                                        <label><?= $expense->expenses_category?></label>
                                    </td>
                                    <td>
                                        <label><?= htmlsc($expense->expenses_date)?></label>
                                    </td>
                                    <td>
                                        <label>  <?='€'.format_amount($expense->expenses_amount_euro); ?></label>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <!-- Expenses euro -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('appointments'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th><?php _trans('appointment_title'); ?></th>
                                <th><?php _trans('project'); ?></th>
                                <th><?php _trans('appointment_date'); ?></th>
                                <th><?php _trans('appointment_kilometers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($appointments_quarter as $appointment) { ?>
                                <tr>
                                    <td>
                                        <label><?= htmlsc($appointment->appointment_id)?></label>
                                    </td>
                                    <td>
                                        <?= htmlsc($appointment->appointment_title)?>
                                    </td>
                                    <td>
                                        <?=anchor('projects/view/' . $appointment->project_id, htmlsc($appointment->project_name)); ?>

                                    </td>
                                    <td>
                                        <label><?= htmlsc($appointment->appointment_date)?></label>
                                    </td>
                                    <td>
                                        <label><?= $appointment->appointment_kilometers?></label>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>


        </div>
    </div>

</div>


<script>
    function get_file_url(_this = null){
        $(_this).parents('.quarter_file').find('#quarter_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.quarter_file').find('.quarter_document_link').val(pdf_url)
    }


    $(document).on('click', '.add_attachments', function () {
        var elm_amount = `<div class="form-group quarter_file" >
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
                <label for="quarter_document_link"><?php _trans('quarter_document_link'); ?></label>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-8 col-sm-8 no-padding">
                    <input type="text" name="quarter_document_link[]" id="quarter_document_link" class="form-control quarter_document_link" readonly
                         >
                </div>
                <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                    <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                    <input type="file" style="display:none;" class='expenses2' id="quarter_file" name="quarter_file[]" accept=".jpeg, .jpg, .png, .pdf" onchange="save_url(this)"/>
                    <button class="btn btn-danger quarter_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>
                </div>
            </div>
        </div>`;

        $('.attachments').prepend(elm_amount);

    })


    $(document).on('click', '.quarter_delete', function () {

        $(this).parents('tr').remove();
       var quarter_id = $(this).data('quarter-id');
       console.log(quarter_id)
        $.ajax({
            url:"<?= site_url('invoices/quarter_attachment_deleted')?>",
            type:'post',
            data:{'quarter_id':quarter_id, _ip_csrf:Cookies.get('ip_csrf_cookie')},
            success: function(data) {

            }
        });

    })

</script>
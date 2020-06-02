
<!-- Button trigger modal -->


<div id="headerbar">
   <div class="col-md-5">
       <h1 class="headerbar-title"><?php _trans('inventory'); ?></h1>
       <form action="export" method="get">

           <div class="row">
               <div class="col-md-3">
                   <label for="inventory_start_date"></label>
                   <div class="input-group">
                       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                           Import
                       </button>
                        <button class="btn btn-info" style="margin-left: 10px"><?= _trans('csv')?></button>
                    </div>

               </div>


               <div class="col-md-3">
                   <label for="inventory_start_date"><?php _trans('start_date'); ?></label>
                   <div class="input-group">
                       <input name="inventory_start_date" id="inventory_start_date" class="form-control datepicker"
                              value="">
                       <div class="input-group-addon">
                           <i class="fa fa-calendar fa-fw"></i>
                       </div>
                   </div>
               </div>
               <div class="col-md-3">
                   <label for="inventory_end_date"><?php _trans('end_date'); ?></label>
                   <div class="input-group">
                       <input name="inventory_end_date" id="inventory_end_date" class="form-control datepicker"
                              value="">
                       <div class="input-group-addon">
                           <i class="fa fa-calendar fa-fw"></i>
                       </div>
                   </div>
               </div>
           </div>
       </form>

   </div>
   <div class="col-md-3">


   </div>
<!--    <a href="--><?//= base_url('index.php/inventory/export')?><!--" class="btn btn-info" style="margin-left: 10px">--><?//= _trans('csv')?><!--</a>-->
    <?php if($this->session->userdata('user_type') == TYPE_ADMIN  || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES){ ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('inventory/tablet_form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('inventory/index'), 'mdl_inventory'); ?>
    </div>

    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt"><?php echo _trans('selected') ?> : <p class="amount_val" style="display: inline;"></p></span>

        <?php if( !in_array($this->session->userdata('user_type'), array(TYPE_SALESPERSON)) ){ ?>
            <span class="total_amt" style="font-weight: bold"><?php echo _trans('total_regular_price'); ?> : <?php echo format_currency($total_regular_price); ?></span>
        <?php } ?>
<!--        <span class="" style="font-weight: bold">--><?php //echo _trans('total_sold'); ?><!-- : --><?php //echo format_currency($total_sold); ?><!--</span>-->
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('inventory/partial_inventory_table'); ?>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post"  action="<?= base_url('index.php/inventory/import')?>" class="form-horizontal inventory_import" enctype="multipart/form-data" >
            <div class="modal-body">

                    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                           value="<?php echo $this->security->get_csrf_hash() ?>">
                    <div class="form-group" >
                        <div class="col-xs-8 col-sm-8">
                            <input type="text" name="inventory_document_link" id="inventory_document_link" class="form-control inventory_document_link" readonly >
                        </div>
                        <div class="col-xs-4 col-sm-4" style="padding-right:0 !important" >
                            <input type="button" id="loadFile" class="btn btn-success col-xs-8 col-md-8 col-lg-8" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                            <input type="file" style="display:none;"  id="inventory_file" name="import_csv" accept=".csv" onchange="save_url(this)"/>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  name="importSubmit" class="btn btn-primary" value="IMPORT">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function get_file_url(_this = null){
        $(_this).parents('.inventory_import').find('#inventory_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.inventory_import').find('.inventory_document_link').val(pdf_url)
    }

</script>

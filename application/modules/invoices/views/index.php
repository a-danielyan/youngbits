<style>

    .headerbar{
        background: #fff;
    }

    .style_price{
        color: #a9a9a9;

    }

    .btn-sm, .btn-group-sm>.btn{
        padding: 11px 10px;
        border-color: #ededed;
        border-top: 0;
        border-bottom: 0;
        font-weight: 600;
        font-size: 14px;
    }

    #headerbar{
        background: #fff;
    }
    thead{
        background: #fff;
    }

    #headerbar .headerbar-title{
        font-size: 19px;
    }

    table.table.table-striped th {
        font-size: 14px;
        font-weight: 600;
    }

    a.btn.btn-default.btn-sm.dropdown-toggle {
        padding: 6px 10px;
        border-radius: 6px;
        border: 0;
    }


</style>

<div class="container-fluid">
    <div class="headerbar mt-4">
        <div class="col-lg-5 text-left">
            <?php if($this->session->userdata('user_type') != TYPE_MANAGERS): ?>
                <div class="col-lg-4 col-md-2 col-sm-12 headerbar-item p-0-md">
                    <div class="btn-group btn-group-sm index-options sum_content">
                        <span class=""><b><?php _trans('total_not_paid'); ?> </b>: <span class="style_price"><?php echo format_currency( $total_not_paid); ?></span></span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2 col-sm-12 headerbar-item p-0-md">
                    <div class="btn-group btn-group-sm index-options sum_content">
                        <span class="total_amt"><b><?php echo _trans('total_sent'); ?> </b>: <span class="style_price"><?php echo format_currency($sum); ?></span></span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2 col-sm-12 headerbar-item p-0-md">
                    <div class="btn-group btn-group-sm index-options sum_content">
                        <span class="selected_amt"><b><?php echo _trans('selected') ?></b> : <span class="style_price amount_val"></span></span>
                    </div>
                </div>

            <?php endif ?>
        </div>
        <?php if (isset($filter_display) and $filter_display == true) { ?>
            <?php $this->layout->load_view('filter/jquery_filter'); ?>

            <div class="col-lg-2  hidden-search-md mt-4 filter_div">
                <form class="navbar-form navbar-left m-0" role="search" onsubmit="return false;">
                    <div class="form-group">
                        <input id="filter" type="text" class="search-query form-control input-sm filter" placeholder="<?= $filter_placeholder; ?>">
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        <?php } ?>
        <div class="col-lg-5 text-right">
            <div class="headerbar-item pull-right">
                <div class="btn-group btn-group-sm index-options">
                    <a href="<?php echo site_url('invoices/status/all'); ?>"
                       class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                        <?php _trans('all'); ?>
                    </a>
                    <a href="<?php echo site_url('invoices/status/draft'); ?>"
                       class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                        <?php _trans('draft'); ?>
                    </a>
                    <a href="<?php echo site_url('invoices/status/sent'); ?>"
                       class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                        <?php _trans('sent'); ?>
                    </a>
                    <a href="<?php echo site_url('invoices/status/viewed'); ?>"
                       class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                        <?php _trans('viewed'); ?>
                    </a>
                    <a href="<?php echo site_url('invoices/status/paid'); ?>"
                       class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                        <?php _trans('paid'); ?>
                    </a>
                    <a href="<?php echo site_url('invoices/status/overdue'); ?>"
                       class="btn  <?php echo $status == 'overdue' ? 'btn-primary' : 'btn-default' ?>" style="border-right: 0">
                        <?php _trans('overdue'); ?>
                    <a href="<?php echo site_url('invoices/status/credit_invoice'); ?>"
                       class="btn  <?php echo $status == 'credit_invoice' ? 'btn-primary' : 'btn-default' ?>" style="border-right: 0">
                        <?php _trans('credit'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>





<div id="headerbar" class="mt-3">



    <div class="col-lg-5 col-md-6 col-sm-7 col-xs-12 headerbar-item">

        <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-5 p-0 headerbar-item">
            <h1 class="headerbar-title uppercase mr-4"><?php _trans('invoices'); ?></h1>

            <button data-url="<?php echo site_url('invoices/generate_multi_pdf/'); ?>" class="downloadPDF" disabled><i class="fa fa-print"></i></button>

        </div>
        <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-7 p-0-sm m-0-xs text-right-xs headerbar-item action_edit_inv_numb"></div>
    </div>

   <div class="text-right">
       <div class="col-lg-3 col-md-2 col-sm-2 col-xs-2 headerbar-item text-center text-left-md btn_new_invoice">
           <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
               <a class="create-invoice btn btn-sm btn-primary" href="#">
                   <i class="fa fa-plus"></i> <?php _trans('new'); ?>
               </a>
           <?php endif;?>
       </div>

       <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3 p-0-xs text-right headerbar-item headerbar_item_div">
           <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
       </div>
       <div class="clearfix"></div>
   </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('invoices/status/all'); ?>"
                   class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('all'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/draft'); ?>"
                   class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('draft'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/sent'); ?>"
                   class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('sent'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/viewed'); ?>"
                   class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('viewed'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/paid'); ?>"
                   class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('paid'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/overdue'); ?>"
                   class="btn  <?php echo $status == 'overdue' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('overdue'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/credit'); ?>"
                   class="btn  <?php echo $status == 'credit_invoice' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('credit'); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('invoices/partial_invoice_table', array('invoices' => $invoices)); ?>
        <input type="hidden" name="url" value="<?=base_url().'index.php/invoices'?>">
    </div>

    <div id="headerbar">



        <div class="col-lg-4"></div>

        <div class="col-lg-4 headerbar-item text-center btn_new_invoice1">
            <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                    data-toggle="collapse" data-target="#ip-submenu-collapse">
                <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
            </button>
            <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                <a class="create-invoice btn btn-sm btn-primary "  href="#">
                    <i class="fa fa-plus"></i> <?php _trans('new'); ?>
                </a>
            <?php endif;?>
        </div>

        <div class="col-lg-4 text-right headerbar-item visible-lg" style='float: right;width: auto'>
            <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
        </div>

    </div>

</div>



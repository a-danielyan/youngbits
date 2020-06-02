<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('payments'); ?></h1>

    <button data-url="<?= base_url() ?>index.php/invoices/generate_multi_pdf/" class="downloadPDF" disabled><i class="fa fa-print"></i></button>



    <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('payments/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php endif;?>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('payments/index'), 'mdl_payments'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('payments/partial_payment_table'); ?>
    </div>

</div>

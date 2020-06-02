<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('payment_arrangements'); ?></h1>

    <button data-url="<?= base_url() ?>index.php/invoices/generate_multi_pdf/" class="downloadPDF" disabled><i class="fa fa-print"></i></button>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('payment_arrangements/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('payment_arrangements/index'), 'mdl_payment_arrangements'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('payment_arrangements/partial_payment_table'); ?>
    </div>

</div>

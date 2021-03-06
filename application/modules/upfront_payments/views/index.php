
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('upfront_payments'); ?></h1>

    <div class="headerbar-item pull-right">

        <div class="headerbar-item pull-right visible-lg">

    </div>

        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('upfront_payments/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>


    </div>



    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('upfront_payments/index'), 'mdl_upfront_payments'); ?>
    </div>
    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt dollar"><p class="amount_val" style="display: inline;"></p></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : € <?=$sum; ?></span>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('upfront_payments/partial_upfront_payments_table'); ?>
    </div>

</div>

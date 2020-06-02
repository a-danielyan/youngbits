
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('subscriptions'); ?></h1>

    <div class="headerbar-item pull-right">

        <div class="headerbar-item pull-right visible-lg"> </div>

        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('subscriptions/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>


    </div>



    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('subscriptions/index'), 'mdl_subscriptions'); ?>
    </div>
    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt"><?php echo _trans('selected') ?> : <p class="amount_val" style="display: inline;"></p></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : <?php echo format_currency($sum); ?></span>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('subscriptions/partial_subscriptions_table'); ?>
    </div>

</div>

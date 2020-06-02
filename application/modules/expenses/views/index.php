
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('expenses'); ?></h1>
    <button class="btn btn-danger delete_sel_expenses d-none">Delete</button>
    <div class="headerbar-item pull-right">

        <div class="headerbar-item pull-right visible-lg">

    </div>

        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('expenses/tablet_form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>


    </div>



    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('expenses/index'), 'mdl_expenses'); ?>
    </div>
    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt dollar"><p class="amount_val dollar" style="display: inline;"></p></span>
        <span class="selected_amt euro"><p class="amount_val euro" style="display: inline;"></p></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : $ <?=$sum['dollar']; ?></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : <?=format_currency($sum['euro']); ?></span>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('expenses/partial_expenses_table'); ?>
    </div>

    <input type="hidden" name="url_expenses"  class="url_expenses" value="<?=site_url('expenses/delete_sel_expenses')?>">
</div>

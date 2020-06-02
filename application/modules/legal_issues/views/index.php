<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('legal_issues'); ?></h1>

    <?php if($this->session->userdata('user_type') == TYPE_ADMIN  || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES){ ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('legal_issues/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('legal_issues/index'), 'mdl_legal_issues'); ?>
    </div>

    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt"><?php echo _trans('selected') ?> : <p class="amount_val" style="display: inline;"></p></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : <?php echo format_currency($sum); ?></span>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('legal_issues/partial_legal_issues_table'); ?>
    </div>

</div>

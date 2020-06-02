
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('expenses_templates'); ?></h1>

    <div class="headerbar-item pull-right">

        <div class="headerbar-item pull-right visible-lg">

    </div>

        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('expenses_templates/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>


    </div>



    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('expenses_templates/index'), 'mdl_expenses_templates'); ?>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('expenses_templates/partial_expenses_table'); ?>
    </div>

</div>

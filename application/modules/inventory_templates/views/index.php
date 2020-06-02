
<!-- Button trigger modal -->


<div id="headerbar">
    <div class="col-md-5">
        <h1 class="headerbar-title"><?php _trans('inventory_templates'); ?></h1>

    </div>
    <div class="col-md-3">


    </div>
    <!--    <a href="--><?//= base_url('index.php/inventory/export')?><!--" class="btn btn-info" style="margin-left: 10px">--><?//= _trans('csv')?><!--</a>-->
    <?php if($this->session->userdata('user_type') == TYPE_ADMIN  || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES){ ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('inventory_templates/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('inventory_templates/index'), 'mdl_inventory_templates'); ?>
    </div>

    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt"><?php echo _trans('selected') ?> : <p class="amount_val" style="display: inline;"></p></span>

        <?php if( !in_array($this->session->userdata('user_type'), array(TYPE_SALESPERSON)) ){ ?>
            <span class="total_amt" style="font-weight: bold"><?php echo _trans('total_regular_price'); ?> : <?php echo format_currency($total_regular_price); ?></span>
        <?php } ?>
        <span class="" style="font-weight: bold"><?php echo _trans('total_sold'); ?> : <?php echo format_currency($total_sold); ?></span>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('inventory_templates/partial_inventory_table'); ?>
    </div>

</div>

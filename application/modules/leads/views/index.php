<div id="headerbar">

    <h1 class="headerbar-title"><?php _trans('prospects'); ?></h1>
    <button data-url="<?php echo site_url('invoices/generate_multi_pdf/'); ?>" class="sendMultiMail" disabled><i class="fa fa-envelope"></i></button>
    <button data-url="<?php echo site_url('invoices/generate_multi_pdf/'); ?>" class="sendMail" disabled>
        <img src="<?= site_url('../assets/core/img/favicon.png')?>" alt="" style="width: 15px">
    </button>


    <?php if(in_array($this->session->userdata('user_type'), array(TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON)) ){ ?>
        <div class="headerbar-item pull-right">
            <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                    data-toggle="collapse" data-target="#ip-submenu-collapse">
                <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
            </button>
            <a class="btn btn-primary btn-sm" href="<?php echo site_url('leads/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>


    <div class="headerbar-item pull-right visible-lg btn_page_bar">
        <?=$links; ?>
    </div>


    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('leads/status/active/' . $filter_group); ?>"
               class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('active'); ?>
            </a>
            <a href="<?php echo site_url('leads/status/inactive/' . $filter_group); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('inactive'); ?>
            </a>
            <a href="<?php echo site_url('leads/status/all/' . $filter_group); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a
        </div>
    </div>
</div>
</div>




<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('leads/status/' . $this->uri->segment(3)), 'mdl_leads'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('leads/status/active'); ?>"
                   class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('active'); ?>
                </a>
                <a href="<?php echo site_url('leads/status/inactive'); ?>"
                   class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('inactive'); ?>
                </a>
                <a href="<?php echo site_url('leads/status/all'); ?>"
                   class="btn  <?php echo $this->uri->segment(3) == 'all' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('all'); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('leads/partial_lead_table'); ?>
    </div>

</div>

<style>
    .select2-container--default .select2-selection--single
    {
        line-height: 1.5;
        padding: 6px 24px 6px 12px;
        height: 30px;
    }
    .select2-container--default .select2-selection
    {
        font-size: 12px;
    }
</style>
<script>
    function filter(status, index)
    {
        window.location = "<?php echo site_url('leads/status'); ?>/" + status + "/" + index;
    }

</script>

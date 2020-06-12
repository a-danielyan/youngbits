<div id="headerbar">

    <h1 class="headerbar-title"><?php _trans($hr_type); ?></h1>
    <button class="sendMultiMail" disabled><i class="fa fa-envelope"></i></button>
    <?php if($this->session->userdata('user_type') == TYPE_ADMIN ){ ?>
    <div class="headerbar-item pull-right">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
        </button>
        <a class="btn btn-primary btn-sm" href="<?php echo site_url('hr/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>
    <?php } ?>

    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('hr/'. $hr_type . '/' . $this->uri->segment(3)), 'mdl_hr'); ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <button class="btn btn-primary inport_button" >Import</button>
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('hr/' . $hr_type . '/active'); ?>"
               class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('active'); ?>
            </a>
            <a href="<?php echo site_url('hr/' . $hr_type . '/inactive'); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('inactive'); ?>
            </a>
            <a href="<?php echo site_url('hr/' . $hr_type . '/all'); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
        </div>
    </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('hr/' . $hr_type . '/' . $this->uri->segment(3)), 'mdl_hr'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('hr/' . $hr_type . '/active'); ?>"
                   class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('active'); ?>
                </a>
                <a href="<?php echo site_url('hr/' . $hr_type . '/inactive'); ?>"
                   class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('inactive'); ?>
                </a>
                <a href="<?php echo site_url('hr/' . $hr_type . '/all'); ?>"
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
        <?php $this->layout->load_view('hr/partial_hr_table'); ?>
    </div>

</div>

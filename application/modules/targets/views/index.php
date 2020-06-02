<div id="headerbar">

    <h1 class="headerbar-title"><?php _trans('Target'); ?></h1>
    <button data-url="<?php echo site_url('invoices/generate_multi_pdf/'); ?>" class="sendMultiMail" disabled><i class="fa fa-envelope"></i></button>

    <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){ ?>
        <div class="headerbar-item pull-right">
            <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                    data-toggle="collapse" data-target="#ip-submenu-collapse">
                <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
            </button>
            <a class="btn btn-primary btn-sm" href="<?php echo site_url('targets/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>

    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('targets/status/' . $this->uri->segment(3) . '/' . $filter_group), 'mdl_targets'); ?>
    </div>

    <?php
    if ($this->session->userdata('user_type') == TYPE_ADMIN) {
        ?>
        <div class="headerbar-item pull-right visible-lg">
            <select name="filter_group" id="filter_group" class="form-control simple-select"
                    onchange="filter('<?= $this->uri->segment(3) ?>', this.value);">
                <option value="0">
                    <?php _trans('all'); ?>
                </option>
                <?php
                foreach ($user_groups as $user_group) { ?>
                    <option value="<?php echo $user_group->group_id; ?>" <?php check_select($user_group->group_id, $filter_group) ?>>
                        <?php echo $user_group->group_name; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php
    }
    ?>

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('targets/status/active/' . $filter_group); ?>"
               class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('active'); ?>
            </a>
            <a href="<?php echo site_url('targets/status/inactive/' . $filter_group); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('inactive'); ?>
            </a>
            <a href="<?php echo site_url('targets/status/all/' . $filter_group); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a
        </div>
    </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('targets/status/' . $this->uri->segment(3)), 'mdl_targets'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('targets/status/active'); ?>"
                   class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('active'); ?>
                </a>
                <a href="<?php echo site_url('targets/status/inactive'); ?>"
                   class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('inactive'); ?>
                </a>
                <a href="<?php echo site_url('targets/status/all'); ?>"
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
        <?php $this->layout->load_view('targets/partial_target_table'); ?>
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
        window.location = "<?php echo site_url('targets/status'); ?>/" + status + "/" + index;
    }

</script>

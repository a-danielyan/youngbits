<div id="headerbar">

    <h1 class="headerbar-title"><?php _trans('clients'); ?></h1>
    <button class="sendMultiMail" disabled><i class="fa fa-envelope"></i></button>
    <div class="headerbar-item pull-right">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
        </button>

        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_FREELANCERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
            <a class="btn btn-primary btn-sm" href="<?php echo site_url('clients/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('clients/status/' . $this->uri->segment(3) . '/' . $filter_group), 'mdl_clients'); ?>
    </div>

    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
    <div class="headerbar-item pull-right visible-lg">
        <select name="filter_group" id="filter_group" class="form-control simple-select"
                onchange="filter('<?= $this->uri->segment(3) ?>', this.value);">
            <option value="0">
                <?php _trans('all'); ?>
            </option>
            <?php foreach ($user_groups as $user_group) { ?>
                <option value="<?php echo $user_group->group_id; ?>" <?php check_select($user_group->group_id, $filter_group) ?>>
                    <?php echo $user_group->group_name; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <?php } ?>

    <div class="headerbar-item pull-right visible-lg">
        <button class="btn btn-primary inport_button" >Inport</button>
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('clients/status/active/' . $filter_group); ?>"
               class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('active'); ?>
            </a>
            <a href="<?php echo site_url('clients/status/inactive/' . $filter_group); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('inactive'); ?>
            </a>
            <a href="<?php echo site_url('clients/status/all/' . $filter_group); ?>"
               class="btn  <?php echo $this->uri->segment(3) == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
        </div>
    </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">
        <div class="submenu-row">
            <?php echo pager(site_url('clients/status/' . $this->uri->segment(3)), 'mdl_clients'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('clients/status/active'); ?>"
                   class="btn <?php echo $this->uri->segment(3) == 'active' || !$this->uri->segment(3) ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('active'); ?>
                </a>
                <a href="<?php echo site_url('clients/status/inactive'); ?>"
                   class="btn  <?php echo $this->uri->segment(3) == 'inactive' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('inactive'); ?>
                </a>
                <a href="<?php echo site_url('clients/status/all'); ?>"
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
        <?php $this->layout->load_view('clients/partial_client_table'); ?>
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
    window.location = "<?php echo site_url('clients/status'); ?>/" + status + "/" + index;
}

</script>

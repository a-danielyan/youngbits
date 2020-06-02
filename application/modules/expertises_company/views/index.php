<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('expertises_company_list'); ?></h1>

    <?php if ( in_array($this->session->userdata('user_type'), array(TYPE_ADMIN)) ) { ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('expertises_company/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('expertises_company/index'), 'mdl_user_groups'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <table class="table table-striped">

        <thead>
        <tr>
            <th><?php _trans('id'); ?></th>
            <th><?php _trans('company_name'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($users_groups as $users_group) { ?>
            <tr>
                <td><?php _htmlsc($users_group->group_id); ?></td>
                <td><a href="expertises_company/view/<?=$users_group->group_id?>"><?php _htmlsc($users_group->group_name); ?></a></td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>

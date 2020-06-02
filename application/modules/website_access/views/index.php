<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('domain_names'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('website_access/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('website_access/status/'.$this->uri->segment(3)), 'mdl_website_access'); ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('website_access/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
            <a href="<?php echo site_url('website_access/status/no_website'); ?>"
               class="btn <?php echo $status == 'no_website' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('no_website'); ?>
            </a>
            <a href="<?php echo site_url('website_access/status/wordpress_website'); ?>"
               class="btn <?php echo $status == 'wordpress_website' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('wordpress_website'); ?>
            </a>
            <a href="<?php echo site_url('website_access/status/other_website'); ?>"
               class="btn <?php echo $status == 'other_website' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('other_website'); ?>
            </a>
        </div>
    </div>


</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>



    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'website_access_id', 'ip_website_access'); ?>><?= _trans('id'); ?></a></th>

                <th><?php _trans('domain_name'); ?></th>
                <th><?php _trans('category'); ?></th>
                <th><?php _trans('client'); ?></th>
                <th><?php _trans('access_control_panel_web'); ?></th>

                <th><?php _trans('mijndomeinreseller'); ?></th>
                <th><?php _trans('website_access_admin'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($website_access as $website) { ?>
                <tr>
                    <td><?php _htmlsc($website->website_access_id); ?></td>
                    <td><?php _htmlsc($website->website_access_domain_name); ?></td>
                    <td><?php
                        if($website->website_access_category == 0){
                            _trans('no_website');
                        }
                        if($website->website_access_category == 1){
                            _trans('wordpress_website');
                        }
                        if($website->website_access_category == 2){
                            _trans('other_website');
                        }

                       ; ?></td>

                    <td><?php _htmlsc($website->client_name); ?></td>
                    <td><?php _htmlsc($website->website_access_control_panel_web); ?></td>
                    <td><?php _htmlsc($website->website_access_mijndomeinreseller); ?></td>
                    <td><?php _htmlsc($website->website_access_admin); ?></td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('website_access/form/' . $website->website_access_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <?php if($this->session->userdata('user_type') != TYPE_ADMINISTRATOR ):?>
                                    <li>
                                        <a href="<?php echo site_url('website_access/delete/' . $website->website_access_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                <?php endif;?>

                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>

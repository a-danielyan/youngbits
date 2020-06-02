<div id="headerbar">


    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('commission_rates/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('commission_rates/index'), 'mdl_commission_rates'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>



            <div class="col" style="padding: 10px 0"> <h4 class="headerbar-title text-center"><?php _trans('commission_rates'); ?></h4></div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                    <tr>
                        <th><a <?= orderableTH($this->input->get(), 'commission_rate_name', 'ip_commission_rates'); ?>><?php _trans('commission_rate_name'); ?></a></th>
                        <th><a <?= orderableTH($this->input->get(), 'commission_rate_percent', 'ip_commission_rates'); ?>><?php _trans('commission_rate_percent'); ?></a></th>
                        <th><a <?= orderableTH($this->input->get(), 'commission_rate_default', 'ip_commission_rates'); ?>><?php _trans('commission_rate_default'); ?></a></th>
                        <th><?php _trans('options'); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($commission_rates as $commission_rate) { ?>
                        <tr>
                            <td><?php _htmlsc($commission_rate->commission_rate_name); ?></td>
                            <td><?=format_amount($commission_rate->commission_rate_percent); ?>%</td>
                            <td><?=($commission_rate->commission_rate_default)? 'Yes': 'No'; ?></td>
                            <td>
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('commission_rates/form/' . $commission_rate->commission_rate_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('commission_rates/delete/' . $commission_rate->commission_rate_id); ?>"
                                               onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>



</div>

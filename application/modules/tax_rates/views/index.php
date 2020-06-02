<div id="headerbar">


    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('tax_rates/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('tax_rates/index'), 'mdl_tax_rates'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>


    <div class="row">
        <div class="col-md-6">
            <div class="col" style="padding: 10px 0"> <h4 class="headerbar-title text-center"><?php _trans('tax_rates'); ?></h4></div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                    <tr>
                        <th><a <?= orderableTH($this->input->get(), 'tax_rate_name', 'ip_tax_rates'); ?>><?php _trans('tax_rate_name'); ?></a></th>
                        <th><a <?= orderableTH($this->input->get(), 'tax_rate_percent', 'ip_tax_rates'); ?>><?php _trans('tax_rate_percent'); ?></a></th>
                        <th><?php _trans('options'); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($tax_rates as $tax_rate) { ?>
                        <tr>
                            <td><?php _htmlsc($tax_rate->tax_rate_name); ?></td>
                            <td><?php echo format_amount($tax_rate->tax_rate_percent); ?>%</td>
                            <td>
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('tax_rates/form/' . $tax_rate->tax_rate_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('tax_rates/delete/' . $tax_rate->tax_rate_id); ?>"
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
        <div class="col-md-6">
            <div class="col" style="padding: 10px 0"> <h4 class="headerbar-title text-center"><?php _trans('tax_rates_mobility'); ?></h4></div>

            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                    <tr>
                        <th></th>
                        <th><?php _trans('amount'); ?></th>
                        <th><?php _trans('options'); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><?php _trans('appointment_price_per_kilometer'); ?></td>
                            <td>$<?=format_amount($user->user_price_per_kilometer); ?></td>
                            <td>
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('tax_rates/tax_rates_mobility/' . $user->user_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('tax_rates/delete/' . $user->user_id); ?>"
                                               onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>


</div>

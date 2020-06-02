<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('dashboard_to_slogans'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('login_quotes/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'quote_text', 'ip_login_quotes'); ?>><?php _trans('quote_text'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'quote_created_date', 'ip_login_quotes'); ?>><?php _trans('quote_created_date'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'quote_created_by', 'ip_login_quotes'); ?>><?php _trans('quote_created_by'); ?></a></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($quotes as $quote) { ?>
                <tr>
                    <td><?php _htmlsc($quote->quote_text); ?></td>
                    <td><?= date($quote->quote_created_date); ?></td>
                    <td><?php _htmlsc($quote->user_name); ?></td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('login_quotes/form/' . $quote->quote_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('login_quotes/delete/' . $quote->quote_id); ?>"
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

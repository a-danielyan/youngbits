<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><?php _trans('subscriptions_name'); ?></th>
            <th><?php _trans('subscriptions_category'); ?></th>
            <th><?php _trans('subscriptions_date'); ?></th>

            <th><?php _trans('subscriptions_amount'); ?></th>
            <th><?php _trans('subscriptions_every'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($records as $subscriptions) { ?>
            <tr>
                <td><?php echo _htmlsc($subscriptions->subscriptions_name); ?></td>
                <td><?php echo _htmlsc($subscriptions->subscriptions_category); ?></td>
                <td><?php echo date_from_mysql($subscriptions->subscriptions_date); ?></td>

                <td><?php echo '$'.format_amount($subscriptions->subscriptions_amount); ?></td>
                <td>
                    <?php foreach ($recur_frequencies as $key => $lang) { ?>
                        <?php if($key == $subscriptions->subscriptions_frequency){ echo _trans($lang); }; ?>
                    <?php } ?>
                </td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('subscriptions/form/' . $subscriptions->subscriptions_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i>
                                    <?php _trans('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('subscriptions/delete/' . $subscriptions->subscriptions_id); ?>"
                                   onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                    <i class="fa fa-trash-o fa-margin"></i>
                                    <?php _trans('delete'); ?>
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

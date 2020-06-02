<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><input type="checkbox" class="checkAllSel"></th>
            <th><a <?= orderableTH($this->input->get(), 'subscriptions_name', 'ip_subscriptions'); ?>><?php _trans('subscriptions_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'subscriptions_category', 'ip_subscriptions'); ?>><?php _trans('subscriptions_category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'subscriptions_start_date', 'ip_subscriptions'); ?>><?php _trans('start_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'subscriptions_end_date', 'ip_subscriptions'); ?>><?php _trans('end_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'subscriptions_amount', 'ip_subscriptions'); ?>><?php _trans('subscriptions_amount'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'subscriptions_every', 'ip_subscriptions'); ?>><?php _trans('subscriptions_every'); ?></a></th>
            <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif; ?>

        </tr>
        </thead>

        <tbody>
        <?php foreach ($records as $subscriptions) { ?>
            <tr>
                  <td><input type="checkbox" value="<?= $subscriptions->subscriptions_id ?>" class="sel" data-amount="<?=format_amount($subscriptions->subscriptions_amount)?>"></td>
                <td><?php echo _htmlsc($subscriptions->subscriptions_name); ?></td>
                <td><?php echo _htmlsc($subscriptions->subscriptions_category); ?></td>
                <td><?php echo _htmlsc($subscriptions->subscriptions_start_date);?></td>
                <td><?php echo _htmlsc($subscriptions->subscriptions_end_date);?></td>

                <td>$<?=format_amount($subscriptions->subscriptions_amount); ?></td>
                <td>
                    <?php foreach ($recur_frequencies as $key => $lang) { ?>
                        <?php if($key == $subscriptions->subscriptions_frequency){ echo _trans($lang); }; ?>
                    <?php } ?>
                </td>
                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
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
                <?php endif; ?>

            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>


<input type="hidden" name="url" value="<?=base_url().'index.php/subscriptions/'?>">
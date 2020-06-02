<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><a <?= orderableTH($this->input->get(), 'payment_arrangement_title', 'ip_payment_arrangements'); ?>><?php _trans('payment_arrangement_title'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_arrangement_payment_number', 'ip_payment_arrangements'); ?>><?php _trans('payment_arrangement_payment_number'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_arrangement_date', 'ip_payment_arrangements'); ?>><?php _trans('date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_arrangement_total_amount', 'ip_payment_arrangements'); ?>><?php _trans('payment_arrangement_total_amount'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_arrangement_balance', 'ip_payment_arrangements'); ?>><?php _trans('payment_arrangement_balance'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_arrangement_text', 'ip_payment_arrangements'); ?>><?php _trans('payment_arrangement_text'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>

        <?php foreach ($payment_arrangements as $payment) { ?>
            <tr>
                <td><?php _htmlsc($payment->payment_arrangement_title); ?></td>
                <td><?php _htmlsc($payment->payment_arrangement_payment_number); ?></td>
                <td> <?= date('Y-m-d', strtotime($payment->payment_arrangements_date))?></td>
                <td><?=($payment->payment_arrangement_client_id) ? htmlsc($payment->client_name) : trans('none'); ?></td>
                <td><?= format_currency($payment->payment_arrangement_total_amount); ?></td>
                <td><?= format_currency($payment->payment_arrangement_balance); ?></td>
                <td><?php _htmlsc($payment->payment_arrangement_text); ?></td>
                <td>

                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('payment_arrangements/form/' . $payment->payment_arrangement_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i>
                                    <?php _trans('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('payment_arrangements/delete/' . $payment->payment_arrangement_id); ?>"
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

<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'payment_date', 'ip_payments'); ?>><?php _trans('payment_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_date_created', 'ip_invoices'); ?>><?php _trans('invoice_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_number', 'ip_invoices'); ?>><?php _trans('invoice'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_amount', 'ip_payments'); ?>><?php _trans('amount'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_method_name', 'ip_payment_methods'); ?>><?php _trans('payment_method'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'payment_note', 'ip_payments'); ?>><?php _trans('note'); ?></th>
            <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif;?>


        </tr>
        </thead>

        <tbody>
        <?php foreach ($payments as $payment) { ?>
            <tr>
                <td><input type="checkbox" value="<?= $payment->invoice_id ?>" class="sel"></td>
                <td><?php echo date_from_mysql($payment->payment_date); ?></td>
                <td><?php echo date_from_mysql($payment->invoice_date_created); ?></td>
                <td><?php echo anchor('invoices/view/' . $payment->invoice_id, $payment->invoice_number); ?></td>
                <td>
                    <a href="<?php echo site_url('clients/view/' . $payment->client_id); ?>"
                       title="<?php _trans('view_client'); ?>">
                        <?php _htmlsc(format_client($payment)); ?>
                    </a>
                </td>
                <td><?php echo format_currency($payment->payment_amount); ?></td>
                <td><?php _htmlsc($payment->payment_method_name); ?></td>
                <td><?php _htmlsc($payment->payment_note); ?></td>
                <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('payments/form/' . $payment->payment_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i>
                                        <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('payments/delete/' . $payment->payment_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i>
                                        <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                <?php endif;?>

            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>

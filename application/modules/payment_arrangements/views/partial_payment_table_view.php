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

            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>

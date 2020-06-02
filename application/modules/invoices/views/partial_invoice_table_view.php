<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><a <?= orderableTH($this->input->get(), 'invoice_status_id', 'ip_invoices'); ?>><?php _trans('status'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_number', 'ip_invoices'); ?>><?php _trans('invoice'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_date_created', 'ip_invoices'); ?>><?php _trans('created'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_date_due', 'ip_invoices'); ?>><?php _trans('due_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client_name'); ?></a></th>
            <th style="text-align: right;"><a <?= orderableTH($this->input->get(), 'invoice_total', 'ip_invoice_amounts'); ?>><?php _trans('amount'); ?></a></th>
            <th style="text-align: right;"><a <?= orderableTH($this->input->get(), 'invoice_balance', 'ip_invoice_amounts'); ?>><?php _trans('balance'); ?></a></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $invoice_idx = 1;
        $invoice_count = count($invoices);
        $invoice_list_split = $invoice_count > 3 ? $invoice_count / 2 : 9999;
        foreach ($invoices as $invoice) {
            // Disable read-only if not applicable
            if ($this->config->item('disable_read_only') == true) {
                $invoice->is_read_only = 0;
            }
            // Convert the dropdown menu to a dropup if invoice is after the invoice split
            $dropup = $invoice_idx > $invoice_list_split ? true : false;
            ?>
            <tr>
                <td>
                    <span class="label <?= $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                        <?= $invoice_statuses[$invoice->invoice_status_id]['label'];
                        if ($invoice->invoice_sign == '-1') { ?>
                            &nbsp;<i class="fa fa-credit-invoice"
                                     title="<?=trans('credit_invoice') ?>"></i>
                        <?php }
                        if ($invoice->is_read_only == 1) { ?>
                            &nbsp;<i class="fa fa-read-only"
                                     title="<?= trans('read_only') ?>"></i>
                        <?php }; ?>
                    </span>
                </td>

                <td>
                    <a href="<?=site_url('invoices/view/' . $invoice->invoice_id); ?>"
                       title="<?php _trans('edit'); ?>">
                        <?=($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id); ?>
                    </a>
                </td>

                <td>
                    <?=date_from_mysql($invoice->invoice_date_created); ?>
                </td>

                <td>
                    <span class="<?php if ($invoice->is_overdue) { ?>font-overdue<?php } ?>">
                        <?php echo date_from_mysql($invoice->invoice_date_due); ?>
                    </span>
                </td>

                <td>
                    <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>"
                       title="<?php _trans('view_client'); ?>">
                        <?php _htmlsc(format_client($invoice)); ?>
                    </a>
                </td>

                <td class="amount <?php if ($invoice->invoice_sign == '-1') {
                    echo 'text-danger';
                }; ?>">
                    <?php echo format_currency($invoice->invoice_total); ?>
                </td>

                <td class="amount">
                    <?php echo format_currency($invoice->invoice_balance); ?>
                </td>

            </tr>
            <?php
            $invoice_idx++;
        } ?>
        </tbody>

    </table>
</div>
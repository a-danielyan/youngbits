<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('recurring_invoices'); ?></h1>



    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt"><?php echo _trans('selected') ?> : <p class="amount_val" style="display: inline;"></p></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : <?php echo format_currency($sum); ?></span>
    </div>
</div>

<div id="content" class="table-content">

    <div id="filter_results">
        <div class="table-responsive">
            <table class="table table-striped">

                <thead>
                <tr>
                    <th><input type="checkbox" class="checkAllSel"></th>
                    <th><a <?= orderableTH($this->input->get(), 'recur_end_date', 'ip_invoices_recurring'); ?>><?php _trans('status'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'invoice_number', 'ip_invoices'); ?>><?php _trans('base_invoice'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recurring_pricing', 'ip_invoices_recurring'); ?>><?php _trans('price'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recur_start_date', 'ip_invoices_recurring'); ?>><?php _trans('start_date'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recur_end_date', 'ip_invoices_recurring'); ?>><?php _trans('end_date'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recur_frequency', 'ip_invoices_recurring'); ?>><?php _trans('every'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recur_next_date', 'ip_invoices_recurring'); ?>><?php _trans('next_date'); ?></a></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($recurring_invoices as $invoice) { ?>
                    <tr>
                        <td><input type="checkbox" value="<?= $invoice->invoice_amount_id ?>" class="sel" data-amount="<?=format_amount($invoice->invoice_total)?>"></td>

                        <td>
                        <span class="label
                            <?php if ($invoice->recur_status == 'active') {
                            echo 'label-success';
                        } else {
                            echo 'label-default';
                        } ?>">
                            <?php _trans($invoice->recur_status); ?>
                        </span>
                        </td>
                        <td>
                            <a href="<?php echo site_url('#' . $invoice->invoice_id); ?>">
                                <?php echo $invoice->invoice_number; ?>
                            </a>
                        </td>
                        <td>
                            $<?=format_amount($invoice->invoice_total)? :'0.00'; ?>
                        </td>
                        <td>
                            <?php echo anchor('#' . $invoice->client_id, htmlsc($invoice->client_name)); ?>
                        </td>
                        <td>
                            <?php echo date_from_mysql($invoice->recur_start_date); ?>
                        </td>
                        <td>
                            <?php echo date_from_mysql($invoice->recur_end_date); ?>
                        </td>
                        <td>
                            <?php _trans($recur_frequencies[$invoice->recur_frequency]); ?>
                        </td>
                        <td>
                            <?php echo date_from_mysql($invoice->recur_next_date); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</div>


<input type="hidden" name="url" value="<?=base_url().'index.php/invoices/recurring'?>">
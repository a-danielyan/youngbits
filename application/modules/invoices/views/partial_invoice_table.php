<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>

            <th> <input type="checkbox" class="checkAllSel"> </th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_status_id', 'ip_invoices'); ?>><?php _trans('status'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_number', 'ip_invoices'); ?>><?php _trans('invoice'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_date_created', 'ip_invoices'); ?>><?php _trans('created'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'invoice_date_due', 'ip_invoices'); ?>><?php _trans('due_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client_name'); ?></a></th>
            <th style="text-align: right;"><a <?= orderableTH($this->input->get(), 'invoice_total', 'ip_invoice_amounts'); ?>><?php _trans('amount'); ?></a></th>
            <th style="text-align: center;"><a <?= orderableTH($this->input->get(), 'invoice_balance', 'ip_invoice_amounts'); ?>><?php _trans('balance'); ?></a></th>
            <th style="text-align: center;"><?php _trans('url'); ?></th>
            <th style="text-align: center;"><a <?= orderableTH($this->input->get(), 'invoice_last_msg_date_stamp', 'ip_invoice_amounts'); ?>><?php _trans('date_sent'); ?></a></th>
            <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif; ?>

        </tr>
        </thead>

        <tbody>
        <?php
//        echo '<pre>';
//        var_dump($invoices[0]->currency_symbol);die;
//        foreach ($invoices as $invoice) {
//
//        }
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
                <td><input type="checkbox" value="<?= $invoice->invoice_id ?>" data-amount="<?=$invoice->invoice_total; ?>" data-pdf="<?=site_url('invoices/generate_multi_pdf/' . $invoice->invoice_id); ?>" class="sel"></td>
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
                       title="<?php _trans('edit'); ?>" class="inv_number">
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

                <td class="amount" style="text-align: center">
                    <?php echo format_currency($invoice->invoice_balance); ?>
                </td>
                <td>
                    <?php if ($invoice->invoice_status_id != 1): ?>
                        <a href="<?= base_url("/index.php/guest/view/invoice/".$invoice->invoice_url_key); ?>" target="_blank"> <?= base_url("/index.php/guest/view/invoice/".$invoice->invoice_url_key); ?></a>
                    <?php endif ?>
                </td>
                <td>
                    <?=$invoice->invoice_last_msg_date_stamp?>
                </td>
                <?php  if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <td>
                        <div class="options btn-group<?php echo $dropup ? ' dropup' : ''; ?>">
                            <a class="btn btn-default btn-sm dropdown-toggle <?= $invoice_statuses[$invoice->invoice_status_id]['class']; ?>" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($invoice->is_read_only != 1) { ?>
                                    <li>
                                        <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/generate_pdf/' . $invoice->invoice_id); ?>"
                                       target="_blank">
                                        <i class="fa fa-print fa-margin"></i> <?php _trans('download_pdf'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                                        <i class="fa fa-send fa-margin"></i> <?php _trans('send_email'); ?>
                                    </a>
                                </li>
                                <?php
                                if ($this->session->userdata('user_type') != TYPE_MANAGERS) {
                                    ?>
                                    <li>
                                        <a href="#" class="invoice-add-payment"
                                           data-invoice-id="<?php echo $invoice->invoice_id; ?>"
                                           data-invoice-balance="<?php echo $invoice->invoice_balance; ?>"
                                           data-invoice-payment-method="<?php echo $invoice->payment_method; ?>">
                                            <i class="fa fa-money fa-margin"></i>
                                            <?php _trans('enter_payment'); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if ($invoice->invoice_status_id == 1 || ($this->config->item('enable_invoice_deletion') === true && $invoice->is_read_only != 1)) { ?>
                                    <li>
                                        <a href="<?php echo site_url('invoices/delete/' . $invoice->invoice_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_invoice_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/generate_slip_pdf/' . $invoice->invoice_id); ?>"
                                       target="_blank">
                                        <i class="fa fa-print fa-margin"></i> <?php _trans('Download Packing Slip'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
            <?php
            $invoice_idx++;
        } ?>
        </tbody>

    </table>
</div>
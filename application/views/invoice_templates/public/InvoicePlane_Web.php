<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
        <?php echo get_setting('custom_title', 'Spudu', true); ?>
        - <?php echo trans('invoice'); ?> <?php echo $invoice->invoice_number; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
</head>
<body>

<div class="container">
    <div id="content">

        <div class="webpreview-header">

            <h2><?php echo trans('invoice'); ?>&nbsp;<?php echo $invoice->invoice_number; ?></h2>
            <h4>&nbsp;<?= _htmle($invoice->invoice_extra_description); ?></h4>

            <div class="btn-group">
                <?php if ($invoice->sumex_id == NULL) : ?>
                <a href="<?php echo site_url('guest/view/generate_invoice_pdf/' . $invoice_url_key); ?>"
                   class="btn btn-primary">
                    <?php else : ?>
                    <a href="<?php echo site_url('guest/view/generate_sumex_pdf/' . $invoice_url_key); ?>"
                       class="btn btn-primary">
                        <?php endif; ?>
                        <i class="fa fa-print"></i> <?php echo trans('download_pdf'); ?>
                    </a>
                    <?php if (get_setting('enable_online_payments') == 1 && $invoice->invoice_balance > 0) { ?>
                        <a href="<?php echo site_url('guest/payment_information/form/' . $invoice_url_key); ?>"
                           class="btn btn-success">
                            <i class="fa fa-credit-card"></i> <?php echo trans('pay_now'); ?>
                        </a>
                    <?php } ?>

            </div>
            <div class="btn-group">

                <?php if ($invoice->sumex_id == NULL) : ?>
                <a href="<?php echo site_url('invoices/generate_slip_pdf/' . $invoice->invoice_id); ?>"
                   class="btn btn-primary">
                    <?php else : ?>
                    <a href="<?php echo site_url('guest/view/generate_sumex_pdf/' . $invoice_url_key); ?>"
                       class="btn btn-primary">
                        <?php endif; ?>
                        <i class="fa fa-print"></i> <?php echo trans('Download Packing Slip PDF'); ?>
                    </a>


            </div>
        </div>

        <hr>

        <?php echo $this->layout->load_view('layout/alerts'); ?>

        <div class="invoice">

            <?php
           if(!empty($companies->logo)){
               echo '<img src="'.site_url('../uploads/'.$companies->logo).'" style="width: 200px; margin:0 0 2% 2% ">';
           }
            ?>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-5">

                    <h4 style="padding-bottom: 2%"><?php _htmlsc($invoice->user_company); ?></h4>
                    <h5><?php _htmlsc($invoice->user_name); ?></h5>
                    <p><?php if ($invoice->user_vat_id) {
                            echo lang("vat_id_short") . ": " . $invoice->user_vat_id . '<br>';
                        } ?>
                        <?php if ($invoice->user_tax_code) {
                            echo lang("tax_code_short") . ": " . $invoice->user_tax_code . '<br>';
                        } ?>
                        <?php if ($invoice->user_address_1) {
                            echo htmlsc($invoice->user_address_1) . '<br>';
                        } ?>
                        <?php if ($invoice->user_address_2) {
                            echo htmlsc($invoice->user_address_2) . '<br>';
                        } ?>

                        <?php if ($invoice->user_zip) {
                            echo htmlsc($invoice->user_zip) . ', ';
                        } ?>
                        <?php if ($invoice->user_city) {
                            echo htmlsc($invoice->user_city) . ', ';
                        } ?>
                        <?php if ($invoice->user_state) {
                            echo htmlsc($invoice->user_state) . '<br> ';
                        } ?>

                        <?php if ($invoice->user_phone) { ?><?php echo trans('phone_abbr'); ?>: <?php echo htmlsc($invoice->user_phone); ?>
                            <br><?php } ?>
                        <?php if ($invoice->user_fax) { ?><?php echo trans('fax_abbr'); ?>: <?php echo htmlsc($invoice->user_fax); ?><?php } ?>
                    </p>

                    <br /><br />
                    <b><?php _trans('delivery_address'); ?></b>
                    <p>
                        <?php if ($invoice->client_address_1_delivery) {
                            echo htmlsc($invoice->client_address_1_delivery) . '<br>';
                        } ?>
                        <?php if ($invoice->client_address_2_delivery) {
                            echo htmlsc($invoice->client_address_2_delivery) . '<br>';
                        } ?>
                        <?php if ($invoice->client_city_delivery) {
                            echo htmlsc($invoice->client_city_delivery) . ' ';
                        } ?>
                        <?php if ($invoice->client_state_delivery) {
                            echo htmlsc($invoice->client_state_delivery) . ' ';
                        } ?>
                        <?php if ($invoice->client_zip_delivery) {
                            echo htmlsc($invoice->client_zip_delivery) . '<br>';
                        } ?>
                        <?php if ($invoice->client_country_delivery) {
                            echo htmlsc(get_country_name(trans('cldr'), $invoice->client_country_delivery)) . '<br>';
                        } ?>
                    </p>


                </div>
                <div class="col-lg-2"></div>
                <div class="col-xs-12 col-md-6 col-lg-5 text-right">

                    <h4><?php _htmlsc($invoice->client_name); ?></h4>
                    <p><?php if ($invoice->client_vat_id) {
                            echo lang("vat_id_short") . ": " . $invoice->client_vat_id . '<br>';
                        } ?>
                        <?php if ($invoice->client_tax_code) {
                            echo lang("tax_code_short") . ": " . $invoice->client_tax_code . '<br>';
                        } ?>
                        <?php if ($invoice->client_address_1) {
                            echo htmlsc($invoice->client_address_1) . '<br>';
                        } ?>
                        <?php if ($invoice->client_address_2) {
                            echo htmlsc($invoice->client_address_2) . '<br>';
                        } ?>
                        <?php if ($invoice->client_zip) {
                            echo htmlsc($invoice->client_zip) . ', ';
                        } ?>
                        <?php if ($invoice->client_city) {
                            echo htmlsc($invoice->client_city) . ', ';
                        } ?>
                        <?php if ($invoice->client_state) {
                            echo htmlsc($invoice->client_state) . '';
                        } ?>
                        <br>
                        <?php if ($invoice->client_phone) {
                            echo trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone); ?>
                            <br>
                        <?php } ?>
                    </p>

                    <br>

                    <table class="table table-condensed">
                        <tbody>
                        <tr>
                            <td><?php echo trans('invoice_date'); ?></td>
                            <td style="text-align:right;"><?php echo date_from_mysql($invoice->invoice_date_created); ?></td>
                        </tr>
                        <tr class="<?php echo($is_overdue ? 'overdue' : '') ?>">
                            <td><?php echo trans('due_date'); ?></td>
                            <td class="text-right">
                                <?php echo date_from_mysql($invoice->invoice_date_due); ?>
                            </td>
                        </tr>
                        <tr class="<?php echo($is_overdue ? 'overdue' : '') ?>">
                            <td><?php echo trans('amount_due'); ?></td>
                            <td style="text-align:right;"><?php echo format_currency($invoice->invoice_balance); ?></td>
                        </tr>
                        <?php if ($payment_method): ?>
                            <tr>
                                <td><?php echo trans('payment_method') . ': '; ?></td>
                                <td><?php _htmlsc($payment_method->payment_method_name); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <br>

            <div class="invoice-items">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><?php echo trans('item'); ?></th>
                            <th><?php echo trans('description'); ?></th>
                            <th class="text-right"><?php echo trans('qty'); ?></th>
                            <th class="text-right"><?php echo trans('price'); ?></th>
                            <th class="text-right"><?php echo trans('discount'); ?></th>
                            <th class="text-right"><?php echo trans('total'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?php _htmlsc($item->item_name); ?></td>
                                <td><?php echo nl2br(htmlsc($item->item_description)); ?></td>
                                <td class="amount">
                                    <?php echo format_amount($item->item_quantity); ?>
                                    <?php if ($item->item_product_unit) : ?>
                                        <br>
                                        <small><?php _htmlsc($item->item_product_unit); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="amount"><?php echo format_currency($item->item_price); ?></td>
                                <td class="amount"><?php echo format_currency($item->item_discount); ?></td>
                                <td class="amount">
                                    <?php echo format_currency($item->item_total - ($item->item_total / 100 * $invoice->invoice_discount_percent)); ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <?php
                        if ($offer != null) {
                        ?>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right"><?php echo trans('transport'); ?>:</td>
                            <td class="amount"><?php echo format_currency($invoice->offer_transport + $invoice->offer_transport_tax); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td class="no-bottom-border" colspan="4"></td>
                            <td class="text-right"><?php echo trans('discount'); ?>:</td>
                            <td class="amount">
                                <?php
                                if ($invoice->invoice_discount_percent > 0) {
                                    echo format_amount($invoice->invoice_discount_percent) . ' %';
                                } else {
                                    echo format_amount($invoice->invoice_discount_amount);
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right"><?php echo trans('subtotal'); ?>:</td>
                            <td class="amount"><?= format_currency($invoice->invoice_item_subtotal - ( $invoice->invoice_item_subtotal / 100 * $invoice->invoice_discount_percent)); ?></td>
                        </tr>

                        <?php if ($invoice->invoice_item_tax_total > 0) { ?>
                            <tr>
                                <td class="no-bottom-border" colspan="4"></td>
                                <td class="text-right"><?php echo trans('item_tax'); ?></td>
                                <td class="amount"><?= format_currency($invoice->invoice_item_tax_total - ( $invoice->invoice_item_tax_total / 100 *$invoice->invoice_discount_percent)); ?></td>
                            </tr>
                        <?php } ?>




                        <tr>
                            <td class="no-bottom-border" colspan="4"></td>
                            <td class="text-right"><?php echo trans('total'); ?>:</td>
                            <td class="amount"><?php echo format_currency($invoice->invoice_total); ?></td>
                        </tr>

                        <tr>
                            <td class="no-bottom-border" colspan="4"></td>
                            <td class="text-right"><?php echo trans('paid'); ?></td>
                            <td class="amount"><?php echo format_currency($invoice->invoice_paid) ?></td>
                        </tr>
                        <tr class="<?php echo ($invoice->invoice_balance > 0) ? 'overdue' : 'text-success'; ?>">
                            <td class="no-bottom-border" colspan="4"></td>
                            <td class="text-right"><?php echo trans('balance'); ?></td>
                            <td class="amount">
                                <b><?php echo format_currency($invoice->invoice_balance) ?></b>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <?php if ($invoice->invoice_balance == 0) {
                    echo '<img src="' . base_url('assets/core/img/paid.png') . '" class="paid-stamp">';
                } ?>

                <?php

                if ($is_overdue || $invoice->invoice_status_id == 5) {
                    echo '<img src="' . base_url('assets/core/img/overdue.png') . '" class="overdue-stamp">';
                } ?>

            </div><!-- .invoice-items -->

            <hr>

            <div class="row">

                <?php if ($invoice->invoice_terms) { ?>
                    <div class="col-xs-12 col-md-6">
                        <h4><?php echo trans('terms'); ?></h4>
                        <p><?php echo nl2br(htmlsc($invoice->invoice_terms)); ?></p>
                    </div>
                <?php } ?>

                <?php
                if (count($attachments) > 0) { ?>
                    <div class="col-xs-12 col-md-6">
                        <h4><?php echo trans('attachments'); ?></h4>
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <?php foreach ($attachments as $attachment) { ?>
                                    <tr class="attachments">
                                        <td><?php echo $attachment['name']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('/guest/get/attachment/' . $attachment['fullname']); ?>"
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-download"></i> <?php echo trans('download') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div><!-- .invoice-items -->
    </div><!-- #content -->
</div>

</body>
</html>

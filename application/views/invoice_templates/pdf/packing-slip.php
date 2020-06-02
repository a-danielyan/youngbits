<pagebreak>
    <!DOCTYPE html>
    <html lang="<?php _trans('cldr'); ?>">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/my_template.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
    </head>
    <body>
<?//= print'<pre>';var_dump($invoice);die; ?>
    <section class="container">
        <div class="one">
            <div><b><?php _htmlsc($invoice->user_company); ?></b></div>
            <div><a><?php _htmlsc($invoice->user_web); ?></a></div>
            <?php
            //        var_dump($invoice);die;
            //        if ($invoice->user_vat_id) {
            //            echo '<div>' . trans('vat_id_short') . ': ' . $invoice->user_vat_id . '</div>';
            //        }
            //        if ($invoice->user_tax_code) {
            //            echo '<div>' . trans('tax_code_short') . ': ' . $invoice->user_tax_code . '</div>';
            //        }
            if ($invoice->user_address_1) {
                echo '<div>' . htmlsc($invoice->user_address_1) . '</div>';
            }
            if ($invoice->user_address_2) {
                echo '<div>' . htmlsc($invoice->user_address_2) . '</div>';
            }
            if ($invoice->user_city || $invoice->user_state || $invoice->user_zip) {
                echo '<div>';
                if ($invoice->user_city) {
                    echo htmlsc($invoice->user_city) . ' ';
                }
                if ($invoice->user_state) {
                    echo htmlsc($invoice->user_state) . ' ';
                }
                if ($invoice->user_zip) {
                    echo htmlsc($invoice->user_zip);
                }
                echo '</div>';
            }
            if ($invoice->user_country) {
                echo '<div>' . get_country_name(trans('cldr'), $invoice->user_country) . '</div>';
            }

            echo '<br/>';

            if ($invoice->user_phone) {
                echo '<div>' . trans('phone') . ': ' . htmlsc($invoice->user_phone) . '</div>';
            }
            if ($invoice->user_fax) {
                echo '<div>' . trans('fax_abbr') . ': ' . htmlsc($invoice->user_fax) . '</div>';
            }
            ?>
        </div>
        <div class="two">
            <h1 style="color: #8394C9;">PACKING SLIP</h1>
            <p style="color: black;font-weight: bold "> DATE <span class="ppp" > <?php echo date_from_mysql($invoice->invoice_date_created, true); ?></span> </p>
            <p style="color: black;font-weight: bold "> CUSTOMER ID<span class="ppp"> <?php _htmlsc($invoice->client_id); ?> </span></p>

        </div>
    </section>


    <main>
        <div class="tables_div">
            <table class="bill_to" style="width: 50%">
                <tr>
                    <th>Bill To:</th>
                    <th style="background: white"></th>
                    <th>Ship To:</th>
                </tr>
                <tr>
                    <td><?php _htmlsc(format_client($invoice)); ?></td>
                    <td></td>
                    <td><?php _htmlsc($invoice->user_name); ?></td>
                </tr>
                <tr>
                    <td>[Company Name]</td>
                    <td></td>
                    <td><?php _htmlsc($invoice->user_company); ?></td>
                </tr>
                <tr>
                    <td><?php       if ($invoice->client_address_1) {
                            echo '<div>' . htmlsc($invoice->client_address_1) . '</div>';
                        } ?></td>
                    <td></td>
                    <td><?php             if ($invoice->user_address_1) {
                            echo '<div>' . htmlsc($invoice->user_address_1) . '</div>';
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td><?php
                        if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
                            echo '<div>';
                            if ($invoice->client_city) {
                                echo htmlsc($invoice->client_city) . ' ';
                            }
                            if ($invoice->client_state) {
                                echo htmlsc($invoice->client_state) . ' ';
                            }
                            if ($invoice->client_zip) {
                                echo htmlsc($invoice->client_zip);
                            }
                            echo '</div>';
                        }
                        ?></td>
                    <td></td>

                    <td><?php
                        if ($invoice->user_city || $invoice->user_state || $invoice->user_zip) {
                            echo '<div>';
                            if ($invoice->user_city) {
                                echo htmlsc($invoice->user_city) . ' ';
                            }
                            if ($invoice->user_state) {
                                echo htmlsc($invoice->user_state) . ' ';
                            }
                            if ($invoice->user_zip) {
                                echo htmlsc($invoice->user_zip);
                            }
                            echo '</div>';
                        }
                        ?></td>
                </tr>
                <tr>
                    <td><?php
                        if ($invoice->client_phone) {
                            echo '<div>' . htmlsc($invoice->client_phone) . '</div>';
                        }
                        ?></td>
                    <td></td>
                    <td><?php
                        if ($invoice->user_phone) {
                            echo '<div>' . htmlsc($invoice->user_phone) . '</div>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <table class="date_table" style="width: 100%">
            <tr>
                <th>Order Date</th>
                <th>Order#</th>
                <th>Purchase Order#</th>
                <th>Customer Contact</th>
            </tr>
            <tr>
                <td><?php _htmlsc($invoice->order_date); ?></td>
                <td><?php _htmlsc($invoice->order); ?></td>
                <td><?php _htmlsc($invoice->purchase_order); ?></td>
                <td><?php _htmlsc($invoice->customer_contact); ?></td>
            </tr>
        </table>
        <!--    <h1 class="invoice-title text-green">-->
        <?php //echo trans('invoice') . ' ' . $invoice->invoice_number; ?><!--</h1>-->

        <table class="item-table">
            <thead>
            <tr>
                <th class="item-name"><?php _trans('item'); ?></th>
                <th class="item-desc"><?php _trans('description'); ?></th>
                <th class="item-amount text-right"><?php _trans('qty'); ?></th>
<!--                <th class="item-price text-right">--><?php //_trans('price'); ?><!--</th>-->
<!--                --><?php //if ($show_item_discounts) : ?>
<!--                    <th class="item-discount text-right">--><?php //_trans('discount'); ?><!--</th>-->
<!--                --><?php //endif; ?>
<!--                <th class="item-total text-right">--><?php //_trans('total'); ?><!--</th>-->
            </tr>
            </thead>
            <tbody>

            <?php
//            echo '<pre>';
//            var_dump($items);die;
            foreach ($items as $item) { ?>

                <tr>
                    <td><?php _htmlsc($item->item_name); ?></td>
                    <td><?php echo nl2br(htmlsc($item->item_description)); ?></td>
                    <td class="text-right">
                        <?php echo format_amount($item->item_quantity); ?>
                        <?php if ($item->item_product_unit) : ?>
                            <br>
                            <small><?php _htmlsc($item->item_product_unit); ?></small>
                        <?php endif; ?>
                    </td>
<!--                    <td class="text-right">-->
<!--                        --><?php //echo format_currency($item->item_price); ?>
<!--                    </td>-->
<!--                    --><?php //if ($show_item_discounts) : ?>
<!--                        <td class="text-right">-->
<!--                            --><?php //echo format_currency($item->item_discount); ?>
<!--                        </td>-->
<!--                    --><?php //endif; ?>
<!--                    <td class="text-right">-->
<!--                        --><?php //echo format_currency($item->item_total); ?>
<!--                    </td>-->
                </tr>
            <?php } ?>

            </tbody>
            <tbody class="invoice-sums">

<!--            <tr>-->
<!--                <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                    --><?php //_trans('subtotal'); ?>
<!--                </td>-->
<!--                <td class="text-right">--><?php //echo format_currency($invoice->invoice_item_subtotal); ?><!--</td>-->
<!--            </tr>-->

<!--            --><?php
//            if ($offer != null) {
//                ?>
<!--                <tr>-->
<!--                    <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                        --><?php //_trans('transport'); ?>
<!--                    </td>-->
<!--                    <td class="text-right">--><?php //echo format_currency($invoice->offer_transport + $invoice->offer_transport_tax); ?><!--</td>-->
<!--                </tr>-->
<!--                --><?php
//            }
//            ?>
<!---->
<!--            --><?php //if ($invoice->invoice_item_tax_total > 0) { ?>
<!--                <tr>-->
<!--                    <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                        --><?php //_trans('item_tax'); ?>
<!--                    </td>-->
<!--                    <td class="text-right">-->
<!--                        --><?php //echo format_currency($invoice->invoice_item_tax_total); ?>
<!--                    </td>-->
<!--                </tr>-->
<!--            --><?php //} ?>

<!--            --><?php //foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
<!--                <tr>-->
<!--                    <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                        --><?php //echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%)'; ?>
<!--                    </td>-->
<!--                    <td class="text-right">-->
<!--                        --><?php //echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
<!--                    </td>-->
<!--                </tr>-->
<!--            --><?php //endforeach ?>

<!--            --><?php //if ($invoice->invoice_discount_percent != '0.00') : ?>
<!--                <tr>-->
<!--                    <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                        --><?php //_trans('discount'); ?>
<!--                    </td>-->
<!--                    <td class="text-right">-->
<!--                        --><?php //echo format_amount($invoice->invoice_discount_percent); ?><!--%-->
<!--                    </td>-->
<!--                </tr>-->
<!--            --><?php //endif; ?>
<!--            --><?php //if ($invoice->invoice_discount_amount != '0.00') : ?>
<!--                <tr>-->
<!--                    <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                        --><?php //_trans('discount'); ?>
<!--                    </td>-->
<!--                    <td class="text-right">-->
<!--                        --><?php //echo format_currency($invoice->invoice_discount_amount); ?>
<!--                    </td>-->
<!--                </tr>-->
<!--            --><?php //endif; ?>
<!---->
<!--            <tr>-->
<!--                <td --><?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
<!--                    <b>--><?php //_trans('total'); ?><!--</b>-->
<!--                </td>-->
<!--                <td class="text-right">-->
<!--                    <b>--><?php //echo format_currency($invoice->invoice_total); ?><!--</b>-->
<!--                </td>-->
<!--            </tr>-->
            <!--            <tr>-->
            <!--                <td -->
            <?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
            <!--                    --><?php //_trans('paid'); ?>
            <!--                </td>-->
            <!--                <td class="text-right">-->
            <!--                    --><?php //echo format_currency($invoice->invoice_paid); ?>
            <!--                </td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td -->
            <?php //echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?><!-- class="text-right">-->
            <!--                    <b>--><?php //_trans('balance'); ?><!--</b>-->
            <!--                </td>-->
            <!--                <td class="text-right text-green">-->
            <!--                    <b>--><?php //echo format_currency($invoice->invoice_balance); ?><!--</b>-->
            <!--                </td>-->
            <!--            </tr>-->
            </tbody>
        </table>
        <table class="last_table" style="width: 100% ">
            <tr>
                <th style="width: 100%; background: #F0F0F0;color: black"><p style="float: left">Comments:</p></th>
            </tr>
            <tr>
                <td style="height: 90px;"></td>
            </tr>
        </table>
        <div class="contact_details">
            <p>If you have any questions or concerns, please contact</p>
            <p><?php _htmlsc($invoice->user_name);?>  <?= _htmlsc($invoice->user_phone);?>  <?= _htmlsc($invoice->user_email); ?></p>
            <h3> Thank You For Your Business!</h3>
        </div>
    </main>

    <watermarktext content="<?php _trans('paid'); ?>" alpha="0.3"/>

    <!--<footer>-->
    <!--    --><?php //if ($invoice->invoice_terms) : ?>
    <!--        <div class="notes">sdsgdsgg-->
    <!--            <b>--><?php //_trans('terms'); ?><!--</b><br/>-->
    <!--            --><?php //echo nl2br(htmlsc($invoice->invoice_terms)); ?>
    <!--        </div>-->
    <!--    --><?php //endif; ?>
    <!--</footer>-->

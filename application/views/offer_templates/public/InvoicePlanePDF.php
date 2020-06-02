<?php
$total_quantity = 0;
$show_discount_items = false;
foreach ($items as $key => $item) {
    if ($item->item_discount_amount &&  $item->item_discount_amount > 0)
    {
        $show_discount_items = true;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('offer'); ?></title>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
</head>
<body>
<header class="clearfix">

    <div class="row">
        <div class="screen-6 pull-left">
            <?php echo offer_logo_pdf(); ?>
        </div>

        <div class="screen-6 pull-right">
            <div class="screen-6 pull-left">
                &nbsp;
            </div>
            <div class="screen-6 background-light-blue pull-right">
                <br />
                <table class="center">
                    <tr>
                        <td><?php _trans('offer_pdf_date'); ?></td>
                        <td><?php echo date_from_mysql($offer->offer_date_created, true); ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('offer_pdf_invoice_id'); ?></td>
                        <td><?php _htmlsc($offer->invoice_number); ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('offer_pdf_package_id'); ?></td>
                        <td><?php _htmlsc($offer->package_id); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
</header>

<main class="clearfix">
    <div class="clear-both">
    </div>
    <div class="row">
        <div class="screen-6 pull-left">
            <table>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_company'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_address_1'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_address_2'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_company_country'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_company_phone'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_company_vat_id'); ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="screen-6 pull-right">
            <table class="pull-right">
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_company_name'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_company'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_business'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_business'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_address'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_address_1'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_zipcode'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_address_2'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_country'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_company_country'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_phone'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_company_phone_no'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_email'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_company_email'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php _trans('offer_pdf_text_vat'); ?>
                    </td>
                    <td>
                        <?php _trans('offer_pdf_company_vat_id_no'); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="clear-both padding-top-15">
    </div>
    <div class="row clear-both">
        <div class="screen-12 background-blue text-title">
            <div class="padding-15">
                <?php _trans('Invoice for client'); ?>
            </div>
        </div>
    </div>

    <div class="clear-both padding-top-15">
    </div>
    <div class="offer clear-both">
        <div class="screen-12">
            <table class="screen-12 offer">
                <tr>
                    <td>
                        <?php _trans('item_kg'); ?>
                    </td>
                    <td>
                        <?php _trans('item_name'); ?>
                    </td>
                    <td>
                        <?php _trans('item_product_SKU'); ?>
                    </td>
                    <td>
                        <?php _trans('product_price'); ?>
                    </td>
                    <?php
                    if ($show_discount_items == true) {
                    ?>
                    <td>
                        <?php _trans('item_discount'); ?>
                    </td>
                    <?php
                    }
                    ?>
                    <td>
                        <?php _trans('item_total_ex_vat'); ?>
                    </td>
                </tr>
                <?php
                foreach ($items as $key => $item) {
                    if ($item->item_quantity) {
                        $total_quantity += $item->item_quantity;
                    }
                ?>
                <tr>
                    <td>
                        <?php echo format_amount($item->item_quantity); ?>
                    </td>
                    <td>
                        <?php echo htmlsc($item->item_name); ?>
                    </td>
                    <td>
                        <?php echo htmlsc($item->item_product_SKU); ?>
                    </td>
                    <td>
                        <?php echo format_amount($item->item_price); ?>
                    </td>
                    <?php
                    if ($show_discount_items == true) {
                    ?>
                    <td>
                        <?php echo format_amount($item->item_discount_amount); ?>
                    </td>
                    <?php
                    }
                    ?>
                    <td>
                        <?php echo format_currency($item->item_total); ?>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="clear-both">
    </div>
    <div class="offer-results clear-both">
        <div class="screen-12">
            <table class="screen-12 offer-results">
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo format_amount($total_quantity); ?>
                    </td>
                    <td>
                        <?php _trans('Total kg'); ?>
                    </td>
                    <td colspan="2">
                        <?php _trans('subtotal'); ?>
                    </td>
                    <td>
                        <?php echo format_currency($offer->offer_item_subtotal); ?>
                    </td>
                </tr>
                <?php
                if ($offer->offer_transport_selected_text != "None") {
                    ?>
                    <tr>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td colspan="2">
                            <?php _trans('Handling / transport'); ?>
                        </td>
                        <td>
                            <?php echo format_currency($offer->offer_transport + $offer->offer_transport_tax); ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td colspan="2">
                        <?php _trans('vat_id_short'); ?>
                    </td>
                    <td>
                        <?php
                        if ($offer->offer_item_tax_total) 
                        {
                            echo format_currency($offer->offer_item_tax_total);
                        }
                        else 
                        {
                            echo "-";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td colspan="2">
                        <?php _trans('Total amount'); ?>
                    </td>
                    <td>
                        <?php
                        if ($offer->offer_total)
                        {
                            echo format_currency($offer->offer_total);
                        }
                        else
                        {
                            echo format_currency(0);
                        }
                        if ($offer->offer_transport_selected_text == "None") {
                            ?>
                            &nbsp;+&nbsp;
                            <?php echo trans('transport');
                        }?>
                    </td>
                </tr>                
            </table>
        </div>
    </div>


    <div class="clear-both padding-15">
    </div>

    <div class="screen-12">
        <div class="screen-12">
            <?php _trans('offer_terms'); ?>:
        </div>
        <div class="screen-12">
            <?php echo $offer->offer_terms; ?>
        </div>
    </div>

    <div class="clear-both padding-15">
    </div>

    <div class="screen-12 box-footer">
        <div class="screen-12 center-text"><?php _trans('Payment & Packaging'); ?></div>
        <div class="screen-12 center-text">
            <?php
$format = trans('The goods are packed on %s boxpallets, dimensions %s with a total weight of %s kg');
echo sprintf($format, $offer->boxpallets, $offer->dimensions, format_amount($total_quantity));
?>
        </div>
        <div class="screen-12 center-text"><?php _trans('Payment of the invoice is in advance by bank'); ?></div>

    </div>
    <div class="clear-both padding-15">
    </div>
    <div class="screen-12">
        <div class="screen-12 center-text"><?php _trans('offer_pdf_bank'); ?>&nbsp;&nbsp;&nbsp;<?php _trans('offer_pdf_iban'); ?> &nbsp;&nbsp;&nbsp; <?php _trans('offer_pdf_bic'); ?></div>
        <div class="screen-12 center-text"><?php _trans('offer_pdf_website'); ?>&nbsp;&nbsp;&nbsp;<?php _trans('offer_pdf_email'); ?></div>
    </div>

</main>


</body>
</html>

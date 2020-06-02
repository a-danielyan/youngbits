<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Spudu
 *
 * @author		Spudu Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2017 Spudu.com
 * @license		https://Spudu.com/license.txt
 * @link		https://Spudu.com
 */

/**
 * Generate the PDF for an invoice
 *
 * @param $invoice_id
 * @param bool $stream
 * @param null $invoice_template
 * @param null $is_guest
 * @return string
 */
function generate_invoice_pdf($invoice_id, $stream = true, $invoice_template = null, $is_guest = null)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('offers/mdl_offers');
    $CI->load->model('invoices/mdl_invoice_tax_rates');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->model('payment_methods/mdl_payment_methods');
    $CI->load->model('companies/mdl_companies');

    $CI->load->helper('country');
    $CI->load->helper('client');
    $CI->load->helper('company');
    $CI->load->helper('invoice');

    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);

    // Adding logo to invoice data
    $invoice->logo = invoice_logo_pdf();

    // Updating invoice user data with company data
    if($invoice->invoice_company_id){
        $company_data = $CI->mdl_companies->getCompany($invoice->invoice_company_id);
        obligateInvoiceData($invoice,$company_data);
    }

    $invoice = $CI->mdl_invoices->get_payments($invoice);

    // Override language with system language
    set_language($invoice->client_language);

    if (!$invoice_template) {
        $CI->load->helper('template');
        $invoice_template = select_pdf_invoice_template($invoice);
    }

    $payment_method = $CI->mdl_payment_methods->where('payment_method_id', $invoice->payment_method)->get()->row();
    if ($invoice->payment_method == 0) {
        $payment_method = false;
    }

    // Determine if discounts should be displayed
    $items = $CI->mdl_items->where('invoice_id', $invoice_id)->get()->result();

    // Discount settings
    $show_item_discounts = false;
    foreach ($items as $item) {
        if ($item->item_discount != '0.00') {
            $show_item_discounts = true;
        }
    }

    // Get all custom fields
    $custom_fields = array(
        'invoice' => $CI->mdl_custom_fields->get_values_for_fields('mdl_invoice_custom', $invoice->invoice_id),
        'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $invoice->client_id),
        'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $invoice->user_id),
    );

    if ($invoice->quote_id) {
        $custom_fields['quote'] = $CI->mdl_custom_fields->get_values_for_fields('mdl_quote_custom', $invoice->quote_id);
    }

    // PDF associated files
    $include_zugferd = $CI->mdl_settings->setting('include_zugferd');

    if ($include_zugferd) {
        $CI->load->helper('zugferd');

        $associatedFiles = array(
            array(
                'name' => 'ZUGFeRD-invoice.xml',
                'description' => 'ZUGFeRD Invoice',
                'AFRelationship' => 'Alternative',
                'mime' => 'text/xml',
                'path' => generate_invoice_zugferd_xml_temp_file($invoice, $items)
            )
        );
    } else {
        $associatedFiles = null;
    }

    $offer = null;
    if ($invoice->parrent_offer_id != 0)
    {
        $offer = $CI->mdl_offers->get_by_id($invoice->parrent_offer_id);
    }

    $data = array(
        'invoice' => $invoice,
        'offer' => $offer,
        'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
        'items' => $items,
        'payment_method' => $payment_method,
        'output_type' => 'pdf',
        'show_item_discounts' => $show_item_discounts,
        'custom_fields' => $custom_fields,
    );
//    echo '<pre>';
//    print_r($data);die;
    $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, true);
    $CI->load->helper('mpdf');
//    echo '<pre>';
//    var_dump($html);die;
    return pdf_create($html, trans('invoice') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number),
        $stream, $invoice->invoice_password, true, $is_guest, $include_zugferd, $associatedFiles);
}

function generate_multi_invoice_pdf($invoice_ids, $stream = true, $invoice_template = null, $is_guest = null)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('offers/mdl_offers');
    $CI->load->model('invoices/mdl_invoice_tax_rates');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->model('payment_methods/mdl_payment_methods');
    $CI->load->model('companies/mdl_companies');

    $CI->load->helper('country');
    $CI->load->helper('client');
    $CI->load->helper('company');

    $html = '';
    $last_invoice = null;

    foreach ($invoice_ids as $invoice_id) {
        if($invoice_id){
            if($invoice = $CI->mdl_invoices->get_by_id($invoice_id)) {
                // Adding logo to invoice data
                $invoice->logo = invoice_logo_pdf();

                // Updating invoice user data with company data
                if($invoice->invoice_company_id){
                    $company_data = $CI->mdl_companies->getCompany($invoice->invoice_company_id);
                    obligateInvoiceData($invoice,$company_data);
                }

                $invoice = $CI->mdl_invoices->get_payments($invoice);

                // Override language with system language
                set_language($invoice->client_language);

                if (!$invoice_template) {
                    $CI->load->helper('template');
                    $invoice_template = select_pdf_invoice_template($invoice);
                }

                $payment_method = $CI->mdl_payment_methods->where('payment_method_id', $invoice->payment_method)->get()->row();
                if ($invoice->payment_method == 0) {
                    $payment_method = false;
                }

                // Determine if discounts should be displayed
                $items = $CI->mdl_items->where('invoice_id', $invoice_id)->get()->result();

                // Discount settings
                $show_item_discounts = false;
                foreach ($items as $item) {
                    if ($item->item_discount != '0.00') {
                        $show_item_discounts = true;
                    }
                }

                // Get all custom fields
                $custom_fields = array(
                    'invoice' => $CI->mdl_custom_fields->get_values_for_fields('mdl_invoice_custom', $invoice->invoice_id),
                    'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $invoice->client_id),
                    'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $invoice->user_id),
                );

                if ($invoice->quote_id) {
                    $custom_fields['quote'] = $CI->mdl_custom_fields->get_values_for_fields('mdl_quote_custom', $invoice->quote_id);
                }

                // PDF associated files
                $include_zugferd = $CI->mdl_settings->setting('include_zugferd');

                if ($include_zugferd) {
                    $CI->load->helper('zugferd');

                    $associatedFiles = array(
                        array(
                            'name' => 'ZUGFeRD-invoice.xml',
                            'description' => 'ZUGFeRD Invoice',
                            'AFRelationship' => 'Alternative',
                            'mime' => 'text/xml',
                            'path' => generate_invoice_zugferd_xml_temp_file($invoice, $items)
                        )
                    );
                } else {
                    $associatedFiles = null;
                }

                $offer = null;
                if ($invoice->parrent_offer_id != 0) {
                    $offer = $CI->mdl_offers->get_by_id($invoice->parrent_offer_id);
                }

                $data = array(
                    'invoice' => $invoice,
                    'offer' => $offer,
                    'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                    'items' => $items,
                    'payment_method' => $payment_method,
                    'output_type' => 'pdf',
                    'show_item_discounts' => $show_item_discounts,
                    'custom_fields' => $custom_fields,
                );
                $html .= $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, true);

                $invoice_template = null;
                $last_invoice = $invoice;
            }
        }
    }


    if($last_invoice){
        $CI->load->helper('mpdf');
        return pdf_create($html, trans('invoice') . '_' . str_replace(array('\\', '/'), '_', $last_invoice->invoice_number),
            $stream, $last_invoice->invoice_password, true, $is_guest, $include_zugferd, $associatedFiles);
    }

}

function generate_invoice_sumex($invoice_id, $stream = true, $client = false)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_items');
    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);
    $CI->load->library('Sumex', array(
        'invoice' => $invoice,
        'items' => $CI->mdl_items->where('invoice_id', $invoice_id)->get()->result()
    ));

    // Append a copy at the end and change the title:
    // WARNING: The title depends on what invoice type is (TP, TG)
    // and is language-dependant. Fix accordingly if you really need this hack
    $temp = tempnam("/tmp", "invsumex_");
    $tempCopy = tempnam("/tmp", "invsumex_");
    $pdf = new FPDI();
    $sumexPDF = $CI->sumex->pdf();

    $sha1sum = sha1($sumexPDF);
    $shortsum = substr($sha1sum, 0, 8);
    $filename = trans('invoice') . '_' . $invoice->invoice_number . '_' . $shortsum;

    if (!$client) {
        file_put_contents($temp, $sumexPDF);

        // Hackish
        $sumexPDF = str_replace(
            "Giustificativo per la richiesta di rimborso",
            "Copia: Giustificativo per la richiesta di rimborso",
            $sumexPDF
        );

        file_put_contents($tempCopy, $sumexPDF);

        $pageCount = $pdf->setSourceFile($temp);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            if ($size['w'] > $size['h']) {
                $pageFormat = 'L';  //  landscape
            } else {
                $pageFormat = 'P';  //  portrait
            }

            $pdf->addPage($pageFormat, array($size['w'], $size['h']));
            $pdf->useTemplate($templateId);
        }

        $pageCount = $pdf->setSourceFile($tempCopy);

        for ($pageNo = 2; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            if ($size['w'] > $size['h']) {
                $pageFormat = 'L';  //  landscape
            } else {
                $pageFormat = 'P';  //  portrait
            }

            $pdf->addPage($pageFormat, array($size['w'], $size['h']));
            $pdf->useTemplate($templateId);
        }

        unlink($temp);
        unlink($tempCopy);

        if ($stream) {
            header("Content-Type", "application/pdf");
            $pdf->Output($filename . '.pdf', 'I');
            return;
        }

        $filePath = UPLOADS_FOLDER . 'temp/' . $filename . '.pdf';
        $pdf->Output($filePath, 'F');
        return $filePath;
    } else {
        if ($stream) {
            return $sumexPDF;
        }

        $filePath = UPLOADS_FOLDER . 'temp/' . $filename . '.pdf';
        file_put_contents($filePath, $sumexPDF);
        return $filePath;
    }
}

/**
 * Generate the PDF for a quote
 *
 * @param $quote_id
 * @param bool $stream
 * @param null $quote_template
 * @return string
 */
function generate_quote_pdf($quote_id, $stream = true, $quote_template = null)
{
    $CI = &get_instance();

    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_quote_items');
    $CI->load->model('quotes/mdl_quote_tax_rates');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->model('companies/mdl_companies');
    $CI->load->helper('country');
    $CI->load->helper('client');
    $CI->load->helper('company');

    $quote = $CI->mdl_quotes->get_by_id($quote_id);

    // Adding logo to invoice data
    $quote->logo = invoice_logo_pdf();

    // Updating invoice user data with company data
    if($quote->quote_company_id){
        $company_data = $CI->mdl_companies->getCompany($quote->quote_company_id);

        obligateQuoteData($quote,$company_data);
    }

    // Override language with system language
    set_language($quote->client_language);

    if (!$quote_template) {
        $quote_template = $CI->mdl_settings->setting('pdf_quote_template');
    }

    // Determine if discounts should be displayed
    $items = $CI->mdl_quote_items->where('quote_id', $quote_id)->get()->result();

    $show_item_discounts = false;
    foreach ($items as $item) {
        if ($item->item_discount != '0.00') {
            $show_item_discounts = true;
        }
    }

    // Get all custom fields
    $custom_fields = array(
        'quote' => $CI->mdl_custom_fields->get_values_for_fields('mdl_quote_custom', $quote->quote_id),
        'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $quote->client_id),
        'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $quote->user_id),
    );

    $data = array(
        'quote' => $quote,
        'quote_tax_rates' => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
        'items' => $items,
        'output_type' => 'pdf',
        'show_item_discounts' => $show_item_discounts,
        'custom_fields' => $custom_fields,
    );

    $html = $CI->load->view('quote_templates/pdf/' . $quote_template, $data, true);

    $CI->load->helper('mpdf');

    return pdf_create($html, trans('quote') . '_' . str_replace(array('\\', '/'), '_', $quote->quote_number), $stream, $quote->quote_password);
}

function generate_multi_quote_pdf($quote_ids, $stream = true, $quote_template = null)
{
    $CI = &get_instance();

    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_quote_items');
    $CI->load->model('quotes/mdl_quote_tax_rates');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->model('companies/mdl_companies');
    $CI->load->helper('company');
    $CI->load->helper('country');
    $CI->load->helper('client');

    $html = '';

    foreach ($quote_ids as $quote_id) {
        if($quote_id){

            $quote = $CI->mdl_quotes->get_by_id($quote_id);

            // Adding logo to invoice data
            $quote->logo = invoice_logo_pdf();

            // Updating invoice user data with company data
            if($quote->quote_company_id){
                $company_data = $CI->mdl_companies->getCompany($quote->quote_company_id);

                obligateQuoteData($quote,$company_data);
            }

            // Override language with system language
            set_language($quote->client_language);

            if (!$quote_template) {
                $quote_template = $CI->mdl_settings->setting('pdf_quote_template');
            }

            // Determine if discounts should be displayed
            $items = $CI->mdl_quote_items->where('quote_id', $quote_id)->get()->result();

            $show_item_discounts = false;
            foreach ($items as $item) {
                if ($item->item_discount != '0.00') {
                    $show_item_discounts = true;
                }
            }

            // Get all custom fields
            $custom_fields = array(
                'quote' => $CI->mdl_custom_fields->get_values_for_fields('mdl_quote_custom', $quote->quote_id),
                'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $quote->client_id),
                'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $quote->user_id),
            );

            $data = array(
                'quote' => $quote,
                'quote_tax_rates' => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
                'items' => $items,
                'output_type' => 'pdf',
                'show_item_discounts' => $show_item_discounts,
                'custom_fields' => $custom_fields,
            );

            $html .= $CI->load->view('quote_templates/pdf/' . $quote_template, $data, true);
            $invoice_template = null;
        }
    }

    $CI->load->helper('mpdf');

    return pdf_create($html, trans('quote') . '_' . str_replace(array('\\', '/'), '_', $quote->quote_number), $stream, $quote->quote_password);
}


/**
 * Generate the PDF for an offer
 *
 * @param $offer_id
 * @param bool $stream
 * @param null $offer_template
 * @param null $is_guest
 * @return string
 */
function generate_offer_pdf($offer_id, $stream = true, $offer_template = null, $is_guest = null)
{
    $CI = &get_instance();

    $CI->load->model('offers/mdl_offer_items');
    $CI->load->model('offers/mdl_offers');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->model('payment_methods/mdl_payment_methods');

    $CI->load->helper('country');
    $CI->load->helper('client');

    $offer = $CI->mdl_offers->get_by_id($offer_id);

    // Override language with system language
    set_language($offer->client_language);

    if (!$offer_template) {
        $CI->load->helper('template');
        $offer_template = select_pdf_offer_template($offer);
    }

    $payment_method = $CI->mdl_payment_methods->where('payment_method_id', $offer->payment_method)->get()->row();
    if ($offer->payment_method == 0) {
        $payment_method = false;
    }

    // Determine if discounts should be displayed
    $items = $CI->mdl_offer_items->where('offer_id', $offer_id)->get()->result();

    // Discount settings
    $show_item_discounts = false;
    foreach ($items as $item) {
        if ($item->item_discount != '0.00') {
            $show_item_discounts = true;
        }
    }

    // Get all custom fields
    $custom_fields = array(
        'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $offer->client_id),
        'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $offer->user_id),
    );

    $data = array(
        'offer' => $offer,
        'items' => $items,
        'payment_method' => $payment_method,
        'output_type' => 'pdf',
        'show_item_discounts' => $show_item_discounts,
        'custom_fields' => $custom_fields,
    );

    $html = $CI->load->view('offer_templates/pdf/' . $offer_template, $data, true);

    $CI->load->helper('mpdf');
    return pdf_create($html, trans('offer') . '_' . str_replace(array('\\', '/'), '_', $offer->offer_number),
        $stream, $offer->offer_password, true, $is_guest, false, null);
}
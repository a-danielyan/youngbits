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
 * Parse a template by predefined template tags
 *
 * @param $object
 * @param $body
 * @param $model_id
 * @return mixed
 */
function parse_template($object, $body)
{

    if (preg_match_all('/{{{([^{|}]*)}}}/', $body, $template_vars)) {
        foreach ($template_vars[1] as $var) {
            switch ($var) {
                case 'invoice_guest_url':
                    $replace = site_url('guest/view/invoice/' . $object->invoice_url_key);
                    break;
                case 'invoice_date_due':
                    $replace = date_from_mysql($object->invoice_date_due, true);
                    break;
                case 'invoice_date_created':
                    $replace = date_from_mysql($object->invoice_date_created, true);
                    break;
                case 'invoice_total':
                    $replace = format_currency($object->invoice_total);
                    break;
                case 'invoice_paid':
                    $replace = format_currency($object->invoice_paid);
                    break;
                case 'invoice_balance':
                    $replace = format_currency($object->invoice_balance);
                    break;
                case 'quote_total':
                    $replace = format_currency($object->quote_total);
                    break;
                case 'quote_date_created':
                    $replace = date_from_mysql($object->quote_date_created, true);
                    break;
                case 'quote_date_expires':
                    $replace = date_from_mysql($object->quote_date_expires, true);
                    break;
                case 'quote_guest_url':
                    $replace = site_url('guest/view/quote/' . $object->quote_url_key);
                    break;
                case 'offer_guest_url':
                    $replace = site_url('guest/view/offer/' . $object->offer_url_key);
                    break;
                case 'offer_due_date':
                    $replace = date_from_mysql($object->offer_due_date, true);
                    break;
                case 'offer_date_created':
                    $replace = date_from_mysql($object->offer_date_created, true);
                    break;
                case 'ticket_status':

                    if ($object->ticket_status == 0)
                    {
                        $replace = trans('draft');
                    }
                    else if ($object->ticket_status == 1)
                    {
                        $replace = trans('rejected');
                    }
                    else if ($object->ticket_status == 2)
                    {
                        $replace = trans('approved');
                    }
                    break;
                default:
                    // Check if it's a custom field
                    if (preg_match('/ip_cf_([0-9].*)/', $var, $cf_id)) {
                        // Get the custom field
                        $CI =& get_instance();
                        $CI->load->model('custom_fields/mdl_custom_fields');
                        $cf = $CI->mdl_custom_fields->get_by_id($cf_id[1]);

                        if ($cf) {
                            // Get the values for the custom field
                            $cf_model = str_replace('ip_', 'mdl_', $cf->custom_field_table);
                            $replace = $CI->mdl_custom_fields
                                ->get_value_for_field($cf_id[1], $cf_model, $object);
                        } else {
                            $replace = '';
                        }
                    } else {
                        $replace = isset($object->{$var}) ? $object->{$var} : $var;
                    }
            }

            $body = str_replace('{{{' . $var . '}}}', $replace, $body);
        }
    }

    return $body;
}


function prospect_template($object, $body)
{

    if (preg_match_all('/{{{([^{|}]*)}}}/', $body, $template_vars)) {
        foreach ($template_vars[1] as $var) {
            switch ($var) {
                case 'lead_surname':
                    $replace = $object->lead_surname;
                    break;
                case 'lead_surname_contactperson':
                    $replace = $object->lead_surname_contactperson;
                    break;
                case 'lead_address_1':
                    $replace = $object->lead_address_1;
                    break;
                case 'lead_address_2':
                    $replace = $object->lead_address_2;
                    break;
                case 'lead_city':
                    $replace = $object->lead_city;
                    break;
                case 'lead_state':
                    $replace = $object->lead_state;
                    break;
                case 'lead_zip':
                    $replace = $object->lead_zip;
                    break;
                case 'lead_country':
                    $replace = $object->lead_country;
                    break;
                case 'lead_city_delivery':
                    $replace = $object->lead_city_delivery;
                    break;
                case 'lead_state_delivery':
                    $replace = $object->lead_state_delivery;
                    break;
                case 'lead_zip_delivery':
                    $replace = $object->lead_zip_delivery;
                    break;
                case 'lead_country_delivery':
                    $replace = $object->lead_country_delivery;
                    break;
                case 'lead_phone':
                    $replace = $object->lead_phone;
                    break;
                case 'lead_fax':
                    $replace = $object->lead_fax;
                    break;
                case 'lead_mobile':
                    $replace = $object->lead_mobile;
                    break;
                case 'lead_email':
                    $replace = $object->lead_email;
                    break;
                case 'lead_web':
                    $replace = $object->lead_web;
                    break;
                case 'lead_vat_id':
                    $replace = $object->lead_vat_id;
                    break;
                case 'lead_tax_code':
                    $replace = $object->lead_tax_code;
                    break;
                case 'lead_avs':
                    $replace = $object->lead_avs;
                    break;
                case 'lead_insurednumber':
                    $replace = $object->lead_insurednumber;
                    break;
                case 'lead_veka':
                    $replace = $object->lead_veka;
                    break;
                case 'lead_birthdate':
                    $replace = $object->lead_birthdate;
                    break;
                case 'lead_gender':
                    $replace = $object->lead_gender;
                    break;
                    $replace = $object->lead_country;
                    break;
                case 'lead_email2':
                    $replace = $object->lead_email2;
                    break;
                case 'lead_category':
                    $replace = $object->lead_category;
                    break;
                case 'lead_function_contactperson':
                    $replace = $object->lead_function_contactperson;
                    break;
                case 'lead_additional_information':
                    $replace = $object->lead_additional_information;
                    break;
                case 'lead_responsible':
                    $replace = $object->lead_responsible;
                    break;
                case 'lead_sector':
                    $replace = $object->lead_sector;
                    break;
                default:
                    // Check if it's a custom field
                    if (preg_match('/ip_cf_([0-9].*)/', $var, $cf_id)) {
                        // Get the custom field
                        $CI =& get_instance();
                        $CI->load->model('custom_fields/mdl_custom_fields');
                        $cf = $CI->mdl_custom_fields->get_by_id($cf_id[1]);

                        if ($cf) {
                            // Get the values for the custom field
                            $cf_model = str_replace('ip_', 'mdl_', $cf->custom_field_table);
                            $replace = $CI->mdl_custom_fields
                                ->get_value_for_field($cf_id[1], $cf_model, $object);
                        } else {
                            $replace = '';
                        }
                    } else {
                        $replace = isset($object->{$var}) ? $object->{$var} : $var;
                    }
            }

            $body = str_replace('{{{' . $var . '}}}', $replace, $body);
        }
    }

    return $body;
}


/**
 * Returns the appropriate PDF template for the given invoice
 *
 * @param $invoice
 * @return mixed
 */
function select_pdf_invoice_template($invoice)
{
    $CI =& get_instance();

    if ($invoice->is_overdue) {
        // Use the overdue template
        return $CI->mdl_settings->setting('pdf_invoice_template_overdue');
    } elseif ($invoice->invoice_status_id == 4) {
        // Use the paid template
        return $CI->mdl_settings->setting('pdf_invoice_template_paid');
    } else {
        // Use the default template
        return $CI->mdl_settings->setting('pdf_invoice_template');
    }
}

/**
 * Returns the appropriate email template for the given invoice
 *
 * @param $invoice
 * @return mixed
 */
function select_email_invoice_template($invoice)
{
    $CI =& get_instance();

    if ($invoice->is_overdue) {
        // Use the overdue template
        return $CI->mdl_settings->setting('email_invoice_template_overdue');
    } elseif ($invoice->invoice_status_id == 4) {
        // Use the paid template
        return $CI->mdl_settings->setting('email_invoice_template_paid');
    } else {
        // Use the default template
        return $CI->mdl_settings->setting('email_invoice_template');
    }
}

/**
 * Returns the appropriate email template for the given ticket
 *
 * @param $ticket
 * @return mixed
 */
function select_email_ticket_template($ticket)
{
    $CI =& get_instance();

    return $CI->mdl_settings->setting('email_ticket_template');
}


/**
 * Returns the appropriate PDF template for the given offer
 *
 * @param $offer
 * @return mixed
 */
function select_pdf_offer_template($offer)
{
    $CI =& get_instance();

    // Use the default template
    return $CI->mdl_settings->setting('pdf_offer_template');
}

/**
 * Returns the appropriate email template for the given offer
 *
 * @param $offer
 * @return mixed
 */
function select_email_offer_template($offer)
{
    $CI =& get_instance();

    // Use the default template
    return $CI->mdl_settings->setting('email_offer_template');
}
function select_email_prospect_template($prospect)
{
    $CI =& get_instance();

    // Use the default template
    return $CI->mdl_settings->setting('email_offer_template');
}

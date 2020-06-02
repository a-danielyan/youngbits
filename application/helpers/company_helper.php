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

function obligateInvoiceData($invoiceData, $companyData)
{
    $invoiceData->user_name = $companyData->name;
    $invoiceData->user_company = $companyData->name;
    $invoiceData->user_address_1 = $companyData->street_1;
    $invoiceData->user_address_2 = $companyData->street_2;
    $invoiceData->user_city = $companyData->city;
    $invoiceData->user_zip = $companyData->zip_code;
    $invoiceData->user_country = $companyData->country_id;
    $invoiceData->user_phone = $companyData->phone;
    $invoiceData->user_vat_id = $companyData->vat_id;
    $invoiceData->user_iban = $companyData->iban;
    $invoiceData->logo = '<img src="' . getcwd() . '/uploads/' . $companyData->logo . '" id="invoice-logo">';

    return $invoiceData;
}

function obligateQuoteData($quoteData, $companyData)
{
    $quoteData->user_name = $companyData->name;
    $quoteData->user_company = $companyData->name;
    $quoteData->user_address_1 = $companyData->street_1;
    $quoteData->user_address_2 = $companyData->street_2;
    $quoteData->user_city = $companyData->city;
    $quoteData->user_zip = $companyData->zip_code;
    $quoteData->user_country = $companyData->country_id;
    $quoteData->user_phone = $companyData->phone;
    $quoteData->user_vat_id = $companyData->vat_id;
    $quoteData->user_iban = $companyData->iban;
    $quoteData->logo = '<img src="' . getcwd() . '/uploads/' . $companyData->logo . '" id="invoice-logo">';

    return $quoteData;
}

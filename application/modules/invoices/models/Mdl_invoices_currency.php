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
 * Class Mdl_Invoices_Recurring
 */
class Mdl_invoices_currency extends Response_Model
{
    public $table = 'ip_invoice_currency';
    public $primary_key = 'ip_invoices_currency.id';


    public function getCurrency( $invoice_id )
    {
        return $this->db->from('ip_invoice_currency')->where('invoice_id', $invoice_id)->get()->row();
    }

    public function setCurrency( $invoice_id , $currency, $from_currency = 'EUR' )
    {
        $has_currency = $this->getCurrency($invoice_id);
        if( empty($has_currency) ){
            $this->db->insert('ip_invoice_currency', [
                'invoice_id' => $invoice_id,
                'currency' => $currency,
                'currency_symbol' => get_currency_symbol($currency),
                'currency_rate' => get_converted_currency_rate( $from_currency,$currency),
            ]);
        }
        elseif( $has_currency->currency != $currency){
            $this->db->where('invoice_id', $invoice_id);
            $this->db->update('ip_invoice_currency',[
                'currency' => $currency,
                'currency_symbol' => get_currency_symbol($currency),
                'currency_rate' => get_converted_currency_rate( $from_currency,$currency)
            ]);
        }

        return $this->getCurrency($invoice_id);
    }

}


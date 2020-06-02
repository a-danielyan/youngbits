<?php
//ok
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
 * Class Mdl_offer_Amounts
 */
class Mdl_Offer_Amounts extends CI_Model
{
    private $offer_transport = 0;
    private $offer_transport_tax = 0;
    /**
     * IP_offer_AMOUNTS
     * offer_amount_id
     * offer_id
     * offer_item_subtotal    SUM(item_subtotal)
     * offer_item_tax_total   SUM(item_tax_total)
     * offer_tax_total
     * offer_total            offer_item_subtotal + offer_item_tax_total + offer_tax_total
     * offer_paid
     * offer_balance          offer_total - offer_paid
     *
     * IP_offer_ITEM_AMOUNTS
     * item_amount_id
     * item_id
     * item_tax_rate_id
     * item_subtotal            item_quantity * item_price
     * item_tax_total           item_subtotal * tax_rate_percent
     * item_total               item_subtotal + item_tax_total
     *
     * @param $offer_id
     */
    public function calculate($offer_id)
    {
        // Get the basic totals
        $query = $this->db->query("
        SELECT  SUM(item_subtotal) AS offer_item_subtotal,
		        SUM(item_tax_total) AS offer_item_tax_total,
		        SUM(item_subtotal) + SUM(item_tax_total) AS offer_total,
		        SUM(item_discount) AS offer_item_discount
		FROM ip_offer_item_amounts
		WHERE item_id IN (
		    SELECT item_id FROM ip_offer_items WHERE offer_id = " . $this->db->escape($offer_id) . "
		    )
        ");

        $offer_amounts = $query->row();

        $offer_item_subtotal = $offer_amounts->offer_item_subtotal - $offer_amounts->offer_item_discount;
        $offer_subtotal = $offer_item_subtotal + $offer_amounts->offer_item_tax_total;
        $offer_total = $this->calculate_discount($offer_id, $offer_subtotal);

        // Create the database array and insert or update
        $db_array = array(
            'offer_id' => $offer_id,
            'offer_item_subtotal' => $offer_item_subtotal,
            'offer_item_tax_total' => $offer_amounts->offer_item_tax_total,
            'offer_total' => $offer_total,
            'offer_paid' => 0,
            'offer_balance' => $offer_total,
            'offer_transport' => $this->offer_transport,
            'offer_transport_tax' => $this->offer_transport_tax
        );

        $this->db->where('offer_id', $offer_id);

        if ($this->db->get('ip_offer_amounts')->num_rows()) {
            // The record already exists; update it
            $this->db->where('offer_id', $offer_id);
            $this->db->update('ip_offer_amounts', $db_array);
        } else {
            // The record does not yet exist; insert it
            $this->db->insert('ip_offer_amounts', $db_array);
        }

        // Calculate the offer taxes
        $this->calculate_offer_taxes($offer_id);
    }

    /**
     * @param $offer_id
     * @param $offer_total
     * @return float
     */
    public function calculate_discount($offer_id, $offer_total)
    {
        $this->db->where('offer_id', $offer_id);
        $offer_data = $this->db->get('ip_offers')->row();

        $total = (float)number_format($offer_total, 2, '.', '');
        $discount_amount = (float)number_format($offer_data->offer_discount_amount, 2, '.', '');
        $discount_percent = (float)number_format($offer_data->offer_discount_percent, 2, '.', '');

        $total = $total - $discount_amount;
        $total = $total - round(($total / 100 * $discount_percent), 2);

        $this->offer_transport = $offer_data->offer_transport_selected;


        $this->load->model('tax_rates/mdl_tax_rates');
        $tax_rate = $this->mdl_tax_rates->get_by_id($offer_data->transport_tax_rate_id);

        if ($tax_rate != null) {
            $this->offer_transport_tax = $this->offer_transport * $tax_rate->tax_rate_percent / 100;
        }
        else
        {
            $this->offer_transport_tax = 0;
        }

        $total = $total + $this->offer_transport + $this->offer_transport_tax;

        return $total;
    }


    /**
     * @param $offer_id
     */
    public function calculate_offer_taxes($offer_id)
    {
        // First check to see if there are any offer taxes applied
        $this->load->model('offers/mdl_offer_tax_rates');
        $offer_tax_rates = $this->mdl_offer_tax_rates->where('offer_id', $offer_id)->get()->result();

        if ($offer_tax_rates) {

            // There are offer taxes applied
            // Get the current offer amount record
            $offer_amount = $this->db->where('offer_id', $offer_id)->get('ip_offer_amounts')->row();

            // Loop through the offer taxes and update the amount for each of the applied offer taxes
            foreach ($offer_tax_rates as $offer_tax_rate) {
                if ($offer_tax_rate->include_item_tax) {
                    // The offer tax rate should include the applied item tax
                    $offer_tax_rate_amount = ($offer_amount->offer_item_subtotal + $offer_amount->offer_item_tax_total) * ($offer_tax_rate->offer_tax_rate_percent / 100);
                } else {
                    // The offer tax rate should not include the applied item tax
                    $offer_tax_rate_amount = $offer_amount->offer_item_subtotal * ($offer_tax_rate->offer_tax_rate_percent / 100);
                }

                // Update the offer tax rate record
                $db_array = array(
                    'offer_tax_rate_amount' => $offer_tax_rate_amount
                );
                $this->db->where('offer_tax_rate_id', $offer_tax_rate->offer_tax_rate_id);
                $this->db->update('ip_offer_tax_rates', $db_array);
            }

            // Update the offer amount record with the total offer tax amount
            $this->db->query("
              UPDATE ip_offer_amounts
              SET offer_tax_total = (
                SELECT SUM(offer_tax_rate_amount)
                FROM ip_offer_tax_rates
                WHERE offer_id = " . $this->db->escape($offer_id) . ")
              WHERE offer_id = " . $this->db->escape($offer_id));

            // Get the updated offer amount record
            $offer_amount = $this->db->where('offer_id', $offer_id)->get('ip_offer_amounts')->row();

            // Recalculate the offer total and balance
            $offer_total = $offer_amount->offer_item_subtotal + $offer_amount->offer_item_tax_total + $offer_amount->offer_tax_total;
            $offer_total = $this->calculate_discount($offer_id, $offer_total);
            $offer_balance = $offer_total - $offer_amount->offer_paid;

            // Update the offer amount record
            $db_array = array(
                'offer_total' => $offer_total,
                'offer_balance' => $offer_balance
            );

            $this->db->where('offer_id', $offer_id);
            $this->db->update('ip_offer_amounts', $db_array);
        } else {
            // No offer taxes applied

            $db_array = array(
                'offer_tax_total' => '0.00'
            );

            $this->db->where('offer_id', $offer_id);
            $this->db->update('ip_offer_amounts', $db_array);
        }
    }
}

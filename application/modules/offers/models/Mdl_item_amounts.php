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
 * Class Mdl_Item_Amounts
 */
class Mdl_Item_Amounts extends CI_Model
{
    /**
     * item_amount_id
     * item_id
     * item_subtotal (item_quantity * item_price)
     * item_tax_total
     * item_total ((item_quantity * item_price) + item_tax_total)
     *
     * @param $item_id
     */
    public function calculate($item_id)
    {
        $this->load->model('offers/mdl_offer_items');
        $item = $this->mdl_offer_items->get_by_id($item_id);


        $item_subtotal = $item->item_quantity * $item->item_price;
        $item_tax_total = $item_subtotal * ($item->item_tax_rate_percent / 100);
        $item_discount_total = $item->item_discount_amount * $item->item_quantity;
        $item_total = $item_subtotal + $item_tax_total - $item_discount_total;

        $db_array = array(
            'item_id' => $item_id,
            'item_subtotal' => $item_subtotal,
            'item_tax_total' => $item_tax_total,
            'item_discount' => $item_discount_total,
            'item_total' => $item_total
        );

        $this->db->where('item_id', $item_id);
        if ($this->db->get('ip_offer_item_amounts')->num_rows()) {
            $this->db->where('item_id', $item_id);
            $this->db->update('ip_offer_item_amounts', $db_array);
        } else {
            $this->db->insert('ip_offer_item_amounts', $db_array);
        }
    }

}

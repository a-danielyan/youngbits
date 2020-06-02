<?php
//ok
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Spudu
 *
 * @author      Spudu Developers & Contributors
 * @copyright   Copyright (c) 2012 - 2017 Spudu.com
 * @license     https://Spudu.com/license.txt
 * @link        https://Spudu.com
 */

/**
 * Class Mdl_Offer_Items
 */
class Mdl_Offer_Items extends Response_Model
{
    public $table = 'ip_offer_items';
    public $primary_key = 'ip_offer_items.item_id';
    public $date_created_field = 'item_date_added';

    public function default_select()
    {
        $this->db->select('ip_offer_items.*,
                           ip_offer_item_amounts.*,
                           item_tax_rates.tax_rate_percent AS item_tax_rate_percent,
                            item_tax_rates.tax_rate_name AS item_tax_rate_name');
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_offer_items.item_order');
    }

    public function default_join()
    {
        $this->db->join('ip_offer_item_amounts', 'ip_offer_items.item_id = ip_offer_item_amounts.item_id', 'left');
        $this->db->join('ip_tax_rates AS item_tax_rates', 'item_tax_rates.tax_rate_id = ip_offer_items.item_tax_rate_id', 'left');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'offer_id' => array(
                'field' => 'offer_id',
                'label' => trans('offer'),
                'rules' => 'required'
            ),
          /*  'item_product_SKU' => array(
                'field' => 'item_product_SKU',
                'label' => trans('item_product_SKU'),
                'rules' => 'required|unique'
            ),
            'item_product_name' => array(
                'field' => 'item_product_name',
                'label' => trans('item_product_name'),
                'rules' => 'required'
            ),
            'item_kg' => array(
                'field' => 'item_kg ',
                'label' => trans('item_kg'),
                'rules' => 'required'
            ),
            'item_price_per_kg' => array(
                'field' => 'item_price_per_kg',
                'label' => trans('item_price_per_kg'),
                'rules' => 'required'
            ),
            'item_product_id' => array(
                'field' => 'item_product_id',
                'label' => trans('original_product')
            ),
            'item_date' => array(
                'field' => 'item_date',
                'label' => trans('item_date')
            )*/
        );
    }

    /**
     * @param null $id
     * @param null $db_array
     * @return int|null
     */
    public function save($id = null, $db_array = null)
    {
        $id = parent::save($id, $db_array);

        $this->load->model('offers/mdl_item_amounts');
        $this->mdl_item_amounts->calculate($id);

        $this->load->model('offers/mdl_offer_amounts');

        if (is_object($db_array) && isset($db_array->offer_id)) {
            $this->mdl_offer_amounts->calculate($db_array->offer_id);
        } elseif (is_array($db_array) && isset($db_array['offer_id'])) {
            $this->mdl_offer_amounts->calculate($db_array['offer_id']);
        }

        return $id;
    }

    /**
     * @param int $item_id
     * @return null
     */
    public function delete($item_id)
    {
        // Get item:
        // the offer id is needed to recalculate offer amounts
        // and the task id to update status if the item refers a task
        $query = $this->db->get_where($this->table,
            array('item_id' => $item_id));
        if ($query->num_rows() == 0) {
            return null;
        }

        $row = $query->row();
        $offer_id = $row->offer_id;

        // Delete the item
        parent::delete($item_id);

        // Delete the item amounts
        $this->db->where('item_id', $item_id);
        $this->db->delete('ip_offer_item_amounts');

        // Recalculate offer amounts
        $this->load->model('offers/mdl_offer_amounts');
        $this->mdl_offer_amounts->calculate($offer_id);
        return $row;
    }
}

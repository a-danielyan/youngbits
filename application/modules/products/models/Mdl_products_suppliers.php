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
 * Class Mdl_Products
 */
class Mdl_products_suppliers extends Response_Model
{
    public $table = 'ip_products_suppliers';
    public $primary_key = 'ip_products_suppliers.supplier_product_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_join()
    {
        $this->db->join('ip_products', 'ip_products.product_id = ip_products_suppliers.product_id', 'left');
    }


    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'supplier_id' => array(
                'field' => 'supplier_id',
                'label' => trans('supplier_name'),
            ),
            'supplier_product_id' => array(
                'field' => 'supplier_product_id',
                'label' => trans('product_name'),
            ),
            'supplier_multiplier' => array(
                'field' => 'supplier_multiplier',
                'label' => trans('multiplier'),
            ),
            'supplier_purchase_price' => array(
                'field' => 'supplier_purchase_price',
                'label' => trans('purchase_price'),
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        return $db_array;
    }

}

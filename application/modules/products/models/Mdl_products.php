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
class Mdl_Products extends Response_Model
{
    public $table = 'ip_products';
    public $primary_key = 'ip_products.product_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'product_name';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_products.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_products_suppliers', 'ip_products.product_id = ip_products_suppliers.supplier_product_id', 'left');
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $this->db->join('ip_units', 'ip_units.unit_id = ip_products.unit_id', 'left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
    }

    public function by_product($match)
    {
        $this->db->group_start();
        $this->db->like('ip_products.product_sku', $match);
        $this->db->or_like('ip_products.product_name', $match);
        $this->db->or_like('ip_products.product_description', $match);
        $this->db->group_end();
    }

    public function by_family($match)
    {
        $this->db->where('ip_products.family_id', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'product_sku' => array(
                'field' => 'product_sku',
                'label' => trans('product_sku'),
                'rules' => ''
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => trans('product_name'),
                'rules' => 'required'
            ),
            'product_description' => array(
                'field' => 'product_description',
                'label' => trans('product_description'),
                'rules' => ''
            ),
            'product_price' => array(
                'field' => 'product_price',
                'label' => trans('product_price'),
                'rules' => 'required'
            ),
            'family_id' => array(
                'field' => 'family_id',
                'label' => trans('family'),
                'rules' => 'numeric'
            ),
            'unit_id' => array(
                'field' => 'unit_id',
                'label' => trans('unit'),
                'rules' => 'numeric'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => trans('tax_rate'),
                'rules' => 'numeric'
            ),
            'product_distributors' => array(
                'field' => 'product_distributors',
                'label' => trans('product_distributors')
            ),
            'product_distributors_multiplier' => array(
                'field' => 'product_distributors_multiplier',
                'label' => trans('product_distributors_multiplier')
            ),
            'product_distributors_purchase_price' => array(
                'field' => 'product_distributors_purchase_price',
                'label' => trans('product_distributors_purchase_price')
            ),
            // Sumex
            'product_tariff' => array(
                'field' => 'product_tariff',
                'label' => trans('product_tariff'),
                'rules' => ''
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        $db_array['product_distributors'] = (!empty($db_array['product_distributors']))?serialize($db_array['product_distributors']):serialize([]);
        $db_array['product_price'] = (empty($db_array['product_price']) ? null : standardize_amount($db_array['product_price']));
        $db_array['family_id'] = (empty($db_array['family_id']) ? null : $db_array['family_id']);
        $db_array['unit_id'] = (empty($db_array['unit_id']) ? null : $db_array['unit_id']);
        $db_array['tax_rate_id'] = (empty($db_array['tax_rate_id']) ? null : $db_array['tax_rate_id']);

        return $db_array;
    }

}

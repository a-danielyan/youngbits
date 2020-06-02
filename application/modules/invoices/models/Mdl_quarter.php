<?php
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
 * Class Mdl_Items
 */
class Mdl_quarter extends Response_Model
{
    public $table = 'ip_quarter';
    public $primary_key = 'ip_quarter.quarter_id';
    public $date_created_field = 'quarter_created_date';

   /* public function default_select()
    {
        $this->db->select('ip_invoice_item_amounts.*, ip_products.*, ip_quarter.*,
            item_tax_rates.tax_rate_percent AS item_tax_rate_percent,
            item_tax_rates.tax_rate_name AS item_tax_rate_name');
    }*/

    public function default_order_by()
    {
        $this->db->order_by($this->table.'.'.$this->date_created_field);
    }


    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'quarter_attachment' => array(
                'field' => 'quarter_attachment',
                'label' => trans('attachment'),
            ),
            'quarter_year' => array(
                'field' => 'quarter_year',
                'label' => trans('quarter_year'),
                'rules' => 'required|unique'
            ),
            'quarter_quarterly' => array(
                'field' => 'quarter_quarterly',
                'label' => trans('quarter_quarterly'),
            ),
            'quarter_created_date' => array(
                'field' => 'quarter_created_date',
                'label' => trans('quarter_created_date'),
            )
        );
    }

    /**
     * @param null $id
     * @param null $db_array
     * @return int|null
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['quarter_year'] = 2018;

        return $db_array;
    }







    /**
     * @param int $item_id
     * @return null
     */

}

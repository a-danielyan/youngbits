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
 * Class Mdl_Inventory
 */
class Mdl_Inventory extends Response_Model
{
    public $table = 'ip_inventory';
    public $primary_key = 'ip_inventory.inventory_id';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_inventory.*,ip_projects.project_name,ip_users.user_name", false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'inventory_date';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_inventory.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_inventory.inventory_project_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_inventory.inventory_created_user', 'left');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {//todo
        return array(
            'inventory_date' => array(
                'field' => 'inventory_date',
                'label' => trans('date'),
            ),
            'inventory_regular_price' => array(
                'field' => 'inventory_regular_price',
                'label' => trans('inventory'),
            ),
            'inventory_document_link' => array(
                'field' => 'inventory_document_link',
                'label' => lang('inventory_document_link')
            ),
            'inventory_category' => array(
                'field' => 'inventory_category',
                'label' => lang('inventory_category')
            ),
            'inventory_category_link_ebay' => array(
                'field' => 'inventory_category_link_ebay',
                'label' => lang('inventory_category_link_ebay')
            ),
            'inventory_status' => array(
                'field' => 'inventory_status',
                'label' => lang('inventory_status')
            ),
            'inventory_location' => array(
                'field' => 'inventory_location',
                'label' => lang('inventory_location')
            ),
            'inventory_size' => array(
                'field' => 'inventory_size',
                'label' => lang('inventory_size')
            ),
            'inventory_weight' => array(
                'field' => 'inventory_weight',
                'label' => lang('inventory_weight')
            ),
            'inventory_post_title' => array(
                'field' => 'inventory_post_title',
                'label' => lang('inventory_post_title'),
                'rules' => 'required'
            ),
            'inventory_post_content' => array(
                'field' => 'inventory_post_content',
                'label' => lang('inventory_post_content')
            ),
            'inventory_project_id' => array(
                'field' => 'inventory_project_id',
                'label' => lang('inventory_project_id')
            ),
            'inventory_percentage_user' => array(
                'field' => 'inventory_percentage_user',
                'label' => lang('percentage_for_user')
            ),
            'inventory_country' => array(
                'field' => 'inventory_country',
                'label' => lang('inventory_country')
            ),
            'inventory_sold' => array(
                'field' => 'inventory_sold',
                'label' => lang('inventory_sold')
            ),
            'inventory_number_items_sold' => array(
                'field' => 'inventory_number_items_sold',
                'label' => lang('inventory_number_items_sold')
            ),
            'inventory_length' => array(
                'field' => 'inventory_length',
                'label' => lang('inventory_length')
            ),
            'inventory_width' => array(
                'field' => 'inventory_width',
                'label' => lang('inventory_width')
            ),
            'inventory_manage_stock' => array(
                'field' => 'inventory_manage_stock',
                'label' => lang('inventory_manage_stock')
            ),
            'inventory_stock_quantity' => array(
                'field' => 'inventory_stock_quantity',
                'label' => lang('inventory_stock_quantity')
            ),
            'inventory_sale_price' => array(
                'field' => 'inventory_sale_price',
                'label' => lang('inventory_sale_price')
            ),
            'inventory_product_url' => array(
                'field' => 'inventory_product_url',
                'label' => lang('inventory_product_url')
            )
        );
    }

    public function statuses()
    {
        return array(
            '0' => array(
                'label' => trans('New'),
                'class' => 'new'
            ),
            '1' => array(
                'label' => trans('With traces of use'),
                'class' => 'with'
            ),
            '2' => array(
                'label' => trans('Bad shape'),
                'class' => 'bad'
            )
        );
    }
    public function categories()
    {
        return   $categories = [
            'Fashion',
            'Home & Garden',
            'House',
            'Electronics',
            'Miscellaneous',
            'Travels',
            'Vehicles',
        ];
    }


    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

//        $db_array['inventory_date'] = date_to_mysql($db_array['inventory_date']);
        if(is_null($this->input->post('inventory_manage_stock'))){
            $db_array['inventory_manage_stock'] = 'no';
            $db_array['inventory_stock_quantity'] = 0;
        }


        if (!empty($this->input->post('inventory_created_user'))) {
            $db_array['inventory_created_user'] = $this->input->post('inventory_created_user');
        }

        return $db_array;
    }

    /**
     * @param null $id
     */
    public function delete($id = null)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    /**
     * @param null $id
     * @return bool
     */
    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }

        if (!$id) {
            parent::set_form_value('inventory_date', date('Y-m-d'));
        }

        return true;
    }

    /**
     * @param $client_id
     * @return $this
     */
    public function by_client($client_id)
    {
        $this->filter_where('ip_clients.client_id', $client_id);
        return $this;
    }

}

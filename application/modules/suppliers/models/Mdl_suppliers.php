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
 * Class Mdl_suppliers
 */
class Mdl_Suppliers extends Response_Model
{
    public $table = 'ip_suppliers';
    public $primary_key = 'ip_suppliers.supplier_id';
    public $date_created_field = 'supplier_date_created';
    public $date_modified_field = 'supplier_date_modified';

    public function default_select()
    {
        $this->db->select(
            'SQL_CALC_FOUND_ROWS ' . $this->table . '.*, ' .
            'CONCAT(' . $this->table . '.supplier_name, " ", ' . $this->table . '.supplier_surname) as supplier_fullname, ' .
            'ip_users_groups.group_name, ip_products_suppliers.supplier_product_id, ip_products_suppliers.supplier_id as product_supplier_id',
            false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'supplier_id';
        $ip_invoices = $this->input->get('table') ? $this->input->get('table') : 'ip_suppliers';
        $this->db->order_by($ip_invoices.'.'.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_products_suppliers', 'ip_suppliers.supplier_id = ip_products_suppliers.supplier_id', 'left');
        $this->db->join('ip_users_groups', 'ip_suppliers.supplier_group_id = ip_users_groups.group_id', 'left');
        $this->db->join('ip_users as u', 'ip_suppliers.created_user_id = u.user_id', 'left')->select('u.user_name as username');

    }

    public function validation_rules()
    {
        return array(
            'supplier_name' => array(
                'field' => 'supplier_name',
                'label' => trans('supplier_name'),
                'rules' => 'required'
            ),
            'supplier_surname' => array(
                'field' => 'supplier_surname',
                'label' => trans('supplier_surname')
            ),
            'supplier_responsible' => array(
                'field' => 'supplier_responsible',
                'label' => trans('responsible')
            ),
            'supplier_surname_contactperson' => array(
                'field' => 'supplier_surname_contactperson',
                'label' => trans('supplier_surname_contactperson')
            ),
            'supplier_additional_information' => array(
                'field' => 'supplier_additional_information',
                'label' => trans('client_additional_information')
            ),
            'supplier_function_contactperson' => array(
                'field' => 'supplier_function_contactperson',
                'label' => trans('supplier_function_contactperson')
            ),
            'supplier_active' => array(
                'field' => 'supplier_active'
            ),
            'supplier_language' => array(
                'field' => 'supplier_language',
                'label' => trans('language'),
            ),
            'supplier_group_id' => array(
                'field' => 'supplier_group_id',
                'label' => trans('group_name'),
            ),
            'supplier_address_1' => array(
                'field' => 'supplier_address_1'
            ),
            'supplier_email2' => array(
                'field' => 'supplier_email'
            ),
            'supplier_city' => array(
                'field' => 'supplier_city',
                'label' => trans('supplier_city'),
            ),
            'supplier_sector' => array(
                'field' => 'supplier_sector',
                'label' => trans('sector'),
            ),
            'commission_rate_id' => array(
                'field' => 'commission_rate_id'
            ),
            'supplier_state' => array(
                'field' => 'supplier_state'
            ),
            'supplier_zip' => array(
                'field' => 'supplier_zip'
            ),
            'supplier_country' => array(
                'field' => 'supplier_country'
            ),
            'supplier_address_1_delivery' => array(
                'field' => 'supplier_address_1_delivery'
            ),
            'supplier_address_2_delivery' => array(
                'field' => 'supplier_address_2_delivery'
            ),
            'supplier_city_delivery' => array(
                'field' => 'supplier_city_delivery'
            ),
            'supplier_state_delivery' => array(
                'field' => 'supplier_state_delivery'
            ),
            'supplier_zip_delivery' => array(
                'field' => 'supplier_zip_delivery'
            ),
            'supplier_country_delivery' => array(
                'field' => 'supplier_country_delivery'
            ),
            'supplier_phone' => array(
                'field' => 'supplier_phone',
                'label' => trans('phone_number'),
                'rules' => 'regex_match[/^[0-9 +-]+$/]|min_length[8]',
            ),
            'supplier_fax' => array(
                'field' => 'supplier_fax'
            ),
            'supplier_mobile' => array(
                'field' => 'supplier_mobile',
                'label' => trans('phone_number').' 2 / '.trans('fax_number'),
                'rules' => 'regex_match[/^[0-9 +-]+$/]|min_length[8]',
            ),
            'supplier_sell_services_products' => array(
                'field' => 'supplier_sell_services_products',
                'label' => trans('supplier_sell_services_products'),
            ),
            'supplier_email' => array(
                'field' => 'supplier_email'
            ),
            'supplier_web' => array(
                'field' => 'supplier_web'
            ),
            'supplier_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'supplier_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            // SUMEX
            'supplier_birthdate' => array(
                'field' => 'supplier_birthdate',
                'rules' => 'callback_convert_date'
            ),
            'supplier_gender' => array(
                'field' => 'supplier_gender'
            ),
            'supplier_avs' => array(
                'field' => 'supplier_avs',
                'label' => trans('sumex_ssn'),
                'rules' => 'callback_fix_avs'
            ),
            'supplier_insurednumber' => array(
                'field' => 'supplier_insurednumber',
                'label' => trans('sumex_insurednumber')
            ),
            'supplier_veka' => array(
                'field' => 'supplier_veka',
                'label' => trans('sumex_veka')
            ),
            'supplier_category' => array(
                'supplier_category' => 'supplier_category',
                'label' => lang('supplier_category')
            ),
            'supplier_file' => array(
                'field' => 'supplier_file',
                'label' => lang('supplier_file')
            ),
            'supplier_email_sent' => array(
                'field' => 'supplier_email_sent',
                'label' => lang('email_sent')
            ),
            'supplier_number_id' => array(
                'field' => 'supplier_number_id',
                'label' => lang('id')
            ),
        );
    }

    /**
     * @param int $amount
     * @return mixed
     */
    function get_latest($amount = 10)
    {
        return $this->mdl_suppliers
            ->where('supplier_active', 1)
            ->order_by('supplier_id', 'DESC')
            ->limit($amount)
            ->get()
            ->result();
    }

    /**
     * @param $input
     * @return string
     */
    function fix_avs($input)
    {
        if ($input != "") {
            if (preg_match('/(\d{3})\.(\d{4})\.(\d{4})\.(\d{2})/', $input, $matches)) {
                return $matches[1] . $matches[2] . $matches[3] . $matches[4];
            } else if (preg_match('/^\d{13}$/', $input)) {
                return $input;
            }
        }

        return "";
    }

    function convert_date($input)
    {
        $this->load->helper('date_helper');

        if ($input == '') {
            return '';
        }

        return date_to_mysql($input);
    }

    public function db_array()
    {
        $db_array = parent::db_array();
        $db_array['created_user_id'] = $this->session->userdata('user_id');
//        $db_array['supplier_group_id'] = $this->input->post('supplier_group_id');
        if(!empty($this->input->post('supplier_group_id'))){
            $db_array['supplier_group_id'] = json_encode($this->input->post('supplier_group_id'));
        }

        $db_array['supplier_email_sent'] = ($this->input->post('supplier_email_sent') != 1)? 0 : 1 ;



        if (!isset($db_array['supplier_active'])) {
            $db_array['supplier_active'] = 0;
        }

        return $db_array;
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    /**
     * Returns supplier_id of existing supplier
     *
     * @param $supplier_name
     * @return int|null
     */
    public function supplier_lookup($supplier_name)
    {
        $supplier = $this->mdl_suppliers->where('supplier_name', $supplier_name)->get();

        if ($supplier->num_rows()) {
            $supplier_id = $supplier->row()->supplier_id;
        } else {
            $db_array = array(
                'supplier_name' => $supplier_name
            );

            $supplier_id = parent::save(null, $db_array);
        }

        return $supplier_id;
    }

    public function with_total()
    {
        $this->filter_select('IFnull((SELECT SUM(invoice_total) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_total', false);
        return $this;
    }

    public function with_total_paid()
    {
        $this->filter_select('IFnull((SELECT SUM(invoice_paid) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_paid', false);
        return $this;
    }

    public function with_total_balance()
    {
        $this->filter_select('IFnull((SELECT SUM(invoice_balance) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_balance', false);
        return $this;
    }


    public function is_inactive()
    {
        $this->filter_where('supplier_active', 0);
        return $this;
    }

    public function is_all()
    {
        $this->filter_where('supplier_active', 1);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('supplier_active', 1);
        return $this;
    }



}

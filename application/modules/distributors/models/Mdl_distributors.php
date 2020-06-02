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
 * Class Mdl_distributors
 */
class Mdl_Distributors extends Response_Model
{
    public $table = 'ip_distributors';
    public $primary_key = 'ip_distributors.distributor_id';
    public $date_created_field = 'distributor_date_created';
    public $date_modified_field = 'distributor_date_modified';

    public function default_select()
    {
        $this->db->select(
            'SQL_CALC_FOUND_ROWS ' . $this->table . '.*, ' .
            'CONCAT(' . $this->table . '.distributor_name, " ", ' . $this->table . '.distributor_surname) as distributor_fullname, ' .
            'ip_users_groups.group_name',
            false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'distributor_id';
        $ip_invoices = $this->input->get('table') ? $this->input->get('table') : 'ip_distributors';
        $this->db->order_by($ip_invoices.'.'.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_users_groups', 'ip_distributors.distributor_group_id = ip_users_groups.group_id', 'left');
        $this->db->join('ip_users as u', 'ip_distributors.created_user_id = u.user_id', 'left')->select('u.user_name as username');

    }

    public function validation_rules()
    {
        return array(
            'distributor_name' => array(
                'field' => 'distributor_name',
                'label' => trans('distributor_name'),
                'rules' => 'required'
            ),
            'distributor_surname' => array(
                'field' => 'distributor_surname',
                'label' => trans('distributor_surname')
            ),
            'distributor_responsible' => array(
                'field' => 'distributor_responsible',
                'label' => trans('responsible')
            ),
            'distributor_surname_contactperson' => array(
                'field' => 'distributor_surname_contactperson',
                'label' => trans('distributor_surname_contactperson')
            ),
            'distributor_additional_information' => array(
                'field' => 'distributor_additional_information',
                'label' => trans('client_additional_information')
            ),
            'distributor_function_contactperson' => array(
                'field' => 'distributor_function_contactperson',
                'label' => trans('distributor_function_contactperson')
            ),
            'distributor_active' => array(
                'field' => 'distributor_active'
            ),
            'distributor_language' => array(
                'field' => 'distributor_language',
                'label' => trans('language'),
            ),
            'distributor_group_id' => array(
                'field' => 'distributor_group_id',
                'label' => trans('group_name'),
            ),
            'distributor_address_1' => array(
                'field' => 'distributor_address_1'
            ),
            'distributor_email2' => array(
                'field' => 'distributor_email'
            ),
            'distributor_city' => array(
                'field' => 'distributor_city',
                'label' => trans('distributor_city'),
            ),
            'distributor_sector' => array(
                'field' => 'distributor_sector',
                'label' => trans('sector'),
            ),
            'commission_rate_id' => array(
                'field' => 'commission_rate_id'
            ),
            'distributor_state' => array(
                'field' => 'distributor_state'
            ),
            'distributor_zip' => array(
                'field' => 'distributor_zip'
            ),
            'distributor_country' => array(
                'field' => 'distributor_country'
            ),
            'distributor_address_1_delivery' => array(
                'field' => 'distributor_address_1_delivery'
            ),
            'distributor_address_2_delivery' => array(
                'field' => 'distributor_address_2_delivery'
            ),
            'distributor_city_delivery' => array(
                'field' => 'distributor_city_delivery'
            ),
            'distributor_state_delivery' => array(
                'field' => 'distributor_state_delivery'
            ),
            'distributor_zip_delivery' => array(
                'field' => 'distributor_zip_delivery'
            ),
            'distributor_country_delivery' => array(
                'field' => 'distributor_country_delivery'
            ),
            'distributor_phone' => array(
                'field' => 'distributor_phone',
                'label' => trans('phone_number'),
                'rules' => 'regex_match[/^[0-9 +-]+$/]|min_length[8]',
            ),
            'distributor_fax' => array(
                'field' => 'distributor_fax'
            ),
            'distributor_mobile' => array(
                'field' => 'distributor_mobile',
                'label' => trans('phone_number').' 2 / '.trans('fax_number'),
                'rules' => 'regex_match[/^[0-9 +-]+$/]|min_length[8]',
            ),
            'distributor_sell_services_products' => array(
                'field' => 'distributor_sell_services_products',
                'label' => trans('distributor_sell_services_products'),
            ),
            'distributor_email' => array(
                'field' => 'distributor_email'
            ),
            'distributor_web' => array(
                'field' => 'distributor_web'
            ),
            'distributor_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'distributor_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            // SUMEX
            'distributor_birthdate' => array(
                'field' => 'distributor_birthdate',
                'rules' => 'callback_convert_date'
            ),
            'distributor_gender' => array(
                'field' => 'distributor_gender'
            ),
            'distributor_avs' => array(
                'field' => 'distributor_avs',
                'label' => trans('sumex_ssn'),
                'rules' => 'callback_fix_avs'
            ),
            'distributor_insurednumber' => array(
                'field' => 'distributor_insurednumber',
                'label' => trans('sumex_insurednumber')
            ),
            'distributor_veka' => array(
                'field' => 'distributor_veka',
                'label' => trans('sumex_veka')
            ),
            'distributor_category' => array(
                'distributor_category' => 'distributor_category',
                'label' => lang('distributor_category')
            ),
            'distributor_file' => array(
                'field' => 'distributor_file',
                'label' => lang('distributor_file')
            ),
            'distributor_email_sent' => array(
                'field' => 'distributor_email_sent',
                'label' => lang('email_sent')
            ),
            'distributor_number_id' => array(
                'field' => 'distributor_number_id',
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
        return $this->mdl_distributors
            ->where('distributor_active', 1)
            ->order_by('distributor_id', 'DESC')
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
//        $db_array['distributor_group_id'] = $this->input->post('distributor_group_id');
        if(!empty($this->input->post('distributor_group_id'))){
            $db_array['distributor_group_id'] = json_encode($this->input->post('distributor_group_id'));
        }

        $db_array['distributor_email_sent'] = ($this->input->post('distributor_email_sent') != 1)? 0 : 1 ;



        if (!isset($db_array['distributor_active'])) {
            $db_array['distributor_active'] = 0;
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
     * Returns distributor_id of existing distributor
     *
     * @param $distributor_name
     * @return int|null
     */
    public function distributor_lookup($distributor_name)
    {
        $distributor = $this->mdl_distributors->where('distributor_name', $distributor_name)->get();

        if ($distributor->num_rows()) {
            $distributor_id = $distributor->row()->distributor_id;
        } else {
            $db_array = array(
                'distributor_name' => $distributor_name
            );

            $distributor_id = parent::save(null, $db_array);
        }

        return $distributor_id;
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
        $this->filter_where('distributor_active', 0);
        return $this;
    }

    public function is_all()
    {
        $this->filter_where('distributor_active', 1);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('distributor_active', 1);
        return $this;
    }



}

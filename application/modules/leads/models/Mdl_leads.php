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
 * Class Mdl_leads
 */
class Mdl_Leads extends Response_Model
{
    public $table = 'ip_leads';
    public $primary_key = 'ip_leads.lead_id';
    public $date_created_field = 'lead_date_created';
    public $date_modified_field = 'lead_date_modified';

    public function default_select()
    {
        $this->db->select(
            'SQL_CALC_FOUND_ROWS ' . $this->table . '.*, ' .
            'CONCAT(' . $this->table . '.lead_name, " ", ' . $this->table . '.lead_surname) as lead_fullname, ' .
            'ip_users_groups.group_name',
            false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'lead_id';
        $ip_invoices = $this->input->get('table') ? $this->input->get('table') : 'ip_leads';
        $this->db->order_by($ip_invoices.'.'.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_users_groups', 'ip_leads.lead_group_id = ip_users_groups.group_id', 'left');
        $this->db->join('ip_users as u', 'ip_leads.created_user_id = u.user_id', 'left')->select('u.user_name as username');

    }

    public function validation_rules()
    {
        return array(
            'lead_name' => array(
                'field' => 'lead_name',
                'label' => trans('lead_name'),
                'rules' => 'required'
            ),
            'lead_surname' => array(
                'field' => 'lead_surname',
                'label' => trans('lead_surname')
            ),
            'lead_responsible' => array(
                'field' => 'lead_responsible',
                'label' => trans('responsible')
            ),
            'lead_surname_contactperson' => array(
                'field' => 'lead_surname_contactperson',
                'label' => trans('lead_surname_contactperson')
            ),
            'lead_additional_information' => array(
                'field' => 'lead_additional_information',
                'label' => trans('client_additional_information')
            ),
            'lead_function_contactperson' => array(
                'field' => 'lead_function_contactperson',
                'label' => trans('lead_function_contactperson')
            ),
            'lead_active' => array(
                'field' => 'lead_active'
            ),
            'lead_language' => array(
                'field' => 'lead_language',
                'label' => trans('language'),
            ),
            'lead_group_id' => array(
                'field' => 'lead_group_id',
                'label' => trans('group_name'),
            ),
            'lead_address_1' => array(
                'field' => 'lead_address_1'
            ),
            'lead_email2' => array(
                'field' => 'lead_email'
            ),
            'lead_city' => array(
                'field' => 'lead_city',
                'label' => trans('lead_city'),
            ),
            'lead_sector' => array(
                'field' => 'lead_sector',
                'label' => trans('sector'),
            ),
            'commission_rate_id' => array(
                'field' => 'commission_rate_id'
            ),
            'lead_state' => array(
                'field' => 'lead_state'
            ),
            'lead_zip' => array(
                'field' => 'lead_zip'
            ),
            'lead_country' => array(
                'field' => 'lead_country'
            ),
            'lead_address_1_delivery' => array(
                'field' => 'lead_address_1_delivery'
            ),
            'lead_address_2_delivery' => array(
                'field' => 'lead_address_2_delivery'
            ),
            'lead_city_delivery' => array(
                'field' => 'lead_city_delivery'
            ),
            'lead_state_delivery' => array(
                'field' => 'lead_state_delivery'
            ),
            'lead_zip_delivery' => array(
                'field' => 'lead_zip_delivery'
            ),
            'lead_country_delivery' => array(
                'field' => 'lead_country_delivery'
            ),
            'lead_phone' => array(
                'field' => 'lead_phone',
                'label' => trans('phone_number'),
                'rules' => 'regex_match[/^[0-9 +-]+$/]|min_length[8]',
            ),
            'lead_fax' => array(
                'field' => 'lead_fax'
            ),
            'lead_mobile' => array(
                'field' => 'lead_mobile',
                'label' => trans('phone_number').' 2 / '.trans('fax_number'),
                'rules' => 'regex_match[/^[0-9 +-]+$/]|min_length[8]',
            ),
            'lead_sell_services_products' => array(
                'field' => 'lead_sell_services_products',
                'label' => trans('lead_sell_services_products'),
            ),
            'lead_email' => array(
                'field' => 'lead_email'
            ),
            'lead_web' => array(
                'field' => 'lead_web'
            ),
            'lead_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'lead_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            // SUMEX
            'lead_birthdate' => array(
                'field' => 'lead_birthdate',
                'rules' => 'callback_convert_date'
            ),
            'lead_gender' => array(
                'field' => 'lead_gender'
            ),
            'lead_avs' => array(
                'field' => 'lead_avs',
                'label' => trans('sumex_ssn'),
                'rules' => 'callback_fix_avs'
            ),
            'lead_insurednumber' => array(
                'field' => 'lead_insurednumber',
                'label' => trans('sumex_insurednumber')
            ),
            'lead_veka' => array(
                'field' => 'lead_veka',
                'label' => trans('sumex_veka')
            ),
            'lead_category' => array(
                'lead_category' => 'lead_category',
                'label' => lang('lead_category')
            ),
            'lead_file' => array(
                'field' => 'lead_file',
                'label' => lang('lead_file')
            ),
            'lead_email_sent' => array(
                'field' => 'lead_email_sent',
                'label' => lang('email_sent')
            ),
            'lead_number_id' => array(
                'field' => 'lead_number_id',
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
        return $this->mdl_leads
            ->where('lead_active', 1)
            ->order_by('lead_id', 'DESC')
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
//        $db_array['lead_group_id'] = $this->input->post('lead_group_id');
        if(!empty($this->input->post('lead_group_id'))){
            $db_array['lead_group_id'] = json_encode($this->input->post('lead_group_id'));
        }

        $db_array['lead_email_sent'] = ($this->input->post('lead_email_sent') != 1)? 0 : 1 ;



        if (!isset($db_array['lead_active'])) {
            $db_array['lead_active'] = 0;
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
     * Returns lead_id of existing lead
     *
     * @param $lead_name
     * @return int|null
     */
    public function lead_lookup($lead_name)
    {
        $lead = $this->mdl_leads->where('lead_name', $lead_name)->get();

        if ($lead->num_rows()) {
            $lead_id = $lead->row()->lead_id;
        } else {
            $db_array = array(
                'lead_name' => $lead_name
            );

            $lead_id = parent::save(null, $db_array);
        }

        return $lead_id;
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
        $this->filter_where('lead_active', 0);
        return $this;
    }

    public function is_all()
    {
        $this->filter_where('lead_active', 1);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('lead_active', 1);
        return $this;
    }



}

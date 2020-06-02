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
 * Class Mdl_targets
 */
class Mdl_Targets extends Response_Model
{
    public $table = 'ip_targets';
    public $primary_key = 'ip_targets.target_id';
    public $date_created_field = 'target_date_created';
    public $date_modified_field = 'target_date_modified';

    public function default_select()
    {
        $this->db->select(
            'SQL_CALC_FOUND_ROWS ' . $this->table . '.*, ' .
            'CONCAT(' . $this->table . '.target_name, " ", ' . $this->table . '.target_surname) as target_fullname, ' .
            'ip_users_groups.group_name',
            false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'target_name';
        $ip_invoices = $this->input->get('table') ? $this->input->get('table') : 'ip_targets';
        $this->db->order_by($ip_invoices.'.'.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_users_groups', 'ip_targets.target_group_id = ip_users_groups.group_id', 'left');
        $this->db->join('ip_users as u', 'ip_targets.created_user_id = u.user_id', 'left')->select('u.user_name as username');

    }

    public function validation_rules()
    {
        return array(
            'target_name' => array(
                'field' => 'target_name',
                'label' => trans('target_name'),
                'rules' => 'required'
            ),
            'target_surname' => array(
                'field' => 'target_surname',
                'label' => trans('target_surname')
            ),
            'target_active' => array(
                'field' => 'target_active'
            ),
            'target_language' => array(
                'field' => 'target_language',
                'label' => trans('language'),
            ),
            'target_group_id' => array(
                'field' => 'target_group_id',
                'label' => trans('group_name'),
            ),
            'target_address_1' => array(
                'field' => 'target_address_1'
            ),
            'target_email2' => array(
                'field' => 'target_email'
            ),
            'target_city' => array(
                'field' => 'target_city'
            ),
            'target_state' => array(
                'field' => 'target_state'
            ),
            'target_zip' => array(
                'field' => 'target_zip'
            ),
            'target_country' => array(
                'field' => 'target_country'
            ),
            'target_address_1_delivery' => array(
                'field' => 'target_address_1_delivery'
            ),
            'target_address_2_delivery' => array(
                'field' => 'target_address_2_delivery'
            ),
            'target_city_delivery' => array(
                'field' => 'target_city_delivery'
            ),
            'target_state_delivery' => array(
                'field' => 'target_state_delivery'
            ),
            'target_zip_delivery' => array(
                'field' => 'target_zip_delivery'
            ),
            'target_country_delivery' => array(
                'field' => 'target_country_delivery'
            ),
            'target_phone' => array(
                'field' => 'target_phone'
            ),
            'target_fax' => array(
                'field' => 'target_fax'
            ),
            'target_mobile' => array(
                'field' => 'target_mobile'
            ),
            'target_email' => array(
                'field' => 'target_email'
            ),
            'target_web' => array(
                'field' => 'target_web'
            ),
            'target_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'target_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            // SUMEX
            'target_birthdate' => array(
                'field' => 'target_birthdate',
                'rules' => 'callback_convert_date'
            ),
            'target_gender' => array(
                'field' => 'target_gender'
            ),
            'target_avs' => array(
                'field' => 'target_avs',
                'label' => trans('sumex_ssn'),
                'rules' => 'callback_fix_avs'
            ),
            'target_insurednumber' => array(
                'field' => 'target_insurednumber',
                'label' => trans('sumex_insurednumber')
            ),
            'target_veka' => array(
                'field' => 'target_veka',
                'label' => trans('sumex_veka')
            ),
            'target_file' => array(
                'field' => 'target_file',
                'label' => lang('target_file')
            ),
        );
    }

    /**
     * @param int $amount
     * @return mixed
     */
    function get_latest($amount = 10)
    {
        return $this->mdl_targets
            ->where('target_active', 1)
            ->order_by('target_id', 'DESC')
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

        if (!isset($db_array['target_active'])) {
            $db_array['target_active'] = 0;
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
     * Returns target_id of existing target
     *
     * @param $target_name
     * @return int|null
     */
    public function target_lookup($target_name)
    {
        $target = $this->mdl_targets->where('target_name', $target_name)->get();

        if ($target->num_rows()) {
            $target_id = $target->row()->target_id;
        } else {
            $db_array = array(
                'target_name' => $target_name
            );

            $target_id = parent::save(null, $db_array);
        }

        return $target_id;
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
        $this->filter_where('target_active', 0);
        return $this;
    }

    public function is_all()
    {
        $this->filter_where('1', 1);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('target_active', 1);
        return $this;
    }

}

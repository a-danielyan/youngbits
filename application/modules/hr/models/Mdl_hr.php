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
 * Class Mdl_Hr
 */
class Mdl_Hr extends Response_Model
{
    public $table = 'ip_hrs';
    public $primary_key = 'ip_hrs.hr_id';
    public $date_created_field = 'hr_date_created';
    public $date_modified_field = 'hr_date_modified';

    public function default_select()
    {
        $this->db->select(
            'SQL_CALC_FOUND_ROWS ' . $this->table . '.*, ' .
            'CONCAT(' . $this->table . '.hr_name, " ", ' . $this->table . '.hr_surname) as hr_fullname ',
            false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'hr_name';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_hrs.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function validation_rules()
    {
        return array(
            'hr_name' => array(
                'field' => 'hr_name',
                'label' => trans('hr_name'),
                'rules' => 'required'
            ),
            'hr_surname' => array(
                'field' => 'hr_surname',
                'label' => trans('hr_surname')
            ),
            'hr_active' => array(
                'field' => 'hr_active'
            ),
            'hr_language' => array(
                'field' => 'hr_language',
                'label' => trans('language'),
            ),
            'hr_address_1' => array(
                'field' => 'hr_address_1'
            ),
            'hr_address_2' => array(
                'field' => 'hr_address_2'
            ),
            'hr_city' => array(
                'field' => 'hr_city'
            ),
            'hr_state' => array(
                'field' => 'hr_state'
            ),
            'hr_zip' => array(
                'field' => 'hr_zip'
            ),
            'hr_country' => array(
                'field' => 'hr_country'
            ),
            'hr_phone' => array(
                'field' => 'hr_phone'
            ),
            'hr_fax' => array(
                'field' => 'hr_fax'
            ),
            'hr_mobile' => array(
                'field' => 'hr_mobile'
            ),
            'hr_email' => array(
                'field' => 'hr_email'
            ),
            'hr_web' => array(
                'field' => 'hr_web'
            ),
            'hr_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'hr_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'hr_birthdate' => array(
                'field' => 'hr_birthdate',
                'rules' => 'callback_convert_date'
            ),
            'hr_gender' => array(
                'field' => 'hr_gender'
            ),
            'hr_avs' => array(
                'field' => 'hr_avs',
                'label' => trans('sumex_ssn'),
                'rules' => 'callback_fix_avs'
            ),
            'hr_insurednumber' => array(
                'field' => 'hr_insurednumber',
                'label' => trans('sumex_insurednumber')
            ),
            'hr_veka' => array(
                'field' => 'hr_veka',
                'label' => trans('sumex_veka')
            ),
            'hr_type' => array(
                'field' => 'hr_type',
                'label' => trans('group_name')
            ),
            'hr_followers' => array(
                'field' => 'hr_followers',
                'label' => trans('hr_followers')
            ),
            'hr_social_link' => array(
                'field' => 'hr_social_link',
                'label' => trans('hr_social_link')
            ),
            'hr_profile_picture' => array(
                'field' => 'hr_profile_picture',
                'label' => trans('profile_picture')
            ),
        );
    }

    /**
     * @param int $amount
     * @return mixed
     */
    function get_latest($amount = 10)
    {
        return $this->mdl_hr
            ->where('hr_active', 1)
            ->order_by('hr_id', 'DESC')
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

        if (!isset($db_array['hr_active'])) {
            $db_array['hr_active'] = 0;
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
     * Returns hr_id of existing hr
     *
     * @param $hr_name
     * @return int|null
     */
    public function hr_lookup($hr_name)
    {
        $hr = $this->mdl_hr->where('hr_name', $hr_name)->get();

        if ($hr->num_rows()) {
            $hr_id = $hr->row()->hr_id;
        } else {
            $db_array = array(
                'hr_name' => $hr_name
            );

            $hr_id = parent::save(null, $db_array);
        }

        return $hr_id;
    }

    public function is_type($type)
    {
        $this->filter_where('hr_type', $type);
        return $this;
    }

    public function is_not_type($type)
    {
        $this->filter_where('hr_type !=', $type);
        return $this;
    }

    public function is_inactive()
    {
        $this->filter_where('hr_active', 0);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('hr_active', 1);
        return $this;
    }

}

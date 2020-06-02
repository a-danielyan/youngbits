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
 * Class Mdl_upfront_payments
 */
class Mdl_upfront_payments extends Response_Model
{
    public $table = 'ip_upfront_payments';
    public $primary_key = 'ip_upfront_payments.upfront_payments_id';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_upfront_payments.*", false);
    }


    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'upfront_payments_date';
        $ip_invoices = $this->input->get('table') ? $this->input->get('table') : 'ip_upfront_payments';
        $this->db->order_by($ip_invoices.'.'.$orderField.' '.$orderType);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'upfront_payments_date' => array(
                'field' => 'upfront_payments_date',
                'label' => trans('date'),
            ),
            'upfront_payments_amount' => array(
                'field' => 'upfront_payments_amount',
                'label' => trans('upfront_payments_amount'),
            ),
            'upfront_payments_description' => array(
                'field' => 'upfront_payments_description',
                'label' => trans('upfront_payments_description')
            ),
            'upfront_payments_document_link' => array(
                'field' => 'upfront_payments_document_link',
                'label' => lang('upfront_payments_document_link')
            ),
            'upfront_payments_category' => array(
                'field' => 'upfront_payments_category',
                'label' => lang('upfront_payments_category'),
            ),
            'upfront_payments_name' => array(
                'field' => 'upfront_payments_name',
                'label' => lang('upfront_payments_name'),
                'rules' => 'required'
            ),
            'upfront_payments_discount' => array(
                'field' => 'upfront_payments_discount',
                'label' => lang('upfront_payments_discount')
            ),
            'upfront_payments_discount_total' => array(
                'field' => 'upfront_payments_discount_total',
                'label' => lang('upfront_payments_discount_total')
            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        $db_array['upfront_payments_date'] = date_to_mysql($db_array['upfront_payments_date']);
        $db_array['upfront_payments_amount'] = standardize_amount($db_array['upfront_payments_amount']);

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
            parent::set_form_value('upfront_payments_date', date('Y-m-d'));
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

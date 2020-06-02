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
 * Class Mdl_Subscriptions
 */
class Mdl_Subscriptions extends Response_Model
{
    public $table = 'ip_subscriptions';
    public $primary_key = 'ip_subscriptions.subscriptions_id';
    public $validation_rules = 'validation_rules';
    public $recur_frequencies = array(
        '7D' => 'calendar_week_1',
        '14D' => 'calendar_week_2',
        '21D' => 'calendar_week_3',
        '28D' => 'calendar_week_4',
        '1M' => 'calendar_month_1',
        '2M' => 'calendar_month_2',
        '3M' => 'calendar_month_3',
        '4M' => 'calendar_month_4',
        '5M' => 'calendar_month_5',
        '6M' => 'calendar_month_6',
        '1Y' => 'calendar_year_1',
    );

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_subscriptions.*", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_subscriptions.subscriptions_date DESC');
    }

    public function default_join()
    {
        //$this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_subscriptions.subscriptions_payment_method_id', 'left');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'subscriptions_date' => array(
                'field' => 'subscriptions_date',
                'label' => trans('date'),
            ),
            'subscriptions_start_date' => array(
                'field' => 'subscriptions_start_date',
                'label' => trans('subscriptions_start_date'),
            ),
            'subscriptions_amount' => array(
                'field' => 'subscriptions_amount',
                'label' => trans('subscriptions_amount'),
                'rules' => 'required'
            ),
            'subscriptions_end_date' => array(
                'field' => 'subscriptions_end_date',
                'label' => trans('subscriptions_end_date'),
            ),
            'subscriptions_frequency' => array(
                'field' => 'subscriptions_frequency',
                'label' => trans('every'),
                'rules' => 'required'
            ),
            'subscriptions_contact' => array(
                'field' => 'subscriptions_contact',
                'label' => trans('subscriptions_contact'),

            ),
            'subscriptions_username' => array(
                'field' => 'subscriptions_username',
                'label' => trans('subscriptions_username'),
            ),
            'subscriptions_note' => array(
                'field' => 'subscriptions_note',
                'label' => trans('note')
            ),
            'subscriptions_document_link' => array(
                'field' => 'subscriptions_document_link',
                'label' => lang('subscriptions_document_link')
            ),
            'subscriptions_category' => array(
                'field' => 'subscriptions_category',
                'label' => lang('subscriptions_category'),
                'rules' => 'required'

            ),
            'subscriptions_name' => array(
                'field' => 'subscriptions_name',
                'label' => lang('subscriptions_name'),
                'rules' => 'required'

            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['subscriptions_date'] = date_to_mysql($db_array['subscriptions_date']);
        $db_array['subscriptions_start_date'] = date_to_mysql($db_array['subscriptions_start_date']);
        $db_array['subscriptions_end_date'] = date_to_mysql($db_array['subscriptions_end_date']);
        $db_array['subscriptions_amount'] = standardize_amount($db_array['subscriptions_amount']);

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
            parent::set_form_value('subscriptions_date', date('Y-m-d'));
            parent::set_form_value('subscriptions_start_date', date('Y-m-d'));
            parent::set_form_value('subscriptions_end_date', date('Y-m-d'));
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

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
 * Class Mdl_Payments
 */
class Mdl_Payment_arrangements extends Response_Model
{
    public $table = 'ip_payment_arrangements';
    public $primary_key = 'ip_payment_arrangements.payment_arrangement_id';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_clients.client_name,
            ip_clients.client_surname,
        	  ip_clients.client_id,
            ip_payment_arrangements.*", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_payment_arrangements.payment_arrangements_date DESC');

    }

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payment_arrangements.payment_arrangement_client_id', 'left');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'payment_arrangement_title' => array(
                'field' => 'payment_arrangement_title',
                'label' => trans('payment_arrangement_title'),
                'rules' => 'required'
            ),
            'payment_arrangements_date' => array(
                'field' => 'payment_arrangements_date',
                'label' => trans('date'),
            ),
            'payment_arrangement_total_amount' => array(
                'field' => 'payment_arrangement_total_amount',
                'label' => trans('payment'),
            ),
            'payment_arrangement_client_id' => array(
                'field' => 'payment_arrangement_client_id',
                'label' => trans('payment_arrangement_client_name')
            ),
            'payment_arrangement_payment_number' => array(
                'field' => 'payment_arrangement_payment_number',
                'label' => trans('payment_arrangement_payment_number')
            ),
            'payment_arrangement_text' => array(
                'field' => 'payment_arrangement_text',
                'label' => trans('payment_arrangement_text')
            )
        );
    }

    /**
     * @param null $id
     * @param null $db_array
     * @return bool|int|null
     */
    public function save($id = null, $db_array = null)
    {
        //$amount = json_encode($this->input->post('payment_arrangement_amount'));

        $payment_amout = $_POST['payment_arrangement_amount']['amout'];
        $payment_data = $_POST['payment_arrangement_amount']['data'];
        $amount = [];
        $arr = [];
        for ($i=0; $i<count($payment_amout); $i++){
            $arr['amount'] = $payment_amout[$i];
            $arr['date'] = $payment_data[$i];
            array_push($amount,$arr);

        }
        $amount_res = json_encode($amount);

        $db_array = ($db_array) ? $db_array : $this->db_array();
        $db_array['payment_arrangements_date'] = date('Y-m-d H-i-s');
        $db_array['payment_arrangement_amount'] =$amount_res;

        if(empty($this->input->post('payment_arrangement_key'))){
            $db_array['payment_arrangement_key'] =$this->get_url_key();
        }

        // Save the payment_arrangements
        $id = parent::save($id, $db_array);

        return $id;
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();


       // $db_array['payment_arrangements_date'] = date_to_mysql($db_array['payment_arrangements_date']);
        $db_array['payment_arrangement_total_amount'] = standardize_amount($db_array['payment_arrangement_total_amount']);

        return $db_array;
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
            parent::set_form_value('payment_arrangements_date', date('Y-m-d'));
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

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }



}

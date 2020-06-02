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
 * Class Mdl_statements
 */
class Mdl_statements extends Response_Model
{
    public $table = 'ip_statements';
    public $primary_key = 'ip_statements.id';


    public function default_select()
    {
        $this->db->select("SQL_CALC_FOUND_ROWS ip_statements.*", false);
    }


    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'ASC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'id';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_statements.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_users', 'ip_users.user_id = ip_statements.user_id', 'left');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'bank_account' => array(
                'field' => 'bank_account',
                'label' => trans('bank_account')
            ),
            'amount' => array(
                'field' => 'amount',
                'label' => trans('amount')
            ),
            'date' => array(
                'field' => 'date',
                'label' => trans('date')
            ),
            'offset' => array(
                'field' => 'offset',
                'label' => trans('offset')
            ),
            'account_name' => array(
                'field' => 'account_name',
                'label' => trans('account_name')
            ),
            'type' => array(
                'field' => 'type',
                'label' => trans('type')
            ),
            'category' => array(
                'field' => 'category',
                'label' => trans('category')
            ),
            'organization' => array(
                'field' => 'organization',
                'label' => trans('organization')
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('description')
            ),
        );
    }

    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }

        if (!$id) {
            parent::set_form_value('date', date('Y-d-m'));
        }

        return true;
    }

    public function insert($data) {

        $res = $this->db->insert_batch('ip_statements',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
  
    }

}
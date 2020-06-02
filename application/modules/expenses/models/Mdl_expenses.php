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
 * Class Mdl_expenses
 */
class Mdl_expenses extends Response_Model
{
    public $table = 'ip_expenses';
    public $primary_key = 'ip_expenses.expenses_id';

    public function default_select()
    {
        $this->db->select("SQL_CALC_FOUND_ROWS ip_expenses.*,ip_projects.*,ip_users.user_name", false);
    }


    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'ASC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'expenses_id';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_expenses.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_expenses.expenses_project_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_expenses.expenses_user_id', 'left');

    }




    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'expenses_date' => array(
                'field' => 'expenses_date',
                'label' => trans('date'),
            ),
            'expenses_amount' => array(
                'field' => 'expenses_amount',
                'label' => trans('expenses_amount'),
            ),
            'expenses_notes' => array(
                'field' => 'expenses_notes',
                'label' => trans('expenses_notes')
            ),
            'expenses_document_link' => array(
                'field' => 'expenses_document_link',
                'label' => lang('expenses_document_link')
            ),
            'expenses_category' => array(
                'field' => 'expenses_category',
                'label' => lang('expenses_category'),
            ),
            'expenses_name' => array(
                'field' => 'expenses_name',
                'label' => lang('expenses_name'),
                'rules' => 'required'
            ),
            'expenses_project_id' => array(
                'field' => 'expenses_project_id',
                'label' => lang('project')
            ),
            'expenses_number_id' => array(
                'field' => 'expenses_number_id',
                'label' => lang('project')
            ),
            'expenses_amount_euro' => array(
                'field' => 'expenses_amount_euro',
                'label' => lang('expenses_amount')
            ),
            'expenses_currency' => array(
                'field' => 'expenses_currency',
                'label' => lang('currency')
            ),
            'expenses_user_id' => array(
                'field' => 'expenses_user_id',
                'label' => lang('user')
            ),
            'todo_ticket_id' => array(
                'field' => 'todo_ticket_id',
                'label' => lang('todo_ticket')
            ),
            'expenses_parent_id' => array(
                'field' => 'expenses_parent_id',
                'label' => lang('parent_id')
            ),
            'expenses_cash_bank' => array(
                'field' => 'expenses_cash_bank',
                'label' => lang('cash_bank')
            ),
            'expenses_taxes' => array(
                'field' => 'expenses_taxes',
                'label' => lang('expenses_taxes')
            ),
            'exclude_from_total' => array(
                'field' => 'exclude_from_total',
                'label' => lang('exclude_from_total')
            )
        );
    }


    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['expenses_date'] = date('Y-m-d',strtotime($db_array['expenses_date']));
        $db_array['expenses_amount'] = standardize_amount($db_array['expenses_amount']);

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
            parent::set_form_value('expenses_date', date('Y-m-d'));
        }

        return true;
    }

    public function cash_bank(){
        return $data = [
            'Cash',
            'Bank',
            'Paypal',
        ];
    }

    public function get_years($order = 'desc') {
        $this->db->select('YEAR(expenses_date) as year');
        $this->db->from('ip_expenses');
        $this->db->order_by('year', $order);
        $this->db->group_by('YEAR(expenses_date)');
        return  $this->db->get()->result_array();
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

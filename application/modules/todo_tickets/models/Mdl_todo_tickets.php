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
 * Class Mdl_Tickets
 */
class Mdl_todo_tickets extends Response_Model
{
    public $table = 'ip_todo_tickets';
    public $primary_key = 'ip_todo_tickets.todo_ticket_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS ip_todo_tickets.*,
          cu.user_name as todo_ticket_created_user_name, 
          au.user_name as todo_ticket_assigned_user_name, 
          ip_clients.client_name,
          ip_projects.project_name,
          ip_projects.client_id AS project_client_id
        ', false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'todo_ticket_id';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_todo_tickets.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_todo_tickets.project_id', 'left');
        $this->db->join('ip_users cu', 'cu.user_id = ip_todo_tickets.todo_ticket_created_user_id', 'left');
        $this->db->join('ip_users au', 'au.user_id = ip_todo_tickets.todo_ticket_assigned_user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_todo_tickets.client_id', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('ip_todo_tickets.todo_ticket_id', 'DESC');
        return $this;
    }

    /**
     * @param string $match
     */
    public function by_todo_ticket($match)
    {
        $this->db->like('todo_ticket_name', $match);
        $this->db->or_like('todo_ticket_description', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'todo_ticket_description' => array(
                'field' => 'todo_ticket_description',
                'label' => trans('todo_ticket_description'),
                'rules' => 'required'
            ),
            'todo_ticket_status' => array(
                'field' => 'todo_ticket_status',
                'label' => trans('status'),
                'rules' => ''
            ),
            'todo_ticket_assigned_user_id' => array(
                'field' => 'todo_assigned_user_id',
                'label' => trans('assign_to'),
                'rules' => ''
            ),
            'todo_ticket_created_user_id' => array(
                'field' => 'todo_ticket_created_user_id',
                'label' => trans('todo_ticket_created_by'),
                'rules' => ''
            ),
            'todo_ticket_insert_time' => array(
                'field' => 'todo_ticket_insert_time',
                'label' => trans('todo_ticket_insert_time'),
                'rules' => ''
            ),
            'client_id' => array(
                'field' => 'client_id',
                'label' => trans('client'),
                'rules' => ''
            ),
            'todo_ticket_number' => array(
                'field' => 'todo_ticket_number',
                'label' => trans('todo_number'),
                'rules' => ''
            ),
            'ticket_document_link' => array(
                'field' => 'ticket_document_link',
                'label' => trans('ticket_document_link'),
                'rules' => ''
            ),
            'todo_ticket_number_of_hours' => array(
                'field' => 'todo_ticket_number_of_hours',
                'label' => trans('todo_ticket_number_of_hours'),
                'rules' => ''
            ),
            'todo_ticket_number_of_hours_managers' => array(
                'field' => 'todo_ticket_number_of_hours_managers',
                'label' => trans('todo_ticket_number_of_hours'),
                'rules' => ''
            ),
            'todo_ticket_assigned_user_group_id' => array(
                'field' => 'todo_ticket_assigned_user_group_id',
                'label' => trans('group'),
                'rules' => ''
            ),
            'todo_ticket_assigned_manager_id' => array(
                'field' => 'todo_ticket_assigned_manager_id',
                'label' => trans('manager'),
                'rules' => ''
            ),
            'todo_ticket_category' => array(
                'field' => 'todo_ticket_category',
                'label' => trans('category'),
                'rules' => ''
            ),
            'todo_ticket_phone_number' => array(
                'field' => 'todo_ticket_phone_number',
                'label' => trans('phone_number'),
                'rules' => ''
            ),
            'todo_ticket_email_address' => array(
                'field' => 'todo_ticket_email_address',
                'label' => trans('email_address'),
                'rules' => ''
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        if(!empty($_POST['to_do_task'])){
            $db_array['todo_ticket_tasks'] = serialize($_POST['to_do_task']);
        }


        if(empty($this->input->post('todo_ticket_url_key'))){
            $db_array['todo_ticket_url_key'] =$this->get_url_key();
        }


        return $db_array;
    }

    /**
     * @param null|integer $id
     * @return bool
     */
    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }

        if (!$id) {

            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
            parent::set_form_value('hour_rate', $user->default_hour_rate);
            parent::set_form_value('tax_rate_id', $user->default_tax_rate_id);
            parent::set_form_value('multiplier', $user->multiplier);
        }

        return true;
    }


    /**
     * @param integer $new_status
     * @param integer $todo_ticket_id
     */
    public function update_status($new_status, $todo_ticket_id)
    {
        $statuses_ok = $this->statuses();
        if (isset($statuses_ok[$new_status])) {
            parent::save($todo_ticket_id, array('todo_ticket_status' => $new_status));
        }
    }

    /**
     * @return array
     */
    public function statuses()
    {
        return array(
            '0' => array(
                'label' => trans('draft'),
                'class' => 'draft'
            ),
            '1' => array(
                'label' => trans('closed'),
                'class' => 'rejected'
            ),
            '2' => array(
                'label' => trans('accepted'),
                'class' => 'sent'
            ),
            '3' => array(
                'label' => trans('in_progress'),
                'class' => 'viewed'
            ),
            '4' => array(
                'label' => trans('paid'),
                'class' => 'paid'
            )
        );
    }


    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }
    //merge index, si form
}

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
class Mdl_todo_tasks extends Response_Model
{
    public $table = 'ip_todo_tasks';
    public $primary_key = 'ip_todo_tasks.todo_task_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,
          ip_projects.project_name ', false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'ASC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'todo_ticket_todo_task_id';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_todo_tasks.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_todo_tasks.todo_task_project_id', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('ip_todo_tasks.todo_task_id', 'DESC');
        return $this;
    }

    public function update_table_ids ($set_value, $where_value) {
        $this->db->set('todo_ticket_todo_task_id', $set_value);
        $this->db->where('todo_task_id', $where_value);
        $this->db->update($this->table);
    }
    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(

            'todo_task_text' => array(
                'field' => 'todo_task_text',
                'label' => trans('todo_task_text'),
                'rules' => ''
            ),

            'todo_ticket_id' => array(
                'field' => 'todo_ticket_id',
                'label' => trans('todo_name'),
                'rules' => ''
            ),
            'todo_task_project_id' => array(
                'field' => 'todo_task_project_id',
                'label' => trans('project'),
                'rules' => ''
            ),
            'client_id' => array(
                'field' => 'client_id',
                'label' => trans('client'),
                'rules' => ''
            ),
            'todo_task_number_of_hours' => array(
                'field' => 'todo_ticket_number_of_hours',
                'label' => trans('todo_task_number_of_hours'),
                'rules' => ''
            ),
            'todo_task_number_of_hours_manager' => array(
                'field' => 'todo_task_number_of_hours_manager',
                'label' => trans('todo_task_number_of_hours'),
                'rules' => ''
            ),
            'todo_task_created_user_id' => array(
                'field' => 'todo_task_created_user_id',
                'label' => trans('todo_task_created_user_id'),
                'rules' => ''
            ),
            'todo_task_document_link' => array(
                'field' => 'todo_task_document_link',
                'label' => trans('todo_task_document_link'),
                'rules' => ''
            ),
            'todo_task_created_date' => array(
                'field' => 'todo_task_created_date',
                'label' => trans('created_date'),
                'rules' => ''
            ),
            'todo_ticket_todo_task_id' => array(
                'field' => 'todo_ticket_todo_task_id',
                'label' => trans('todo_ticket_todo_task_id')
            ),
            'todo_task_deadline' => array(
                'field' => 'todo_task_deadline',
                'label' => trans('deadline')
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
                'class' => 'approved'
            ),
            '3' => array(
                'label' => trans('within_guarantee_warranty'),
                'class' => 'viewed'
            )
        );
    }

    public function is_draft()
    {
        $this->filter_where('todo_ticket_status', 0);
        return $this;
    }

    public function is_accepted()
    {
        $this->filter_where('todo_ticket_status', 2);
        return $this;
    }

    public function is_closed()
    {
        $this->filter_where('todo_ticket_status', 1);
        return $this;
    }

    public function is_within_guarantee_warranty()
    {
        $this->filter_where('todo_ticket_status', 3);
        return $this;
    }

    public function update_todo_tasks($todo_tasks,$todo_ticket_id = NULL){
        foreach ($todo_tasks as $todo_task) {
            if(!empty($todo_task['todo_task_id'])){
                $data = array(
                    'todo_task_text' => $todo_task['todo_task_text'],
                    'todo_ticket_id' => $todo_ticket_id,
                    'todo_task_project_id' => $todo_task['todo_task_project_id'],
                    'todo_task_number_of_hours' => $todo_task['todo_task_number_of_hours'],
//                    'todo_task_number_of_hours_manager' => $todo_task['todo_task_number_of_hours_manager'],
//                    'todo_ticket_todo_task_id' => $todo_task['todo_ticket_todo_task_id']
                );

                if(!empty($todo_task['todo_task_document_link'])){
                    $data['todo_task_document_link'] = $todo_task['todo_task_document_link'];
                }

                if(!empty($todo_task['todo_task_number_of_hours_manager'])){
                    $data['todo_task_number_of_hours_manager'] = $todo_task['todo_task_number_of_hours_manager'];
                    $data['todo_task_number_of_hours'] = $todo_task['todo_task_number_of_hours_manager'];
                }


                $this->db->set($data);
                $this->db->where('todo_task_id', $todo_task['todo_task_id']);
                $this->db->update('ip_todo_tasks');
            }
        }
    }

    public function insert_todo_tasks($todo_tasks,$todo_ticket_id = NULL){
        if(!empty($todo_tasks[0]))
           foreach ($todo_tasks as $todo_task) {
               if(!empty($todo_task['todo_task_text']) && empty($todo_task['todo_task_id'])){
                    $data = array(
                        'todo_task_text' => $todo_task['todo_task_text'],
                        'todo_ticket_id' => $todo_ticket_id,
                        'todo_task_project_id' => $todo_task['todo_task_project_id'],
                        'todo_task_number_of_hours' => $todo_task['todo_task_number_of_hours'],
                        'todo_task_created_user_id' => $this->session->userdata('user_id'),
                        'todo_task_created_date' => $todo_task['todo_task_created_date'],
                        'todo_task_deadline' => $todo_task['todo_task_deadline'],
                        'todo_ticket_todo_task_id' => $todo_task['todo_ticket_todo_task_id']
                    );

                    if(!empty($todo_task['todo_task_document_link'])){
                        $data['todo_task_document_link'] = $todo_task['todo_task_document_link'];
                    }

                    if(!empty($todo_task['todo_task_number_of_hours_manager'])){
                        $data['todo_task_number_of_hours_manager'] = $todo_task['todo_task_number_of_hours_manager'];
                        $data['todo_task_number_of_hours'] = $todo_task['todo_task_number_of_hours_manager'];
                    }
                    $this->db->insert('ip_todo_tasks', $data);
               }
           }
    }
}

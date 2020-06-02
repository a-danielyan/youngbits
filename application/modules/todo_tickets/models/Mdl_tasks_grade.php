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
 * Class Mdl_Tax_Rates
 */
class Mdl_Tasks_grade extends Response_Model
{
    public $table = 'ip_todo_tasks_grade';
    public $primary_key = 'ip_todo_tasks_grade.id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *, ip_users.user_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_todo_tasks_grade.task_created_date', 'DESC');
    }


    public function default_join()
    {
        $this->db->join('ip_todo_tickets', 'ip_todo_tickets.todo_ticket_id = ip_todo_tasks_grade.ticket_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_todo_tasks_grade.user_id', 'left');
    }


    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'task_grade' => array(
                'field' => 'task_grade',
                'label' => trans('task_grade'),
                'rules' => 'required|integer'
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => trans('ticket_user'),
            ),
            'ticket_id' => array(
                'field' => 'ticket_id',
                'label' => trans('ticket_id'),
            ),
            'task_id' => array(
                'field' => 'task_id',
                'label' => trans('task_id'),
            )
        );
    }

    public function save_todo_task_grade($ticket_id, $task_id, $user_id, $grade){
        $task_created_date = date('Y-m-d H:i:s');
        $data = array('ticket_id' => $ticket_id, 'ip_todo_tasks_grade.user_id' => $user_id, 'task_id' => $task_id,);
        $issetGrade = $this->where($data)->get()->row();

        $data['task_created_date'] = $task_created_date;
        $data['task_grade'] = $grade;

        if(empty($issetGrade)) {
            $this->db->insert($this->table, $data);
        } else {
            $this->db->set(array('task_grade' => $grade));
            $this->db->where('id', $issetGrade->id);
            $this->db->update($this->table);
        }
        return true;
    }

}

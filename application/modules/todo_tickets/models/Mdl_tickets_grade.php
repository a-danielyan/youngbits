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
class Mdl_Tickets_grade extends Response_Model
{
    public $table = 'ip_todo_tickets_grade';
    public $primary_key = 'ip_todo_tickets_grade.id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *, ip_users.user_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_todo_tickets_grade.ticket_created_date', 'DESC');
    }


    public function default_join()
    {
        $this->db->join('ip_users', 'ip_users.user_id = ip_todo_tickets_grade.user_id', 'left');
    }


    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'ticket_grade' => array(
                'field' => 'ticket_grade',
                'label' => trans('ticket_grade'),
                'rules' => 'required|integer'
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => trans('ticket_user'),
            ),
            'ticket_id' => array(
                'field' => 'ticket_id',
                'label' => trans('ticket_id'),
            )
        );
    }

    public function save_todo_grade($ticket_id, $user_id, $grade){
        $ticket_created_date = date('Y-m-d H:i:s');
        $data = array('ticket_id' => $ticket_id, 'ip_todo_tickets_grade.user_id' => $user_id);
        $issetGrade = $this->where($data)->get()->row();

        $data['ticket_created_date'] = $ticket_created_date;
        $data['ticket_grade'] = $grade;

        if(empty($issetGrade)) {
            $this->db->insert($this->table, $data);
        } else {
            $this->db->set(array('ticket_grade' => $grade));
            $this->db->where('id', $issetGrade->id);
            $this->db->update($this->table);
        }
        return true;
    }

}

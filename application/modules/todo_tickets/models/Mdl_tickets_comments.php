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
class Mdl_Tickets_comments extends Response_Model
{
    public $table = 'ip_todo_tickets_comments';
    public $primary_key = 'ip_todo_tickets_comments.ticket_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *, ip_users.user_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_todo_tickets_comments.ticket_created_date', 'DESC');
    }


    public function default_join()
    {
        $this->db->join('ip_users', 'ip_users.user_id = ip_todo_tickets_comments.ticket_user_id', 'left');
    }


    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'ticket_comment' => array(
                'field' => 'ticket_comment',
                'label' => trans('ticket_name'),
                'rules' => 'required'
            ),
            'ticket_user_id' => array(
                'field' => 'ticket_user_id',
                'label' => trans('ticket_user'),
            ),
            'ticket_id' => array(
                'field' => 'ticket_id',
                'label' => trans('ticket_id'),
            ),
            'ticket_created_date' => array(
                'field' => 'ticket_created_date',
                'label' => trans('ticket_created_date'),
            ),
        );
    }

    public function insert_todo_comments($todo_comments){
        if(!empty($todo_comments))
            $todo_comments['ticket_created_date'] = date('Y-m-d H:i:s');
            $this->db->insert('ip_todo_tickets_comments', $todo_comments);
            return $this->db->insert_id();
    }

}

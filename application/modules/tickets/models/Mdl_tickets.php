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
class Mdl_Tickets extends Response_Model
{
    public $table = 'ip_tickets';
    public $primary_key = 'ip_tickets.ticket_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,
          cu.user_name as ticket_created_user_name, 
          au.user_name as ticket_assigned_user_name, 
          ip_clients.client_name,
          ip_projects.project_name,
          ip_projects.client_id AS project_client_id
        ', false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'ticket_name';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_tickets.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_tickets.project_id', 'left');
        $this->db->join('ip_users cu', 'cu.user_id = ip_tickets.ticket_created_user_id', 'left');
        $this->db->join('ip_users au', 'au.user_id = ip_tickets.ticket_assigned_user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_tickets.client_id', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('ip_tickets.ticket_id', 'DESC');
        return $this;
    }

    /**
     * @param string $match
     */
    public function by_ticket($match)
    {
        $this->db->like('ticket_name', $match);
        $this->db->or_like('ticket_description', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'ticket_name' => array(
                'field' => 'ticket_name',
                'label' => trans('ticket_name'),
                'rules' => 'required'
            ),
            'ticket_description' => array(
                'field' => 'ticket_description',
                'label' => trans('ticket_description'),
                'rules' => ''
            ),
            'ticket_status' => array(
                'field' => 'ticket_status',
                'label' => trans('status'),
                'rules' => ''
            ),
            'ticket_assigned_user_id' => array(
                'field' => 'ticket_assigned_user_id',
                'label' => trans('assign_to'),
                'rules' => ''
            ),
            'ticket_created_user_id' => array(
                'field' => 'ticket_created_user_id',
                'label' => trans('ticket_created_by'),
                'rules' => ''
            ),
            'ticket_insert_time' => array(
                'field' => 'ticket_insert_time',
                'label' => trans('ticket_insert_time'),
                'rules' => ''
            ),
            'project_id' => array(
                'field' => 'project_id',
                'label' => trans('project'),
                'rules' => ''
            ),
            'client_id' => array(
                'field' => 'client_id',
                'label' => trans('client'),
                'rules' => ''
            ),
            'ticket_number' => array(
                'field' => 'ticket_number',
                'label' => trans('ticket_number'),
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
     * @param integer $ticket_id
     */
    public function update_status($new_status, $ticket_id)
    {
        $statuses_ok = $this->statuses();
        if (isset($statuses_ok[$new_status])) {
            parent::save($ticket_id, array('ticket_status' => $new_status));
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
        $this->filter_where('ticket_status', 0);
        return $this;
    }

    public function is_accepted()
    {
        $this->filter_where('ticket_status', 2);
        return $this;
    }

    public function is_closed()
    {
        $this->filter_where('ticket_status', 1);
        return $this;
    }

    public function is_within_guarantee_warranty()
    {
        $this->filter_where('ticket_status', 3);
        return $this;
    }
    //merge index, si form
}

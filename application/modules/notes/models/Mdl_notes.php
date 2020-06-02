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
 * Class Mdl_Notes
 */
class Mdl_Notes extends Response_Model {

    public $table = 'ip_notes';
    public $primary_key = 'ip_notes.notes_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,
          (CASE WHEN DATEDIFF(NOW(), ip_notes.created_date) > 0 THEN 1 ELSE 0 END) is_overdue,
           ip_projects.*', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_projects.project_id, ip_notes.created_date','DESC');

    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_notes.project_id = ip_projects.project_id', 'left');

//        $this->db->join('ip_projects', 'ip_projects.project_id = ip_notes.project_id', 'left');

    }

    public function get_latest()
    {
        $this->db->order_by('ip_notes.notes_id', 'DESC');
        return $this;
    }

    /**
     * @param string $match
     */
    public function by_notes($match)
    {
        $this->db->like('notes_title', $match);
        $this->db->or_like('notes_description', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'notes_title' => array(
                'field' => 'notes_title',
                'label' => trans('Title'),
                'rules' => 'required'
            ),
            'notes_description' => array(
                'field' => 'notes_description',
                'label' => trans('Description'),
                'rules' => ''
            ),
            'project_id' => array(
                'field' => 'project_id',
                'label' => trans('Project'),
                'rules' => 'required'
            ),
            'note_status' => array(
                'field' => 'note_status',
                'label' => lang('status')
            ),
            'notes_category' => array(
                'field' => 'notes_category',
                'label' => lang('note_category')
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        $db_array['created_date'] = date('Y-m-d');
        $db_array['created_time'] = date('H:i:s');
        if($this->input->post('notes_url_key') == null){
            $db_array['notes_url_key'] =$this->get_url_key();
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
            parent::set_form_value('created_date', date('Y-m-d'));
        }



        return true;
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }

    public function update_status($new_status, $note_id)
    {
        $statuses_ok = $this->statuses();
        if (isset($statuses_ok[$new_status])) {
            parent::save($note_id, array('note_status' => $new_status));
        }
    }

    public function statuses()
    {
        return array(
            '0' => array(
                'label' => trans('not_started'),
                'class' => 'draft'
            ),
            '1' => array(
                'label' => trans('not_started'),
                'class' => 'draft'
            ),
            '2' => array(
                'label' => trans('in_progress'),
                'class' => 'viewed'
            ),
            '3' => array(
                'label' => trans('complete'),
                'class' => 'sent'
            ),
            '4' => array(
                'label' => trans('invoiced'),
                'class' => 'paid'
            ),
            '5' => array(
                'label' => trans('quoted'),
                'class' => 'paid'
            )
        );
    }
}
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
 * Class Mdl_Projects
 */
class Mdl_Projects extends Response_Model
{
    public $table = 'ip_projects';
    public $primary_key = 'ip_projects.project_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *, ip_projects.project_id,ip_tasks.task_id', false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'project_id';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_projects.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
        $this->db->group_by('ip_projects.project_id');
    }

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_projects.client_id', 'left');
        $this->db->join('ip_tasks', 'ip_tasks.project_id = ip_projects.project_id', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('ip_projects.project_id', 'DESC');

        return $this;
    }

    public function read_groups_for_project($project_id = 0)
    {
        $this->db->select(
            'ip_projects_groups.project_id,
             ip_projects_groups.group_id',
            false);
        $this->db->from('ip_projects_groups');
        if ($project_id != 0) {
            $this->db->where('ip_projects_groups.project_id', $project_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'project_name' => array(
                'field' => 'project_name',
                'label' => trans('project_name'),
                'rules' => 'required'
            ),
            'client_id' => array(
                'field' => 'client_id',
                'label' => trans('client'),
                'rules' => 'required'
            ),
            'project_group_id' => array(
                'field' => 'project_group_id',
                'label' => trans('group_name'),
            ),
            'project_notes_key' => array(
                'field' => 'project_notes_key',
                'label' => trans('project_notes_key'),
            ),
            'project_guest_pass' => array(
                'field' => 'project_guest_pass',
                'label' => trans('project_guest_pass'),
            ),
            'project_url_google_drive' => array(
                'field' => 'project_url_google_drive',
                'label' => trans('project_url_google_drive'),
            ),
            'project_url_trello' => array(
                'field' => 'project_url_trello',
                'label' => trans('project_url_trello'),
            ),
            'project_description' => array(
                'field' => 'project_description',
                'label' => trans('project_description'),
            ),
            'project_image_url' => array(
                'field' => 'project_image_url',
                'label' => trans('project_image_url'),
            ),
            'project_financial_needs' => array(
                'field' => 'project_financial_needs',
                'label' => trans('project_financial_needs'),
            ),
        );
    }

    public function save($id = NULL, $db_array = NULL)
    {
        $group_ids = array();
        if ($this->input->post('project_group_id')) {
            $group_ids = $this->input->post('project_group_id');
            unset($_POST['project_group_id']);
        }
        $db_array =[];
        $db_array['project_name'] = $this->input->post('project_name');
        $db_array['client_id'] = $this->input->post('client_id');
        $db_array['created_date'] = date('Y-m-d H:i:s');
        $db_array['project_guest_pass'] = $this->input->post('project_guest_pass');
        $db_array['project_url_google_drive'] = $this->input->post('project_url_google_drive');
        $db_array['project_url_trello'] = $this->input->post('project_url_trello');
        $db_array['project_image_url'] = $this->input->post('project_image_url');
        $db_array['project_description'] = $this->input->post('project_description');
        $db_array['project_financial_needs'] = $this->input->post('project_financial_needs');

        if(empty($this->input->post('project_notes_key'))){
            $db_array['project_notes_key'] =$this->get_url_key();
        }

        $id = parent::save($id,$db_array);
        //delete old project groups which are removed
        $this->db->where('project_id', $id);
        $this->db->where_not_in('group_id', $group_ids);
        $this->db->delete('ip_projects_groups');

        if (count($group_ids) > 0) {
            $select_data_array = array();
            foreach ($group_ids as $group_id) {
                array_push($select_data_array, "SELECT " . $id . " AS project_id, " . $group_id . " AS group_id ");
            }

            $query_string = "INSERT INTO ip_projects_groups
                (project_id, group_id)
                SELECT * FROM ( " . implode(' UNION ALL ', $select_data_array) . ") as tmp
                    WHERE (project_id, group_id) NOT IN  (
                     SELECT project_id, group_id FROM ip_projects_groups
                    )";
            $this->db->query($query_string);
        }

        return $id;
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }


    public function get_tasks($project_id)
    {
        $result = array();

        if (!$project_id) {
            return $result;
        }


        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        return $result;
    }


    public function get_projectname_by_id($id){

        $this->db->select('project_name');
        $this->db->where('project_id', $id);
        $query = $this->db->get('ip_projects')->row();
        if(!empty($query)){
            $project_name = $query->project_name;
        }
        else{
            $project_name = '';
        }

        return $project_name;
    }

}

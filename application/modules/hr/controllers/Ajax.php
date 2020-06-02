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
 * Class Ajax
 */
class Ajax extends Custom_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
    }


    public function name_query()
    {
        // Load the model & helper
        $this->load->model('hr/mdl_hr');

        $response = array();

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchHrs = $this->input->get('permissive_search_hrs');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of hrs names
        $permissiveSearchHrs ? $moreHrsQuery = '%' : $moreHrsQuery = '';

        // Search for hrs
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $hrs = $this->mdl_hr
            ->where('hr_active', 1)
            ->having('hr_name LIKE \'' . $moreHrsQuery . $escapedQuery . '%\'')
            ->or_having('hr_surname LIKE \'' . $moreHrsQuery . $escapedQuery . '%\'')
            ->or_having('hr_fullname LIKE \'' . $moreHrsQuery . $escapedQuery . '%\'')
            ->order_by('hr_name')
            ->get()
            ->result();

        foreach ($hrs as $hr) {
            $response[] = array(
                'id' => $hr->hr_id,
                'text' => htmlsc(format_hr($hr)),
            );
        }

        // Return the results
        echo json_encode($response);
    }

    public function save_preference_permissive_search_hrs()
    {
        $this->load->model('mdl_settings');
        $permissiveSearchHrs = $this->input->get('permissive_search_hrs');

        if (!preg_match('!^[0-1]{1}$!', $permissiveSearchHrs)) {
            exit;
        }

        $this->mdl_settings->save('enable_permissive_search_hrs', $permissiveSearchHrs);
    }

    public function save_hr_note()
    {
        $this->load->model('hr/mdl_hr_notes');

        if ($this->mdl_hr_notes->run_validation()) {
            $this->mdl_hr_notes->save();

            $response = array(
                'success' => 1,
                'new_token' => $this->security->get_csrf_hash(),
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'new_token' => $this->security->get_csrf_hash(),
                'validation_errors' => json_errors(),
            );
        }

        echo json_encode($response);
    }

    public function load_hr_notes()
    {
        $this->load->model('hr/mdl_hr_notes');
        $data = array(
            'hr_notes' => $this->mdl_hr_notes->where('hr_id',
                $this->input->post('hr_id'))->get()->result()
        );

        $this->layout->load_view('hr/partial_notes', $data);
    }

}

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
class Ajax extends NormalUser_Controller
{
    public $ajax_controller = true;

    public function name_query()
    {
        // Load the model & helper
        $this->load->model('targets/mdl_targets');

        $response = array();

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchtargets = $this->input->get('permissive_search_targets');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of targets names
        $permissiveSearchtargets ? $moretargetsQuery = '%' : $moretargetsQuery = '';

        // Search for targets
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $targets = $this->mdl_targets
            ->where('target_active', 1)
            ->having('target_name LIKE \'' . $moretargetsQuery . $escapedQuery . '%\'')
            ->or_having('target_surname LIKE \'' . $moretargetsQuery . $escapedQuery . '%\'')
            ->or_having('target_fullname LIKE \'' . $moretargetsQuery . $escapedQuery . '%\'')
            ->order_by('target_name')
            ->get()
            ->result();

        foreach ($targets as $target) {
            $response[] = array(
                'id' => $target->target_id,
                'text' => htmlsc(format_target($target)),
            );
        }

        // Return the results
        echo json_encode($response);
    }

    public function save_target_note()
    {
        $this->load->model('targets/mdl_target_notes');

        if ($this->mdl_target_notes->run_validation()) {
            $this->mdl_target_notes->save();

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

    public function load_target_notes()
    {
        $this->load->model('targets/mdl_target_notes');
        $data = array(
            'target_notes' => $this->mdl_target_notes->where('target_id',
                $this->input->post('target_id'))->get()->result()
        );

        $this->layout->load_view('targets/partial_notes', $data);
    }

}

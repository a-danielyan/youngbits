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
        $this->load->model('leads/mdl_leads');

        $response = array();

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchleads = $this->input->get('permissive_search_leads');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of leads names
        $permissiveSearchleads ? $moreleadsQuery = '%' : $moreleadsQuery = '';

        // Search for leads
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $leads = $this->mdl_leads
            ->where('lead_active', 1)
            ->having('lead_name LIKE \'' . $moreleadsQuery . $escapedQuery . '%\'')
            ->or_having('lead_surname LIKE \'' . $moreleadsQuery . $escapedQuery . '%\'')
            ->or_having('lead_fullname LIKE \'' . $moreleadsQuery . $escapedQuery . '%\'')
            ->order_by('lead_name')
            ->get()
            ->result();

        foreach ($leads as $lead) {
            $response[] = array(
                'id' => $lead->lead_id,
                'text' => htmlsc(format_lead($lead)),
            );
        }

        // Return the results
        echo json_encode($response);
    }

    public function save_lead_note()
    {
        $this->load->model('leads/mdl_lead_notes');

        if ($this->mdl_lead_notes->run_validation()) {
            $this->mdl_lead_notes->save();

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

    public function load_lead_notes()
    {
        $this->load->model('leads/mdl_lead_notes');
        $data = array(
            'lead_notes' => $this->mdl_lead_notes->where('lead_id',
                $this->input->post('lead_id'))->get()->result()
        );

        $this->layout->load_view('leads/partial_notes', $data);
    }

}

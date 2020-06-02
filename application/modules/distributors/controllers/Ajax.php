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
        $this->load->model('distributors/mdl_distributors');

        $response = array();

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchdistributors = $this->input->get('permissive_search_distributors');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of distributors names
        $permissiveSearchdistributors ? $moredistributorsQuery = '%' : $moredistributorsQuery = '';

        // Search for distributors
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $distributors = $this->mdl_distributors
            ->where('distributor_active', 1)
            ->having('distributor_name LIKE \'' . $moredistributorsQuery . $escapedQuery . '%\'')
            ->or_having('distributor_surname LIKE \'' . $moredistributorsQuery . $escapedQuery . '%\'')
            ->or_having('distributor_fullname LIKE \'' . $moredistributorsQuery . $escapedQuery . '%\'')
            ->order_by('distributor_name')
            ->get()
            ->result();

        foreach ($distributors as $distributor) {
            $response[] = array(
                'id' => $distributor->distributor_id,
                'text' => htmlsc(format_distributor($distributor)),
            );
        }

        // Return the results
        echo json_encode($response);
    }

    public function save_distributor_note()
    {
        $this->load->model('distributors/mdl_distributor_notes');

        if ($this->mdl_distributor_notes->run_validation()) {
            $this->mdl_distributor_notes->save();

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

    public function load_distributor_notes()
    {
        $this->load->model('distributors/mdl_distributor_notes');
        $data = array(
            'distributor_notes' => $this->mdl_distributor_notes->where('distributor_id',
                $this->input->post('distributor_id'))->get()->result()
        );

        $this->layout->load_view('distributors/partial_notes', $data);
    }

}

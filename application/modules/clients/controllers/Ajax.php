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
        $this->load->model('clients/mdl_clients');

        $response = array();

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchClients = $this->input->get('permissive_search_clients');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of clients names
        $permissiveSearchClients ? $moreClientsQuery = '%' : $moreClientsQuery = '';

        // Search for clients
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $clients;
        if ($this->session->userdata('user_type') <> TYPE_ADMIN) {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));

           $clients = $this->mdl_clients
               ->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))
               ->where('client_active', 1)
               ->having('client_name LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
               ->or_having('client_surname LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
               ->or_having('client_fullname LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
               ->order_by('client_name')
               ->get()
               ->result();
        }
        else
        {
            $clients = $this->mdl_clients
                ->where('client_active', 1)
                ->having('client_name LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
                ->or_having('client_surname LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
                ->or_having('client_fullname LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
                ->order_by('client_name')
                ->get()
                ->result();
        }

        foreach ($clients as $client) {
            $response[] = array(
                'id' => $client->client_id,
                'text' => htmlsc(format_client($client)),
            );
        }

        // Return the results
        echo json_encode($response);
    }

    public function save_preference_permissive_search_clients()
    {
        $this->load->model('mdl_settings');
        $permissiveSearchClients = $this->input->get('permissive_search_clients');

        if (!preg_match('!^[0-1]{1}$!', $permissiveSearchClients)) {
            exit;
        }

        $this->mdl_settings->save('enable_permissive_search_clients', $permissiveSearchClients);
    }

    public function save_client_note()
    {
        $this->load->model('clients/mdl_client_notes');

        if ($this->mdl_client_notes->run_validation()) {
            $this->mdl_client_notes->save();

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

    public function load_client_notes()
    {
        $this->load->model('clients/mdl_client_notes');
        $data = array(
            'client_notes' => $this->mdl_client_notes->where('client_id',
                $this->input->post('client_id'))->get()->result()
        );

        $this->layout->load_view('clients/partial_notes', $data);
    }



}

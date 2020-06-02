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

class Ajax extends NormalUser_Controller
{
    public function save_project_note()
    {
        $this->load->model('projects/mdl_projects_notes');

        if ($this->mdl_projects_notes->run_validation()) {
            $this->mdl_projects_notes->save();

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

    public function load_project_notes()
    {
        $this->load->model('projects/mdl_projects_notes');
        $data = array(
            'projects_notes' => $this->mdl_projects_notes->where('project_id',
                $this->input->post('project_id'))->get()->result()
        );

        $this->layout->load_view('projects/partial_project', $data);
    }
}

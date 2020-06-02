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
 * Class fleets
 */
class Fleets extends Custom_Controller {

	/**
     * fleets constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN));

        parent::__construct($users);
        $this->load->model('mdl_fleets');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_fleets->paginate(site_url('fleets/index'), $page);
        $fleets = $this->mdl_fleets->result();

        $this->layout->set('fleets', $fleets);
        $this->layout->buffer('content', 'fleets/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if( in_array($this->session->userdata('user_type'), array(TYPE_FREELANCERS, TYPE_EMPLOYEES))){
            redirect('dashboard');
        }
        if ($this->input->post('btn_cancel')) {
            redirect('fleets');
        }

        if ($this->mdl_fleets->run_validation()) {
            $this->mdl_fleets->save($id);
            redirect('fleets');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_fleets->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }

        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->layout->set(
            array(
                /*'projects' => $this->mdl_projects->get()->result(),
                'fleets_statuses' => $this->mdl_fleets->statuses(),*/
            )
        );

        $this->layout->buffer('content', 'fleets/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_fleets->delete($id);
        redirect('fleets');
    }

}

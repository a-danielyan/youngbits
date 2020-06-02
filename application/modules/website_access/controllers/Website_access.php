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
 * Class Settings
 */
class Website_access extends Admin_Controller
{
    /**
     * Settings constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_website_access');
        $this->load->library('crypt');
        $this->load->library('form_validation');
    }




    public function index($page = 0)
    {


        redirect('website_access/status/all');


    }


    public function status($status = 'all', $page = 0){

        // Determine which group of quotes to load
        switch ($status) {
            case 'no_website':
                $this->mdl_website_access->no_website();
                break;
            case 'wordpress_website':
                $this->mdl_website_access->wordpress_website();
                break;
            case 'other_website':
                $this->mdl_website_access->other_website();
                break;
        }

        // Get all companies
        $this->mdl_website_access->paginate(site_url('website_access/status/' . $status), $page);

        $website_access = $this->mdl_website_access->result();

        $this->layout->set(
            array(
                'website_access' => $website_access,
                'status' => $status
            )
        );



        $this->layout->buffer('content', 'website_access/index');
        $this->layout->render();
    }




    public function form($id = null)
    {

        $this->load->model('clients/mdl_clients');
        if ($this->input->post('btn_cancel')) {
            redirect('website_access');
        }

        if ($this->mdl_website_access->run_validation()) {


            $id = $this->mdl_website_access->save($id);
            redirect('website_access');

        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_website_access->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }


        $this->load->model('projects/mdl_projects');
        $projects = $this->mdl_projects->get()->result();


        $this->layout->set(
            array(
                'clients' => $this->mdl_clients->where('client_active', 1)->get()->result(),
                'projects' => $projects,
                'website_access_status' => $this->mdl_website_access->statuses(),
            )
        );

        $this->layout->buffer('content', 'website_access/form');
        $this->layout->render();


    }

    /**
     * @param $id
     */
    public function delete($id)
    {

        $this->mdl_website_access->delete($id);
        redirect('website_access');
    }

}

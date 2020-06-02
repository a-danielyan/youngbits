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
class Companies extends Admin_Controller
{
    /**
     * Settings constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_companies');
        $this->load->library('crypt');
        $this->load->library('form_validation');
    }

    public function index($page = 0)
    {

        // Load required resources
        $this->load->helper('country');

        // Get all companies
        $this->mdl_companies->paginate(site_url('companies'), $page);
        $companies = $this->mdl_companies->result();
        // Set data in the layout
        $this->layout->set(
            array(
                'countries' => get_country_list(trans('cldr')),
                'companies' => $companies
            )
        );



        $this->layout->buffer('content', 'companies/index');
        $this->layout->render();
    }

    public function add()
    {
        $this->load->helper('country');
        $this->layout->set(
            array(
                'countries' => get_country_list(trans('cldr')),
            )
        );

        $this->layout->buffer('content', 'companies/form');
        $this->layout->render();
    }

    public function edit($id = 0)
    {
        if($id){
            $company = $this->mdl_companies->getCompany($id);
            $this->load->helper('country');
            $this->layout->set(
                array(
                    'countries' => get_country_list(trans('cldr')),
                    'company' => $company
                )
            );

            $this->layout->buffer('content', 'companies/edit');
            $this->layout->render();

        }else{
            redirect('companies');
        }
    }

    public function editCompany($id = 0)
    {
        if($id){
            $data = $this->input->post();
            if($data){
                if(isset($_FILES['logo']) && $_FILES['logo']['name'] != ''){
                    $data['logo'] = $this->uploadLogo();
                }
                if($this->mdl_companies->editCompany($id, $data)){
                    $this->session->set_flashdata('alert_success', lang('company_updated'));
                }else{
                    $this->session->set_flashdata('alert_warning', lang('error_editing_company'));

                }
            }
        }
        redirect('companies');

    }

    public function addCompany()
    {
        $data = $this->input->post();
        if($data){
            $data['logo'] = '';
            if(isset($_FILES['logo']) && $_FILES['logo']['name'] != ''){
                $data['logo'] = $this->uploadLogo();
            }
            if($this->mdl_companies->addCompany($data)){
                $this->session->set_flashdata('alert_success', lang('company_added'));
            }else{
                $this->session->set_flashdata('alert_success', lang('error_adding_company'));

            }
        }

        redirect('companies');
    }

    public function uploadLogo()
    {
        $upload_config = array(
            'upload_path' => './uploads/',
            'allowed_types' => 'gif|jpg|jpeg|png|svg',
            'max_size' => '9999',
            'max_width' => '9999',
            'max_height' => '9999',
            'encrypt_name' => true
        );

        if (!empty($_FILES['logo']) && $_FILES['logo']['name']) {
            $this->load->library('upload', $upload_config);

            if (!$this->upload->do_upload('logo')) {
                $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                redirect('companies');
            }

            $upload_data = $this->upload->data();

            return $upload_data['file_name'];
        }
    }

    public function delete($id = 0)
    {
        if($id){
            $this->mdl_companies->delete($id);
            redirect('companies');
        }
    }
}

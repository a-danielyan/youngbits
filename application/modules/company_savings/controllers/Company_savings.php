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
 * Class Units
 */
class Company_savings extends Admin_Controller
{
    /**
     * Units constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_company_savings');
    }

    /**
     * @param int $page
     */
    public function index()
    {

        $success = [TYPE_EMPLOYEES,TYPE_FREELANCERS];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $company_savings = $this->mdl_company_savings->select('ip_company_savings.*,ip_users.user_name')->join('ip_users', 'company_saving_created_by = ip_users.user_id')->get()->result();

        $this->layout->set('company_savings', $company_savings);
        $this->layout->buffer('content', 'company_savings/index');
        $this->layout->render();

    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('company_savings');
        }

        if ($this->mdl_company_savings->run_validation()) {
            // Get the db array
            $db_array = $this->mdl_company_savings->db_array();
            $this->mdl_company_savings->save($id, $db_array);
            redirect('company_savings');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_company_savings->prep_form($id)) {
                show_404();
            }
        }

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS){
            $this->layout->buffer('content', 'company_savings/form');
            $this->layout->render();
        }else{
            redirect('company_savings');
        }

    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_company_savings->delete($id);
        redirect('company_savings');
    }

}

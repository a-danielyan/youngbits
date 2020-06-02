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
 * Class commission_rates
 */
class Commission_Rates extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_commission_rates');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_commission_rates->where('commission_rate_user_id',$this->session->userdata('user_id'))->paginate(site_url('commission_rates/index'), $page);
        $commission_rates = $this->mdl_commission_rates->result();
        $this->layout->set('commission_rates', $commission_rates);
        $this->layout->buffer('content', 'commission_rates/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('commission_rates');
        }

        if ($this->mdl_commission_rates->run_validation()) {
            $this->mdl_commission_rates->form_values['commission_rate_percent'] = standardize_amount($this->mdl_commission_rates->form_values['commission_rate_percent']);

            // We need to use the correct decimal point for sql IPT-310
            $db_array = $this->mdl_commission_rates->db_array();
            $db_array['commission_rate_percent'] = standardize_amount($this->input->post('commission_rate_percent'));
            $db_array['commission_rate_user_id'] = $this->session->userdata('user_id');
            $db_array['commission_rate_created'] = date('Y-m-d H-i-s');
            if(!empty($this->input->post('commission_rate_default'))){
                $this->mdl_commission_rates->default_commission_rate($this->session->userdata('user_id'));
                $db_array['commission_rate_default'] = $this->input->post('commission_rate_default');
            }


            $this->mdl_commission_rates->save($id, $db_array);

            redirect('commission_rates');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_commission_rates->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->buffer('content', 'commission_rates/form');
        $this->layout->render();
    }




    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_commission_rates->delete($id);
        redirect('commission_rates');
    }

}

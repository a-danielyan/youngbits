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
 * Class Expertises
 */
class Expertises extends NormalUser_Controller
{
    /**
     * Expertises constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_expertises');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $this->mdl_expertises->paginate(site_url('expertises/index'), $page);
        $expertises = $this->mdl_expertises->result();

        $this->layout->set('expertises', $expertises);
        $this->layout->buffer('content', 'expertises/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {




        if($this->input->post('expertise_name')){
            $expertise =  $this->mdl_expertises->where('expertise_name',$this->input->post('expertise_name'))->get()->row();
            if(!empty($expertise)){
                $this->session->set_flashdata('alert_error', '"'.$this->input->post('expertise_name').'" already exists');
                redirect('expertises/form');
            }

        }

        if ($this->input->post('btn_cancel')) {
            redirect('expertises');
        }



        if ($this->mdl_expertises->run_validation()) {

            $this->mdl_expertises->save($id);
            redirect('expertises');
        }
        if(!empty($id)){
            $expertise = $this->mdl_expertises->get_by_id($id);;
            $success = [TYPE_ADMIN,TYPE_MANAGERS];
            if(!in_array($this->session->userdata('user_type'),$success)){
                if($expertise->expertise_created_user_id !== $this->session->userdata('user_id'))
                    redirect('expertises');
            }


        }
        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_expertises->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->buffer('content', 'expertises/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_expertises->delete($id);
        redirect('expertises');
    }

}

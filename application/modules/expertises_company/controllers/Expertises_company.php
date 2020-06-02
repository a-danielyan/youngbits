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
class Expertises_company extends NormalUser_Controller
{
    /**
     * Expertises constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('expertises/mdl_expertises');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->load->model('user_groups/mdl_user_groups');

        $this->mdl_user_groups->where('group_name !=','all')->paginate(site_url('expertises_company/index'), $page);
        $expertises = $this->mdl_expertises->get()->result();

        $users_groups = $this->mdl_user_groups->result();




        $this->layout->set('expertises_company', $expertises);
        $this->layout->set('users_groups', $users_groups);
        $this->layout->buffer('content', 'expertises_company/index');
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
                redirect('expertises_company/form');
            }

        }

        if ($this->input->post('btn_cancel')) {
            redirect('expertises_company');
        }



        if ($this->mdl_expertises->run_validation()) {

            $this->mdl_expertises->save($id);
            redirect('expertises_company');
        }
        if(!empty($id)){
            $expertise = $this->mdl_expertises->get_by_id($id);;
            $success = [TYPE_ADMIN,TYPE_MANAGERS];
            if(!in_array($this->session->userdata('user_type'),$success)){
                if($expertise->expertise_created_user_id !== $this->session->userdata('user_id'))
                    redirect('expertises_company');
            }


        }
        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_expertises->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->buffer('content', 'expertises_company/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function view($id)
    {
        $this->load->model('user_groups/mdl_user_groups');
        $this->load->model('users/mdl_users');
        $this->load->model('expertises/mdl_expertises');
        $user_groups = $this->mdl_user_groups->where('group_id',$id)->get()->row();

        $users = $this->mdl_users->where('user_group_id',$user_groups->group_id)->get()->result();
        $new_user_data = [];

        foreach ($users as $key => $user){
            $expertises = $this->mdl_expertises->where('expertise_created_user_id',$user->user_id)->get()->result();
            if(!is_null($expertises)){
                foreach ($expertises as $expertise) {
                    array_push($new_user_data,$expertise);
                }
            }
        }


        $this->layout->set('user_groups', $user_groups );
        $this->layout->set('users', $users );
        $this->layout->set('expertises', $new_user_data );
        $this->layout->buffer('content', 'expertises_company/view');
        $this->layout->render();

    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_expertises->delete($id);
        redirect('expertises_company');
    }

}

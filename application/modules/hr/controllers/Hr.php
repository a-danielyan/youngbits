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
 * Class Hr
 */
class Hr extends Custom_Controller
{
    /**
     * Hr constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        $access=[TYPE_MANAGERS];

        parent::__construct($users);
        if(in_array($this->session->userdata('user_type'),$access)){
            redirect('dashboard');
        }
        $this->load->model('mdl_hr');
    }

    public function index()
    {



        // Display active HR by default
        redirect('hr/employees');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }


        $this->mdl_hr->paginate(site_url('hr/status/' . $status), $page);
        $hr = $this->mdl_hr->result();

        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr'
            )
        );

        $this->layout->buffer('content', 'hr/index');
        $this->layout->render();
    }

    /**
     * @param string #all
     * @param int $page
     */
    public function all($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }

        $this->mdl_hr->is_not_type(TYPE_ADMIN)->paginate(site_url('hr/all/' . $status), $page);
        $hr = $this->mdl_hr->result();

        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr',
                'hr_type' => 'all'
            )
        );

        $this->layout->buffer('content', 'hr/index');
        $this->layout->render();
    }


    /**
     * @param string $normalusers
     * @param int $page
     */
    public function other_users($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }


        $this->mdl_hr->is_type(TYPE_ADMINISTRATOR)->paginate(site_url('hr/normalusers/' . $status), $page);
        $hr = $this->mdl_hr->result();

        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr',
                'hr_type' => 'other_users'
            )
        );

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            $this->layout->buffer('content', 'hr/index');
            $this->layout->render();
        }else {
            redirect('dashboard');
        }

    }

    /**
     * @param string $employees
     * @param int $page
     */
    public function employees($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }


        $this->mdl_hr->is_type(TYPE_EMPLOYEES)->paginate(site_url('hr/employees/' . $status), $page);
        $hr = $this->mdl_hr->result();

        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr',
                'hr_type' => 'employees'
            )
        );

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            $this->layout->buffer('content', 'hr/index');
            $this->layout->render();
        }else {
            redirect('dashboard');
        }

    }

    /**
 * @param string $freelancers
 * @param int $page
 */
    public function freelancers($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }

        $this->mdl_hr->is_type(TYPE_FREELANCERS)->paginate(site_url('hr/freelancers/' . $status), $page);
        $hr = $this->mdl_hr->result();
        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr',
                'hr_type' => 'freelancers'
            )
        );

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_ACCOUNTANT ){
            $this->layout->buffer('content', 'hr/index');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }

    }


    /**
     * @param string $promoters
     * @param int $page
     */
    public function influencers($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }

        $this->mdl_hr->is_type(TYPE_PROMOTERS)->paginate(site_url('hr/freelancers/' . $status), $page);
        $hr = $this->mdl_hr->result();
        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr',
                'hr_type' => 'Influencers'
            )
        );

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_ACCOUNTANT ){
            $this->layout->buffer('content', 'hr/index');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }

    }

    /**
     * @param string $managers
     * @param int $page
     */
    public function managers($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_hr->$function();
        }


        $this->mdl_hr->is_type(TYPE_MANAGERS)->paginate(site_url('hr/managers/' . $status), $page);
        $hr = $this->mdl_hr->result();

        $this->layout->set(
            array(
                'records' => $hr,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_hr'),
                'filter_method' => 'filter_hr',
                'hr_type' => 'managers'
            )
        );

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            $this->layout->buffer('content', 'hr/index');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }


    }


    /**
     * @param null $id
     */
    public function form($id = null)
    {

        if ($this->input->post('btn_cancel')) {

            if (!$id)
            {
                redirect('hr');
            }
            $hr = $this->mdl_hr
                ->where('ip_hrs.hr_id', $id)
                ->get()->row();

            $url = "hr";
            if ($hr) {
                if ($hr->hr_type == TYPE_MANAGERS)
                {
                    $url .= "/managers";
                }
                else if ($hr->hr_type == TYPE_MANAGERS)
                {
                    $url .= "/managers";
                }
                else if ($hr->hr_type == TYPE_INFLUANCERS)
                {
                    $url .= "/influencers";
                }
                else if ($hr->hr_type == TYPE_FREELANCERS)
                {
                    $url .= "/freelancers";
                }
                else if ($hr->hr_type == TYPE_ADMINISTRATORS)
                {
                    $url .= "/administrators";
                }
                else if ($hr->hr_type == TYPE_EMPLOYEES)
                {
                    $url .= "/employees";
                }
            }

            redirect($url);
        }
        
        $new_hr = false;
        
        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('hr_name') != '') {
            $check = $this->db->get_where('ip_hrs', array(
                'hr_name' => $this->input->post('hr_name'),
                'hr_surname' => $this->input->post('hr_surname')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('hr_already_exists'));
                redirect('hr/form');
            } else {
                $new_hr = true;
            }
        }



        if ($this->mdl_hr->run_validation()) {

            if ($_FILES['hr_profile_picture_file']['name']) {
                /*Create folder username*/
                if (!is_dir('uploads/hr_profile_picture/'.$this->input->post('hr_name'))) {
                    mkdir('./uploads/hr_profile_picture/' . $this->input->post('hr_name'), 0777, TRUE);

                }
                $new_name = time().$_FILES["hr_profile_picture_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/hr_profile_picture/'.$this->input->post('hr_name').'/',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('hr_profile_picture_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('hr');
                }

                $upload_data = $this->upload->data();


                $_POST['hr_profile_picture'] = base_url() . './uploads/hr_profile_picture/' . $this->input->post('hr_name').'/' . $upload_data['file_name'];
            }







            $id = $this->mdl_hr->save($id);

            if ($id == 0) {
                $this->session->set_flashdata('alert_error', 'Error');
                $this->session->set_flashdata('alert_success', null);
                redirect('hr/form/' . $id);
                return;
            } else {
                redirect('hr/view/' . $id);
                //redirect('hr');
            }
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_hr->prep_form($id)) {
                show_404();
            }
            $this->mdl_hr->set_form_value('is_update', true);
        }
        $this->load->model('user_groups/mdl_user_groups');
        $this->load->helper('country');

        $this->layout->set(
            array(
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_hr->form_value('hr_country') ?: get_setting('default_country'),
                'delivery_selected_country' => $this->mdl_hr->form_value('hr_country_delivery') ?: get_setting('default_country'),
                'languages' => get_available_languages(),
                'user_groups' => $this->mdl_user_groups->get()->result()
            )
        );


        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
            $this->layout->buffer('content', 'hr/form');
            $this->layout->render();
        }else{
            show_404();
        }
    }

    /**
     * @param int $hr_id
     */
    public function view($hr_id)
    {
        $this->load->model('hr/mdl_hr_notes');
        $this->load->helper('custom_values_helper');

        $hr = $this->mdl_hr
                ->where('ip_hrs.hr_id', $hr_id)
                ->get()->row();

        if (!$hr) {
            show_404();
        }

        $this->load->model('user_groups/mdl_user_groups');

        $this->layout->set(
            array(
                'hr' => $hr,
                'hr_notes' => $this->mdl_hr_notes->where('hr_id', $hr_id)->get()->result(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
            )
        );

        $this->layout->buffer(
            array(
                array(
                    'partial_notes',
                    'hr/partial_notes'
                ),
                array(
                    'content',
                    'hr/view'
                )
            )
        );

        $this->layout->render();
    }

    /**
     * @param int $hr_id
     */
    public function delete($hr_id)
    {
        $hr = $this->mdl_hr
            ->where('ip_hrs.hr_id', $hr_id)
            ->get()->row();

        $url = "hr";
        if ($hr) {
            if ($hr->hr_type == TYPE_MANAGERS)
            {
                $url .= "/managers";
            }
            else if ($hr->hr_type == TYPE_MANAGERS)
            {
                $url .= "/managers";
            }
            else if ($hr->hr_type == TYPE_INTERNS)
            {
                $url .= "/interns";
            }
            else if ($hr->hr_type == TYPE_FREELANCERS)
            {
                $url .= "/freelancers";
            }
            else if ($hr->hr_type == TYPE_ADMINISTRATORS)
            {
                $url .= "/administrators";
            }
            else if ($hr->hr_type == TYPE_EMPLOYEES)
            {
                $url .= "/employees";
            }
        }
        $this->mdl_hr->delete($hr_id);
        redirect($url);
    }

}

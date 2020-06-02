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
 * Class Appointments
 */
class Appointments_templates extends NormalUser_Controller
{
    /**
     * Appointments constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_appointments_templates');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $success = [TYPE_ADMINISTRATOR];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $this->mdl_appointments_templates->paginate(site_url('appointments_templates/index'), $page);
        $this->load->model('projects/mdl_projects');

        if($this->session->userdata('user_type') <> TYPE_ADMIN){

            $projects_groups = $this->mdl_appointments_templates->join('ip_projects_groups', 'ip_appointments_templates.project_id = ip_projects_groups.project_id', 'left');
            $appointments = $projects_groups->get()->result();

            foreach ($appointments as $key => &$appointment) {
                if (empty($appointment->group_id) || +$appointment->group_id != $this->session->userdata('user_group_id')) {
                    unset($appointments[$key]);
                }
            }
        }else{
            $appointments=$this->mdl_appointments_templates->where('`ip_appointments_templates`.`appointments_user_id`', $this->session->userdata('user_id'))->result();
        }

        $this->layout->set('appointments', $appointments);

        $this->layout->set('appointment_statuses', $this->mdl_appointments_templates->statuses());

        $this->layout->buffer('content', 'appointments_templates/index');
        $this->layout->render();


    }

    /**
     * @param null $id
     */



    public function send_email(){
        $subject = "Spudu";
        $htmlContent = '<h2 style="color: blue;">You have been invited to <a href="'.$this->input->post('appoinment_url').'">'.$this->input->post('appoinment_name').'</a> Appointment</h2>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($this->input->post('email'),$subject,$htmlContent,$headers);
    }

    public function form($id = null)
    {

        $success = [TYPE_ACCOUNTANT,TYPE_ADMINISTRATOR];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }


        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('users/mdl_users');
        $this->load->model('invoices/mdl_invoices_recurring');
        $this->load->model('products/mdl_products');

        if ($id != null){
            if ($this->session->userdata('user_type') <> TYPE_ADMIN){
                $appointment = $this->mdl_appointments_templates->get_by_id($id);
                $projects_groups = $this->mdl_projects->join('ip_projects_groups', 'ip_projects.project_id = ip_projects_groups.project_id', 'left')
                    ->where('ip_projects_groups.group_id',$this->session->userdata('user_group_id'))->get()->result();

            }
        }
        if ($this->input->post('btn_cancel')) {
            redirect('appointments_templates');
        }

        if ($this->session->userdata('user_type') != TYPE_ADMIN) {

            if ($id != null) {
                $appointment2 = $this->mdl_appointments_templates->get_by_id($id);
                if (!empty($_POST)) {
                    $_POST['multiplier'] = $appointment2->multiplier;
                }
            } else {
                if (!empty($_POST)) {
                    $_POST['multiplier'] = 1;
                }
            }
        }else{
            $projects_groups = $this->mdl_projects->get()->result();
        }
        if ($id == null && !empty($_POST))
        {

            $_POST['user_id'] = $this->session->userdata('user_id');
        }
        if ($this->mdl_appointments_templates->run_validation()) {
            if ($_FILES['appointment_file']['name']) {


                $new_name = time().$_FILES["appointment_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/appointment/',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('appointment_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('appointments_templates');
                }


                $upload_data = $this->upload->data();
                $_POST['appointment_url_document'] = base_url() . "uploads/appointment/" . $upload_data['file_name'];
            }
            $this->mdl_appointments_templates->save($id);
            redirect('appointments_templates');
        }


        if (!$this->input->post('btn_submit')) {

            $prep_form = $this->mdl_appointments_templates->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }


        $data =json_decode($this->mdl_appointments_templates->form_value('appointment_add_people'),true);
        $count_data  = (!empty($data))? count($data) : 0 ;

        $appointment_wek= json_decode($this->mdl_appointments_templates->form_value('appointment_wek'));
        if(!empty($appointment_wek)){
            foreach ($appointment_wek as $appointment_day){

                if($appointment_day == 1){
                    $data_wek['monday'] = 1;

                }else if($appointment_day == 2){
                    $data_wek['tuesday'] = 2;
                }else if($appointment_day == 3){
                    $data_wek['wednesday'] = 3;
                }elseif($appointment_day == 4){
                    $data_wek['thursday'] = 4;
                }elseif($appointment_day == 5){
                    $data_wek['friday'] = 5;
                }elseif($appointment_day == 6){
                    $data_wek['saturday'] = 6;
                }elseif($appointment_day == 7){
                    $data_wek['sunday'] = 7;
                }
            }
        }

        if(empty($data_wek)){
            $data_wek = NULL;
        }




        $this->layout->set(
            array(
                'appointment_products' =>$this->mdl_appointments_templates->form_value('appointment_product_id'),
                'recur_frequencies' => $this->mdl_invoices_recurring->recur_frequencies,
                'products' => $this->mdl_products->get()->result(),
                'data' => json_decode($this->mdl_appointments_templates->form_value('appointment_add_people')),
                'appointment_wek' => $data_wek,
                'count' => $count_data ,
                'projects' => $projects_groups,
                'users' =>  $this->mdl_users->where('user_id !=',$this->session->userdata('user_id'))->get()->result(),
                'user' => $this->mdl_users->get_by_id($this->session->userdata('user_id')),
                'appointment_statuses' => $this->mdl_appointments_templates->statuses(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );

        $this->layout->buffer('content', 'appointments_templates/form');
        $this->layout->render();
    }


    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_appointments_templates->delete($id);
        redirect('appointments_templates');
    }



    public function add_new_person(){
        $appointment_id = $this->input->post('appointment_id');

        $json_id = (int)$this->input->post('json_id');
        $appointment = $this->mdl_appointments_templates->get_appointment_by_id($appointment_id);
        $object = (Object)[];
        $object->$json_id = (Object)[
            'name' =>$this->input->post('name'),
            'email' =>$this->input->post('email')
        ];


        if (!is_null($appointment[0]->appointment_add_people) && ($appointment[0]->appointment_add_people !="{}")) {
            $json_arr = (array)(json_decode($appointment[0]->appointment_add_people));
            $json_arr[] = $object;
            $json_arr = str_replace('"0":{',"",json_encode($json_arr));
        }else {
            $json_arr = array();
            $json_arr[] = $object;
            $json_arr = json_encode((Object)$json_arr);
            $json_arr = str_replace('"0":{',"",$json_arr);
        }
        $json_arr = str_replace('}}}',"}}",$json_arr);
        $this->mdl_appointments_templates->update_appointment_by_id($appointment_id,$json_arr);
    }

    public function delete_person(){
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $appointment_id = $this->input->post('appointment_id');
        $json_id = (int)$this->input->post('json_id');
        $appointment = $this->mdl_appointments_templates->get_appointment_by_id($appointment_id);
        $json_arr = $appointment[0]->appointment_add_people;
        $string = '"'.$json_id.'"'.':{"name":'.'"'.$name.'","email":'.'"'.$email.'"}';
        $json_arr = str_replace($string,"", $json_arr);
        $json_arr = str_replace("{,","{", $json_arr);
        $this->mdl_appointments_templates->update_appointment_by_id($appointment_id,$json_arr);
    }

}

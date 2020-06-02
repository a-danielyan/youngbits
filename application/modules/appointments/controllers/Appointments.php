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
class Appointments extends NormalUser_Controller
{
    /**
     * Appointments constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_appointments');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $total_kl = $this->total_kilometers();

        if(in_array($this->session->userdata('user_type'),[TYPE_ADMIN])){
            $this->mdl_appointments->paginate(site_url('appointments/index'), $page);

        }else{
            $this->mdl_appointments->where('ip_appointments.appointment_user_id', $this->session->userdata('user_id') )->paginate(site_url('appointments/index'), $page);
        }

        $this->load->model('projects/mdl_projects');


        if($this->session->userdata('user_type') <> TYPE_ADMIN){

            $projects_groups = $this->mdl_appointments->where('ip_appointments.appointment_user_id', $this->session->userdata('user_id'))->join('ip_projects_groups', 'ip_appointments.project_id = ip_projects_groups.project_id', 'left');


            if ($this->input->get('type') && $this->input->get('field') && $this->input->get('table')) {

                $field = $this->input->get('field');
                $type = $this->input->get('type');
                $projects_groups = $projects_groups->order_by($field, $type);
            }
            $appointments = $projects_groups->result();

        }else{

            if ($this->input->get('type') && $this->input->get('field') && $this->input->get('table')) {

                $field = $this->input->get('field');
                $type = $this->input->get('type');
//                before my changes here used --------------- `ip_appointments`.`appointments_user_id`
                $appointments = $this->mdl_appointments->order_by('ip_appointments.'.$field, $type)->where(['`ip_appointments`.`appointment_user_id`' => $this->session->userdata('user_id')])->get()->result();


            } else {
//                $appointments = $this->mdl_appointments->where('`ip_appointments`.`appointment_user_id`', $this->session->userdata('user_id'))->result();
                $appointments = $this->mdl_appointments->get()->result();
            }
        }

        $this->layout->set('appointments', $appointments);
        $this->layout->set('total_kl',$total_kl);

        $this->layout->set('appointment_statuses', $this->mdl_appointments->statuses());

        $this->layout->buffer('content', 'appointments/index');
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


        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }


        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('users/mdl_users');
        $this->load->model('invoices/mdl_invoices_recurring');
        $this->load->model('products/mdl_products');
        $this->load->model('appointments_templates/mdl_appointments_templates');

        if ($id != null){
            if ($this->session->userdata('user_type') <> TYPE_ADMIN){
                $appointment = $this->mdl_appointments->get_by_id($id);
                $projects_groups = $this->mdl_projects->join('ip_projects_groups', 'ip_projects.project_id = ip_projects_groups.project_id', 'left')
                    ->where('ip_projects_groups.group_id',$this->session->userdata('user_group_id'))->get()->result();

            }
        }
        if ($this->input->post('btn_cancel')) {
            redirect('appointments');
        }

        if ($this->session->userdata('user_type') != TYPE_ADMIN) {

            if ($id != null) {
                $appointment2 = $this->mdl_appointments->get_by_id($id);
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

        if ($this->mdl_appointments->run_validation()) {
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
                    redirect('appointments');
                }


                $upload_data = $this->upload->data();
                $_POST['appointment_url_document'] = base_url() . "uploads/appointment/" . $upload_data['file_name'];
            }

            $this->mdl_appointments->save($id);
            redirect('appointments');
        }


        if (!$this->input->post('btn_submit')) {

            $prep_form = $this->mdl_appointments->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }


        $data =json_decode($this->mdl_appointments->form_value('appointment_add_people'),true);
        $count_data  = (!empty($data))? count($data) : 0 ;

        $appointment_wek= json_decode($this->mdl_appointments->form_value('appointment_wek'));
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


        if(empty($id)){
            $this->layout->set(
                array(
                    'appointment_templates' =>$this->mdl_appointments_templates->get()->result(),
                )
            );

        }

        $this->layout->set(
            array(
                'appointment_products' =>$this->mdl_appointments->form_value('appointment_product_id'),
                'recur_frequencies' => $this->mdl_invoices_recurring->recur_frequencies,
                'products' => $this->mdl_products->get()->result(),
                'data' => json_decode($this->mdl_appointments->form_value('appointment_add_people')),
                'appointment_wek' => $data_wek,
                'count' => $count_data ,
                'projects' => (!empty($projects_groups))?$projects_groups:'',
                'users' =>  $this->mdl_users->where('user_id !=',$this->session->userdata('user_id'))->get()->result(),
                'user' => $this->mdl_users->get_by_id($this->session->userdata('user_id')),
                'appointment_statuses' => $this->mdl_appointments->statuses(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );

        $this->layout->buffer('content', 'appointments/form');
        $this->layout->render();
    }

    public function select_templates(){

        $id = $_POST['template_id'];

        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('users/mdl_users');
        $this->load->model('invoices/mdl_invoices_recurring');
        $this->load->model('products/mdl_products');
        $this->load->model('appointments_templates/mdl_appointments_templates');





        $appointment = $this->mdl_appointments_templates->get_by_id($id);
        $projects_groups = $this->mdl_projects->join('ip_projects_groups', 'ip_projects.project_id = ip_projects_groups.project_id', 'left')
          ->get()->result();

        $count_data  = (!empty($data) && is_array($data))? count($data) : 0 ;


        $appointment_wek= json_decode($appointment->appointment_wek);
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














        $data = [
            'appointment_templates' =>$this->mdl_appointments_templates->get()->result(),
            'count' => $count_data ,

            'appointments' =>$appointment,
            'appointment_products' =>$this->mdl_appointments->form_value('appointment_product_id'),
            'recur_frequencies' => $this->mdl_invoices_recurring->recur_frequencies,
            'products' => $this->mdl_products->get()->result(),
            'data' => json_decode($appointment->appointment_add_people),
            'appointment_wek' => $data_wek,
            'projects' => $projects_groups,
            'user' => $this->mdl_users->get_by_id($this->session->userdata('user_id')),
            'appointment_statuses' => $this->mdl_appointments->statuses(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),

        ];

        $this->load->view('appointments/form_templates',$data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_appointments->delete($id);
        redirect('appointments');
    }

    /**
     * @param $id
     */
    public function total_kilometers($total_kl =  0)
    {
        $this->load->model('appointments/mdl_appointments');
        if(in_array($this->session->userdata('user_type'),[TYPE_ADMIN])){
            $appointments = $this->mdl_appointments->get()->result();
        }else{
            $appointments = $this->mdl_appointments->where('ip_appointments.appointment_user_id', $this->session->userdata('user_id') )->get()->result();
        }


        foreach ($appointments as $appointment){
            $total_kl += $appointment->appointment_kilometers;
        }


        if(!empty($_POST['status'])){
            echo $total_kl;
        }
        return  $total_kl;

    }

    public function add_new_person(){
        $appointment_id = $this->input->post('appointment_id');

        $json_id = (int)$this->input->post('json_id');
        $appointment = $this->mdl_appointments->get_appointment_by_id($appointment_id);
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
        $this->mdl_appointments->update_appointment_by_id($appointment_id,$json_arr);
    }

    public function delete_person(){
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $appointment_id = $this->input->post('appointment_id');
        $json_id = (int)$this->input->post('json_id');
        $appointment = $this->mdl_appointments->get_appointment_by_id($appointment_id);
        $json_arr = $appointment[0]->appointment_add_people;
        $string = '"'.$json_id.'"'.':{"name":'.'"'.$name.'","email":'.'"'.$email.'"}';
        $json_arr = str_replace($string,"", $json_arr);
        $json_arr = str_replace("{,","{", $json_arr);
        $this->mdl_appointments->update_appointment_by_id($appointment_id,$json_arr);
    }
}

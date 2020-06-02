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
 * Class Users
 */
class Users extends Admin_Controller
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_users');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        if($this->session->userdata('user_type') != TYPE_ADMIN){
            redirect('dashboard');
        }
        $this->mdl_users->paginate(site_url('users/index'), $page);
        $users = $this->mdl_users->result();

        foreach ($users as $key => $user){
            if(!is_null($user->user_expertises_id)){
                $user_expertises = unserialize($user->user_expertises_id);
                    foreach ($user_expertises as $user_expertise){
                        $user->user_expertises[] = $this->expertises_name($user_expertise);
                    }
            }
        }

        $this->layout->set('users', $users);
        $this->layout->set('user_types', $this->mdl_users->user_types());
        $this->layout->buffer('content', 'users/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function expertises_name($expertise_id){
        $this->load->model('expertises/mdl_expertises');
        $expertises =  $this->mdl_expertises->where('expertise_id',$expertise_id)->get()->row();

        return $expertises->expertise_name;
    }

    public function form($id = null)
    {
        if($this->session->userdata('user_type') != TYPE_ADMIN){
            $user = $this->mdl_users->get_by_id($id);
            if($user->user_id != $this->session->userdata('user_id'))
            redirect('dashboard');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('users');
        }

        if ($this->mdl_users->run_validation(($id) ? 'validation_rules_existing' : 'validation_rules')) {

            $files = [];
            $arr =[];


            if (!empty($_FILES['user_file']["size"][0])){


                $count = count($_FILES['user_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['user_file'.$i] = [
                        'name'=>$_FILES['user_file']['name'][$i],
                        'type'=>$_FILES['user_file']['type'][$i],
                        'tmp_name'=>$_FILES['user_file']['tmp_name'][$i],
                        'error'=>$_FILES['user_file']['error'][$i],
                        'size'=>$_FILES['user_file']['size'][$i]
                    ];
                }
                unset($_FILES['user_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/users/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);
                    $this->upload->do_upload($key);
                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/users/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['user_files'])){
                foreach ($_POST['user_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $_POST['user_document_link'] = serialize($files);
            }else{
                $_POST['user_document_link'] = '';
            }


            if(isset( $_POST['user_expertises_id'])){

                $_POST['user_expertises_id'] = serialize($this->input->post('user_expertises_id'));
            }

            $id = $this->mdl_users->save($id);
            $this->load->model('custom_fields/mdl_user_custom');
            $this->mdl_user_custom->save_custom($id, $this->input->post('custom'));

            // Update the session details if the logged in user edited his account
            if ($this->session->userdata('user_id') == $id) {
                $new_details = $this->mdl_users->get_by_id($id);

                $session_data = array(
                    'user_type' => $new_details->user_type,
                    'user_id' => $new_details->user_id,
                    'user_name' => $new_details->user_name,
                    'user_email' => $new_details->user_email,
                    'user_company' => $new_details->user_company,
                    'user_language' => isset($new_details->user_language) ? $new_details->user_language : 'system',
                );

                $this->session->set_userdata($session_data);
            }

            $this->session->unset_userdata('user_clients');

            redirect('users');
        }

        if ($id && !$this->input->post('btn_submit')) {
            if (!$this->mdl_users->prep_form($id)) {
                show_404();
            }

            $this->load->model('custom_fields/mdl_user_custom');

            $user_custom = $this->mdl_user_custom->where('user_id', $id)->get();

            if ($user_custom->num_rows()) {
                $user_custom = $user_custom->row();

                unset($user_custom->user_id, $user_custom->user_custom_id);

                foreach ($user_custom as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {


            if (!empty($_FILES['user_nda_file_post']['size'])) {
                if($_FILES['user_nda_file_post']['type'] == 'application/pdf' || $_FILES['user_nda_file_post']['type'] == 'application/msword' || $_FILES['user_nda_file_post']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
                    $new_name = uniqid() . $_FILES["user_nda_file_post"]['name'];

                    if ($id) {
                        $check = $this->db->get_where('ip_users', array('user_id' => $id))->result();
                        $old_name = $check[0]->user_nda_file;
                        if ($old_name && file_exists(UPLOADS_FOLDER . 'users/' . $old_name)) {
                            unlink(UPLOADS_FOLDER . 'users/' . $old_name);
                        }
                    }

                    move_uploaded_file($_FILES['user_nda_file_post']['tmp_name'], UPLOADS_FOLDER . 'users/' . $new_name);
                    $_POST['user_nda_file'] = $new_name;
                }else{
                    $this->session->set_flashdata('alert_error', 'Select Only pdf/doc/docx Format');
                    if($id) {
                        redirect("users/form/$id");
                    }else{
                        redirect("users/form");
                    }
                }
            }

            if (!empty($_FILES['user_file_post']['size'])) {
                if($_FILES['user_file_post']['type'] == 'application/pdf' || $_FILES['user_file_post']['type'] == 'application/msword' || $_FILES['user_file_post']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
                    $new_name = uniqid() . $_FILES["user_file_post"]['name'];

                    if ($id) {
                        $check = $this->db->get_where('ip_users', array('user_id' => $id))->result();
                        $old_name = $check[0]->user_file;
                        if ($old_name && file_exists(UPLOADS_FOLDER . 'users/' . $old_name)) {
                            unlink(UPLOADS_FOLDER . 'users/' . $old_name);
                        }
                    }

                    move_uploaded_file($_FILES['user_file_post']['tmp_name'], UPLOADS_FOLDER . 'users/' . $new_name);
                    $_POST['user_file'] = $new_name;
                }else{
                    $this->session->set_flashdata('alert_error', 'Select Only pdf/doc/docx Format');
                    if($id) {
                        redirect("users/form/$id");
                    }else{
                        redirect("users/form");
                    }
                }
            }





            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }

        $this->load->helper('custom_values');
        $this->load->model('user_clients/mdl_user_clients');
        $this->load->model('clients/mdl_clients');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_fields/mdl_user_custom');
        $this->load->model('custom_values/mdl_custom_values');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('user_groups/mdl_user_groups');
        $this->load->model('expertises/mdl_expertises');
        $this->load->helper('country');

        $custom_fields = $this->mdl_custom_fields->by_table('ip_user_custom')->get()->result();
        $custom_values = [];
        foreach ($custom_fields as $custom_field) {
            if (in_array($custom_field->custom_field_type, $this->mdl_custom_values->custom_value_fields())) {
                $values = $this->mdl_custom_values->get_by_fid($custom_field->custom_field_id)->result();
                $custom_values[$custom_field->custom_field_id] = $values;
            }
        }

        $fields = $this->mdl_user_custom->get_by_useid($id);

        foreach ($custom_fields as $cfield) {
            foreach ($fields as $fvalue) {
                if ($fvalue->user_custom_fieldid == $cfield->custom_field_id) {
                    // TODO: Hackish, may need a better optimization
                    $this->mdl_users->set_form_value(
                        'custom[' . $cfield->custom_field_id . ']',
                        $fvalue->user_custom_fieldvalue
                    );
                    break;
                }
            }
        }


        $files = $this->mdl_users->where('user_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->user_document_link);
        }else{
            $upload_files= [];
        }

        $expertises =  $this->mdl_expertises->get()->result();
        $user =  $this->mdl_users->get_by_id($id);
        $user_expertises ='';
        if (!empty($user->user_expertises_id)){
            $user_expertises = unserialize($user->user_expertises_id);
        }


        $allow_edit = true;
        if($this->session->userdata('user_type') != TYPE_ADMIN){
            $allow_edit = false;
        }


        $this->layout->set(
            array(
                'id' => $id,
                'allow_edit' =>$allow_edit,
                'user_expertises' =>$user_expertises,
                'upload_files' => $upload_files,
                'expertises' => $expertises,
                'user_types' => $this->mdl_users->user_types(),
                'user_clients' => $this->mdl_user_clients->where('ip_user_clients.user_id', $id)->get()->result(),
                'custom_fields' => $custom_fields,
                'custom_values' => $custom_values,
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_users->form_value('user_country') ?: get_setting('default_country'),
                'clients' => $this->mdl_clients->where('client_active', 1)->get()->result(),
                'languages' => get_available_languages(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
            )
        );

        $this->layout->buffer('content', 'users/form');
        $this->layout->render();
    }

    /**
     * @param $user_id
     */
    public function change_password($user_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('users');
        }

        if ($this->mdl_users->run_validation('validation_rules_change_password')) {
            $this->mdl_users->save_change_password($user_id, $this->input->post('user_password'));
            redirect('users/form/' . $user_id);
        }

        $this->layout->buffer('content', 'users/form_change_password');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        if ($id <> 1) {
            $this->mdl_users->delete($id);
        }
        redirect('users');
    }

    /**
     * @param $user_id
     * @param $user_client_id
     */
    public function delete_user_client($user_id, $user_client_id)
    {
        $this->load->model('mdl_user_clients');

        $this->mdl_user_clients->delete($user_client_id);

        redirect('users/form/' . $user_id);
    }

}

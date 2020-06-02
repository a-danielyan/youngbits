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
 * Class Ajax
 */
class Ajax extends Custom_Controller
{
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
    }

    public $ajax_controller = true;

    public function get_content()
    {
        $this->load->model('email_templates/mdl_email_templates');

        $id = $this->input->post('email_template_id');

        echo json_encode($this->mdl_email_templates->get_by_id($id));
    }



    public function get_email(){

            if ($_FILES['email_template_img']['name']) {
                $_FILES["email_template_img"]['name'] = time().$_FILES["email_template_img"]['name'];

                $upload_config = array(
                    'upload_path' => './uploads/email_template_img/',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $_FILES["email_template_img"]['name']
                );
                $this->load->library('upload', $upload_config);
                $this->upload->do_upload('email_template_img');

                $upload_data = $this->upload->data();

                $img_url= base_url() . "uploads/email_template_img/" . $upload_data['file_name'];
                echo $img_url;
            }




    }



}

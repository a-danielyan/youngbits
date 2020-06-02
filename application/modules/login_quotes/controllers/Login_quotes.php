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
class Login_quotes extends Admin_Controller
{
    /**
     * Units constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_login_quotes');
    }

    /**
     * @param int $page
     */
    public function index()
    {
        $quotes = $this->mdl_login_quotes->select('ip_login_quotes.*,ip_users.user_name')->join('ip_users', 'quote_created_by = ip_users.user_id')->get()->result();

        $this->layout->set('quotes', $quotes);
        $this->layout->buffer('content', 'login_quotes/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {

        if ($this->input->post('btn_cancel')) {
            redirect('login_quotes');
        }

        if ($this->mdl_login_quotes->run_validation()) {

            if ($_FILES['quote_file']['name']) {
                $new_name = time().$_FILES["quote_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/quotes/',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('quote_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('tasks');
                }

                $upload_data = $this->upload->data();

                $_POST['quote_document_link'] = base_url() . "uploads/quotes/" . $upload_data['file_name'];
            }


            // Get the db array
            $db_array = $this->mdl_login_quotes->db_array();
            $this->mdl_login_quotes->save($id, $db_array);
            redirect('login_quotes');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_login_quotes->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->buffer('content', 'login_quotes/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_login_quotes->delete($id);
        redirect('login_quotes');
    }

}

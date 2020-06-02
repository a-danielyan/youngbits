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
 * Class expenses
 */
class Expenses_templates extends Admin_Controller
{
    /**
     * expenses constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_expenses_templates');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $this->load->helper('allowance');
        $this->session->set_userdata('previous_url', current_url());

        $this->mdl_expenses_templates->paginate(site_url('expenses_templates/index'), $page);
        $expenses = $this->mdl_expenses_templates->result();

        foreach ($expenses as $expense){
            $expenses_document_link = unserialize($expense->expenses_document_link);
            if(is_array($expenses_document_link)){
                $expense->expenses_document_link = $expenses_document_link[0];
            }else{

                $expense->expenses_document_link = unserialize($expense->expenses_document_link);
            }

        }


        $this->layout->set(
            array(
                'records' => $expenses,
                'cash_banks'=>$this->mdl_expenses_templates->cash_bank(),
                'filter_display' => true,
                'filter_placeholder' => trans('filter_expenses'),
                'filter_method' => 'filter_expenses'
            )
        );

            $this->layout->buffer('content', 'expenses_templates/index');
            $this->layout->render();

    }

    /**
     * @param null $id
     */




    public function form($id = null)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }


        $this->load->model('projects/mdl_projects');
        $this->load->model('expenses/mdl_expenses');
        $this->load->model('users/mdl_users');
        $projects = $this->mdl_projects->get()->result();


        if ($this->input->post('btn_cancel')) {
            redirect('expenses_templates');
        }

        if ($this->mdl_expenses_templates->run_validation()) {
            $expenses_files = $this->input->post('expenses_document_link');
            $files = [];
            $arr =[];
            $_POST['exclude_from_total'] = $this->input->post('exclude_from_total')=='on' ? 1 : 0;

            if (!empty($_FILES['expenses_file']["size"][0])){
                $count = count($_FILES['expenses_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['expenses_file'.$i] = [
                        'name'=>$_FILES['expenses_file']['name'][$i],
                        'type'=>$_FILES['expenses_file']['type'][$i],
                        'tmp_name'=>$_FILES['expenses_file']['tmp_name'][$i],
                        'error'=>$_FILES['expenses_file']['error'][$i],
                        'size'=>$_FILES['expenses_file']['size'][$i]
                    ];
                }
                unset($_FILES['expenses_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/expenses/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/expenses/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['expenses_files'])){
                foreach ($_POST['expenses_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $_POST['expenses_document_link'] = serialize($files);
            }else{
                $_POST['expenses_document_link'] = serialize('');
            }

            $id = $this->mdl_expenses_templates->save($id);
            redirect('expenses_templates');

        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_expenses_templates->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }


        $this->load->model('payment_methods/mdl_payment_methods');

        $amounts = array();


        $files = $this->mdl_expenses_templates->where('expenses_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->expenses_document_link);
        }else{
            $upload_files= [];
        }


        $this->layout->set(
            array(
                'upload_files'=>$upload_files,
                'projects'=>$projects,
                'expenses_id' => $id,
                'cash_banks'=>$this->mdl_expenses_templates->cash_bank(),
                'users' => $this->mdl_users->where('user_active', 1)->get()->result(),
                'expenses' => $this->mdl_expenses->get()->result(),
            )
        );

            $this->layout->buffer('content', 'expenses_templates/form');
            $this->layout->render();


    }

    /**
     * @param $id
     */
    public function delete($id)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $this->mdl_expenses_templates->delete($id);
        redirect('expenses_templates');
    }

   
}

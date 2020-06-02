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
class Expenses extends Admin_Controller
{
    public $multipart_files = [];
    /**
     * expenses constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_expenses');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $this->load->helper('allowance');

        $this->session->set_userdata('previous_url', current_url());

        $this->mdl_expenses->paginate(site_url('expenses/index'), $page);
        $expenses = $this->mdl_expenses->result();

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
                'filter_display' => true,
                'cash_banks'=>$this->mdl_expenses->cash_bank(),
                'sum' => $this->sum(),
                'filter_placeholder' => trans('filter_expenses'),
                'filter_method' => 'filter_expenses'
            )
        );

            $this->layout->buffer('content', 'expenses/index');
            $this->layout->render();

    }

    /**
     * @param null $id
     */


    public function sum($sum = []){

        $expenses = $this->mdl_expenses->get()->result();

        $sum['dollar'] = 0;
        $sum['euro'] = 0;
        foreach ($expenses as $s){
            if($s->exclude_from_total==0) {

                if($s->expenses_currency == 'euro'){
                    $sum['euro']+= $s->expenses_amount_euro;
                }else{
                    $sum['dollar']+= $s->expenses_amount;
                }
            }
        }
        return $sum;
    }

    public function total_price($sum  = []){
        $expenses = $this->mdl_expenses->get()->result();

        $sum['dollar'] = 0;
        $sum['euro'] = 0;
        foreach ($expenses as $s){
            if($s->expenses_currency == 'euro'){
                $sum['euro']+= $s->expenses_amount_euro;
            }else{
                $sum['dollar']+= $s->expenses_amount;
            }
        }
        echo json_encode($sum);
    }




    public function form($id = null)
    {


        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }
        $previous_url = $this->session->userdata('previous_url');

        $this->load->model('projects/mdl_projects');
        $this->load->model('users/mdl_users');
        $this->load->model('expenses_templates/mdl_expenses_templates');

        $projects = $this->mdl_projects->get()->result();


        if ($this->input->post('btn_cancel')) {
            redirect($previous_url);
        }



        if ($this->mdl_expenses->run_validation()) {
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

            $id = $this->mdl_expenses->save($id);
            if(!empty($id)){
                $this->session->unset_userdata('expenses_documents');
                $this->session->unset_userdata('expenses_multipart_documents');

            }
            redirect('expenses');

        }


        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_expenses->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }


        $this->load->model('payment_methods/mdl_payment_methods');




        $files = $this->mdl_expenses->where('expenses_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->expenses_document_link);
        }else{
            $upload_files= [];
        }



        if(empty($id)){
            $this->layout->set(
                array(
                    'expenses_templates' =>$this->mdl_expenses_templates->get()->result(),
                )
            );

        }

        $tablet_files_session = '';
        if(is_null($id)){
            $tablet_files_session = $this->session->userdata('expenses_documents');

            if(!is_null($this->session->userdata('expenses_multipart_documents'))){
                $tablet_files_session = $this->session->userdata('expenses_multipart_documents');
            }
        }





        $this->layout->set(
            array(
                'tablet_files'=>$tablet_files_session,
                'upload_files'=>$upload_files,
                'cash_banks'=>$this->mdl_expenses->cash_bank(),
                'projects'=>$projects,
                'expenses_id' => $id,
                'users' => $this->mdl_users->where('user_active', 1)->get()->result(),
                'expenses' => $this->mdl_expenses->get()->result(),
            )
        );

            $this->layout->buffer('content', 'expenses/form');
            $this->layout->render();


    }


    public function tablet_form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('expenses');
        }

        $files = [];

        if(!empty($_FILES['expenses_file'])){

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



            if(!empty($this->session->userdata('expenses_multipart_documents'))){
                $expenses_multipart_doc = $this->session->userdata('expenses_multipart_documents');
                $this->session->set_userdata('expenses_documents', $expenses_multipart_doc);
                $this->session->unset_userdata('expenses_multipart_documents');

            }

            $this->session->unset_userdata('expenses_documents');
            $this->session->set_userdata('expenses_documents', $files);
            redirect('expenses/form');
        }
        $this->layout->buffer('content', 'expenses/tablet_form');
        $this->layout->render();
    }



    /***** Upload FILES multipart *****/

    public function manually_add() {
        $this->layout->buffer('content', 'expenses/manually_add');
        $this->layout->render();
    }

    public function drag_and_drop() {
        $this->session->unset_userdata('expenses_multipart_documents');
        $this->layout->buffer('content', 'expenses/drag_and_drop');
        $this->layout->render();
    }

    public function file_upload() {
        $this->session->unset_userdata('expenses_multipart_documents');
        if (!empty($_FILES)) {
            $multipart_files = [];
            $tempFile = $_FILES['file']['tmp_name'];
            $fileNames = $_FILES['file']['name'];
            $targetPath = '/uploads/expenses/';

            foreach ($fileNames as $fileName) {
                $targetFile = $targetPath . $fileName ;
                $multipart_files[] = $targetFile;

            }

            if (!empty($_FILES['file']["size"][0])){
                $count = count($_FILES['file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['expenses_file'.$i] = [
                        'name'=>$_FILES['file']['name'][$i],
                        'type'=>$_FILES['file']['type'][$i],
                        'tmp_name'=>$_FILES['file']['tmp_name'][$i],
                        'error'=>$_FILES['file']['error'][$i],
                        'size'=>$_FILES['file']['size'][$i]
                    ];
                }
                unset($_FILES['file']);

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
                }
            }


            if(is_array($multipart_files)){
                $this->session->set_userdata('expenses_multipart_documents', $multipart_files);
            }

//            echo json_encode($multipart_files);
            // if you want to save in db,where here
            // with out model just for example
            // $this->load->database(); // load database
            // $this->db->insert('file_table',array('file_name' => $fileName));
        }
    }

    public function upload(){

        echo json_encode($this->session->userdata('expenses_multipart_documents'));


    }
    public function select_templates(){

        $id = $_POST['template_id'];


        $this->load->model('projects/mdl_projects');
        $this->load->model('users/mdl_users');
        $this->load->model('expenses_templates/mdl_expenses_templates');

        $expenses = $this->mdl_expenses_templates->get_by_id($id);
        $projects = $this->mdl_projects->get()->result();
        $files = $this->mdl_expenses_templates->where('expenses_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->expenses_document_link);
        }else{
            $upload_files= [];
        }

        $data = [
                'tablet_files'=>$this->session->userdata('expenses_multipart_documents'),
                'upload_files'=>$upload_files,
                'projects'=>$projects,
                'expenses_id' => $id,
                'cash_banks'=>$this->mdl_expenses->cash_bank(),
                'users' => $this->mdl_users->where('user_active', 1)->get()->result(),
                'expenses' =>$expenses,
                'expenses_list' =>$this->mdl_expenses->get()->result(),
          ];
        $this->load->view('expenses/form_templates',$data);
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

        $this->mdl_expenses->delete($id);
        redirect('expenses');
    }

    public function delete_sel_expenses()
    {
        foreach ($_POST['sel_expenses'] as $sel_expenses) {
            $this->mdl_expenses->delete($sel_expenses);
        }

        echo json_encode($_POST['sel_expenses']);

    }




   
}

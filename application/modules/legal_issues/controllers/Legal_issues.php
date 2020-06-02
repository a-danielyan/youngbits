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
 * Class Inventory
 */
class Legal_issues extends Admin_Controller
{
    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_legal_issues');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_legal_issues->paginate(site_url('legal_issues/index'), $page);
        $legal_issues = $this->mdl_legal_issues->result();




        $this->layout->set(
            array(
                'records' => $legal_issues,
                'sum' => $this->sum(),
                'filter_display' => false,
                'filter_placeholder' => trans('filter_legal_issues'),
                'filter_method' => 'filter_legal_issues'
            )
        );

        $this->layout->buffer('content', 'legal_issues/index');
        $this->layout->render();
    }

    public function sum($sum = 0){

        $legal_issues = $this->mdl_legal_issues->get()->result();
        foreach ($legal_issues as $i){
            $sum+=$i->legal_issues_amount;
        }
        return $sum;
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {

        if(!empty($id) && $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){
            redirect('legal_issues');

        }

        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            redirect('legal_issues');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('legal_issues');
        }

        if ($this->mdl_legal_issues->run_validation()) {

            $legal_issues_files = $this->input->post('legal_issues_document_link');
            $files = [];
            $arr =[];

            if (!empty($_FILES['legal_issues_file']["size"][0])){
                $count = count($_FILES['legal_issues_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['legal_issues_file'.$i] = [
                        'name'=>$_FILES['legal_issues_file']['name'][$i],
                        'type'=>$_FILES['legal_issues_file']['type'][$i],
                        'tmp_name'=>$_FILES['legal_issues_file']['tmp_name'][$i],
                        'error'=>$_FILES['legal_issues_file']['error'][$i],
                        'size'=>$_FILES['legal_issues_file']['size'][$i]
                    ];
                }
                unset($_FILES['legal_issues_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/legal_issues/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);
                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/legal_issues/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }

            }



            if(!empty($_POST['legal_issues_files'])){
                foreach ($_POST['legal_issues_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $_POST['legal_issues_document_link'] = serialize($files);
            }else{
                $_POST['legal_issues_document_link'] = serialize('');
            }

            $id = $this->mdl_legal_issues->save($id);

            redirect('legal_issues');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_legal_issues->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }

        $amounts = array();

        $files = $this->mdl_legal_issues->where('legal_issues_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->legal_issues_document_link);
        }else{
            $upload_files= [];
        }




        $this->layout->set(
            array(
                'legal_issues_id' => $id,
                'upload_files'=>$upload_files,
                'amounts' => json_encode($amounts)
            )
        );

        $this->layout->buffer('content', 'legal_issues/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_legal_issues->delete($id);
        redirect('legal_issues');
    }


    public function total_price($sum  = 0){
        $legal_issues = $this->mdl_legal_issues->get()->result();
        foreach ($legal_issues as $i){
            $sum+=$i->legal_issues_amount;
        }
        echo $sum;
    }

}

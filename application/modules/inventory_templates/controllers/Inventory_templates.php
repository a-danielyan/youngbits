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
class Inventory_templates extends Admin_Controller
{

    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('mdl_inventory_templates');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $this->session->set_userdata('previous_url', current_url());
        $this->mdl_inventory_templates->paginate(site_url('inventory_templates/index'), $page);
        $inventory = $this->mdl_inventory_templates->result();


        $categories = $this->mdl_inventory_templates->categories();


        $this->layout->set(
            array(
                'records' => $inventory,
                'total_regular_price' => $this->sum(0,'inventory_regular_price'),
                'total_sold' => $this->sum(0,'inventory_number_items_sold'),
                'inventory_statuses' => $this->mdl_inventory_templates->statuses(),
                'categories' => $categories,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_inventory'),
                'filter_method' => 'filter_inventory'
            )
        );

        $this->layout->buffer('content', 'inventory_templates/index');
        $this->layout->render();
    }

    public function sum($sum = 0,$amount){

        $inventory = $this->mdl_inventory_templates->get()->result();
        foreach ($inventory as $i){
            $sum+=$i->$amount;
        }
        return $sum;
    }



    public function validFile($url){
        $file_headers = @get_headers($url);
        $is_image = 0;
        $status = false;
        foreach ($file_headers as $key => $value) {
            if (stripos($value, 'Content-Type: image') !== false) {
                $is_image ++;
            }
            if (strripos($value, '200 OK')) {
                $status = true;
            }
        }
        if ($is_image && $status) {
            echo "image";
        }
        else{
            echo "isn't image";
        }
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $previous_url = $this->session->userdata('previous_url');

        $categories = $this->mdl_inventory_templates->categories();

        $percentage_users = [
            '0',
            '10',
            '20',
            '30',
            '40',
        ];
        if(!empty($id) && $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){
            redirect($previous_url);

        }

        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            redirect($previous_url);
        }

        if ($this->input->post('btn_cancel')) {
            redirect($previous_url);
        }

        if ($this->mdl_inventory_templates->run_validation()) {

            $inventory_files = $this->input->post('inventory_document_link');
            $files = [];
            $arr =[];

            if (!empty($_FILES['inventory_file']["size"][0])){
                $count = count($_FILES['inventory_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['inventory_file'.$i] = [
                        'name'=>$_FILES['inventory_file']['name'][$i],
                        'type'=>$_FILES['inventory_file']['type'][$i],
                        'tmp_name'=>$_FILES['inventory_file']['tmp_name'][$i],
                        'error'=>$_FILES['inventory_file']['error'][$i],
                        'size'=>$_FILES['inventory_file']['size'][$i]
                    ];
                }
                unset($_FILES['inventory_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/inventory_templates/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);
                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/inventory_templates/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }

            }



            if(!empty($_POST['inventory_files'])){
                foreach ($_POST['inventory_files'] as $file){
                    array_push($files,$file);
                }
            }



            if(!empty($files)){
                $_POST['inventory_document_link'] = serialize($files);
            }else{
                $_POST['inventory_document_link'] = serialize('');
            }

            $id = $this->mdl_inventory_templates->save($id);

            redirect($previous_url);
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_inventory_templates->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }
        $this->load->model('projects/mdl_projects');
        $amounts = array();

        $files = $this->mdl_inventory_templates->where('inventory_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->inventory_document_link);
        }else{
            $upload_files= [];
        }

        $projects = $this->mdl_projects->get()->result();

        $tablet_files_session = '';
        if(is_null($id)){
            $tablet_files_session = $this->session->userdata('inventory_documents');

            if(!is_null($this->session->userdata('inventory_multipart_documents'))){
                $tablet_files_session = $this->session->userdata('inventory_multipart_documents');
            }
        }



        $this->layout->set(
            array(
                'tablet_files'=>$tablet_files_session,
                'categories' => $categories,
                'percentage_users' => $percentage_users,
                'projects' => $projects,
                'inventory_id' => $id,
                'inventory_statuses' => $this->mdl_inventory_templates->statuses(),
                'upload_files'=>$upload_files,
                'amounts' => json_encode($amounts)
            )
        );

        $this->layout->buffer('content', 'inventory_templates/form');
        $this->layout->render();
    }


    public function tablet_form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('inventory');
        }
        $files = [];

        if(!empty($_FILES['inventory_file'])){
            if (!empty($_FILES['inventory_file']["size"][0])){
                $count = count($_FILES['inventory_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['inventory_file'.$i] = [
                        'name'=>$_FILES['inventory_file']['name'][$i],
                        'type'=>$_FILES['inventory_file']['type'][$i],
                        'tmp_name'=>$_FILES['inventory_file']['tmp_name'][$i],
                        'error'=>$_FILES['inventory_file']['error'][$i],
                        'size'=>$_FILES['inventory_file']['size'][$i]
                    ];
                }
                unset($_FILES['inventory_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/inventory_templates/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/inventory_templates/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($this->session->userdata('inventory_multipart_documents'))){
                $inventory_multipart_doc = $this->session->userdata('inventory_multipart_documents');
                $this->session->set_userdata('inventory_documents', $inventory_multipart_doc);
                $this->session->unset_userdata('inventory_multipart_documents');

            }

            $this->session->unset_userdata('inventory_documents');
            $this->session->set_userdata('inventory_documents', $files);
            redirect('inventory_templates/form');
        }




        $this->layout->buffer('content', 'inventory_templates/tablet_form');
        $this->layout->render();
    }


    public function delete($id)
    {
        $this->mdl_inventory_templates->delete($id);
        redirect('inventory');
    }


    public function total_price($sum  = 0){
        $inventory = $this->mdl_inventory_templates->get()->result();
        foreach ($inventory as $i){
            $sum+=$i->inventory_regular_price;
        }
        echo $sum;
    }

    public function category_id($csv_category){
        $categories = $this->mdl_inventory_templates->categories();
        foreach ($categories as $key => $category) {
            if($csv_category == $category){
                return $key;
            }else{
                return 1;
            }
        }
    }
}

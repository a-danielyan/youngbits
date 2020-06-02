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
class Inventory extends Admin_Controller
{

    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('mdl_inventory');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->session->set_userdata('previous_url', current_url());
        $this->mdl_inventory->paginate(site_url('inventory/index'), $page);
        $inventory = $this->mdl_inventory->result();


        $categories = $this->mdl_inventory->categories();


        $this->layout->set(
            array(
                'records' => $inventory,
                'total_regular_price' => $this->sum(0,'inventory_regular_price'),
                'total_sold' => $this->sum(0,'inventory_number_items_sold'),
                'inventory_statuses' => $this->mdl_inventory->statuses(),
                'categories' => $categories,
                'filter_display' => false,
                'filter_placeholder' => trans('filter_inventory'),
                'filter_method' => 'filter_inventory'
            )
        );

        $this->layout->buffer('content', 'inventory/index');
        $this->layout->render();
    }

    public function sum($sum = 0,$amount){

        $inventory = $this->mdl_inventory->get()->result();
        foreach ($inventory as $i){
            $sum+=$i->$amount;
        }
        return $sum;
    }


    public function export(){
        $categories = $this->mdl_inventory->categories();

        $start_date = date('Y-m-d',strtotime($_GET['inventory_start_date']));
        $end_date = (!empty($_GET['inventory_end_date']))? $_GET['inventory_end_date'] : date('Y-m-d');

        $inventorys= $this->mdl_inventory->where('inventory_date >=', $start_date)->where('inventory_date <=', date('Y-m-d',strtotime($end_date)))->get()->result();

        $filename = 'mydata_'.date('Ymd').'.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // file creation
        $file = fopen('php://output', 'w');
        fputcsv($file,array(
            'Title',
            'Description',
            'Date',
            'User',
            'Percentage for user',
            'Category',
            'Project',
//            'City',
            'Country',
            'Weight',
            'Length',
            'Width',
            'Manage stock',
            'Stock',
            'Regular price',
            'Sale price',
            'Product url',
//            'Sold items',
            'Images',
        ));

        foreach ($inventorys as $inventory){
            $attachment = '';
            if(unserialize($inventory->inventory_document_link)) {

                $inventory_img = unserialize($inventory->inventory_document_link);

                foreach ($inventory_img as $img) {
                    if (!empty($img)) {
                        $attachment .= $img . '|';
                    }
                }

                $attachment= substr($attachment, 0, -1);
            }else{
                $attachment = 'https://administration.youngbits.com/uploads/Domain_names_salle.jpg';

            }


            $csv = array(
                ( $inventory->inventory_post_title)? $inventory->inventory_post_title:'',
                $inventory->inventory_post_content,
                $inventory->inventory_date,
                $inventory->user_name,
                $inventory->inventory_percentage_user,
                $categories[$inventory->inventory_category],
                $inventory->project_name,
//                $inventory->City,
                $inventory->inventory_country,
                $inventory->inventory_weight,
                $inventory->inventory_length,
                $inventory->inventory_width,
                $inventory->inventory_manage_stock,
                $inventory->inventory_stock_quantity,
                $inventory->inventory_regular_price,
                $inventory->inventory_sale_price,
                $inventory->inventory_product_url,
//                $inventory->Sold_items,
                $attachment,

            );
            fputcsv($file,$csv);
        }

        fclose($file);
        exit;
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
        $this->load->model('inventory_templates/mdl_inventory_templates');
        $previous_url = $this->session->userdata('previous_url');

        $categories = $this->mdl_inventory->categories();

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
            $this->session->userdata('inventory_documents');
            $this->session->userdata('inventory_multipart_documents');
            redirect($previous_url);
        }

        if ($this->mdl_inventory->run_validation()) {

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
                        'upload_path' => './uploads/inventory/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);
                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/inventory/" .  $upload_data['file_name'];
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

            $id = $this->mdl_inventory->save($id);

            redirect($previous_url);
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_inventory->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }
        $this->load->model('projects/mdl_projects');
        $amounts = array();

        $files = $this->mdl_inventory->where('inventory_id',$id)->get()->row();
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
        if(empty($id)){

            $this->layout->set(
                array(
                    'inventory_templates' =>$this->mdl_inventory_templates->get()->result(),
                )
            );

        }



        $this->layout->set(
            array(
                'tablet_files'=>$tablet_files_session,
                'categories' => $categories,
                'percentage_users' => $percentage_users,
                'projects' => $projects,
                'inventory_id' => $id,
                'inventory_statuses' => $this->mdl_inventory->statuses(),
                'upload_files'=>$upload_files,
                'amounts' => json_encode($amounts)
            )
        );

        $this->layout->buffer('content', 'inventory/form');
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
                        'upload_path' => './uploads/inventory/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/inventory/" .  $upload_data['file_name'];
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
            redirect('inventory/form');
        }




        $this->layout->buffer('content', 'inventory/tablet_form');
        $this->layout->render();
    }
    /**
     * @param $id
     */

    /***** Upload FILES multipart *****/

    public function manually_add() {
        $this->layout->buffer('content', 'inventory/manually_add');
        $this->layout->render();
    }

    public function drag_and_drop() {
        $this->session->unset_userdata('inventory_multipart_documents');
        $this->layout->buffer('content', 'inventory/drag_and_drop');
        $this->layout->render();
    }


    public function file_upload() {
        $this->session->unset_userdata('inventory_multipart_documents');
        if (!empty($_FILES)) {
            $multipart_files = [];
            $tempFile = $_FILES['file']['tmp_name'];
            $fileNames = $_FILES['file']['name'];
            $targetPath = '/uploads/inventory/';

            foreach ($fileNames as $fileName) {
                $targetFile = $targetPath . $fileName ;
                $multipart_files[] = $targetFile;

            }

            if (!empty($_FILES['file']["size"][0])){
                $count = count($_FILES['file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['inventory_file'.$i] = [
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
                        'upload_path' => './uploads/inventory/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/inventory/" .  $upload_data['file_name'];
                }
            }


            if(is_array($multipart_files)){
                $this->session->set_userdata('inventory_multipart_documents', $multipart_files);
            }

        }
    }

    public function upload(){

        echo json_encode($this->session->userdata('inventory_multipart_documents'));


    }

    public function select_templates(){

        $id = $_POST['template_id'];


        $this->load->model('projects/mdl_projects');
        $this->load->model('users/mdl_users');
        $this->load->model('inventory_templates/mdl_inventory_templates');

        $inventory = $this->mdl_inventory_templates->get_by_id($id);
        $projects = $this->mdl_projects->get()->result();
        $files = $this->mdl_inventory_templates->where('inventory_id',$id)->get()->row();
        $categories = $this->mdl_inventory->categories();
        $percentage_users = [
            '0',
            '10',
            '20',
            '30',
            '40',
        ];
        if(!empty($files)){
            $upload_files= unserialize($files->inventory_document_link);
        }else{
            $upload_files= [];
        }


        $data = [
            'tablet_files'=>$this->session->userdata('inventory_documents'),
            'upload_files'=>$upload_files,
            'categories'=>$categories,
            'percentage_users'=>$percentage_users,
            'inventory_statuses' => $this->mdl_inventory->statuses(),
            'projects'=>$projects,
            'inventory_id' => $id,
            'users' => $this->mdl_users->where('user_active', 1)->get()->result(),
            'inventory' =>$inventory,
            'inventory_list' =>$this->mdl_inventory->get()->result(),
        ];
        $this->load->view('inventory/form_templates',$data);
    }

    public function delete($id)
    {
        $this->mdl_inventory->delete($id);
        redirect('inventory');
    }


    public function total_price($sum  = 0){
        $inventory = $this->mdl_inventory->get()->result();
        foreach ($inventory as $i){
            $sum+=$i->inventory_regular_price;
        }
        echo $sum;
    }

    public function import($id =null){

        // If import request is submitted
        if($this->input->post('importSubmit')){

            // Form field validation rules
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            // Validate submitted form data
            if($this->form_validation->run() != true){

                $insertCount = $updateCount = $rowCount = $notAddCount = 0;


                // If file uploaded
                if(is_uploaded_file($_FILES['import_csv']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['import_csv']['tmp_name']);
                    // Insert/update CSV data into database
                    if(!empty($csvData)){

                        foreach($csvData as $row){
                            $rowCount++;


                            // Prepare data for DB insertion
                            $db_array = array(
                                'inventory_post_title' => $row['post_title'],
                                'inventory_post_content' => $row['post_content'],
                                'inventory_date' => date('Y-m-d', strtotime($row['post_date'])),
                                'inventory_regular_price' => $row['regular_price'],
                                'inventory_sale_price' => $row['sale_price'],
                                'inventory_weight' => $row['weight'],
                                'inventory_length' => $row['length'],
                                'inventory_width' => $row['width'],
                                'inventory_manage_stock' => $row['manage_stock'],
                                'inventory_product_url' => $row['product_url'],
                                'inventory_document_link' => serialize(explode('|', $row['images'])),
                                'inventory_category' => $this->category_id($row['tax:product_cat']),
                                'inventory_created_user' => $this->session->userdata('user_id'),
                            );

                            $prevCount = $this->mdl_inventory->where('ip_inventory.inventory_post_title',$row['post_title'])->get()->row();
                            if($prevCount !== NULL){
                                // Update member data
                                $this->db->set($db_array);
                                $this->db->where('ip_inventory.inventory_id',$prevCount->inventory_id);
                                $this->db->update('ip_inventory');
                            }else{
                                $this->db->insert("ip_inventory", $db_array);

                            }



                        }
                        // Status message with imported data count
                        $successMsg = 'Members imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                        $this->session->set_userdata('success_msg', $successMsg);
                    }
                }else{
                    $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                }
            }else{
                $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('inventory');
    }


    public function category_id($csv_category){
        $categories = $this->mdl_inventory->categories();
        foreach ($categories as $key => $category) {
            if($csv_category == $category){
                return $key;
            }else{
                return 1;
            }
        }
    }
}

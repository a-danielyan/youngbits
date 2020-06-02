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
 * Class Bank_statements
 */
class Bank_statements extends Admin_Controller
{
	/**
     * Bank_statements constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_statements');
        $this->load->model('projects/mdl_projects');
        $this->load->model('users/mdl_users');
    }

    public function index($page = 0)
    {

    	$this->load->helper('allowance');

    	$this->session->set_userdata('previous_url', current_url());
    	
        $this->mdl_statements->paginate(site_url('bank_statements/index'), $page);
        $statements = $this->mdl_statements->result();

        foreach ($statements as $key => $value) {
            $user_id = $value->user_id;
            $project_id = $value->project_id;
            if($user_id !== 0){
                $username = $this->mdl_users->get_username_by_id($user_id);
            }
            else{
                $username = '';
            }
            $value->username = $username;
            if($project_id !== 0){
                $project_name = $this->mdl_projects->get_projectname_by_id($project_id);
            }
            else{
                $project_name = '';
            }
            $value->project_name = $project_name;
        }

        $users = $this->mdl_users->get()->result();
        $projects = $this->mdl_projects->get()->result();

        $this->layout->set('statements', $statements);
        $this->layout->set('users', $users);
        $this->layout->set('projects', $projects);
        $this->layout->buffer('content', 'bank_statements/index');
        $this->layout->render();
    }


    public function export(){

        $statements= $this->mdl_statements->get()->result();

        $filename = 'statements.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // file creation
        $file = fopen('php://output', 'w');
        fputcsv($file,array(
            'Account name',
            'Bank account',
            'Date',
            'Amount',
            'Tegenrekening IBAN/BBAN',
            'Type',
            'Category',
            'Organization',
            'User',
            'Parent',
            'Project',
            'Currency',
            'Taxes',
            'Exclude from Total',
            'Attachments',
            'Description',
        ));
        foreach ($statements as $value){
            $attachment = '';
            $user_id = $value->user_id;
            $project_id = $value->project_id;
            if($user_id !== 0){
                $username = $this->mdl_users->get_username_by_id($user_id);
            }
            else{
                $username = '';
            }
            if($project_id !== 0){
                $project_name = $this->mdl_projects->get_projectname_by_id($project_id);
            }
            else{
                $project_name = '';
            }

            if($value->exclude_from_total == 0){
                $excluded = "No";
            }
            else{
                $excluded = "Yes";
            }

            if(unserialize($value->expenses_document_link)) {

                $stat_img = unserialize($value->expenses_document_link);

                foreach ($stat_img as $img) {
                    if (!empty($img)) {
                        $attachment .= $img . '|';
                    }
                }
                $attachment= substr($attachment, 0, -1);
            }else{
                $attachment = 'https://administration.youngbits.com/uploads/Domain_names_salle.jpg';

            }

            $csv = array(
                ( $value->account_name)? $value->account_name:'',
                $value->bank_account,
                $value->date,
                $value->amount,
                $value->offset,
                $value->type,
                $value->category,
                $value->organization,
                $username,
                $value->parent_id,
                $project_name,
                $value->currency,
                $value->taxes,
                $excluded,
                $attachment,
                $value->description,

            );
            fputcsv($file,$csv);
        }

        fclose($file);
        exit;
    }

    public function attach_file(){

        $statement_id = $this->input->post('statement_id');

        $stat_files = $this->mdl_statements->where('id',$statement_id)->get()->row();
        if(!empty($stat_files->expenses_document_link)){
            $files_arr= unserialize($stat_files->expenses_document_link);
            if(is_array($files_arr) && count($files_arr) > 0){
                $files = $files_arr;
            }
            else{
                $files = [];
            }
        }else{
            $files= [];
        }

        if ($_FILES['image']['name']) {
            $new_name = time().$_FILES["image"]['name'];
            $upload_config = array(
                'upload_path' => './uploads/statements/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'file_name' => $new_name
            );
            $this->load->library('upload', $upload_config);

            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                redirect('bank_statements');
            }

            $upload_data = $this->upload->data();
            $files_new= base_url() . "uploads/statements/" .  $upload_data['file_name'];
            array_push($files,$files_new);

            if(!empty($files)){
                $expenses_document_link = serialize($files);
            }else{
                $expenses_document_link = serialize('');
            }

            $arr = array(
                'expenses_document_link' => $expenses_document_link
            );

            $this->db->where('id', $statement_id);
            $this->db->update('ip_statements', $arr);

            redirect('bank_statements');
        }

    }

    public function get_record_fields()
    {
        $statements = $this->mdl_statements->get()->result();
        $users = $this->mdl_users->get()->result();
        $projects = $this->mdl_projects->get()->result();

        $data = array(
            'users' => $users,
            'projects' => $projects,
            'statements' => $statements
        );
        echo json_encode($data);
    }

    public function save_record(){
        $records = $this->input->post('records');

        $i = 0;
        foreach ($records as $val){
            $data[$i]['date'] = $val['record_date'];
            $data[$i]['amount'] = $val['record_amount'];
            $data[$i]['type'] = $val['record_type'];
            $data[$i]['user_id'] = $val['record_user'];
            $data[$i]['project_id'] = $val['record_project'];
            $data[$i]['parent_id'] = $val['record_parent'];
            $data[$i]['category'] = $val['record_category'];
            $data[$i]['account_name'] = $val['record_account'];
            $data[$i]['description'] = $val['record_desc'];

            $i++;
        }
        $this->mdl_statements->insert($data);
        echo json_encode(array(
                'status' => true
            )
        );
    }


    public function import_26(){
        if (!$this->input->post('btn_submit')) {
            $this->load->helper('directory');

            $this->layout->buffer('content', 'bank_statements/statement_index');
            $this->layout->render();
        } else {

            $path = 'uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('import_statement')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                 
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;

                    // echo "<pre>";
                    // var_dump($allDataInSheet);
                    // die;
                    foreach ($allDataInSheet as $value) {
                        if($flag){
                            $flag =false;
                            continue;
                        }
                        $date = date_create($value['A']);
                        $inserdata[$i]['date'] = date_format($date,"Y-m-d");
                        $inserdata[$i]['organization'] = rtrim($value['B'],'"');
                        $inserdata[$i]['offset'] = rtrim($value['C'],'"');
                        $inserdata[$i]['description'] = rtrim($value['E'],'"');
                        $inserdata[$i]['category'] = rtrim($value['F'],'"');
                        $inserdata[$i]['amount'] = rtrim($value['G'],'"');
                        $inserdata[$i]['currency'] = 'euro';

                        $i++;
                    }
                    $result = $this->mdl_statements->insert($inserdata);

                    redirect('bank_statements');         
      
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .$e->getMessage());
                }
            }else{
              echo $error['error'];
            }

        }
    }

    public function import_abn()
    {
        if (!$this->input->post('btn_submit')) {
            $this->load->helper('directory');

            $this->layout->buffer('content', 'bank_statements/statement_index');
            $this->layout->render();
        } else {

            $path = 'uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('import_statement')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;
                 
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value) {
                        if($flag){
                            $flag =false;
                            continue;
                        }
                        $date = date_create($value['C']);
                        $inserdata[$i]['bank_account'] = rtrim($value['A'],'"');
                        $inserdata[$i]['currency'] = rtrim($value['B'],'"');
                        $inserdata[$i]['date'] = date_format($date,"Y-m-d");
                        $inserdata[$i]['amount'] = rtrim($value['G'],'"');
                        $inserdata[$i]['description'] = rtrim($value['H'],'"');
                        $inserdata[$i]['type'] = 'bank';

                        $i++;
                    }
                    $result = $this->mdl_statements->insert($inserdata);

                    redirect('bank_statements');            
      
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .$e->getMessage());
                }
            }else{
              echo $error['error'];
            }

        }
    }

    public function form(){

    	if (!$this->input->post('btn_submit')) {
            $this->load->helper('directory');

            $this->layout->buffer('content', 'bank_statements/statement_index');
            $this->layout->render();
        } else {

        	$path = 'uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('import_statement')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
              	if (!empty($data['upload_data']['file_name'])) {
	                $import_xls_file = $data['upload_data']['file_name'];
	            } else {
	                $import_xls_file = 0;
	            }
	            $inputFileName = $path . $import_xls_file;
	             
	            try {
	                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
	                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	                $objPHPExcel = $objReader->load($inputFileName);
	                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	                $flag = true;
	                $i=0;
	                foreach ($allDataInSheet as $value) {
	                  	if($flag){
		                    $flag =false;
		                    continue;
	                  	}
	                  	$obj_arr = explode(',"', $value['A']);

                        $amount = str_replace(',', '.', $obj_arr[6]);
	                  	$inserdata[$i]['bank_account'] = rtrim($obj_arr[0],'"');
	                  	$inserdata[$i]['date'] = rtrim($obj_arr[4],'"');
	                  	$inserdata[$i]['amount'] = $amount;
	                  	$inserdata[$i]['offset'] = rtrim($obj_arr[8],'"');
	                  	$inserdata[$i]['account_name'] = rtrim($obj_arr[9],'"');
	                  	$description = rtrim($obj_arr[19],'"');
	                  	if(rtrim($obj_arr[20],'"') !== ' '){
	                  		$description .= ','.rtrim($obj_arr[20],'"');
	                  	}
	                  	if(rtrim($obj_arr[21],'"') !== ''){
	                  		$description .= ','.rtrim($obj_arr[21],'"');
	                  	}
                        $inserdata[$i]['description'] = $description;
	                  	$inserdata[$i]['type'] = 'bank';

	                  	$i++;
	                }
	                $result = $this->mdl_statements->insert($inserdata);

                  	redirect('bank_statements');            
	  
	          	} catch (Exception $e) {
	               	die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .$e->getMessage());
	            }
          	}else{
              echo $error['error'];
            }

        }
    }


    public function edit($id = null)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $previous_url = $this->session->userdata('previous_url');


        if ($this->input->post('btn_cancel')) {
            redirect($previous_url);
        }

        if ($this->input->post('btn_submit')) {
            $post_referer = $this->input->post('referer_url');

            $date = date("Y-m-d", strtotime($this->input->post('date')));

            $files = [];
            $arr = [];
            $exclude_from_total = $this->input->post('exclude_from_total')=='on' ? 1 : 0;

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
                        'upload_path' => './uploads/statements/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/statements/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['expenses_files'])){
                foreach ($_POST['expenses_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $expenses_document_link = serialize($files);
            }else{
                $expenses_document_link = serialize('');
            }


            $data = array(
            	'bank_account' => $this->input->post('bank_account'),
            	'amount' => $this->input->post('amount'),
            	'date' => $date,
            	'offset' => $this->input->post('offset'),
            	'account_name' => $this->input->post('account_name'),
                'type' => $this->input->post('type'),
                'user_id' => $this->input->post('user_id'),
                'project_id' => $this->input->post('project_id'),
            	'parent_id' => $this->input->post('parent_id'),
            	'category' => $this->input->post('category'),
                'currency' => $this->input->post('currency'),
                'taxes' => $this->input->post('taxes'),
                'exclude_from_total' => $exclude_from_total,
                'expenses_document_link' => $expenses_document_link,
            	'organization' => $this->input->post('organization'),
            	'description' => $this->input->post('description')
            );

            $this->db->where('id', $id);
			$this->db->update('ip_statements', $data);

            redirect($post_referer);

        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_statements->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }


        $users = $this->mdl_users->get()->result();
        $projects = $this->mdl_projects->get()->result();
        $statements = $this->mdl_statements->get()->result();

        $stat_files = $this->mdl_statements->where('id',$id)->get()->row();
        if(!empty($stat_files)){
            $upload_files= unserialize($stat_files->expenses_document_link);
        }else{
            $upload_files= [];
        }
        $referer_url = $_SERVER['HTTP_REFERER'];

        $this->layout->set(
            array(
                'statement_id' => $id,
                'users' => $users,
                'projects' => $projects,
                'upload_files' => $upload_files,
                'referer_url' => $referer_url,
                'statements' => $statements
            )
        );

        $this->layout->buffer('content', 'bank_statements/edit');
        $this->layout->render();

    }


    public function add()
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $previous_url = $this->session->userdata('previous_url');


        if ($this->input->post('btn_cancel')) {
            redirect($previous_url);
        }

        if ($this->input->post('btn_submit')) {

            $date = $newDate = date("Y-d-m", strtotime($this->input->post('date')));  
            $files = [];
            $arr = [];
            $exclude_from_total = $this->input->post('exclude_from_total')=='on' ? 1 : 0;

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
                        'upload_path' => './uploads/statements/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/statements/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['expenses_files'])){

                foreach ($_POST['expenses_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $expenses_document_link = serialize($files);
            }else{
                $expenses_document_link = serialize('');
            }

            $data = array(
                'bank_account' => $this->input->post('bank_account'),
                'amount' => $this->input->post('amount'),
                'date' => $date,
                'offset' => $this->input->post('offset'),
                'account_name' => $this->input->post('account_name'),
                'type' => $this->input->post('type'),
                'user_id' => $this->input->post('user_id'),
                'project_id' => $this->input->post('project_id'),
                'parent_id' => $this->input->post('parent_id'),
                'category' => $this->input->post('category'),
                'currency' => $this->input->post('currency'),
                'taxes' => $this->input->post('taxes'),
                'exclude_from_total' => $exclude_from_total,
                'expenses_document_link' => $expenses_document_link,
                'organization' => $this->input->post('organization'),
                'description' => $this->input->post('description')
            );

            $this->db->insert('ip_statements',$data);

            redirect('bank_statements');

        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_statements->prep_form();

            if (!$prep_form) {
                show_404();
            }
        }


        $users = $this->mdl_users->get()->result();
        $projects = $this->mdl_projects->get()->result();
        $statements = $this->mdl_statements->get()->result();

        $this->layout->set(
            array(
                'users' => $users,
                'projects' => $projects,
                'statements' => $statements
            )
        );

        $this->layout->buffer('content', 'bank_statements/add');
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

        $this->mdl_statements->delete($id);
        redirect('bank_statements');
    }

    public function delete_sel_statements()
    {
        foreach ($_POST['sel_statements'] as $sel_statements) {
            $this->mdl_statements->delete($sel_statements);
        }

        echo json_encode($_POST['sel_statements']);
    }


    public function save_statement()
    {

        $stat_res = $this->input->post('stat_res');

        foreach ($stat_res as $val){

            $this->db->set('type',$val['stat_type']);
            $this->db->set('user_id',$val['stat_user']);
            $this->db->set('project_id',$val['stat_project']);
            $this->db->set('parent_id',$val['stat_parent']);
            $this->db->set('category',$val['stat_category']);
            $this->db->set('description',$val['stat_desc']);
            $this->db->where('id',$val['stat_id']);
            $this->db->update('ip_statements');

        }
        echo json_encode($stat_res);

    }


}
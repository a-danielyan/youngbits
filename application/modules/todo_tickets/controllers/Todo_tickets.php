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
 * Class Tickets
 */
class Todo_tickets extends NormalUser_Controller
{
    /**
     * Tickets constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_todo_tickets');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        redirect('todo_tickets/status');
    }

    public function status($status = 'in_progress', $page = 0)
    {




        $this->load->helper('allowance');
        // Determine which group of invoices to load

        $this->mdl_todo_tickets->paginate(site_url('todo_tickets/status/' . $status), $page);

        $todo_tickets = $this->mdl_todo_tickets->get()->result();
        $new_todo_tickets = array();
        $new_ticket_ids = array();
        foreach ($todo_tickets as $ticket)
        {
            if (!$ticket) {

                continue;
            }

            if ($this->session->userdata('user_type') == TYPE_ADMIN){
                array_push($new_todo_tickets, $ticket);
            }
            else if ($this->session->userdata('user_type') == TYPE_MANAGERS){

                if ($ticket->todo_ticket_created_user_id == $this->session->userdata('user_id') || $ticket->todo_ticket_assigned_manager_id == $this->session->userdata('user_id')){
                    array_push($new_todo_tickets, $ticket);

                }
            }else{


                if (empty($ticket->todo_ticket_created_user_id) && empty($ticket->todo_ticket_assigned_user_id) ){
                    array_push($new_todo_tickets, $ticket);
                    array_push($new_ticket_ids, $ticket->todo_ticket_id);
                    continue;
                }

                if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
                    $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') )
                {
                    continue;

                }
                array_push($new_todo_tickets, $ticket);
            }


            $ticket->total_time=0;


            array_push($new_ticket_ids, $ticket->todo_ticket_id);
        }
        if (count($new_ticket_ids) == 0)
        {
            array_push($new_ticket_ids, -1);
        }


        if($status == 'draft'){
            foreach ($new_todo_tickets as $key => $todo_ticket){
                if($todo_ticket->todo_ticket_status != 0){
                  unset($new_todo_tickets[$key]);

                }
            }
        }

        if($status == 'accepted'){
            foreach ($new_todo_tickets as $key => $todo_ticket){
                if($todo_ticket->todo_ticket_status != 2){
                  unset($new_todo_tickets[$key]);

                }
            }
        }
        if($status == 'closed'){
            foreach ($new_todo_tickets as $key => $todo_ticket){
                if($todo_ticket->todo_ticket_status != 1){
                  unset($new_todo_tickets[$key]);

                }
            }
        }
        if($status == 'in_progress'){
            foreach ($new_todo_tickets as $key => $todo_ticket){
                if($todo_ticket->todo_ticket_status != 3){
                  unset($new_todo_tickets[$key]);

                }
            }
        }
        if($status == 'paid'){
            foreach ($new_todo_tickets as $key => $todo_ticket){
                if($todo_ticket->todo_ticket_status != 4){
                  unset($new_todo_tickets[$key]);

                }
            }
        }

        $this->load->model('todo_tickets/mdl_todo_tasks');
        $quantity = 15;
        $start = +$this->uri->segment(4);
        if(!$start) $start = 0;
        $config['base_url'] = site_url('todo_tickets/status/' . $status);
        $config['uri_segment'] = 3;
        $config['total_rows'] = count($new_todo_tickets);
        $config['per_page'] = $quantity;
        $config['display_pages'] = FALSE;
        $config["cur_page"] = $start;
        $config['first_tag_open'] = '<div class="model-pager btn-group btn-group-sm">';



        $config['first_link']= '<span class="btn btn-default btn_page"   title="' . trans('first'). '"><i class="fa fa-fast-backward no-margin"></i></span>';
        $config['prev_link'] = '<span class="btn btn-default btn_page"   title="' . trans('prev') . '"><i class="fa fa-backward no-margin"></i></span>';
        $config['next_link'] = '<span class="btn btn-default btn_page"   title="' . trans('next') . '"><i class="fa fa-forward no-margin"></i></span>';
        $config['last_link'] = '<span class="btn btn-default btn_page"   title="' . trans('last') . '"><i class="fa fa-fast-forward no-margin"></i></span>';
        $config['first_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();
        $this->mdl_todo_tickets->where_in('ip_todo_tickets.todo_ticket_id', $new_ticket_ids)->paginate(site_url('todo_tickets/status/' . $status), $page);

        $this->layout->set( array(
            'links' => $links,
            'todo_tickets' => array_slice($new_todo_tickets, $start, $quantity),
            'ticket_statuses' => $this->mdl_todo_tickets->statuses(),
            'status'=>$status,
        ));
        $this->layout->buffer('content', 'todo_tickets/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */

    public function time_to_minuite($time_m)
    {


        $time = explode(':', $time_m);
        $total_minute = 0;
        if (!empty($time)) {

            if ($time[0] > 0) {
                $total_minute = $time[0] * 60;
            }


            if ($time[1] > 0) {
                $total_minute += $time[1];
            }
            return $total_minute;


        }
    }

    public function time_to_calculate($time_t){
        $total_minute  = 0;
        if(!empty($time_t)){


            if($time_t >= 60){
                $total_minute =  $time_t / 60;
            }else{
                $total_minute =sprintf("0.%d", $time_t);
            }

            return number_format($total_minute,2) ;

        }
    }


    public function form($id = null)
    {
        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            redirect('dashboard');
        }

        $expenses=[];

        $this->load->model('users/mdl_users');
        $this->load->helper('allowance');
        $this->load->model('todo_tickets/mdl_todo_tasks');
        $this->load->helper('mailer');
        $this->load->model('expenses/mdl_expenses');
        $this->load->model('user_groups/mdl_user_groups');


        /*TO-DO EXPENSES*/
        $todo_expenses = [];
        if($this->input->method() == 'post'){
            $todo_expenses['expenses_name']= $this->input->post('expenses_name');
            $todo_expenses['expenses_category']= $this->input->post('expenses_category');
            $todo_expenses['expenses_project_id']= $this->input->post('expenses_project_id');
            $todo_expenses['expenses_user_id']= $this->input->post('expenses_user_id');
            $todo_expenses['expenses_date']=date('Y-m-d', strtotime($this->input->post('expenses_date')));
            $todo_expenses['expenses_currency']= $this->input->post('expenses_currency');
            $todo_expenses['expenses_amount']= $this->input->post('expenses_amount');
            $todo_expenses['expenses_amount_euro']= $this->input->post('expenses_amount_euro');
            $todo_expenses['expenses_notes']= $this->input->post('expenses_notes');
            $todo_expenses['todo_ticket_id']= $id;

        }



        $user_groups = $this->mdl_user_groups->get()->result();

        if (!empty($_FILES['ticket_file']['size'])) {

            $new_name_ticket = $_FILES["ticket_file"]['name'];
            $upload_config_ticket = array(
                'upload_path' => './uploads/todo_ticket',
                'allowed_types' => 'pdf|jpg|jpeg|png|xml|xlsx|csv',
                'file_name' => $new_name_ticket
            );
            $this->load->library('upload', $upload_config_ticket);
            $this->upload->do_upload('expenses_file');
            $upload_data_ticket= $this->upload->data();
            $files_new_ticket= base_url() . "uploads/todo_ticket/" .  $upload_data_ticket['file_name'];


            $_POST['ticket_document_link'] = $files_new_ticket;
        }



        if (!empty($_FILES['expenses_file']['size'])) {

            $new_name_exp = time().$_FILES["expenses_file"]['name'];
            $upload_config_exp = array(
                'upload_path' => './uploads/expenses',
                'allowed_types' => 'pdf|jpg|jpeg|png|xml|xlsx|csv',
                'file_name' => $new_name_exp
            );
            $this->load->library('upload', $upload_config_exp);
            $this->upload->do_upload('expenses_file');
            $upload_data_exp = $this->upload->data();
            $files_new_exp= base_url() . "uploads/expenses/" .  $upload_data_exp['file_name'];


             $todo_expenses['expenses_document_link'] = serialize($files_new_exp);
        }






        /*TO-DO TASKS*/

        $todo_tasks_arr = [];
        if(!empty($this->input->post('todo_task_id'))){
            $todo_task_id = $this->input->post('todo_task_id');
            foreach ($todo_task_id as $key => $val) {
                $todo_tasks_arr[$key]['todo_task_id'] = $val;
            }
        }

        if(!empty($this->input->post('todo_task_text'))){
            $todo_task_texts = $this->input->post('todo_task_text');
            foreach ($todo_task_texts as $key => $val) {
                $todo_tasks_arr[$key]['todo_task_text'] = $val;
            }
        }

        if(!empty($this->input->post('todo_task_project_id'))){
            $todo_task_project_ids = $this->input->post('todo_task_project_id');
            foreach ($todo_task_project_ids as $key => $val) {
                $todo_tasks_arr[$key]['todo_task_project_id'] = $val;
            }
        }
        if(!empty($this->input->post('todo_task_created_date'))){
            $todo_task_created_date = $this->input->post('todo_task_created_date');

            foreach ($todo_task_created_date as $key => $val) {

                $todo_tasks_arr[$key]['todo_task_created_date'] = $val;
            }
        }

        if(!empty($this->input->post('todo_task_deadline'))){
            $todo_task_deadline = $this->input->post('todo_task_deadline');
            foreach ($todo_task_deadline as $key => $val) {

                $todo_tasks_arr[$key]['todo_task_deadline'] = $val ; // date('Y-m-d', strtotime($val))
            }
        }

        if(!empty($this->input->post('todo_ticket_todo_task_id'))){
            $todo_ticket_todo_task_id = $this->input->post('todo_ticket_todo_task_id');
            arsort($todo_ticket_todo_task_id);

            foreach ($todo_ticket_todo_task_id as $key => $val) {

                $todo_tasks_arr[$key]['todo_ticket_todo_task_id'] = $val;
            }
        }

        /**** Total time USER ****/
        $total_time = 0;
        if(!empty($this->input->post('todo_task_number_of_hours'))){
            $todo_ticket_number_of_hours = $this->input->post('todo_task_number_of_hours');

            foreach ($todo_ticket_number_of_hours as $key => $val) {
                $time_m = $this->time_to_minuite($val);
                $total_time += $time_m;


                $todo_tasks_arr[$key]['todo_task_number_of_hours'] = (is_null($val))?'00:00':$val;
            }


        }


        /*** Total time manager ***/
        if(!empty($this->input->post('todo_task_number_of_hours_manager'))){

            $todo_task_number_of_hours = $this->input->post('todo_task_number_of_hours');
            $todo_task_number_of_hours_manager = $this->input->post('todo_task_number_of_hours_manager');
            $time_m_manager = 0;
            foreach ($todo_task_number_of_hours_manager as $key => $val) {
                if($todo_task_number_of_hours[$key] == "00:00"){
                    $time_m_manager = $this->time_to_minuite($val);
                    $total_time += $time_m_manager;
                }
                $todo_tasks_arr[$key]['todo_task_number_of_hours_manager'] = (is_null($val))?'00:00':$val;
            }

        }


        if(isset($_POST['todo_ticket_number_of_hours'])){
            $_POST['todo_ticket_number_of_hours'] =  $this->time_to_calculate($total_time);
        }

        $files = [];
        if (!empty($_FILES['todo_task_file']["size"])){
            unset($_FILES['expenses_file']);

            $count = count($_FILES['todo_task_file']['name']);
            for($i=0;$i<$count;$i++){
                $_FILES['todo_task_file'.$i] = [
                    'name'=>$_FILES['todo_task_file']['name'][$i],
                    'type'=>$_FILES['todo_task_file']['type'][$i],
                    'tmp_name'=>$_FILES['todo_task_file']['tmp_name'][$i],
                    'error'=>$_FILES['todo_task_file']['error'][$i],
                    'size'=>$_FILES['todo_task_file']['size'][$i]
                ];
            }
            unset($_FILES['todo_task_file']);


            $count_file = 0;
            foreach ($_FILES as $key => $file){


                if($file['size'] == 0){
                    $count_file++;
                    continue;
                }

                $new_name = time().$file['name'];
                $upload_config = array(
                    'upload_path' => './uploads/todo_task/',
                    'allowed_types' => 'pdf|jpg|jpeg|png|xml|xlsx|csv',
                    'file_name' => $new_name
                );

                $this->load->library('upload', $upload_config);

                $this->upload->do_upload($key);

                $upload_data = $this->upload->data();

                $files_new= base_url() . "uploads/todo_task/" .  $upload_data['file_name'];
                $files[$count_file] = $files_new;

                $count_file++;
            }
        }






        if(!empty($files)){
            foreach ($files as $key => &$val) {

                if(empty($val)){
                    $val = '';
                }
                $todo_tasks_arr[$key-1]['todo_task_document_link'] = $val;
            }

        }

        $success = [TYPE_ADMIN,TYPE_MANAGERS];
        $allow_edit = false;
        if(in_array($this->session->userdata('user_type'),$success)){
            $allow_edit = true;
        }

        if ($id != null)
        {
            /*UPDATE todo tasks*/
            if(is_array($todo_tasks_arr) && !is_null($todo_tasks_arr)){


                $this->mdl_todo_tasks->update_todo_tasks($todo_tasks_arr,$id);
            }

            if(!empty($todo_expenses) && isset($id)){
                if(!empty($todo_expenses["expenses_name"])){
                    $this->mdl_expenses->save($this->input->post('expenses_id'), $todo_expenses);
                }
            }

            $ticket = $this->mdl_todo_tickets->get_by_id($id);

            if ($this->session->userdata('user_type') <> TYPE_ADMIN){
                if(empty($ticket->todo_ticket_assigned_user_id)  && $this->input->post('todo_ticket_status') != 0){
                    $_POST['todo_ticket_assigned_user_id'] = $this->session->userdata('user_id');
                }


                if($ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id')){
                    if($ticket->todo_ticket_assigned_user_group_id != $this->session->userdata('user_group_id') ){
                        if($ticket->todo_ticket_assigned_manager_id != $this->session->userdata('user_id') ){
                                redirect('todo_tickets/status/in_progress');
                        }
                    }
                    if(!empty($ticket->todo_ticket_assigned_user_id) && $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id')){
                        if(!empty($ticket->todo_ticket_assigned_manager_id) != $this->session->userdata('user_id')){
                            redirect('todo_tickets/status/in_progress');
                        }
                    }
                }
            }

            $expenses = $this->mdl_expenses->where('ip_expenses.todo_ticket_id',$id)->get()->row();
        }

        if($id != null && !empty($_POST)){
            if(!empty($ticket->todo_ticket_created_user_id)){
                $_POST['todo_ticket_created_user_id'] = $ticket->todo_ticket_created_user_id;
            }
        }

        if ($this->input->post('btn_cancel')) {
            redirect('todo_tickets/status/in_progress');
        }

        if ($id == null && !empty($_POST)) {
            $_POST['todo_ticket_created_user_id'] = $this->session->userdata('user_id');
            $_POST['todo_ticket_insert_time'] = date("Y-m-d H:i:s");

            if ($this->session->userdata('user_type') <> TYPE_ADMIN && $this->session->userdata('user_type') <> TYPE_MANAGERS) {
                $_POST['todo_ticket_assigned_user_id'] = $this->session->userdata('user_id');
            }
        }

        $user;
        if (!empty($_POST['todo_ticket_assigned_user_id'])) {
            $user = $this->mdl_users->get_by_id($_POST['todo_ticket_assigned_user_id']);
        }

        $todo_ticket_number = $this->input->post('todo_ticket_number');
        if (!empty($_POST) && empty($todo_ticket_number)) {
            $this->load->model('invoice_groups/mdl_invoice_groups');

            if ($id && isset($user)) {
                $_POST['todo_ticket_number'] = "Ticket-" . $id . "-" . $user->user_name;
            }
            else {
                $_POST['todo_ticket_number'] = "Ticket-" . $id;
            }
        }


        if ($this->mdl_todo_tickets->run_validation()) {
//            var_dump($id);die;

            $need_to_update_todo_ticket_number = false;
            if ($id == null)
            {
                $need_to_update_todo_ticket_number = true;


            }

            $id = $this->mdl_todo_tickets->save($id);

            $new_todo_ticket = $this->mdl_todo_tickets->where('todo_ticket_id',$id)->get()->row();
            $user_from = $this->mdl_users->get_by_id($new_todo_ticket->todo_ticket_assigned_user_id);
            $user_to= $this->mdl_users->get_by_id($new_todo_ticket->todo_ticket_created_user_id);

            if(!empty($user_from) && !empty($user_to)){
                $this->load->library('email');

                // Set email configuration
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $html = '<a href="'.site_url('guest/view/todo_ticket/' .$new_todo_ticket->todo_ticket_url_key).'">'.site_url('guest/view/project/' .$new_todo_ticket->todo_ticket_url_key).'</a>';
                // Set the email params
                $this->email->from($user_to->user_email);
                $this->email->to($user_from->user_email);
                $this->email->subject(trans('todo_ticket_email_msg'));
                $this->email->message($html);

                // Send the reset email
                if (!$this->email->send()) {
                    $email_failed = true;
                    log_message('error', $this->email->print_debugger());
                }
            }

            if (!empty($this->input->post('todo_task_id'))){
                /*INSERT todo tasks*/

                if(is_array($todo_tasks_arr) && !is_null($todo_tasks_arr)){
                    $this->mdl_todo_tasks->insert_todo_tasks($todo_tasks_arr,$id);
                }
            }
            $todo_expenses['todo_ticket_id'] = $id;

            if ($need_to_update_todo_ticket_number)
            {


                if (isset($user)) {
                    $this->mdl_todo_tickets->save($id, array('todo_ticket_number' => "Ticket-" . $id . "-" . $user->user_name));
                }
                else
                {
                    $this->mdl_todo_tickets->save($id, array('todo_ticket_number' => "Ticket-" . $id));
                }
            }
            redirect('todo_tickets/status/in_progress');
        }
        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_todo_tickets->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }

        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('clients/mdl_clients');
        $this->load->model('invoice_groups/mdl_invoice_groups');



        $projects = null;

        if ($this->session->userdata('user_type') == TYPE_ADMIN )
        {
            $projects = $this->mdl_projects->get()->result();
        }
        else
        {
            $all_projects = $this->mdl_projects->get()->result();

            $projects = array();

            foreach ($all_projects as $project)
            {
                if (!$project) {
                    continue;
                }

                if ($project->client_id == null)
                {
                    continue;
                }
                if (!allow_to_see_client_for_logged_user($project->client_id))
                {
                    continue;
                }
                array_push($projects, $project);
            }
        }

        $not_admin_not_administrators = array('ip_users.user_type <>' => TYPE_ADMIN, 'ip_users.user_type !=' => TYPE_ADMIN);
        $to_do_tasks = $this->mdl_todo_tasks->where('todo_ticket_id',$id)->get()->result();

        if(!empty($expenses)){
            $expenses->expenses_document_link = unserialize($expenses->expenses_document_link);
        }else{
            $expenses = "";
        }

        $last_task_id_in_table = $this->mdl_todo_tasks->order_by("todo_ticket_todo_task_id", "desc")->where(['todo_ticket_id' => $id])->get()->row();

        $last_task_id_in_table = isset($last_task_id_in_table->todo_ticket_todo_task_id) ? $last_task_id_in_table->todo_ticket_todo_task_id : 0;

        $mangers =  $this->mdl_users->where('user_type',TYPE_MANAGERS)->get()->result();

        $this->layout->set(
            array(
                'last_task_id_in_table' => $last_task_id_in_table,
                'allow_edit' =>$allow_edit,
                'user_groups' =>$user_groups,
                'expenses' =>$expenses,
                'to_do_tasks' =>$to_do_tasks,
                'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
                'projects' => $projects,
                'clients' => $this->session->userdata('user_type') <> TYPE_ADMIN ? $this->mdl_clients->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))->get()->result()
                    : $this->mdl_clients->get()->result(),
                'users' =>  $this->session->userdata('user_type') <> TYPE_ADMIN ? $this->mdl_users->get()->result()
                    : $this->mdl_users->get()->result(),
                'mangers' =>  $mangers,
                'ticket_statuses' => $this->mdl_todo_tickets->statuses(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'time_manager' => '',
                'time' => '',
            )
        );
        $this->layout->buffer('content', 'todo_tickets/form');
        $this->layout->render();
    }


    public function accepted_suggestion_time_manager(){

         $this->load->model('todo_tickets/mdl_todo_tasks');
        $todo_task = $this->mdl_todo_tasks->where('todo_task_id', $_POST['todo_task_id'])->get()->row();


        $this->db->set(array('todo_task_number_of_hours' => $todo_task->todo_task_number_of_hours_manager));
        $this->db->where('todo_task_id', $_POST['todo_task_id']);
        $this->db->update('ip_todo_tasks');

        echo $todo_task->todo_task_number_of_hours_manager;
    }
    /**
     * @param int $ticket_id
     */
    public function wp_form_new_ticket($todo_ticket_arr = null, $id  =null){


        $ticket = $this->mdl_todo_tickets->order_by('todo_ticket_id',"desc")
            ->limit(1)->get('todo_ticket_id')->row();;

        $ticket_id = $ticket->todo_ticket_id + 1;
        $todo_ticket_arr = [
         'todo_ticket_name' => $_GET['et_pb_contact_todo-name_0'],
         'todo_ticket_category' => $_GET['et_pb_contact_category_0'],
         'todo_ticket_description' => $_GET['et_pb_contact_title_0'],
         'todo_ticket_phone_number' => $_GET['et_pb_contact_phone_0'],
         'todo_ticket_number' => "Ticket-" .$ticket_id,
         'todo_ticket_email_address' => $_GET['et_pb_contact_mail_0'],
        ];

        $this->mdl_todo_tickets->save($id, $todo_ticket_arr);
//        var_dump($todo_ticket_arr);die;
    }

    public function wp_test($data = null){
//        var_dump($_GET);
    }
    public function view($todo_ticket_id)
    {




        $this->load->model('todo_tickets/mdl_todo_tickets');
        $this->load->helper('allowance');
        $this->load->model('todo_tickets/mdl_todo_tasks');
        $this->load->model('todo_tickets/mdl_tickets_comments');
        $this->load->model('todo_tickets/mdl_tickets_grade');
        $this->load->model('todo_tickets/mdl_tasks_grade');
        $ticket = $this->mdl_todo_tickets->where('ip_todo_tickets.todo_ticket_id', $todo_ticket_id)->get()->row();

        if (!$ticket) {
            show_404();
        }

        if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') &&
            $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
        {
            redirect('todo_tickets/status/in_progress');
        }
        if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') &&
            !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
        {
            if($ticket->todo_ticket_assigned_manager_id != $this->session->userdata('user_id') ){
                redirect('todo_tickets/status/in_progress');
            }
        }

        $todo_tasks = $this->mdl_todo_tasks->where('todo_ticket_id',$todo_ticket_id)->get()->result();

        // get grade for assigned user
        foreach ($todo_tasks as $key => &$per_task) {
            $per_task->grade = $this->mdl_tasks_grade->where(['ticket_id' => $per_task->todo_ticket_id, 'task_id' => $per_task->todo_task_id])->get()->row();
            $per_task->grade = isset( $per_task->grade) ?  $per_task->grade->task_grade : 'Not graded yet!';
            // admin or manager grade
            $per_task->task_grade = $per_task->grade;


            //        START SORTING TASKS IDS
            $this->mdl_todo_tasks->update_table_ids($key+1, $per_task->todo_task_id);
            $per_task->todo_ticket_todo_task_id = $key+1;
            //        END SORTING TASKS IDS
        }

        $tickets_comments = $this->mdl_tickets_comments->where('ticket_id',$todo_ticket_id)->get()->result();
        $current_ticket_grade = $this->mdl_tickets_grade->where(['ticket_id' => $todo_ticket_id, 'ip_todo_tickets_grade.user_id' => $this->session->userdata('user_id')])->get()->row();
        $current_grade = isset($current_ticket_grade->ticket_grade) ? $current_ticket_grade->ticket_grade : '';

        $this->layout->set(
            array(
                'todo_tasks' => $todo_tasks,
                'ticket' => $ticket,
                'tickets_comments' => $tickets_comments,
                'ticket_statuses' => $this->mdl_todo_tickets->statuses(),
                'current_grade' => $current_grade
            )
        );

        $this->layout->buffer('content', 'todo_tickets/view');
        $this->layout->render();
    }

    public function todo_task_status(){

        if(!empty($this->input->post('todo_task_id') )){
            $this->db->set(['todo_task_status'=>$this->input->post('todo_task_status')]);
            $this->db->where('todo_task_id', $this->input->post('todo_task_id'));
            $this->db->update('ip_todo_tasks');
        }

        echo $this->input->post('todo_task_status');
    }

    public function  todo_ticket_grade () {
        $this->load->model('todo_tickets/mdl_tickets_grade');
        $user_id = $this->input->post('user_id');
        $request_method = $this->input->server('REQUEST_METHOD');

        if ($request_method != 'POST') {
            echo json_encode(array('status' => 'error', 'msg' => 'Invalid action')); exit();
        }


        if ($user_id != $this->session->userdata('user_id')) {
            echo json_encode(array('status' => 'error', 'msg' => 'Wrong user')); exit();
        }


        if ($this->mdl_tickets_grade->run_validation()) {
            $todo_ticket_grade = $this->input->post('ticket_grade');
            $todo_ticket_id = $this->input->post('ticket_id');

            $result = $this->mdl_tickets_grade->save_todo_grade($todo_ticket_id, $user_id, $todo_ticket_grade);

            if ($result) {
                $response = array(
                    'status' => 'success',
                    'msg' => 'Your grade is ' . $todo_ticket_grade
                );
            }
            else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'Oops! Something went wrong :( '
                );
            }
        } else {
            $this->load->helper('json_error');
            $response = array(
                'status' => 'error',
                'msg' => $this->mdl_tickets_grade->validation_errors
            );


        }
        echo json_encode($response);
        exit();
    }
    public function  todo_task_grade () {
        $this->load->model('todo_tickets/mdl_tasks_grade');
        $user_id = $this->input->post('user_id');
        $request_method = $this->input->server('REQUEST_METHOD');

        if ($request_method != 'POST') {
            echo json_encode(array('status' => 'error', 'msg' => 'Invalid action')); exit();
        }


        if ($user_id != $this->session->userdata('user_id')) {
            echo json_encode(array('status' => 'error', 'msg' => 'Wrong user')); exit();
        }


        if ($this->mdl_tasks_grade->run_validation()) {
            $task_grade = $this->input->post('task_grade');
            $todo_ticket_id = $this->input->post('ticket_id');
            $todo_task_id = $this->input->post('task_id');

            $result = $this->mdl_tasks_grade->save_todo_task_grade($todo_ticket_id, $todo_task_id, $user_id, $task_grade);

            if ($result) {
                $response = array(
                    'status' => 'success',
                    'msg' => 'Graded!'
                );
            }
            else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'Oops! Something went wrong :( '
                );
            }
        } else {
            $this->load->helper('json_error');
            $response = array(
                'status' => 'error',
                'msg' => $this->mdl_tasks_grade->validation_errors
            );


        }
        echo json_encode($response);
        exit();
    }


    /* Todo Comments */
    public function todo_comment(){

        $this->load->model('todo_tickets/mdl_tickets_comments');
        if ($this->mdl_tickets_comments->run_validation()) {
            $new_todo_comment_id =$this->mdl_tickets_comments->insert_todo_comments($this->input->post());
            $new_comment= $this->mdl_tickets_comments->where('id',$new_todo_comment_id)->get()->row();
            echo json_encode($new_comment);

        }else{
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );

            echo json_encode($response);
        }
    }

    /**
     * @param $id
     */
    public function delete($id)
    {

        $this->load->model('todo_tickets/mdl_todo_tickets');
        $this->load->helper('allowance');

        $ticket = $this->mdl_todo_tickets->where('ip_todo_tickets.todo_ticket_id', $id)->get()->row();

        if (!$ticket) {
            show_404();
        }
        if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') &&
            $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
        {
            redirect('todo_tickets/status/in_progress');
        }
        if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') &&
            !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
        {
            redirect('todo_tickets/status/in_progress');
        }

        $this->mdl_todo_tickets->delete($id);
        redirect('todo_tickets/status/in_progress');
    }

    public function todo_task_delete(){
        if(!empty($this->input->post('todo_task_id')) && $this->session->userdata('user_type') == TYPE_ADMIN){
            $this->db->where('todo_task_id', $this->input->post('todo_task_id'));
            $this->db->delete('ip_todo_tasks');
        }
    }



}

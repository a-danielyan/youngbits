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
 * Class Projects
 */
class Projects extends NormalUser_Controller
{
    /**
     * Projects constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_projects');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $success = [TYPE_ADMINISTRATOR];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }


        $this->mdl_projects->paginate(site_url('projects/index'), $page);
        $projects_groups =  $this->mdl_projects->join('ip_projects_groups','ip_projects.project_id = ip_projects_groups.project_id');

        if ($this->session->userdata('user_type') == TYPE_ADMIN) {
            $projects =$projects_groups->result();
        }else {
            $projects = $projects_groups->where('group_id',$this->session->userdata('user_group_id'))->result();
        }

        $this->layout->set('projects', $projects);
        $this->layout->buffer('content', 'projects/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {


        $success = [TYPE_ADMINISTRATOR];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        if($this->session->userdata('user_type') == TYPE_ADMINISTRATOR || $this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            redirect('projects');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('projects');
        }

        if ($this->mdl_projects->run_validation()) {
            $this->mdl_projects->save($id);
            redirect('projects');
        }

        if ($id and !$this->input->post('btn_submit')) {

            if (!$this->mdl_projects->prep_form($id)) {
                show_404();
            }
        }

        $this->load->model('clients/mdl_clients');
        $this->load->model('user_groups/mdl_user_groups');

        if ($id)
        {
            //only Managers and Admin can edit project
            if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
                $projects_groups = $this->mdl_projects->read_groups_for_project($id);

                $projectgroup = array('project_id' => $id, 'group_id' => $this->session->userdata('user_group_id'));
                $key = array_search($projectgroup, $projects_groups);
                if ($key === false && $this->session->userdata('user_type') != TYPE_ADMIN) {
                    show_404();
                }
            }
            else if ($this->session->userdata('user_type') == TYPE_ACCOUNTANT) {
                show_404();
            }
        }

        $this->layout->set(
            array(
                'clients' => $this->mdl_clients->where('client_active', 1)->get()->result(),
                'client' => $this->mdl_clients->get_by_id($this->mdl_projects->form_value('client_id', true)),
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'project_groups' => isset($id) ? $this->mdl_projects->read_groups_for_project($id) : array(),
            ));

        $this->layout->buffer('content', 'projects/form');
        $this->layout->render();



    }

    /**
     * @param null $project_id
     */
    public function view($project_id){

        $success = [TYPE_ADMINISTRATOR];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('projects');
        }
        if ($this->input->post('btn_cancel')) {
            redirect('projects');
        }


        $this->load->model('user_groups/mdl_user_groups');
        $this->load->model('users/mdl_users');
        $this->load->model('projects/mdl_projects_notes');
        $this->load->model('projects/mdl_projects');
        $this->load->model('appointments/mdl_appointments');
        $this->load->model('expenses/mdl_expenses');
        $this->load->model('website_access/mdl_website_access');
        $this->load->model('todo_tickets/mdl_todo_tickets');



        $website_access = $this->mdl_website_access->where('website_access_project_id',$project_id)->get()->result();

        $expenses_amount = 0;
        $project = $this->mdl_projects->get_by_id($project_id);

        $project_notes =$this->mdl_projects_notes->where('project_id',$project->project_id)->get()->result();

        if (!$project) {
            show_404();
        }

        if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
            $projects_groups = $this->mdl_projects->read_groups_for_project($project->project_id);
            $projectgroup = array('project_id' => $project->project_id, 'group_id' => $this->session->userdata('user_group_id'));
            $key = array_search($projectgroup, $projects_groups);
            if ($key === false && $this->session->userdata('user_type') != TYPE_ADMIN) {
                show_404();
            }
        }














        if (!empty($_GET) && !empty($_GET['todo_task_id']) && count($_GET['todo_task_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_invoice") {
            $this->load->model('invoices/mdl_invoices');
            $this->load->model('invoices/mdl_item_amounts');
            $this->load->model('invoices/mdl_invoice_amounts');
            $this->load->model('todo_tickets/mdl_todo_tasks');
            $this->load->model('todo_tickets/mdl_todo_tickets');

            $db_array = array();
            $db_array["user_id"] = $this->session->userdata('user_id');
            $db_array["client_id"] = $project->client_id;
            $db_array["invoice_password"] = "";
            $db_array["invoice_date_created"] = date("Y-m-d");
            $db_array["invoice_discount_amount"] = 0;
            $db_array["invoice_discount_percent"] = 0;
            $db_array["invoice_terms"] = "";
            $db_array["invoice_url_key"] = $this->mdl_invoices->get_url_key();
            $db_array["invoice_group_id"] = get_setting('default_invoice_group');
            $db_array["invoice_number"] = $this->mdl_invoices->get_invoice_number(get_setting('default_invoice_group'));
            $db_array["payment_method"] = "";
            $db_array["invoice_terms"] = get_setting('default_invoice_terms');
            $date = date("Y-m-d");
            $db_array["invoice_date_due"] = date('Y-m-d', strtotime($date . ' + 14 days'));
            $this->db->insert("ip_invoices", $db_array);
            $invoice_id = $this->db->insert_id();


            foreach ($_GET['todo_task_id'] as $key => $value)
            {
                $todo_task_id = $value;
                $todo_task = $this->mdl_todo_tasks->get_by_id($todo_task_id);
                $todo_ticket_user_id = $this->mdl_todo_tickets->get_by_id($todo_task->todo_ticket_id);

                $user = $this->mdl_users->get_by_id($todo_ticket_user_id->todo_ticket_assigned_user_id);
                $todo_task->default_hour_rate  = ($this->calculete_todo_tickets($todo_task) * $user->default_hour_rate) * $user->multiplier;

                $db_array = array();
                $db_array["invoice_id"] = $invoice_id;
                $db_array["item_task_id"] = $todo_task_id;
                $db_array["item_date_added"] =''; //$todo_task->task_finish_date
                $db_array["item_name"] = $todo_task->todo_task_text;
                $db_array["item_product_SKU"] = "";
                $db_array["item_description"] = '';
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $todo_task->default_hour_rate;
                $db_array["item_discount_amount"] = 0;
                $db_array["item_is_recurring"] = 0;
                $db_array["item_tax_rate_id"] ='' ; //$todo_task->tax_rate_id

                $this->db->insert("ip_invoice_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_item_amounts->calculate($item_id);

            }

            $this->mdl_invoice_amounts->calculate($invoice_id);

            $this->session->set_flashdata('alert_success', trans('invoice_successfully_created'));
            redirect('invoices/view/' .$invoice_id);
        }
        else if (!empty($_GET) && !empty($_GET['todo_task_id']) && count($_GET['todo_task_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_quote") {



            $this->load->model('quotes/mdl_quotes');
            $this->load->model('quotes/mdl_quote_item_amounts');
            $this->load->model('quotes/mdl_quote_amounts');
            $this->load->model('todo_tickets/mdl_todo_tasks');
            $this->load->model('todo_tickets/mdl_todo_tickets');

            $db_array = array();
            $db_array["user_id"] = $this->session->userdata('user_id');
            $db_array["client_id"] = $project->client_id;
            $db_array["invoice_group_id"] = get_setting('default_invoice_group');
            $db_array["quote_password"] = "";
            $db_array["quote_date_created"] = date("Y-m-d");
            $db_array["quote_discount_amount"] = 0;
            $db_array["quote_discount_percent"] = 0;
            $db_array["notes"] = "";
            $db_array["quote_url_key"] = $this->mdl_quotes->get_url_key();
            $db_array["notes"] = get_setting('default_quote_notes', '', true);
            $date = date("Y-m-d");
            $db_array["quote_date_expires"] = date('Y-m-d', strtotime($date . ' + 14 days'));

            $this->db->insert("ip_quotes", $db_array);
            $quote_id = $this->db->insert_id();


            foreach ($_GET['todo_task_id'] as $key => $value)
            {
                $todo_task_id = $value;
                $todo_task = $this->mdl_todo_tasks->get_by_id($todo_task_id);
                $todo_ticket_user_id = $this->mdl_todo_tickets->get_by_id($todo_task->todo_ticket_id);

                $user = $this->mdl_users->get_by_id($todo_ticket_user_id->todo_ticket_assigned_user_id);
                $todo_task->default_hour_rate  = ($this->calculete_todo_tickets($todo_task) * $user->default_hour_rate) * $user->multiplier;

                $db_array = array();
                $db_array["quote_id"] = $quote_id;
                $db_array["item_tax_rate_id"] = ''; //$task->tax_rate_id
                $db_array["item_date_added"] = '';  //$task->task_finish_date
                $db_array["item_task_id"] = $todo_task_id;
                $db_array["item_name"] = $todo_task->todo_task_text;
                $db_array["item_description"] = ''; //$task->task_description
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $todo_task->default_hour_rate;
                $db_array["item_discount_amount"] = 0;

                $this->db->insert("ip_quote_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_quote_item_amounts->calculate($item_id);

            }

            $this->mdl_quote_amounts->calculate($quote_id);

            $this->session->set_flashdata('alert_success', trans('quote_successfully_created'));
            redirect('quotes/view/' .$quote_id);
        }








/** Generate INVOICE Appointment**/



        if (!empty($_GET) && !empty($_GET['appointment_id']) && count($_GET['appointment_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_invoice") {


            $this->load->model('invoices/mdl_invoices');
            $this->load->model('invoices/mdl_item_amounts');
            $this->load->model('invoices/mdl_invoice_amounts');
            $this->load->model('appointments/mdl_appointments');

            $db_array = array();
            $db_array["user_id"] = $this->session->userdata('user_id');
            $db_array["client_id"] = $project->client_id;
            $db_array["invoice_password"] = "";
            $db_array["invoice_date_created"] = date("Y-m-d");
            $db_array["invoice_discount_amount"] = 0;
            $db_array["invoice_discount_percent"] = 0;
            $db_array["invoice_terms"] = "";
            $db_array["invoice_url_key"] = $this->mdl_invoices->get_url_key();
            $db_array["invoice_group_id"] = get_setting('default_invoice_group');
            $db_array["invoice_number"] = $this->mdl_invoices->get_invoice_number(get_setting('default_invoice_group'));
            $db_array["payment_method"] = "";
            $db_array["invoice_terms"] = get_setting('default_invoice_terms');
            $date = date("Y-m-d");
            $db_array["invoice_date_due"] = date('Y-m-d', strtotime($date . ' + 14 days'));
            $this->db->insert("ip_invoices", $db_array);
            $invoice_id = $this->db->insert_id();

            /** The klm * price  INVOICE **/
            foreach ($_GET['appointment_id'] as $key => $value)
            {
                $appointment_id = $value;
                $appointment = $this->mdl_appointments->get_by_id($appointment_id);
                $appointment_kilometer_total = $appointment->appointment_kilometers *  $appointment->appointment_price_per_kilometer;

                $db_array = array();
                $db_array["invoice_id"] = $invoice_id;
                $db_array["item_task_id"] = '';
                $db_array["item_date_added"] ='';
                $db_array["item_name"] = $appointment->appointment_title;
                $db_array["item_product_SKU"] = "";
                $db_array["item_description"] =$appointment->appointment_description;
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $appointment_kilometer_total;
                $db_array["item_discount_amount"] = 0;
                $db_array["item_is_recurring"] = 0;
                $db_array["item_tax_rate_id"] ='' ;

                $this->db->insert("ip_invoice_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_item_amounts->calculate($item_id);

            }


/** The total * hourly  INVOICE **/

            foreach ($_GET['appointment_id'] as $key => $value)
            {
                $appointment_id = $value;
                $appointment = $this->mdl_appointments->get_by_id($appointment_id);
                $user = $this->mdl_users->get_by_id($appointment->appointment_user_id);
                $appointment->default_hour_rate  = $this->calculete_appointment($appointment) * $user->default_hour_rate;


                $db_array = array();
                $db_array["invoice_id"] = $invoice_id;
                $db_array["item_task_id"] = '';
                $db_array["item_date_added"] ='';
                $db_array["item_name"] = $appointment->appointment_title;
                $db_array["item_product_SKU"] = "";
                $db_array["item_description"] =$appointment->appointment_description;
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $appointment->default_hour_rate;
                $db_array["item_discount_amount"] = 0;
                $db_array["item_is_recurring"] = 0;
                $db_array["item_tax_rate_id"] ='' ;

                $this->db->insert("ip_invoice_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_item_amounts->calculate($item_id);

            }




            $this->mdl_invoice_amounts->calculate($invoice_id);

            $this->session->set_flashdata('alert_success', trans('invoice_successfully_created'));
            redirect('invoices/view/' .$invoice_id);
        }
        else if (!empty($_GET) && !empty($_GET['appointment_id']) && count($_GET['appointment_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_quote") {



            $this->load->model('quotes/mdl_quotes');
            $this->load->model('quotes/mdl_quote_item_amounts');
            $this->load->model('quotes/mdl_quote_amounts');
            $this->load->model('appointments/mdl_appointments');

            $db_array = array();
            $db_array["user_id"] = $this->session->userdata('user_id');
            $db_array["client_id"] = $project->client_id;
            $db_array["invoice_group_id"] = get_setting('default_invoice_group');
            $db_array["quote_password"] = "";
            $db_array["quote_date_created"] = date("Y-m-d");
            $db_array["quote_discount_amount"] = 0;
            $db_array["quote_discount_percent"] = 0;
            $db_array["notes"] = "";
            $db_array["quote_url_key"] = $this->mdl_quotes->get_url_key();
            $db_array["notes"] = get_setting('default_quote_notes', '', true);
            $date = date("Y-m-d");
            $db_array["quote_date_expires"] = date('Y-m-d', strtotime($date . ' + 14 days'));

            $this->db->insert("ip_quotes", $db_array);
            $quote_id = $this->db->insert_id();

            /** The klm * price  INVOICE **/
            foreach ($_GET['appointment_id'] as $key => $value)
            {

                $appointment_id = $value;
                $appointment = $this->mdl_appointments->get_by_id($appointment_id);
                $appointment_kilometer_total = $appointment->appointment_kilometers *  $appointment->appointment_price_per_kilometer;


                $db_array = array();
                $db_array["quote_id"] = $quote_id;
                $db_array["item_tax_rate_id"] = '';
                $db_array["item_date_added"] = '';
                $db_array["item_task_id"] = '';
                $db_array["item_name"] = $appointment->appointment_title;
                $db_array["item_description"] = $appointment->appointment_description;
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $appointment_kilometer_total;
                $db_array["item_discount_amount"] = 0;

                $this->db->insert("ip_quote_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_quote_item_amounts->calculate($item_id);

            }

            /** The total * hourly  QUOTE **/

            foreach ($_GET['appointment_id'] as $key => $value)
            {

                $appointment_id = $value;
                $appointment = $this->mdl_appointments->get_by_id($appointment_id);
                $user = $this->mdl_users->get_by_id($appointment->appointment_user_id);
                $appointment->default_hour_rate  = $this->calculete_appointment($appointment) * $user->default_hour_rate;

                $db_array = array();
                $db_array["quote_id"] = $quote_id;
                $db_array["item_tax_rate_id"] = '';
                $db_array["item_date_added"] = '';
                $db_array["item_task_id"] = '';
                $db_array["item_name"] = $appointment->appointment_title;
                $db_array["item_description"] = $appointment->appointment_description;
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $appointment->default_hour_rate;
                $db_array["item_discount_amount"] = 0;

                $this->db->insert("ip_quote_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_quote_item_amounts->calculate($item_id);

            }

            $this->mdl_quote_amounts->calculate($quote_id);

            $this->session->set_flashdata('alert_success', trans('quote_successfully_created'));
            redirect('quotes/view/' .$quote_id);
        }








































if (!empty($_GET) && !empty($_GET['expenses_id']) && count($_GET['expenses_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_quote") {

            $this->load->model('quotes/mdl_quotes');
            $this->load->model('quotes/mdl_quote_item_amounts');
            $this->load->model('quotes/mdl_quote_amounts');
            $this->load->model('expenses/mdl_expenses');

            $db_array = array();
            $db_array["user_id"] = $this->session->userdata('user_id');
            $db_array["client_id"] = $project->client_id;
            $db_array["invoice_group_id"] = get_setting('default_invoice_group');
            $db_array["quote_password"] = "";
            $db_array["quote_date_created"] = date("Y-m-d");
            $db_array["quote_discount_amount"] = 0;
            $db_array["quote_discount_percent"] = 0;
            $db_array["notes"] = "";
            $db_array["quote_url_key"] = $this->mdl_quotes->get_url_key();
            $db_array["notes"] = get_setting('default_quote_notes', '', true);
            $date = date("Y-m-d");
            $db_array["quote_date_expires"] = date('Y-m-d', strtotime($date . ' + 14 days'));

            $this->db->insert("ip_quotes", $db_array);
            $quote_id = $this->db->insert_id();


            foreach ($_GET['expenses_id'] as $key => $value)
            {
                $expenses_id = $value;
                $expenses = $this->mdl_expenses->get_by_id($expenses_id);
                $multiplier = 1;
                $default_tax_rate_id = 0;
                if(!empty($expenses->expenses_user_id)){
                    $user = $this->mdl_users->where('user_id',$expenses->expenses_user_id)->get()->row();
                    $multiplier = ($user->multiplier != 0 )?$user->multiplier:1;
                    $default_tax_rate_id = $user->default_tax_rate_id;
                }

                if($expenses->expenses_currency == 'euro'){
                    $expenses_amount = $expenses->expenses_amount_euro;
                }else{
                    $expenses_amount = $expenses->expenses_amount;
                }


                $db_array = array();
                $db_array["quote_id"] = $quote_id;
                $db_array["item_tax_rate_id"] = $default_tax_rate_id;
                $db_array["item_date_added"] = $expenses->expenses_date;
                $db_array["item_task_id"] = $expenses_id;
                $db_array["item_name"] = $expenses->expenses_name;
                $db_array["item_description"] = '';
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $expenses_amount * $multiplier;
                $db_array["item_discount_amount"] = 0;

                $this->db->insert("ip_quote_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_quote_item_amounts->calculate($item_id);
            }

            $this->mdl_quote_amounts->calculate($quote_id);

            $this->session->set_flashdata('alert_success', trans('quote_successfully_created'));

            redirect('quotes/view/' .$quote_id);
        }else
            if (!empty($_GET) && !empty($_GET['expenses_id']) && count($_GET['expenses_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_invoice") {

            $this->load->model('invoices/mdl_invoices');
            $this->load->model('invoices/mdl_item_amounts');
            $this->load->model('invoices/mdl_invoice_amounts');
            $this->load->model('expenses/mdl_expenses');

            $db_array = array();
            $db_array["user_id"] = $this->session->userdata('user_id');
            $db_array["client_id"] = $project->client_id;
            $db_array["invoice_password"] = "";
            $db_array["invoice_date_created"] = date("Y-m-d");
            $db_array["invoice_discount_amount"] = 0;
            $db_array["invoice_discount_percent"] = 0;
            $db_array["invoice_terms"] = "";
            $db_array["invoice_url_key"] = $this->mdl_invoices->get_url_key();
            $db_array["invoice_group_id"] = get_setting('default_invoice_group');
            $db_array["invoice_number"] = $this->mdl_invoices->get_invoice_number(get_setting('default_invoice_group'));
            $db_array["payment_method"] = "";
            $db_array["invoice_terms"] = get_setting('default_invoice_terms');
            $date = date("Y-m-d");
            $db_array["invoice_date_due"] = date('Y-m-d', strtotime($date . ' + 14 days'));
            $this->db->insert("ip_invoices", $db_array);
            $invoice_id = $this->db->insert_id();


            foreach ($_GET['expenses_id'] as $key => $value)
            {

                $expenses_id = $value;
                $expenses = $this->mdl_expenses->get_by_id($expenses_id);
                $multiplier = 1;
                $default_tax_rate_id = 0;
                if(!empty($expenses->expenses_user_id)){
                    $user = $this->mdl_users->where('user_id',$expenses->expenses_user_id)->get()->row();
                    $multiplier = ($user->multiplier != 0 )?$user->multiplier:1;
                    $default_tax_rate_id = $user->default_tax_rate_id;
                }


                if($expenses->expenses_currency == 'euro'){
                    $expenses_amount = $expenses->expenses_amount_euro;
                }else{
                    $expenses_amount = $expenses->expenses_amount;
                }



                $db_array = array();
                $db_array["invoice_id"] = $invoice_id;
                $db_array["item_task_id"] = '';
                $db_array["item_date_added"] = $expenses->expenses_date;
                $db_array["item_name"] = $expenses->expenses_name;
                $db_array["item_product_SKU"] = "";
                $db_array["item_description"] = '';
                $db_array["item_quantity"] = 1;
                $db_array["item_price"] = $expenses_amount * $multiplier;
                $db_array["item_discount_amount"] = 0;
                $db_array["item_is_recurring"] = 0;
                $db_array["item_tax_rate_id"] = $default_tax_rate_id;

                $this->db->insert("ip_invoice_items", $db_array);
                $item_id = $this->db->insert_id();

                $this->mdl_item_amounts->calculate($item_id);


            }

            $this->mdl_invoice_amounts->calculate($invoice_id);

            $this->session->set_flashdata('alert_success', trans('invoice_successfully_created'));
            redirect('invoices/view/' .$invoice_id);
        }

        $this->load->model('todo_tickets/mdl_todo_tasks');






        $appointments=$this->mdl_appointments->where('ip_appointments.project_id',$project->project_id)->get()->result();
        $expenses=$this->mdl_expenses->where('ip_expenses.expenses_project_id',$project->project_id)->get()->result();



        $todo_tasks  = $this->mdl_todo_tasks->where('ip_todo_tasks.todo_task_project_id',$project->project_id)->get()->result();

        foreach ($todo_tasks as $key => &$todo_task) {
            $todo_ticket  = $this->mdl_todo_tickets->where('ip_todo_tickets.todo_ticket_id',$todo_task->todo_ticket_id)->get()->row();
            if(!empty($todo_ticket->todo_ticket_assigned_user_id)){
                $user = $this->mdl_users->get_by_id($todo_ticket->todo_ticket_assigned_user_id);
                $multiplier = (!empty($user->multiplier))?$user->multiplier:1;
                $default_hour_rate = (!empty($user->default_hour_rate))?$user->default_hour_rate:1;
                $todo_task->default_hour_rate  = ($this->calculete_todo_tickets($todo_task) * $default_hour_rate) * $multiplier;
            }else{
                $todo_task->default_hour_rate = 0;
            }

        }


        $this->layout->set(array(
            'todo_tasks' => $todo_tasks,
            'appointments' => $appointments,
            'expenses' => $expenses,
            'sum_expenses' => $this->sum_expenses($expenses),
            'project' => $project,
            'project_groups' => $this->mdl_projects->read_groups_for_project($project->project_id),
            'user_groups' => $this->mdl_user_groups->get()->result(),
            'projects_notes' => $project_notes,
            'website_access' => $website_access,
        ));
        $this->layout->buffer(
            array(
                array(
                    'partial_project',
                    'projects/partial_project'
                ),
                array(
                    'content',
                    'projects/view'
                )
            )
        );
        $this->layout->render();
    }


    public function calculete_appointment($appointment,$total_minute = 0){

        $time  =  explode(':',$appointment->appointment_total_time_of);
        if(!empty($time)){

            if($time[0]>0){
                $total_minute = $time[0]*60;
            }

            if($time[1] > 0){
                $total_minute =$total_minute + $time[1];
            }


            if($total_minute > 59){
                $total_minute =  $total_minute / 60;
            }else{
                $total_minute  = $total_minute * 100 / 60;
                $total_minute =sprintf("0.%d", $total_minute);

            }
            return $total_minute;
        }


    }

    public function calculete_todo_tickets($todo_task,$total_minute = 0){

        $time  =  explode(':',$todo_task->todo_task_number_of_hours);
        if(!empty($time)){

            if($time[0]>0){
                $total_minute = $time[0]*60;
            }

            if($time[1] > 0){
                $total_minute =$total_minute + $time[1];
            }


            if($total_minute > 59){
                $total_minute =  $total_minute / 60;
            }else{
                $total_minute  = $total_minute * 100 / 60;
                $total_minute =sprintf("0.%d", $total_minute);

            }
            return $total_minute;
        }


    }

    public function sum_expenses($expenses,$sum = []){

//        $expenses = $this->mdl_expenses->get()->result();

        $sum['dollar'] = 0;
        $sum['euro'] = 0;
        foreach ($expenses as $s){
            if($s->expenses_currency == 'euro'){
                $sum['euro']+= $s->expenses_amount_euro;
            }else{
                $sum['dollar']+= $s->expenses_amount;
            }
        }
        return $sum;
    }

    public function total_price_expenses($sum  = []){
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


    public function sum($arr,$fild_name,$sum=0){
        foreach ($arr as $i){
            $sum+=$i->$fild_name;
        }

        return $sum;

    }

    /**
     * @param $id
     */
    public function delete($id)
    {

        $success = [TYPE_ADMINISTRATOR];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        // only Managers and Admin can delete projects
        if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
            $projects_groups = $this->mdl_projects->read_groups_for_project($id);
            $projectgroup = array('project_id' => $id, 'group_id' => $this->session->userdata('user_group_id'));
            $key = array_search($projectgroup, $projects_groups);
            if ($key === false && $this->session->userdata('user_type') != TYPE_ADMIN) {
                show_404();
            }
        }
        else if ($this->session->userdata('user_type') != TYPE_ADMIN) {
            show_404();
        }


        $this->mdl_projects->delete($id);
        redirect('projects');
    }

}

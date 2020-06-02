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
 * Class View
 */
class View extends Base_Controller
{
    /**
     * @param $invoice_url_key
     */
    public function invoice($invoice_url_key = '')
    {
        if (!$invoice_url_key) {
            show_404();
        }

        $this->load->model('invoices/mdl_invoices');
        $this->load->model('offers/mdl_offers');
        $this->load->helper('country');

        $invoice = $this->mdl_invoices->guest_visible()->where('invoice_url_key', $invoice_url_key)->get();

        if ($invoice->num_rows() != 1) {
            show_404();
        }

        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('companies/mdl_companies');

        $invoice = $invoice->row();

        if ($this->session->userdata('user_type') <> TYPE_ADMIN and $invoice->invoice_status_id == 2) {
            $this->mdl_invoices->mark_viewed($invoice->invoice_id);
        }

        $payment_method = $this->mdl_payment_methods->where('payment_method_id', $invoice->payment_method)->get()->row();
        if ($invoice->payment_method == 0) {
            $payment_method = null;
        }

        // Get all custom fields
        $custom_fields = array(
            'invoice' => $this->mdl_custom_fields->get_values_for_fields('mdl_invoice_custom', $invoice->invoice_id),
            'client' => $this->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $invoice->client_id),
            'user' => $this->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $invoice->user_id),
        );

        // Attachments
        $attachments = $this->get_attachments($invoice_url_key);

        $is_overdue = ($invoice->invoice_balance > 0 && strtotime($invoice->invoice_date_due) < time() ? true : false);

        $offer = null;
        if ($invoice->parrent_offer_id != 0)
        {
            $offer = $this->mdl_offers->get_by_id($invoice->parrent_offer_id);
        }
        $companies = $this->mdl_companies->where('ip_companies.id',$invoice->invoice_company_id)->get()->row();
        $data = array(
            'invoice' => $invoice,
            'items' => $this->mdl_items->where('invoice_id', $invoice->invoice_id)->get()->result(),
            'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice->invoice_id)->get()->result(),
            'invoice_url_key' => $invoice_url_key,
            'flash_message' => $this->session->flashdata('flash_message'),
            'payment_method' => $payment_method,
            'is_overdue' => $is_overdue,
            'attachments' => $attachments,
            'custom_fields' => $custom_fields,
            'offer' => $offer,
            'companies' => $companies
        );

        $this->load->view('invoice_templates/public/' . get_setting('public_invoice_template') . '.php', $data);
    }

    private function get_attachments($key)
    {
        $path = UPLOADS_FOLDER . '/customer_files';
        $files = scandir($path);
        $attachments = array();

        if ($files !== false) {
            foreach ($files as $file) {
                if ('.' != $file && '..' != $file && strpos($file, $key) !== false) {
                    $obj['name'] = substr($file, strpos($file, '_', 1) + 1);
                    $obj['fullname'] = $file;
                    $obj['size'] = filesize($path . '/' . $file);
                    $obj['fullpath'] = base_url($path . '/' . $file);
                    $attachments[] = $obj;
                }
            }
        }

        return $attachments;
    }

    /**
     * @param $invoice_url_key
     * @param bool $stream
     * @param null $invoice_template
     */
    public function generate_invoice_pdf($invoice_url_key, $stream = true, $invoice_template = null)
    {
        $this->load->model('invoices/mdl_invoices');

        $invoice = $this->mdl_invoices->guest_visible()->where('invoice_url_key', $invoice_url_key)->get();

        if ($invoice->num_rows() == 1) {
            $invoice = $invoice->row();

            if (!$invoice_template) {
                $invoice_template = get_setting('pdf_invoice_template');
            }

            $this->load->helper('pdf');

            generate_invoice_pdf($invoice->invoice_id, $stream, $invoice_template, 1);
        }
    }

    /**
     * @param $invoice_url_key
     * @param bool $stream
     * @param null $invoice_template
     */
    public function generate_sumex_pdf($invoice_url_key, $stream = true, $invoice_template = null)
    {
        $this->load->model('invoices/mdl_invoices');

        $invoice = $this->mdl_invoices->guest_visible()->where('invoice_url_key', $invoice_url_key)->get();

        if ($invoice->num_rows() == 1) {
            $invoice = $invoice->row();

            if ($invoice->sumex_id == NULL) {
                show_404();
                return;
            }

            if (!$invoice_template) {
                $invoice_template = get_setting('pdf_invoice_template');
            }

            $this->load->helper('pdf');

            generate_invoice_sumex($invoice->invoice_id);
        }
    }

    /**
     * @param $quote_url_key
     */
    public function quote($quote_url_key = '')
    {
        if (!$quote_url_key) {
            show_404();
        }

        $this->load->model('quotes/mdl_quotes');
        $this->load->model('companies/mdl_companies');

        $quote = $this->mdl_quotes->guest_visible()->where('quote_url_key', $quote_url_key)->get();

        if ($quote->num_rows() != 1) {
            show_404();
        }

        $this->load->model('quotes/mdl_quote_items');
        $this->load->model('quotes/mdl_quote_tax_rates');

        $quote = $quote->row();

        if ($this->session->userdata('user_type') <> TYPE_ADMIN and $quote->quote_status_id == 2) {
            $this->mdl_quotes->mark_viewed($quote->quote_id);
        }

        // Attachments
        $attachments = $this->get_attachments($quote_url_key);
        /*$path = '/uploads/customer_files';
        $files = scandir(getcwd() . $path);
        $attachments = array();

        if ($files !== false) {
            foreach ($files as $file) {
                if ('.' != $file && '..' != $file && strpos($file, $quote_url_key) !== false) {
                    $obj['name'] = substr($file, strpos($file, '_', 1) + 1);
                    $obj['fullname'] = $file;
                    $obj['size'] = filesize($path . '/' . $file);
                    $obj['fullpath'] = base_url($path . '/' . $file);
                    $attachments[] = $obj;
                }
            }
        }*/

        $is_expired = (strtotime($quote->quote_date_expires) < time() ? true : false);
        $companies = $this->mdl_companies->getCompanies();
        $data = array(
            'quote' => $quote,
            'items' => $this->mdl_quote_items->where('quote_id', $quote->quote_id)->get()->result(),
            'quote_tax_rates' => $this->mdl_quote_tax_rates->where('quote_id', $quote->quote_id)->get()->result(),
            'quote_url_key' => $quote_url_key,
            'flash_message' => $this->session->flashdata('flash_message'),
            'is_expired' => $is_expired,
            'attachments' => $attachments,
            'companies' => $companies,
        );
        $this->load->view('quote_templates/public/' . get_setting('public_quote_template') . '.php', $data);
    }

    /**
     * @param $quote_url_key
     * @param bool $stream
     * @param null $quote_template
     */
    public function generate_quote_pdf($quote_url_key, $stream = true, $quote_template = null)
    {
        $this->load->model('quotes/mdl_quotes');

        $quote = $this->mdl_quotes->guest_visible()->where('quote_url_key', $quote_url_key)->get();

        if ($quote->num_rows() == 1) {
            $quote = $quote->row();

            if (!$quote_template) {
                $quote_template = get_setting('pdf_quote_template');
            }

            $this->load->helper('pdf');

            generate_quote_pdf($quote->quote_id, $stream, $quote_template);
        }
    }

    /**
     * @param $quote_url_key
     */
    public function approve_quote($quote_url_key)
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->helper('mailer');

        $this->mdl_quotes->approve_quote_by_key($quote_url_key);
        email_quote_status($this->mdl_quotes->where('ip_quotes.quote_url_key', $quote_url_key)->get()->row()->quote_id, "approved");

        redirect('guest/view/quote/' . $quote_url_key);
    }

    /**
     * @param $quote_url_key
     */
    public function reject_quote($quote_url_key)
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->helper('mailer');

        $this->mdl_quotes->reject_quote_by_key($quote_url_key);
        email_quote_status($this->mdl_quotes->where('ip_quotes.quote_url_key', $quote_url_key)->get()->row()->quote_id, "rejected");

        redirect('guest/view/quote/' . $quote_url_key);
    }

    /**
     * @param $offer_url_key
     */
    public function offer($offer_url_key = '')
    {
        if (!$offer_url_key) {
            show_404();
        }

        $this->load->model('offers/mdl_offers');

        $offer = $this->mdl_offers->guest_visible()->where('offer_url_key', $offer_url_key)->get();

        if ($offer->num_rows() != 1) {
            show_404();
        }

        $this->load->model('offers/mdl_offer_items');
        $this->load->model('payment_methods/mdl_payment_methods');

        $offer = $offer->row();

        if ($this->session->userdata('user_type') <> TYPE_ADMIN and $offer->offer_status_id == 2) {
            $this->mdl_offers->mark_viewed($offer->offer_id);
        }

        $is_overdue = ($offer->offer_balance > 0 && strtotime($offer->offer_due_date) < time() ? true : false);


        if ($offer->transport_tax_rate_id != 0)
        {
            $offer->transport_tailgate = $offer->transport_tailgate  + $offer->transport_tailgate * $offer->transport_tax_rate_percent / 100;
            $offer->transport_without_tailgate = $offer->transport_without_tailgate  + $offer->transport_without_tailgate * $offer->transport_tax_rate_percent / 100;
        }


        $data = array(
            'offer' => $offer,
            'items' => $this->mdl_offer_items->where('offer_id', $offer->offer_id)->get()->result(),
            'offer_url_key' => $offer_url_key,
            'flash_message' => $this->session->flashdata('flash_message'),
            'is_overdue' => $is_overdue,
        );

        if ($offer->offer_status_id == 2) {
            $this->mdl_offers->mark_viewed($offer->offer_id);
        }

        $this->load->view('offer_templates/public/' . get_setting('public_offer_template') . '.php', $data);
    }

    /**
     * @param $offer_url_key
     * @param bool $stream
     * @param null $offer_template
     */
    public function generate_offer_pdf($offer_url_key, $stream = true, $offer_template = null)
    {
        $this->load->model('offers/mdl_offers');

        $offer = $this->mdl_offers->guest_visible()->where('offer_url_key', $offer_url_key)->get();

        if ($offer->num_rows() == 1) {
            $offer = $offer->row();

            if (!$offer_template) {
                $offer_template = get_setting('pdf_offer_template');
            }

            $this->load->helper('pdf');

            generate_offer_pdf($offer->offer_id, $stream, $offer_template, 1);
        }
    }

    /**
     * @param $offer_url_key
     */
    public function offer_accept($offer_url_key)
    {
        $this->load->model('offers/mdl_offers');

        try {
            $offer = $this->mdl_offers->guest_visible()->where('offer_url_key', $offer_url_key)->get();
            if ($offer->num_rows() != 1) {
                show_404();
            }

            $this->load->model('offers/mdl_offer_items');
            $this->load->model('payment_methods/mdl_payment_methods');

            $offer = $offer->row();

            $this->mdl_offers->approve_offer_by_id($offer->offer_id, $_POST['transport'], $_POST['comment']);

            $response = array(
                'success' => 1,
                'offer_id' => $offer->offer_id
            );
            echo json_encode($response);
        }
        catch (Exception $e) {
            $response = array(
                'success' => 0,
                'validation_errors' => 'unknown'
            );
            echo json_encode($response);
        }
    }

    /**
     * @param $offer_url_key
     */
    public function offer_decline($offer_url_key)
    {
        $this->load->model('offers/mdl_offers');

        try {
            $offer = $this->mdl_offers->guest_visible()->where('offer_url_key', $offer_url_key)->get();
            if ($offer->num_rows() != 1) {
                show_404();
            }

            $this->load->model('offers/mdl_offer_items');
            $this->load->model('payment_methods/mdl_payment_methods');

            $offer = $offer->row();

            $this->mdl_offers->decline_offer_by_id($offer->offer_id, $_POST['transport'], $_POST['comment']);

            $response = array(
                'success' => 1,
                'offer_id' => $offer->offer_id
            );
            echo json_encode($response);
        }
        catch (Exception $e) {
            $response = array(
                'success' => 0,
                'validation_errors' => 'unknown'
            );
            echo json_encode($response);
        }
    }

    public function notes($notes_url_key = '')
    {
        if (!$notes_url_key) {
            show_404();
        }

        $this->load->model('notes/mdl_notes');

        $notes_arr = $this->mdl_notes->where('notes_url_key', $notes_url_key)->get();

        if ($notes_arr->num_rows() != 1) {
            show_404();
        }

        $data = array(
            'notes' => $notes_arr->row(),
        );


       $this->load->view('note_templates/public/NotesPlane_web', $data);

    }


    public function project($project_notes_key = '')
    {

        if ($this->input->post('btn_cancel')) {
            redirect('projects');
        }

        $this->load->model('user_groups/mdl_user_groups');
        $this->load->model('projects/mdl_projects_notes');
        $this->load->model('projects/mdl_projects');
        $this->load->model('appointments/mdl_appointments');


        $project = $this->mdl_projects->where('project_notes_key',$project_notes_key)->get()->row();

        if (!$project) {
            show_404();
        }

        $project_notes =$this->mdl_projects_notes->where('project_id',$project->project_id)->get()->result();
         if (!empty($_GET) && !empty($_GET['task_id']) && count($_GET['task_id']) > 0 && !empty($_GET['btn_submit_tasks']) && $_GET['btn_submit_tasks'] == "create_quote") {

            $this->load->model('quotes/mdl_quotes');
            $this->load->model('quotes/mdl_quote_item_amounts');
            $this->load->model('quotes/mdl_quote_amounts');

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


            $this->mdl_quote_amounts->calculate($quote_id);

            $this->session->set_flashdata('alert_success', trans('quote_successfully_created'));
            redirect('quotes/view/' .$quote_id);
        }




        $appointments=$this->mdl_appointments->where('ip_appointments.project_id',$project->project_id)->get()->result();


        $this->layout->set(array(
            'appointments' => $appointments,
            'project' => $project,
            'project_groups' => $this->mdl_projects->read_groups_for_project($project->project_id),
            'user_groups' => $this->mdl_user_groups->get()->result(),
            'projects_notes' => $project_notes,
        ));
        $this->layout->buffer(
            array(
                array(
                    'partial_project',
                    'projects/partial_project'
                ),
                array(
                    'content',
                    'projects/partial_project_table'
                )
            )
        );

        $this->load->view('layout/includes/head');
        $this->load->view('projects/partial_project_table');
    }

    public function project_notes($project_notes_key = '')
    {
        $this->load->model('projects/mdl_projects');
        $this->load->model('notes/mdl_notes');
        $project = $this->mdl_projects->where('project_notes_key', $project_notes_key)->get()->row();
        $notes = $this->db->select('*')->from('ip_notes')->where('project_id', $project->project_id)->get()->result();

        if (empty($project)) {
            show_404();
        }

        $data = array(
            'notes' => $notes,
            'project' => $project,
        );

       $this->load->view('note_templates/public/NotesProject_web',$data);
    }

    public function client($client_url_key = '')
    {


        $this->load->model('clients/mdl_clients');
        $this->load->model('clients/mdl_client_notes');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('payments/mdl_payments');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_fields/mdl_client_custom');
        $this->load->model('commission_rates/mdl_commission_rates');
        $this->load->model('projects/mdl_projects');
        $this->load->model('invoices/mdl_invoices_recurring');
        $this->load->model('payment_arrangements/mdl_payment_arrangements');


        $x = $this->mdl_clients->where('client_url_key', $client_url_key)->get()->row();
        $client_id = $x->client_id;
        $commission_rate = $this->mdl_commission_rates->where('commission_rate_id',$x->commission_rate_id)->get()->row();

        $recurring_invoices = $this->mdl_invoices_recurring->where('ip_invoices.client_id',$client_id)->get()->result();



        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $client = $this->mdl_clients
                ->with_total()
                ->with_total_balance()
                ->with_total_paid()
                ->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))
                ->where('ip_clients.client_id', $client_id)
                ->get()->row();
        }
        else {
            $client = $this->mdl_clients
                ->with_total()
                ->with_total_balance()
                ->with_total_paid()
                ->where('ip_clients.client_id', $client_id)
                ->get()->row();
        }

        $custom_fields = $this->mdl_client_custom->get_by_client($client_id)->result();

        $this->mdl_client_custom->prep_form($client_id);
        if (!$client) {
            show_404();
        }

        $this->load->model('user_groups/mdl_user_groups');
        $client_groups = $this->mdl_clients->read_groups($client_id);


        $payment_arrangements = $this->mdl_payment_arrangements->where('payment_arrangement_client_id',$client_id)->get()->result();

        foreach ($payment_arrangements as $key => $val){

            $payment_arrangements[$key]->payment_arrangement_balance =$this->payment_arrangement_balance(json_decode($val->payment_arrangement_amount),$val->payment_arrangement_total_amount);


        }
        $this->layout->set(
            array(

                'commission_rate' => $commission_rate,
                'client' => $client,
                'client_notes' => $this->mdl_client_notes->where('client_id', $client_id)->get()->result(),
                'invoices' => $this->mdl_invoices->by_client($client_id)->limit(20)->get()->result(),
                'quotes' => $this->mdl_quotes->by_client($client_id)->limit(20)->get()->result(),
                'payments' => $this->mdl_payments->by_client($client_id)->limit(20)->get()->result(),
                'custom_fields' => $custom_fields,
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'invoice_statuses' => $this->mdl_invoices->statuses(),
                'client_groups' => $client_groups,
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'projects' => $this->mdl_projects->where('ip_projects.client_id',$client_id)->get()->result(),
                'recurring_invoices' => $recurring_invoices,
                'recur_frequencies'=> $this->mdl_invoices_recurring->recur_frequencies,
                'sum' => $this->sum(),
                 'payment_arrangements' => $payment_arrangements,
            )
        );

        $this->layout->buffer(
            array(
                array(
                    'invoice_table',
                    'invoices/partial_invoice_table_view'
                ),
                array(
                    'invoices_recurring_table',
                    'invoices/partial_recurring_table'
                ),
                array(
                    'quote_table',
                    'quotes/partial_quote_table'
                ),
                array(
                    'payment_table',
                    'payments/partial_payment_table_view'
                ),
                array(
                    'project_table',
                    'projects/partial_project_table_view'
                ),
                array(
                    'partial_notes',
                    'clients/partial_notes'
                ),
                array(
                    'payment_arrangements',
                    'payment_arrangements/partial_payment_table_view'
                ),
                array(
                    'content',
                    'clients/view'
                )
            )
        );

        if (empty($client)) {
            show_404();
        }


        $data = array(
            'client' => $client,
        );

        $data['menu'] = $this->load->view('layout/includes/head', NULL, TRUE);
       $this->load->view('clients/public/Client_web',$data);
    }
    public function payment_arrangement_balance($arr,$sum){

        $balance = 0;
        foreach ($arr as $amount){
            $balance+=(+$amount->amount);
        }
        return (+$sum) - $balance;

    }

    public function sum($sum = 0){
        $this->load->model('invoices/mdl_invoices_recurring');
        $invoices_recurring = $this->mdl_invoices_recurring->get()->result();
        foreach ($invoices_recurring as $i){
            $sum+= $i->invoice_total;
        }
        return 5;
    }



    public function appointment($appointment_url_key = '')
    {
        if (!$appointment_url_key) {
            show_404();
        }

        $this->load->model('appointments/mdl_appointments');
        $this->load->model('fleets/mdl_fleets');
        $appointment_arr = $this->mdl_appointments->where('appointment_url_key', $appointment_url_key)->get()->row();

        $defalut = $this->mdl_fleets->where('fleet_default_car',1)->where('fleet_user_id',$appointment_arr->appointment_user_id)->get()->row();
        $data = array(
            'defrault' => $defalut,
            'appointments' => $appointment_arr,
        );
       $this->load->view('appointment_templates/public/AppointmentsPlane_web', $data);

    }


    public function recurring_income($recurring_income_url_key = '')
    {
        if (!$recurring_income_url_key) {
            show_404();
        }

        $this->load->model('recurring_income/mdl_recurring_income');
        $recurring_income = $this->mdl_recurring_income->where('recurring_income_url_key', $recurring_income_url_key)->get()->row();

        $data = array(
            'recurring_income' => $recurring_income,
        );
       $this->load->view('recurring_income_templates/public/RecurringIncome_Web', $data);

    }

    public function todo_ticket($todo_ticket_url_key = '')
    {

        if (!$todo_ticket_url_key) {
            show_404();
        }



        $this->load->model('todo_tickets/mdl_todo_tickets');
        $this->load->helper('allowance');
        $this->load->model('todo_tickets/mdl_todo_tasks');
//        $ticket = $this->mdl_todo_tickets->where('ip_todo_tickets.todo_ticket_id', $todo_ticket_id)->get()->row();
        $ticket = $this->mdl_todo_tickets->where('todo_ticket_url_key', $todo_ticket_url_key)->get()->row();

        if (!$ticket) {
            show_404();
        }





        $todo_tasks = $this->mdl_todo_tasks->where('todo_ticket_id',$ticket->todo_ticket_id)->get()->result();

        $data= array(
            'todo_tasks' => $todo_tasks,
            'ticket' => $ticket,
            'ticket_statuses' => $this->mdl_todo_tickets->statuses()
        );






       $this->load->view('todo_ticket/public/Todo_ticket_view', $data);

    }



}

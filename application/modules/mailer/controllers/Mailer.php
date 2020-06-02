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
 * Class Mailer
 */
class Mailer extends NormalUser_Controller
{
    private $mailer_configured;

    /**
     * Mailer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('mailer');

        $this->mailer_configured = mailer_configured();

        if ($this->mailer_configured == false) {
            $this->layout->buffer('content', 'mailer/not_configured');
            $this->layout->render();
        }
    }

    /**
     * @param $invoice_id
     */
    public function invoice($invoice_id)
    {



        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('invoices/mdl_templates');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        $email_template_id = select_email_invoice_template($invoice);

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);
            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        // Get all custom fields
        $this->load->model('custom_fields/mdl_custom_fields');
        $custom_fields = array();
        foreach (array_keys($this->mdl_custom_fields->custom_tables()) as $table) {
            $custom_fields[$table] = $this->mdl_custom_fields->by_table($table)->get()->result();
        }



        $this->layout->set('selected_pdf_template', select_pdf_invoice_template($invoice));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'invoice')->get()->result());
        $this->layout->set('invoice', $invoice);
        $this->layout->set('custom_fields', $custom_fields);
        $this->layout->set('pdf_templates', $this->mdl_templates->get_invoice_templates());
        $this->layout->buffer('content', 'mailer/invoice');
        $this->layout->render();
    }

    /**
     * @param $offer_id
     */
    public function offer($offer_id)
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('offers/mdl_templates');
        $this->load->model('offers/mdl_offers');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $offer = $this->mdl_offers->get_by_id($offer_id);

        $email_template_id = select_email_offer_template($offer);

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);
            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        // Get all custom fields
        $this->load->model('custom_fields/mdl_custom_fields');
        $custom_fields = array();
        foreach (array_keys($this->mdl_custom_fields->custom_tables()) as $table) {
            $custom_fields[$table] = $this->mdl_custom_fields->by_table($table)->get()->result();
        }

        $this->layout->set('selected_pdf_template', select_pdf_offer_template($offer));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'offer')->get()->result());
        $this->layout->set('offer', $offer);
        //$this->layout->set('custom_fields', $custom_fields);
        $this->layout->set('pdf_templates', $this->mdl_templates->get_offer_templates());
        $this->layout->buffer('content', 'mailer/offer');
        $this->layout->render();
    }

    /**
     * @param $quote_id
     */
    public function quote($quote_id)
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('invoices/mdl_templates');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('upload/mdl_uploads');
        $this->load->model('email_templates/mdl_email_templates');

        $email_template_id = get_setting('email_quote_template');

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);
            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        // Get all custom fields
        $this->load->model('custom_fields/mdl_custom_fields');
        $custom_fields = array();
        foreach (array_keys($this->mdl_custom_fields->custom_tables()) as $table) {
            $custom_fields[$table] = $this->mdl_custom_fields->by_table($table)->get()->result();
        }

        $this->layout->set('selected_pdf_template', get_setting('pdf_quote_template'));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'quote')->get()->result());
        $this->layout->set('quote', $this->mdl_quotes->get_by_id($quote_id));
        $this->layout->set('custom_fields', $custom_fields);
        $this->layout->set('pdf_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->buffer('content', 'mailer/quote');
        $this->layout->render();

    }

    /**
     * @param $ticket_id
     */
    public function tickets($ticket_id)
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('tickets/mdl_tickets');
        $this->load->model('clients/mdl_clients');
        $this->load->model('users/mdl_users');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');
        $this->load->helper('allowance');

        $ticket = $this->mdl_tickets->get_by_id($ticket_id);

        if (!$ticket)
        {
            redirect('tickets/status/all');
        }

        if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
            $ticket->client_id == null && $ticket->project_client_id == null)
        {
            redirect('tickets/view/' . $ticket_id);
        }

        if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
            !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
        {
            redirect('tickets/status/all');
        }

        $client = null;

        if ($ticket->client_id != null)
        {
            $client = $this->mdl_clients->get_by_id($ticket->client_id);
        }
        else if($ticket->project_client_id == null)
        {
            $client = $this->mdl_clients->get_by_id($ticket->project_client_id);
        }

        $user_assigned = null;

        if ($ticket->ticket_assigned_user_id) {
            $user_assigned = $this->mdl_users->get_by_id($ticket->ticket_assigned_user_id);
        }

        $email_template_id = select_email_ticket_template($ticket);

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);
            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        //$this->layout->set('selected_pdf_template', select_pdf_invoice_template($invoice));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'ticket')->get()->result());
        $this->layout->set('ticket', $ticket);
        $this->layout->set('client', $client);
        $this->layout->set('user', $user_assigned);
        //$this->layout->set('pdf_templates', $this->mdl_templates->get_invoice_templates());
        $this->layout->buffer('content', 'mailer/tickets');
        $this->layout->render();
    }

    /**
     * @param $invoice_id
     */
    public function send_invoice($invoice_id)
    {

        $previous_url = $this->session->userdata('previous_url');

        if ($this->input->post('btn_cancel')) {
            redirect($previous_url);
        }

        if (!$this->mailer_configured) {
            return;
        }

        $to = $this->input->post('to_email');

        if (empty($to)) {
            $this->session->set_flashdata('alert_danger', trans('email_to_address_missing'));
            redirect('mailer/invoice/' . $invoice_id);
        }

        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');

        if (strlen($body) != strlen(strip_tags($body))) {
            $body = htmlspecialchars_decode($body);
        } else {
            $body = htmlspecialchars_decode(nl2br($body));
        }

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = $this->mdl_uploads->get_invoice_uploads($invoice_id);

        if (email_invoice($invoice_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            $this->mdl_invoices->mark_sent($invoice_id);
            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
            $this->mdl_invoices->send_msg($invoice_id);
            redirect($previous_url);
        } else {
            redirect($previous_url);
        }
    }

    public function send_ticket($ticket_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('tickets/view/' . $ticket_id);
        }

        if (!$this->mailer_configured) {
            return;
        }

        $to = $this->input->post('to_email');

        if (empty($to)) {
            $this->session->set_flashdata('alert_danger', trans('email_to_address_missing'));
            redirect('mailer/tickets/' . $ticket_id);
        }

        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $subject = $this->input->post('subject');
        $body = $this->input->post('body');

        if (strlen($body) != strlen(strip_tags($body))) {
            $body = htmlspecialchars_decode($body);
        } else {
            $body = htmlspecialchars_decode(nl2br($body));
        }

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');

        if (email_ticket($ticket_id, "", $from, $to, $subject, $body, $cc, $bcc, null)) {
            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
            redirect('tickets/view/' . $ticket_id);
        } else {
            redirect('mailer/ticket/' . $ticket_id);
        }
    }

    /**
     * @param $offer_id
     */
    public function send_offer($offer_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('offers/view/' . $offer_id);
        }

        if (!$this->mailer_configured) {
            return;
        }

        $to = $this->input->post('to_email');

        if (empty($to)) {
            $this->session->set_flashdata('alert_danger', trans('email_to_address_missing'));
            redirect('mailer/offer/' . $offer_id);
        }

        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');

        if (strlen($body) != strlen(strip_tags($body))) {
            $body = htmlspecialchars_decode($body);
        } else {
            $body = htmlspecialchars_decode(nl2br($body));
        }

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = $this->mdl_uploads->get_offer_uploads($offer_id);

        if (email_offer($offer_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            $this->mdl_offers->mark_sent($offer_id);
            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
            redirect('offers/view/' . $offer_id);
        } else {
            redirect('mailer/offer/' . $offer_id);
        }
    }


    /**
     * @param $quote_id
     */
    public function send_quote($quote_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('quotes/view/' . $quote_id);
        }

        if (!$this->mailer_configured) {
            return;
        }

        $to = $this->input->post('to_email');

        if (empty($to)) {
            $this->session->set_flashdata('alert_danger', trans('email_to_address_missing'));
            redirect('mailer/quote/' . $quote_id);
        }

        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');

        if (strlen($this->input->post('body')) != strlen(strip_tags($this->input->post('body')))) {
            $body = htmlspecialchars_decode($this->input->post('body'));
        } else {
            $body = htmlspecialchars_decode(nl2br($this->input->post('body')));
        }

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = $this->mdl_uploads->get_quote_uploads($quote_id);

        if (email_quote($quote_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            $this->mdl_quotes->mark_sent($quote_id);

            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));

            redirect('quotes/view/' . $quote_id);
        } else {
            redirect('mailer/quote/' . $quote_id);
        }
    }


    public function prospect_id($prospect_id)
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('leads/mdl_leads');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $prospect = $this->mdl_leads->get_by_id($prospect_id);
        $email_template_id = 4;

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);

            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }






        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'sales_marketing')->get()->result());
        $this->layout->set('prospect', $prospect);
        $this->layout->buffer('content', 'mailer/prospect');
        $this->layout->render();
    }



    public function prospect_email_address(){
        $this->load->model('leads/mdl_leads');
        if ($this->input->post('btn_cancel')) {
            redirect('leads/status/active');
        }

        if (!$this->mailer_configured) {
            return;
        }



        $prospect_email = explode(",", trim($_POST['to_email']));
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        if (strlen($body) != strlen(strip_tags($body))) {
            $body = htmlspecialchars_decode($body);
        } else {
            $body = htmlspecialchars_decode(nl2br($body));
        }
        foreach ($prospect_email as $email){
            $email = trim($email);
            if(!empty($email)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $db_prospect = $this->mdl_leads->where('ip_leads.lead_email', $email)->get()->row();
                    email_prospect($from, $email, $subject, $body, '',$db_prospect);

                }else{

                    $this->session->set_flashdata('alert_error', trans('email_to_address_missing'));
                    redirect('leads/status/active');
                }
            }

        }
        redirect('leads/status/active');





    }





    public function prospect()
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('leads/mdl_leads');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $data_prospect_id=$_POST['arr_email'];


        $prospect_data =  [];
        if(!empty($data_prospect_id)){
            foreach ($data_prospect_id as $prospect_id){
                $prospect = $this->mdl_leads->get_by_id($prospect_id);
                array_push($prospect_data,$prospect);
            }
        }
        $email_template_id = 4;


        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);

            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->get()->result());
        $this->layout->set('prospects', $prospect_data);
        $this->layout->buffer('content', 'mailer/prospect');
        $this->layout->render();
    }


    public function supplier()
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $data_prospect_id=$_POST['arr_email'];


        $supplier_data =  [];
        if(!empty($data_prospect_id)){
            foreach ($data_prospect_id as $supplier_id){
                $supplier = $this->mdl_suppliers->get_by_id($supplier_id);
                array_push($supplier_data,$supplier);
            }
        }
        $email_template_id = 4;


        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);

            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->get()->result());
        $this->layout->set('suppliers', $supplier_data);
        $this->layout->buffer('content', 'mailer/supplier');
        $this->layout->render();
    }




    public function supplier_email_address(){
        $this->load->model('suppliers/mdl_suppliers');
        if ($this->input->post('btn_cancel')) {
            redirect('suppliers/status/active');
        }

        if (!$this->mailer_configured) {
            return;
        }



        $supplier_email = explode(",", trim($_POST['to_email']));
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        if (strlen($body) != strlen(strip_tags($body))) {
            $body = htmlspecialchars_decode($body);
        } else {
            $body = htmlspecialchars_decode(nl2br($body));
        }
        foreach ($supplier_email as $email){
            $email = trim($email);
            if(!empty($email)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $db_supplier = $this->mdl_suppliers->where('ip_suppliers.supplier_email', $email)->get()->row();
                    email_prospect($from, $email, $subject, $body, '',$db_supplier);

                }else{

                    $this->session->set_flashdata('alert_error', trans('email_to_address_missing'));
                    redirect('suppliers/status/active');
                }
            }

        }
        redirect('suppliers/status/active');





    }




    public function distributor()
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('distributors/mdl_distributors');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $data_distributor_id=$_POST['arr_email'];


        $distributor_data =  [];
        if(!empty($data_distributor_id)){
            foreach ($data_distributor_id as $distributor_id){
                $distributor = $this->mdl_distributors->get_by_id($distributor_id);
                array_push($distributor_data,$distributor);
            }
        }
        $email_template_id = 4;


        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);

            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->get()->result());
        $this->layout->set('distributors', $distributor_data);
        $this->layout->buffer('content', 'mailer/distributor');
        $this->layout->render();
    }




    public function distributor_email_address(){
        $this->load->model('distributors/mdl_distributors');
        if ($this->input->post('btn_cancel')) {
            redirect('distributors/status/active');
        }

        if (!$this->mailer_configured) {
            return;
        }

        $distributor_email = explode(",", trim($_POST['to_email']));
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        if (strlen($body) != strlen(strip_tags($body))) {
            $body = htmlspecialchars_decode($body);
        } else {
            $body = htmlspecialchars_decode(nl2br($body));
        }
        foreach ($distributor_email as $email){
            $email = trim($email);
            if(!empty($email)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $db_distributor = $this->mdl_distributors->where('ip_distributors.distributor_email', $email)->get()->row();
                    email_prospect($from, $email, $subject, $body, '',$db_distributor);

                }else{

                    $this->session->set_flashdata('alert_error', trans('email_to_address_missing'));
                    redirect('distributors/status/active');
                }
            }

        }
        redirect('distributors/status/active');
    }
}

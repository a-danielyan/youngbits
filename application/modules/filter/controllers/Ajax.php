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
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function filter_invoices()
    {
        $this->load->model('invoices/mdl_invoices');

        $query = $this->input->post('filter_query');
        $keywords = explode(' ', $query);

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_invoices->like("CONCAT_WS('^',LOWER(invoice_number),invoice_date_created,invoice_date_due,LOWER(client_name),invoice_total,invoice_balance)", $keyword);
            }
        }

        $data = array(
            'invoices' => $this->mdl_invoices->get()->result(),
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);
    }

    public function filter_quotes()
    {
        $this->load->model('quotes/mdl_quotes');

        $query = $this->input->post('filter_query');
        $keywords = explode(' ', $query);

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_quotes->like("CONCAT_WS('^',LOWER(quote_number),quote_date_created,quote_date_expires,LOWER(client_name),quote_total)", $keyword);
            }
        }

        $data = array(
            'quotes' => $this->mdl_quotes->get()->result(),
            'quote_statuses' => $this->mdl_quotes->statuses()
        );

        $this->layout->load_view('quotes/partial_quote_table', $data);
    }

    public function filter_clients()
    {
        $this->load->model('clients/mdl_clients');
        $this->load->model('user_groups/mdl_user_groups');

        $query = $this->input->post('filter_query');
        $keywords = explode(' ', $query);

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_clients->like("CONCAT_WS('^',LOWER(client_name),LOWER(client_surname),LOWER(client_email),client_phone,client_active)", $keyword);
            }
        }
        $this->load->helper('country');
        $this->load->helper('custom_values');


        $clients = $this->mdl_clients->with_total_balance()->get()->result();

        foreach ($clients as $client){
            $client->client_groups = $this->mdl_clients->read_groups($client->client_id);
        }

        $data = array(
            'records' => $clients,
            'filter_display' => true,
            'filter_placeholder' => trans('filter_clients'),
            'filter_method' => 'filter_clients',
            'user_groups' => $this->mdl_user_groups->get()->result(),
        );


        $this->layout->load_view('clients/partial_client_table', $data);
    }

    public function filter_leads()
    {
        $this->load->model('leads/mdl_leads');

        $query = $this->input->post('filter_query');
        $keywords = explode(' ', $query);

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_leads->like("CONCAT_WS('^',LOWER(lead_name),LOWER(lead_surname),LOWER(lead_email),lead_phone,lead_active)", $keyword);
            }
        }

        $data = array(
            'records' => $this->mdl_leads->get()->result()
        );

        $this->layout->load_view('leads/partial_lead_table', $data);
    }

    public function filter_expenses()
    {
        $this->load->model('expenses/mdl_expenses');

        $query = $this->input->post('filter_query');

        $keywords = explode(' ', $query);

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_expenses->like("CONCAT_WS('^',expenses_name,expenses_category)", $keyword);
            }
        }

        $expenses =  $this->mdl_expenses->get()->result();
        foreach ($expenses as $expense){
            $expenses_document_link = unserialize($expense->expenses_document_link);
            if(is_array($expenses_document_link)){
                $expense->expenses_document_link = $expenses_document_link[0];
            }else{

                $expense->expenses_document_link = unserialize($expense->expenses_document_link);
            }

        }
        $data = array(
            'cash_banks'=>$this->mdl_expenses->cash_bank(),
            'records' =>$expenses
        );

        $this->layout->load_view('expenses/partial_expenses_table', $data);
    }

    public function filter_payments()
    {
        $this->load->model('payments/mdl_payments');

        $query = $this->input->post('filter_query');
        $keywords = explode(' ', $query);

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_payments->like("CONCAT_WS('^',payment_date,LOWER(invoice_number),LOWER(client_name),payment_amount,LOWER(payment_method_name),LOWER(payment_note))", $keyword);
            }
        }

        $data = array(
            'payments' => $this->mdl_payments->get()->result()
        );

        $this->layout->load_view('payments/partial_payment_table', $data);
    }

}

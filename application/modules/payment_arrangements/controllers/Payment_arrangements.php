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
 * Class payment_arrangements
 */
class Payment_arrangements extends Custom_Controller
{
    /**
     * payment_arrangements constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);

        $this->load->model('mdl_payment_arrangements');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_payment_arrangements->paginate(site_url('payment_arrangements/index'), $page);


        $payment_arrangements = $this->mdl_payment_arrangements->get()->result();
        foreach ($payment_arrangements as $key => $val){

            $payment_arrangements[$key]->payment_arrangement_balance =$this->payment_arrangement_balance(json_decode($val->payment_arrangement_amount),$val->payment_arrangement_total_amount);


        }


        $this->layout->set(
            array(
                'payment_arrangements' => $payment_arrangements,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_payment_arrangements'),
                'filter_method' => 'filter_payment_arrangements'
            )
        );

        $this->layout->buffer('content', 'payment_arrangements/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {

        if ($this->input->post('btn_cancel')) {
            redirect('payment_arrangements');
        }

        if ($this->mdl_payment_arrangements->run_validation()) {


            $id = $this->mdl_payment_arrangements->save($id);

            redirect('payment_arrangements');
        }


        if (!$this->input->post('btn_submit')) {

            $prep_form = $this->mdl_payment_arrangements->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }

            $this->load->model('custom_values/mdl_custom_values');

        } else {

            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_payment_arrangements->set_form_value('custom[' . $key . ']', $val);
                }
            }


        }

        $this->load->helper('custom_values');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_values/mdl_custom_values');

        $open_invoices = $this->mdl_invoices
            ->where('ip_invoice_amounts.invoice_balance >', 0)
            ->or_where('ip_invoice_amounts.invoice_balance <', 0)
            ->get()->result();



        $amounts = array();
        $invoice_payment_methods = array();
        foreach ($open_invoices as $open_invoice) {
            $amounts['invoice' . $open_invoice->invoice_id] = format_amount($open_invoice->invoice_balance);
            $invoice_payment_methods['invoice' . $open_invoice->invoice_id] = $open_invoice->payment_method;
        }

        $this->load->model('clients/mdl_clients');

        $amount='';
        $payment_arrangement_amount = $this->mdl_payment_arrangements->where('payment_arrangement_id',$id)->get()->row();
        if(!empty($payment_arrangement_amount)){
            $amount = json_decode($payment_arrangement_amount->payment_arrangement_amount);
        }


        $this->layout->set(
            array(
                'clients' => $this->mdl_clients->where('client_active', 1)->get()->result(),
                'client' => $this->mdl_clients->get_by_id($this->mdl_payment_arrangements->form_value('payment_arrangement_client_id', true)),
                'payment_arrangements_id' => $id,
                'payment_arrangement_amount' => $amount
            )
        );

        if ($id) {
            $this->layout->set('payment', $this->mdl_payment_arrangements->where('ip_payment_arrangements.payment_arrangement_id', $id)->get()->row());
        }

        $this->layout->buffer('content', 'payment_arrangements/form');
        $this->layout->render();

    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_payment_arrangements->delete($id);
        redirect('payment_arrangements');
    }

    public function payment_arrangement_balance($arr,$sum){

        $balance = 0;
        foreach ($arr as $amount){
            $balance+=(+$amount->amount);
        }
        return (+$sum) - $balance;

    }


}

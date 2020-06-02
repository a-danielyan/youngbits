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
 * Class Clients
 */
class Clients extends NormalUser_Controller
{
    /**
     * Clients constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_clients');
    }

    public function index()
    {
        // Display active clients by default
        redirect('clients/status/active');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $filter_group = 0, $page = 0){
        $this->session->set_userdata('previous_url', current_url());
        $this->load->model('user_groups/mdl_user_groups');
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_clients->$function();
        }

        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $this->mdl_clients->with_total_balance()
                ->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))
                ->paginate(site_url('clients/status/' . $status), $page);
        }
        else
        {
            if ($filter_group != 0) {
                $this->mdl_clients->with_total_balance()
                    ->where('ip_clients_groups.group_id', $filter_group)
                    ->paginate(site_url('clients/status/' . $status), $page);
            }
            else
            {
                $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status), $page);
            }
        }

        $clients = $this->mdl_clients->result();

        foreach ($clients as $client)
        {
            $client->client_groups = $this->mdl_clients->read_groups($client->client_id);
        }

        $this->layout->set(
            array(
                'records' => $clients,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_clients'),
                'filter_method' => 'filter_clients',
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'filter_group' => $filter_group,
            )
        );


        $this->layout->buffer('content', 'clients/index');
        $this->layout->render();
    }



    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $access=[TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$access)){
            redirect('clients');
        }
        $previous_url = $this->session->userdata('previous_url');




        if ($this->input->post('btn_cancel')) {
            redirect('clients');
        }
        
        $new_client = false;
        
        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('client_name') != '') {
            $check = $this->db->get_where('ip_clients', array(
                'client_name' => $this->input->post('client_name'),
                'client_surname' => $this->input->post('client_surname')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('client_already_exists'));
                redirect('clients/form');
            } else {
                $new_client = true;
            }
        }
        
        if ($this->mdl_clients->run_validation()) {

            if ($_FILES['attached_client_file']['name']) {

                $new_name = time().$_FILES["attached_client_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/clients',
                    'allowed_types' => 'doc|docx|pdf',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('attached_client_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect($previous_url);
                }
                $upload_data = $this->upload->data();

                $_POST['client_file'] = base_url() . "uploads/" . $upload_data['file_name'];
            }



            $id = $this->mdl_clients->save($id);

            if ($new_client) {
                $this->load->model('user_clients/mdl_user_clients');
                $this->mdl_user_clients->get_users_all_clients();
            }
            
            $this->load->model('custom_fields/mdl_client_custom');
            $result = $this->mdl_client_custom->save_custom($id, $this->input->post('custom'));

            if ($result !== true) {
                $this->session->set_flashdata('alert_error', $result);
                $this->session->set_flashdata('alert_success', null);
                redirect($previous_url);
                return;
            } else {
                redirect($previous_url);
            }
        }

        if ($id and !$this->input->post('btn_submit')) {

            if (!$this->mdl_clients->prep_form($id)) {
                show_404();
            }

            $this->load->model('custom_fields/mdl_client_custom');
            $this->mdl_clients->set_form_value('is_update', true);

            $client_custom = $this->mdl_client_custom->where('client_id', $id)->get();

            if ($client_custom->num_rows()) {
                $client_custom = $client_custom->row();

                unset($client_custom->client_id, $client_custom->client_custom_id);

                foreach ($client_custom as $key => $val) {
                    $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {
            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }


        $this->load->model('commission_rates/mdl_commission_rates');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_values/mdl_custom_values');
        $this->load->model('custom_fields/mdl_client_custom');
        $this->load->model('user_groups/mdl_user_groups');

        $commission_rates = $this->mdl_commission_rates->where('commission_rate_user_id',$this->session->userdata('user_id'))->get()->result();
        $custom_fields = $this->mdl_custom_fields->by_table('ip_client_custom')->get()->result();
        $custom_values = [];
        foreach ($custom_fields as $custom_field) {
            if (in_array($custom_field->custom_field_type, $this->mdl_custom_values->custom_value_fields())) {
                $values = $this->mdl_custom_values->get_by_fid($custom_field->custom_field_id)->result();
                $custom_values[$custom_field->custom_field_id] = $values;
            }
        }

        $fields = $this->mdl_client_custom->get_by_clid($id);

        foreach ($custom_fields as $cfield) {
            foreach ($fields as $fvalue) {
                if ($fvalue->client_custom_fieldid == $cfield->custom_field_id) {
                    // TODO: Hackish, may need a better optimization
                    $this->mdl_clients->set_form_value(
                        'custom[' . $cfield->custom_field_id . ']',
                        $fvalue->client_custom_fieldvalue
                    );
                    break;
                }
            }
        }

        $this->load->helper('country');
        $this->load->helper('custom_values');


        $client_groups = $this->mdl_clients->read_groups($this->mdl_clients->form_value('client_id'));

        if ($this->session->userdata('user_type') <> TYPE_ADMIN && $new_client != false) {
            $found = false;
            foreach ($client_groups as $client_group){
                if ($client_group["group_id"] == $this->session->userdata('user_group_id')) {
                    $found = true;
                }
            }
            if (!$found)
            {
                redirect('clients');
            }
        }


        $this->layout->set(
            array(
               /* 'commission_rate_id' => $commission_rate_id,*/
                'commission_rates' => $commission_rates,
                'custom_fields' => $custom_fields,
                'custom_values' => $custom_values,
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_clients->form_value('client_country') ?: get_setting('default_country'),
                'delivery_selected_country' => $this->mdl_clients->form_value('client_country_delivery') ?: get_setting('default_country'),
                'languages' => get_available_languages(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'client_groups' => $client_groups
            )
        );

        if($this->session->userdata('user_type') != TYPE_ACCOUNTANT){
            $this->layout->buffer('content', 'clients/form');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }

    }

    /**
     * @param int $client_id
     */
    public function view($client_id)
    {
        $this->load->model('clients/mdl_client_notes');
        $this->load->model('payment_arrangements/mdl_payment_arrangements');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('payments/mdl_payments');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_fields/mdl_client_custom');

        //$client;

        if ($this->session->userdata('user_type') != TYPE_ADMIN)
        {
            $client = $this->mdl_clients
                ->with_total()
                ->with_total_balance()
                ->with_total_paid()
                ->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))
                ->where('ip_clients.client_id', $client_id)
                ->get()->row();
        }else {
            $client = $this->mdl_clients
                ->with_total()
                ->with_total_balance()
                ->with_total_paid()
                ->where('ip_clients.client_id', $client_id)
                ->get()->row();
        }

        if(!$client){
            show_404();

        }
        $custom_fields = $this->mdl_client_custom->get_by_client($client_id)->result();

        $this->mdl_client_custom->prep_form($client_id);


        $this->load->model('user_groups/mdl_user_groups');
        $client_groups = $this->mdl_clients->read_groups($client_id);


        $payment_arrangements = $this->mdl_payment_arrangements->where('payment_arrangement_client_id',$client_id)->get()->result();
        foreach ($payment_arrangements as $key => $val){

            $payment_arrangements[$key]->payment_arrangement_balance =$this->payment_arrangement_balance(json_decode($val->payment_arrangement_amount),$val->payment_arrangement_total_amount);


        }

        $this->layout->set(
            array(
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
                'payment_arrangements' => $payment_arrangements,
            )
        );



        $this->layout->buffer(
            array(
                array(
                    'invoice_table',
                    'invoices/partial_invoice_table'
                ),
                array(
                    'quote_table',
                    'quotes/partial_quote_table'
                ),
                array(
                    'payment_table',
                    'payments/partial_payment_table'
                ),
                array(
                    'partial_notes',
                    'clients/partial_notes'
                ),
                array(
                    'payment_arrangements',
                    'payment_arrangements/partial_payment_table'
                ),
                array(
                    'content',
                    'clients/view'
                )
            )
        );

        $this->layout->render();

    }

    /**
     * @param int $client_id
     */
    public function delete($client_id)
    {


        if ($this->session->userdata('user_type') == TYPE_ADMIN) {
            $this->mdl_clients->delete($client_id);
            redirect('clients');
        }
    }


    public function payment_arrangement_balance($arr,$sum){

        $balance = 0;
        foreach ($arr as $amount){
            $balance+=(+$amount->amount);
        }
        return (+$sum) - $balance;

    }

}

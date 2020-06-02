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
 * Class leads
 */
class Leads extends NormalUser_Controller
{
    /**
     * leads constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_leads');
        $success = [TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON];
        if(!in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }
    }

    public function index()
    {
        // Display active leads by default
        redirect('leads/status/active');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $filter_group = 0, $page = 0){


        $this->session->set_userdata('previous_url', current_url());
        $this->load->model('user_groups/mdl_user_groups');

        if (is_numeric(array_search($status, array('active', 'inactive','all')))) {
            $function = 'is_' . $status;
            $this->mdl_leads->$function();
        }
        $this->load->model('users/mdl_users');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN){
            $this->mdl_leads->is_all()->paginate(site_url('leads/status/' . $status), $page);
        }else{
            $this->mdl_leads->is_all()->paginate(site_url('leads/status/' . $status), $page);
        }
        $leads = $this->mdl_leads->$function()->get()->result();

        if(is_array($leads)){
            foreach ($leads as $key=>$val) {
                if($leads[$key]->lead_group_id !== 'null' &&  $leads[$key]->lead_group_id != '0' && !empty($leads[$key]->lead_group_id) ) {
                     $groups = json_decode($leads[$key]->lead_group_id);

                      if(is_array($groups)){
                          $groups_arr = [];
                            foreach ($groups as $group) {
                                $group_all = $this->mdl_user_groups->where('group_id', $group)->get()->row();
                                $group_all->group_name;
                                array_push($groups_arr, $group_all->group_name);
                            }

                          $leads[$key]->group_name = $groups_arr;
                          if($this->session->userdata('user_type') != TYPE_ADMIN &&  !in_array($this->session->userdata('user_group_id'),$groups)){
                              unset($leads[$key]);
                          }

                      }else if(!is_array($groups) && $this->session->userdata('user_type') <> TYPE_ADMIN  && $leads[$key]->lead_group_id != $this->session->userdata('user_group_id')){
                            unset($leads[$key]);
                      }
                }
            }
        }

        $quantity = 15;
        $start = +$this->uri->segment(4);
        if(!$start) $start = 0;
        $config['base_url'] = site_url('leads/status/' . $status);
        $config['uri_segment'] = 3;
        $config['total_rows'] = count($leads);
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

        $this->load->model('commission_rates/mdl_commission_rates');

        $commission_rates = $this->mdl_commission_rates->where('commission_rate_user_id',$this->session->userdata('user_id'))->get()->result();
        $this->layout->set(
            array(
                'links' =>  $this->pagination->create_links(),
                'records' => array_slice($leads, $start, $quantity),
                'filter_display' => true,
                'filter_placeholder' => trans('filter_leads'),
                'filter_method' => 'filter_leads',
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'filter_group' => $filter_group,
                'commission_rates' => $commission_rates,
            )
        );

        $this->layout->buffer('content', 'leads/index');
        $this->layout->render();

    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $previous_url = $this->session->userdata('previous_url');
        if ($this->input->post('btn_cancel')) {
            redirect('leads');
        }

        $new_lead = false;

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('lead_name') != '') {

            $check = $this->db->get_where('ip_leads', array(
                'lead_name' => $this->input->post('lead_name'),
                'lead_surname' => $this->input->post('lead_surname')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('lead_already_exists'));
                redirect('leads/form');
            } else {
                $new_lead = true;
            }
        }


        if ($this->mdl_leads->run_validation()) {
            if ($_FILES['attached_lead_file']['name']) {

                $new_name = time().$_FILES["attached_lead_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/prospects',
                    'allowed_types' => 'doc|docx|pdf',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('attached_lead_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect($previous_url);
                }
                $upload_data = $this->upload->data();

                $_POST['lead_file'] = base_url() . "uploads/" . $upload_data['file_name'];
            }
            $id = $this->mdl_leads->save($id);

            redirect($previous_url);
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_leads->prep_form($id)) {
                show_404();
            }

            $this->mdl_leads->set_form_value('is_update', true);

        }

        $this->load->helper('country');
        $this->load->model('user_groups/mdl_user_groups');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN && $new_lead != false) {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
            if ($user->user_group_id != $this->mdl_leads->form_value('lead_group_id'))
            {
                show_404();
            }
        }

        $this->layout->set(
            array(
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_leads->form_value('lead_country') ?: get_setting('default_country'),
                'delivery_selected_country' => $this->mdl_leads->form_value('lead_country_delivery') ?: get_setting('default_country'),
                'languages' => get_available_languages(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
            )
        );

            $this->layout->buffer('content', 'leads/form');
            $this->layout->render();

    }

    /**
     * @param int $lead_id
     */
    public function view($lead_id)
    {
        $this->load->model('leads/mdl_lead_notes');
        $this->load->model('user_groups/mdl_user_groups');
        $this->load->helper('custom_values_helper');

        $lead;

        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));

            $lead = $this->mdl_leads
                ->where('ip_leads.lead_id', $lead_id)
                ->get()->row();

        }
        else {
            $lead = $this->mdl_leads
                ->where('ip_leads.lead_id', $lead_id)
                ->get()->row();


        }


        if(!empty($lead->lead_group_id)) {
            $groups = json_decode($lead->lead_group_id);
if(is_array($groups)){
    $groups_arr = [];
    foreach ($groups as $group) {
        $group_all = $this->mdl_user_groups->where('group_id', $group)
            ->get()->row();

        $group_all->group_name;
        array_push($groups_arr, $group_all->group_name);

    }
    $lead->group_name = $groups_arr;
}


        }

        if ($lead != null && !empty($_POST['generate_lead_id']))
        {

            $client_id = $this->LeadsToClient($lead);
            $this->session->set_flashdata('alert_success', trans('client_successfully_created'));
            redirect('clients/view/' . $client_id);
            die("generate" . $_POST['generate_lead_id']);
        }



        $this->layout->set(

            array(
                'lead' => $lead,
                'lead_notes' => $this->mdl_lead_notes->where('lead_id', $lead_id)->get()->result(),
                //'invoices' => $this->mdl_invoices->by_lead($lead_id)->limit(20)->get()->result(),
                //'quotes' => $this->mdl_quotes->by_lead($lead_id)->limit(20)->get()->result(),
                //'payments' => $this->mdl_payments->by_lead($lead_id)->limit(20)->get()->result(),
                //'custom_fields' => $custom_fields,
                //'quote_statuses' => $this->mdl_quotes->statuses(),
                //'invoice_statuses' => $this->mdl_invoices->statuses()
            )
        );
        $this->layout->buffer(
            array(
                array(
                    'partial_notes',
                    'leads/partial_notes'
                ),
                array(
                    'content',
                    'leads/view'
                )
            )
        );
        $this->layout->render();
    }

    public function LeadsToClient($lead)
    {

        $db_array = array();
        $db_array["client_date_created"] = date('Y-m-d');
        if ($lead->lead_name != null)
            $db_array["client_name"] = $lead->lead_name;
        //if ($lead->lead_group_id != null)
        //    $db_array["client_group_id"] = $lead->lead_group_id;
        if ($lead->lead_address_1 != null)
        $db_array["client_address_1"] = $lead->lead_address_1;
        if ($lead->lead_email2 != null)
        $db_array["lead_email2"] = $lead->lead_email2;
        if ($lead->lead_city != null)
        $db_array["client_city"] = $lead->lead_city;
        if ($lead->lead_state != null)
        $db_array["client_state"] = $lead->lead_state;
        if ($lead->lead_zip != null)
        $db_array["client_zip"] = $lead->lead_zip;
        if ($lead->lead_country != null)
        $db_array["client_country"] = $lead->lead_country;
        if ($lead->lead_address_1_delivery != null)
        $db_array["client_address_1_delivery"] = $lead->lead_address_1_delivery;
        if ($lead->lead_address_2_delivery != null)
        $db_array["client_address_2_delivery"] = $lead->lead_address_2_delivery;
        if ($lead->lead_city_delivery != null)
        $db_array["client_city_delivery"] = $lead->lead_city_delivery;
        if ($lead->lead_state_delivery != null)
        $db_array["client_state_delivery"] = $this->lead_state_delivery;
        if ($lead->lead_zip_delivery != null)
        $db_array["client_zip_delivery"] = $lead->lead_zip_delivery;
        if ($lead->lead_country_delivery != null)
        $db_array["client_country_delivery"] = $lead->lead_country_delivery;
        if ($lead->lead_phone != null)
        $db_array["client_phone"] = $lead->lead_phone;
        if ($lead->lead_fax != null)
        $db_array["client_fax"] = $lead->lead_fax;
        if ($lead->lead_mobile != null)
        $db_array["client_mobile"] = $lead->lead_mobile;
        if ($lead->lead_email != null)
        $db_array["client_email"] = $lead->lead_email;
        if ($lead->lead_web != null)
        $db_array["client_web"] = $lead->lead_web;
        if ($lead->lead_vat_id != null)
        $db_array["client_vat_id"] = $lead->lead_vat_id;
        if ($lead->lead_tax_code != null)
        $db_array["client_tax_code"] = $lead->lead_tax_code;
        if ($lead->lead_language != null)
        $db_array["client_language"] = $lead->lead_language;
        if ($lead->lead_surname != null)
        $db_array["client_surname"] = $lead->lead_surname;
        if ($lead->lead_avs != null)
        $db_array["client_avs"] = $lead->lead_avs;
        if ($lead->lead_insurednumber != null)
        $db_array["client_insurednumber"] = $lead->lead_insurednumber;
        if ($lead->lead_veka != null)
        $db_array["client_veka"] = $lead->lead_veka;
        if ($lead->lead_birthdate != null)
        $db_array["client_birthdate"] = $lead->lead_birthdate;
        if ($lead->lead_gender != null)
        $db_array["client_gender"] = $lead->lead_gender;
        $this->db->insert("ip_clients", $db_array);
        $client_id = $this->db->insert_id();

        if ($lead->lead_group_id != null) {
            $db_array_group = array();
            $db_array_group["client_id"] = $client_id;
            $db_array_group["group_id"] = $lead->lead_group_id;
            $this->db->insert("ip_clients_groups", $db_array_group);
            $this->db->insert_id();
        }

        return $client_id;
    }

    /**
     * @param int $lead_id
     */
    public function delete($lead_id)
    {


        $previous_url = $this->session->userdata('previous_url');
        $this->mdl_leads->delete($lead_id);
        redirect($previous_url);
    }

}

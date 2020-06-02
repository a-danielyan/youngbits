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
 * Class distributors
 */
class Distributors extends NormalUser_Controller
{
    /**
     * distributors constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_distributors');
        $success = [TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON];
        if(!in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }
    }

    public function index()
    {
        // Display active distributors by default
        redirect('distributors/status/active');
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
            $this->mdl_distributors->$function();
        }
        $this->load->model('users/mdl_users');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN){
            $this->mdl_distributors->is_all()->paginate(site_url('distributors/status/' . $status), $page);
        }else{
            $this->mdl_distributors->is_all()->paginate(site_url('distributors/status/' . $status), $page);
        }
        $distributors = $this->mdl_distributors->$function()->get()->result();

        if(is_array($distributors)){
            foreach ($distributors as $key=>$val) {
                if($distributors[$key]->distributor_group_id !== 'null' &&  $distributors[$key]->distributor_group_id != '0' && !empty($distributors[$key]->distributor_group_id) ) {
                     $groups = json_decode($distributors[$key]->distributor_group_id);

                      if(is_array($groups)){
                          $groups_arr = [];
                            foreach ($groups as $group) {
                                $group_all = $this->mdl_user_groups->where('group_id', $group)->get()->row();
                                $group_all->group_name;
                                array_push($groups_arr, $group_all->group_name);
                            }

                          $distributors[$key]->group_name = $groups_arr;
                          if($this->session->userdata('user_type') != TYPE_ADMIN &&  !in_array($this->session->userdata('user_group_id'),$groups)){
                              unset($distributors[$key]);
                          }

                      }else if(!is_array($groups) && $this->session->userdata('user_type') <> TYPE_ADMIN  && $distributors[$key]->distributor_group_id != $this->session->userdata('user_group_id')){
                            unset($distributors[$key]);
                      }
                }
            }
        }

        $quantity = 15;
        $start = +$this->uri->segment(4);
        if(!$start) $start = 0;
        $config['base_url'] = site_url('distributors/status/' . $status);
        $config['uri_segment'] = 3;
        $config['total_rows'] = count($distributors);
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
                'records' => array_slice($distributors, $start, $quantity),
                'filter_display' => true,
                'filter_placeholder' => trans('filter_distributors'),
                'filter_method' => 'filter_distributors',
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'filter_group' => $filter_group,
                'commission_rates' => $commission_rates,
            )
        );

        $this->layout->buffer('content', 'distributors/index');
        $this->layout->render();

    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $previous_url = $this->session->userdata('previous_url');
        if ($this->input->post('btn_cancel')) {
            redirect('distributors');
        }

        $new_distributor = false;

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('distributor_name') != '') {

            $check = $this->db->get_where('ip_distributors', array(
                'distributor_name' => $this->input->post('distributor_name'),
                'distributor_surname' => $this->input->post('distributor_surname')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('distributor_already_exists'));
                redirect('distributors/form');
            } else {
                $new_distributor = true;
            }
        }


        if ($this->mdl_distributors->run_validation()) {
            if ($_FILES['attached_distributor_file']['name']) {

                $new_name = time().$_FILES["attached_distributor_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/distributors',
                    'allowed_types' => 'pdf|jpg|jpeg|png|doc|docx|pdf',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('attached_distributor_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect($previous_url);
                }
                $upload_data = $this->upload->data();

                $_POST['distributor_file'] = base_url() . "uploads/" . $upload_data['file_name'];
            }
            $id = $this->mdl_distributors->save($id);

            redirect($previous_url);
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_distributors->prep_form($id)) {
                show_404();
            }

            $this->mdl_distributors->set_form_value('is_update', true);

        }

        $this->load->helper('country');
        $this->load->model('user_groups/mdl_user_groups');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN && $new_distributor != false) {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
            if ($user->user_group_id != $this->mdl_distributors->form_value('distributor_group_id'))
            {
                show_404();
            }
        }

        $this->layout->set(
            array(
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_distributors->form_value('distributor_country') ?: get_setting('default_country'),
                'delivery_selected_country' => $this->mdl_distributors->form_value('distributor_country_delivery') ?: get_setting('default_country'),
                'languages' => get_available_languages(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
            )
        );

            $this->layout->buffer('content', 'distributors/form');
            $this->layout->render();

    }

    /**
     * @param int $distributor_id
     */
    public function view($distributor_id)
    {
        $this->load->model('distributors/mdl_distributor_notes');
        $this->load->model('user_groups/mdl_user_groups');
        $this->load->helper('custom_values_helper');

        $distributor;

        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));

            $distributor = $this->mdl_distributors
                ->where('ip_distributors.distributor_id', $distributor_id)
                ->get()->row();

        }
        else {
            $distributor = $this->mdl_distributors
                ->where('ip_distributors.distributor_id', $distributor_id)
                ->get()->row();


        }


        if(!empty($distributor->distributor_group_id)) {
            $groups = json_decode($distributor->distributor_group_id);
            if(is_array($groups)){
                $groups_arr = [];
                foreach ($groups as $group) {
                    $group_all = $this->mdl_user_groups->where('group_id', $group)
                        ->get()->row();

                    $group_all->group_name;
                    array_push($groups_arr, $group_all->group_name);

                }
                $distributor->group_name = $groups_arr;
            }


        }

        if ($distributor != null && !empty($_POST['generate_distributor_id']))
        {

            $client_id = $this->DistributorsToClient($distributor);
            $this->session->set_flashdata('alert_success', trans('client_successfully_created'));
            redirect('clients/view/' . $client_id);
            die("generate" . $_POST['generate_distributor_id']);
        }



        $this->layout->set(

            array(
                'distributor' => $distributor,
                'distributor_notes' => $this->mdl_distributor_notes->where('distributor_id', $distributor_id)->get()->result(),
                //'invoices' => $this->mdl_invoices->by_distributor($distributor_id)->limit(20)->get()->result(),
                //'quotes' => $this->mdl_quotes->by_distributor($distributor_id)->limit(20)->get()->result(),
                //'payments' => $this->mdl_payments->by_distributor($distributor_id)->limit(20)->get()->result(),
                //'custom_fields' => $custom_fields,
                //'quote_statuses' => $this->mdl_quotes->statuses(),
                //'invoice_statuses' => $this->mdl_invoices->statuses()
            )
        );
        $this->layout->buffer(
            array(
                array(
                    'partial_notes',
                    'distributors/partial_notes'
                ),
                array(
                    'content',
                    'distributors/view'
                )
            )
        );
        $this->layout->render();
    }

    public function DistributorsToClient($distributor)
    {

        $db_array = array();
        $db_array["client_date_created"] = date('Y-m-d');
        if ($distributor->distributor_name != null)
            $db_array["client_name"] = $distributor->distributor_name;
        //if ($distributor->distributor_group_id != null)
        //    $db_array["client_group_id"] = $distributor->distributor_group_id;
        if ($distributor->distributor_address_1 != null)
        $db_array["client_address_1"] = $distributor->distributor_address_1;
        if ($distributor->distributor_email2 != null)
        $db_array["client_email2"] = $distributor->distributor_email2;
        if ($distributor->distributor_city != null)
        $db_array["client_city"] = $distributor->distributor_city;
        if ($distributor->distributor_state != null)
        $db_array["client_state"] = $distributor->distributor_state;
        if ($distributor->distributor_zip != null)
        $db_array["client_zip"] = $distributor->distributor_zip;
        if ($distributor->distributor_country != null)
        $db_array["client_country"] = $distributor->distributor_country;
        if ($distributor->distributor_address_1_delivery != null)
        $db_array["client_address_1_delivery"] = $distributor->distributor_address_1_delivery;
        if ($distributor->distributor_address_2_delivery != null)
        $db_array["client_address_2_delivery"] = $distributor->distributor_address_2_delivery;
        if ($distributor->distributor_city_delivery != null)
        $db_array["client_city_delivery"] = $distributor->distributor_city_delivery;
        if ($distributor->distributor_state_delivery != null)
        $db_array["client_state_delivery"] = $distributor->distributor_state_delivery;
        if ($distributor->distributor_zip_delivery != null)
        $db_array["client_zip_delivery"] = $distributor->distributor_zip_delivery;
        if ($distributor->distributor_country_delivery != null)
        $db_array["client_country_delivery"] = $distributor->distributor_country_delivery;
        if ($distributor->distributor_phone != null)
        $db_array["client_phone"] = $distributor->distributor_phone;
        if ($distributor->distributor_fax != null)
        $db_array["client_fax"] = $distributor->distributor_fax;
        if ($distributor->distributor_mobile != null)
        $db_array["client_mobile"] = $distributor->distributor_mobile;
        if ($distributor->distributor_email != null)
        $db_array["client_email"] = $distributor->distributor_email;
        if ($distributor->distributor_web != null)
        $db_array["client_web"] = $distributor->distributor_web;
        if ($distributor->distributor_vat_id != null)
        $db_array["client_vat_id"] = $distributor->distributor_vat_id;
        if ($distributor->distributor_tax_code != null)
        $db_array["client_tax_code"] = $distributor->distributor_tax_code;
        if ($distributor->distributor_language != null)
        $db_array["client_language"] = $distributor->distributor_language;
        if ($distributor->distributor_surname != null)
        $db_array["client_surname"] = $distributor->distributor_surname;
        if ($distributor->distributor_avs != null)
        $db_array["client_avs"] = $distributor->distributor_avs;
        if ($distributor->distributor_insurednumber != null)
        $db_array["client_insurednumber"] = $distributor->distributor_insurednumber;
        if ($distributor->distributor_veka != null)
        $db_array["client_veka"] = $distributor->distributor_veka;
        if ($distributor->distributor_birthdate != null)
        $db_array["client_birthdate"] = $distributor->distributor_birthdate;
        if ($distributor->distributor_gender != null)
        $db_array["client_gender"] = $distributor->distributor_gender;
        $this->db->insert("ip_clients", $db_array);
        $client_id = $this->db->insert_id();

        if ($distributor->distributor_group_id != null) {
            $db_array_group = array();
            $db_array_group["client_id"] = $client_id;
            $db_array_group["group_id"] = $distributor->distributor_group_id;
            $this->db->insert("ip_clients_groups", $db_array_group);
            $this->db->insert_id();
        }

        return $client_id;
    }

    /**
     * @param int $distributor_id
     */
    public function delete($distributor_id)
    {


        $previous_url = $this->session->userdata('previous_url');
        $this->mdl_distributors->delete($distributor_id);
        redirect($previous_url);
    }

}

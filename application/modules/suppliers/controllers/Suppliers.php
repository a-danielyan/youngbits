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
 * Class suppliers
 */
class Suppliers extends NormalUser_Controller
{
    /**
     * suppliers constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_suppliers');
        $success = [TYPE_ADMIN,TYPE_MANAGERS,TYPE_SALESPERSON];
        if(!in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }
    }

    public function index()
    {
        // Display active suppliers by default
        redirect('suppliers/status/active');
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
            $this->mdl_suppliers->$function();
        }
        $this->load->model('users/mdl_users');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN){
            $this->mdl_suppliers->is_all()->paginate(site_url('suppliers/status/' . $status), $page);
        }else{
            $this->mdl_suppliers->is_all()->paginate(site_url('suppliers/status/' . $status), $page);
        }
        $suppliers = $this->mdl_suppliers->$function()->get()->result();

        if(is_array($suppliers)){
            foreach ($suppliers as $key=>$val) {
                if($suppliers[$key]->supplier_group_id !== 'null' &&  $suppliers[$key]->supplier_group_id != '0' && !empty($suppliers[$key]->supplier_group_id) ) {
                     $groups = json_decode($suppliers[$key]->supplier_group_id);

                      if(is_array($groups)){
                          $groups_arr = [];
                            foreach ($groups as $group) {
                                $group_all = $this->mdl_user_groups->where('group_id', $group)->get()->row();
                                $group_all->group_name;
                                array_push($groups_arr, $group_all->group_name);
                            }

                          $suppliers[$key]->group_name = $groups_arr;
                          if($this->session->userdata('user_type') != TYPE_ADMIN &&  !in_array($this->session->userdata('user_group_id'),$groups)){
                              unset($suppliers[$key]);
                          }

                      }else if(!is_array($groups) && $this->session->userdata('user_type') <> TYPE_ADMIN  && $suppliers[$key]->supplier_group_id != $this->session->userdata('user_group_id')){
                            unset($suppliers[$key]);
                      }
                }
            }
        }

        $quantity = 15;
        $start = +$this->uri->segment(4);
        if(!$start) $start = 0;
        $config['base_url'] = site_url('suppliers/status/' . $status);
        $config['uri_segment'] = 3;
        $config['total_rows'] = count($suppliers);
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
                'records' => array_slice($suppliers, $start, $quantity),
                'filter_display' => true,
                'filter_placeholder' => trans('filter_suppliers'),
                'filter_method' => 'filter_suppliers',
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'filter_group' => $filter_group,
                'commission_rates' => $commission_rates,
            )
        );

        $this->layout->buffer('content', 'suppliers/index');
        $this->layout->render();

    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $previous_url = $this->session->userdata('previous_url');
        if ($this->input->post('btn_cancel')) {
            redirect('suppliers');
        }

        $new_supplier = false;

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('supplier_name') != '') {

            $check = $this->db->get_where('ip_suppliers', array(
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_surname' => $this->input->post('supplier_surname')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('supplier_already_exists'));
                redirect('suppliers/form');
            } else {
                $new_supplier = true;
            }
        }


        if ($this->mdl_suppliers->run_validation()) {
            if ($_FILES['attached_supplier_file']['name']) {

                $new_name = time().$_FILES["attached_supplier_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/suppliers',
                    'allowed_types' => 'pdf|jpg|jpeg|png|doc|docx|pdf',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('attached_supplier_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect($previous_url);
                }
                $upload_data = $this->upload->data();

                $_POST['supplier_file'] = base_url() . "uploads/" . $upload_data['file_name'];
            }
            $id = $this->mdl_suppliers->save($id);

            $this->load->model('products/mdl_products_suppliers');



            if(!empty($_POST)){
                echo '<pre>';
                var_dump($_POST);
                die;
            }

            if(!empty($this->input->post('supplier_id'))){

                $product_supplier['supplier_id']= $this->input->post('supplier_id');
                $product_supplier['supplier_product_id']= $new_product_id;
                $product_supplier['supplier_multiplier']= $this->input->post('supplier_multiplier');
                $product_supplier['supplier_purchase_price']= $this->input->post('supplier_purchase_price');

                $this->mdl_products_suppliers->save($id, $product_supplier);

            }

            redirect($previous_url);
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_suppliers->prep_form($id)) {
                show_404();
            }

            $this->mdl_suppliers->set_form_value('is_update', true);

        }

        $this->load->helper('country');
        $this->load->model('user_groups/mdl_user_groups');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN && $new_supplier != false) {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
            if ($user->user_group_id != $this->mdl_suppliers->form_value('supplier_group_id'))
            {
                show_404();
            }
        }

        $this->load->model('products/mdl_products');
        $products = $this->mdl_products->where('ip_products_suppliers.supplier_id',$id)->or_where('ip_products_suppliers.supplier_id',NULL)->get()->result();
        $this->layout->set(
            array(
                'products' => $products,
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_suppliers->form_value('supplier_country') ?: get_setting('default_country'),
                'delivery_selected_country' => $this->mdl_suppliers->form_value('supplier_country_delivery') ?: get_setting('default_country'),
                'languages' => get_available_languages(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
            )
        );

            $this->layout->buffer('content', 'suppliers/form');
            $this->layout->render();

    }

    /**
     * @param int $supplier_id
     */
    public function view($supplier_id)
    {
        $this->load->model('suppliers/mdl_supplier_notes');
        $this->load->model('user_groups/mdl_user_groups');
        $this->load->helper('custom_values_helper');

        $supplier;

        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));

            $supplier = $this->mdl_suppliers
                ->where('ip_suppliers.supplier_id', $supplier_id)
                ->get()->row();

        }
        else {
            $supplier = $this->mdl_suppliers
                ->where('ip_suppliers.supplier_id', $supplier_id)
                ->get()->row();


        }


        if(!empty($supplier->supplier_group_id)) {
            $groups = json_decode($supplier->supplier_group_id);
            if(is_array($groups)){
                $groups_arr = [];
                foreach ($groups as $group) {
                    $group_all = $this->mdl_user_groups->where('group_id', $group)
                        ->get()->row();

                    $group_all->group_name;
                    array_push($groups_arr, $group_all->group_name);

                }
                $supplier->group_name = $groups_arr;
            }


        }

        if ($supplier != null && !empty($_POST['generate_supplier_id']))
        {

            $client_id = $this->DistributorsToClient($supplier);
            $this->session->set_flashdata('alert_success', trans('client_successfully_created'));
            redirect('clients/view/' . $client_id);
            die("generate" . $_POST['generate_supplier_id']);
        }



        $this->layout->set(

            array(
                'supplier' => $supplier,
                'supplier_notes' => $this->mdl_supplier_notes->where('supplier_id', $supplier_id)->get()->result(),
                //'invoices' => $this->mdl_invoices->by_supplier($supplier_id)->limit(20)->get()->result(),
                //'quotes' => $this->mdl_quotes->by_supplier($supplier_id)->limit(20)->get()->result(),
                //'payments' => $this->mdl_payments->by_supplier($supplier_id)->limit(20)->get()->result(),
                //'custom_fields' => $custom_fields,
                //'quote_statuses' => $this->mdl_quotes->statuses(),
                //'invoice_statuses' => $this->mdl_invoices->statuses()
            )
        );
        $this->layout->buffer(
            array(
                array(
                    'partial_notes',
                    'suppliers/partial_notes'
                ),
                array(
                    'content',
                    'suppliers/view'
                )
            )
        );
        $this->layout->render();
    }

    public function DistributorsToClient($supplier)
    {

        $db_array = array();
        $db_array["client_date_created"] = date('Y-m-d');
        if ($supplier->supplier_name != null)
            $db_array["client_name"] = $supplier->supplier_name;
        //if ($supplier->supplier_group_id != null)
        //    $db_array["client_group_id"] = $supplier->supplier_group_id;
        if ($supplier->supplier_address_1 != null)
        $db_array["client_address_1"] = $supplier->supplier_address_1;
        if ($supplier->supplier_email2 != null)
        $db_array["client_email2"] = $supplier->supplier_email2;
        if ($supplier->supplier_city != null)
        $db_array["client_city"] = $supplier->supplier_city;
        if ($supplier->supplier_state != null)
        $db_array["client_state"] = $supplier->supplier_state;
        if ($supplier->supplier_zip != null)
        $db_array["client_zip"] = $supplier->supplier_zip;
        if ($supplier->supplier_country != null)
        $db_array["client_country"] = $supplier->supplier_country;
        if ($supplier->supplier_address_1_delivery != null)
        $db_array["client_address_1_delivery"] = $supplier->supplier_address_1_delivery;
        if ($supplier->supplier_address_2_delivery != null)
        $db_array["client_address_2_delivery"] = $supplier->supplier_address_2_delivery;
        if ($supplier->supplier_city_delivery != null)
        $db_array["client_city_delivery"] = $supplier->supplier_city_delivery;
        if ($supplier->supplier_state_delivery != null)
        $db_array["client_state_delivery"] = $supplier->supplier_state_delivery;
        if ($supplier->supplier_zip_delivery != null)
        $db_array["client_zip_delivery"] = $supplier->supplier_zip_delivery;
        if ($supplier->supplier_country_delivery != null)
        $db_array["client_country_delivery"] = $supplier->supplier_country_delivery;
        if ($supplier->supplier_phone != null)
        $db_array["client_phone"] = $supplier->supplier_phone;
        if ($supplier->supplier_fax != null)
        $db_array["client_fax"] = $supplier->supplier_fax;
        if ($supplier->supplier_mobile != null)
        $db_array["client_mobile"] = $supplier->supplier_mobile;
        if ($supplier->supplier_email != null)
        $db_array["client_email"] = $supplier->supplier_email;
        if ($supplier->supplier_web != null)
        $db_array["client_web"] = $supplier->supplier_web;
        if ($supplier->supplier_vat_id != null)
        $db_array["client_vat_id"] = $supplier->supplier_vat_id;
        if ($supplier->supplier_tax_code != null)
        $db_array["client_tax_code"] = $supplier->supplier_tax_code;
        if ($supplier->supplier_language != null)
        $db_array["client_language"] = $supplier->supplier_language;
        if ($supplier->supplier_surname != null)
        $db_array["client_surname"] = $supplier->supplier_surname;
        if ($supplier->supplier_avs != null)
        $db_array["client_avs"] = $supplier->supplier_avs;
        if ($supplier->supplier_insurednumber != null)
        $db_array["client_insurednumber"] = $supplier->supplier_insurednumber;
        if ($supplier->supplier_veka != null)
        $db_array["client_veka"] = $supplier->supplier_veka;
        if ($supplier->supplier_birthdate != null)
        $db_array["client_birthdate"] = $supplier->supplier_birthdate;
        if ($supplier->supplier_gender != null)
        $db_array["client_gender"] = $supplier->supplier_gender;
        $this->db->insert("ip_clients", $db_array);
        $client_id = $this->db->insert_id();

        if ($supplier->supplier_group_id != null) {
            $db_array_group = array();
            $db_array_group["client_id"] = $client_id;
            $db_array_group["group_id"] = $supplier->supplier_group_id;
            $this->db->insert("ip_clients_groups", $db_array_group);
            $this->db->insert_id();
        }

        return $client_id;
    }

    /**
     * @param int $supplier_id
     */
    public function delete($supplier_id)
    {


        $previous_url = $this->session->userdata('previous_url');
        $this->mdl_suppliers->delete($supplier_id);
        redirect($previous_url);
    }

}

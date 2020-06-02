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
 * Class targets
 */
class Targets extends NormalUser_Controller
{
    /**
     * targets constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_targets');
    }

    public function index()
    {
        // Display active targets by default
        redirect('targets/status/active');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $filter_group = 0, $page = 0){
        $this->load->model('user_groups/mdl_user_groups');
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_targets->$function();
        }


        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
            $this->mdl_targets->is_all()->where('target_group_id', $user->user_group_id)->paginate(site_url('targets/status/' . $status), $page);
        }
        else
        {
            if ($filter_group != 0) {
                $this->mdl_targets->is_all()
                    ->where('ip_targets.target_group_id', $filter_group)
                    ->paginate(site_url('targets/status/' . $status), $page);
            }
            else {
                $this->mdl_targets->is_all()->paginate(site_url('targets/status/' . $status), $page);
            }
        }

        $targets = $this->mdl_targets->result();

        $this->layout->set(
            array(
                'records' => $targets,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_targets'),
                'filter_method' => 'filter_targets',
                'user_groups' => $this->mdl_user_groups->get()->result(),
                'filter_group' => $filter_group,
            )
        );


        if($this->session->userdata('user_type') != TYPE_EMPLOYEES || $this->session->userdata('user_type') != TYPE_FREELANCERS){

        }else{
            redirect('dashboard');
        }

        $this->layout->buffer('content', 'targets/index');
        $this->layout->render();


    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {


        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT ){
            redirect('targets');
        }


        if ($this->input->post('btn_cancel')) {
            redirect('targets');
        }

        $new_target = false;

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('target_name') != '') {
            $check = $this->db->get_where('ip_targets', array(
                'target_name' => $this->input->post('target_name'),
                'target_surname' => $this->input->post('target_surname')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('target_already_exists'));
                redirect('targets/form');
            } else {
                $new_target = true;
            }
        }

        if ($this->mdl_targets->run_validation()) {
            if ($_FILES['attached_target_file']['name']) {

                $new_name = time().$_FILES["attached_target_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/',
                    'allowed_types' => 'doc|docx|pdf',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('attached_target_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('targets/form/' . $id);
                }
                $upload_data = $this->upload->data();

                $_POST['target_file'] = base_url() . "uploads/" . $upload_data['file_name'];
            }

            $id = $this->mdl_targets->save($id);

            redirect('targets/view/' . $id);
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_targets->prep_form($id)) {
                show_404();
            }

            $this->mdl_targets->set_form_value('is_update', true);

        }

        $this->load->helper('country');
        $this->load->model('user_groups/mdl_user_groups');

        if ($this->session->userdata('user_type') <> TYPE_ADMIN && $new_target != false) {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
            if ($user->user_group_id != $this->mdl_targets->form_value('target_group_id'))
            {
                show_404();
            }
        }

        $this->layout->set(
            array(
                //'custom_fields' => $custom_fields,
                //'custom_values' => $custom_values,
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_targets->form_value('target_country') ?: get_setting('default_country'),
                'delivery_selected_country' => $this->mdl_targets->form_value('target_country_delivery') ?: get_setting('default_country'),
                'languages' => get_available_languages(),
                'user_groups' => $this->mdl_user_groups->get()->result(),
            )
        );


        $this->layout->buffer('content', 'targets/form');
        $this->layout->render();


    }

    /**
     * @param int $target_id
     */
    public function view($target_id)
    {
        $this->load->model('targets/mdl_target_notes');
        $this->load->helper('custom_values_helper');

        $target;

        if ($this->session->userdata('user_type') <> TYPE_ADMIN)
        {
            $this->load->model('users/mdl_users');
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));

            $target = $this->mdl_targets
                ->where('ip_targets.target_id', $target_id)
                ->where('target_group_id', $user->user_group_id)
                ->get()->row();
        }
        else {
            $target = $this->mdl_targets
                ->where('ip_targets.target_id', $target_id)
                ->get()->row();
        }


        if ($target != null && !empty($_POST['generate_target_id']))
        {
            $client_id = $this->targetsToClient($target);
            $this->session->set_flashdata('alert_success', trans('client_successfully_created'));
            redirect('clients/view/' . $client_id);
            die("generate" . $_POST['generate_target_id']);
        }

        if (!$target) {
            show_404();
        }

        $this->layout->set(
            array(
                'target' => $target,
                'target_notes' => $this->mdl_target_notes->where('target_id', $target_id)->get()->result(),
                //'invoices' => $this->mdl_invoices->by_target($target_id)->limit(20)->get()->result(),
                //'quotes' => $this->mdl_quotes->by_target($target_id)->limit(20)->get()->result(),
                //'payments' => $this->mdl_payments->by_target($target_id)->limit(20)->get()->result(),
                //'custom_fields' => $custom_fields,
                //'quote_statuses' => $this->mdl_quotes->statuses(),
                //'invoice_statuses' => $this->mdl_invoices->statuses()
            )
        );

        $this->layout->buffer(
            array(
                array(
                    'partial_notes',
                    'targets/partial_notes'
                ),
                array(
                    'content',
                    'targets/view'
                )
            )
        );

        $this->layout->render();
    }

    public function targetsToClient($target)
    {
        $db_array = array();
        $db_array["client_date_created"] = date('Y-m-d');
        if ($target->target_name != null)
            $db_array["client_name"] = $target->target_name;
        //if ($target->target_group_id != null)
        //    $db_array["client_group_id"] = $target->target_group_id;
        if ($target->target_address_1 != null)
            $db_array["client_address_1"] = $target->target_address_1;
        if ($target->target_email2 != null)
            $db_array["target_email2"] = $target->target_email2;
        if ($target->target_city != null)
            $db_array["client_city"] = $target->target_city;
        if ($target->target_state != null)
            $db_array["client_state"] = $target->target_state;
        if ($target->target_zip != null)
            $db_array["client_zip"] = $target->target_zip;
        if ($target->target_country != null)
            $db_array["client_country"] = $target->target_country;
        if ($target->target_address_1_delivery != null)
            $db_array["client_address_1_delivery"] = $target->target_address_1_delivery;
        if ($target->target_address_2_delivery != null)
            $db_array["client_address_2_delivery"] = $target->target_address_2_delivery;
        if ($target->target_city_delivery != null)
            $db_array["client_city_delivery"] = $target->target_city_delivery;
        if ($target->target_state_delivery != null)
            $db_array["client_state_delivery"] = $this->target_state_delivery;
        if ($target->target_zip_delivery != null)
            $db_array["client_zip_delivery"] = $target->target_zip_delivery;
        if ($target->target_country_delivery != null)
            $db_array["client_country_delivery"] = $target->target_country_delivery;
        if ($target->target_phone != null)
            $db_array["client_phone"] = $target->target_phone;
        if ($target->target_fax != null)
            $db_array["client_fax"] = $target->target_fax;
        if ($target->target_mobile != null)
            $db_array["client_mobile"] = $target->target_mobile;
        if ($target->target_email != null)
            $db_array["client_email"] = $target->target_email;
        if ($target->target_web != null)
            $db_array["client_web"] = $target->target_web;
        if ($target->target_vat_id != null)
            $db_array["client_vat_id"] = $target->target_vat_id;
        if ($target->target_tax_code != null)
            $db_array["client_tax_code"] = $target->target_tax_code;
        if ($target->target_language != null)
            $db_array["client_language"] = $target->target_language;
        if ($target->target_surname != null)
            $db_array["client_surname"] = $target->target_surname;
        if ($target->target_avs != null)
            $db_array["client_avs"] = $target->target_avs;
        if ($target->target_insurednumber != null)
            $db_array["client_insurednumber"] = $target->target_insurednumber;
        if ($target->target_veka != null)
            $db_array["client_veka"] = $target->target_veka;
        if ($target->target_birthdate != null)
            $db_array["client_birthdate"] = $target->target_birthdate;
        if ($target->target_gender != null)
            $db_array["client_gender"] = $target->target_gender;
        $this->db->insert("ip_clients", $db_array);
        $client_id = $this->db->insert_id();

        if ($target->target_group_id != null) {
            $db_array_group = array();
            $db_array_group["client_id"] = $client_id;
            $db_array_group["group_id"] = $target->target_group_id;
            $this->db->insert("ip_clients_groups", $db_array_group);
            $this->db->insert_id();
        }

        return $client_id;
    }

    /**
     * @param int $target_id
     */
    public function delete($target_id)
    {
        $this->mdl_targets->delete($target_id);
        redirect('Target');
    }

}

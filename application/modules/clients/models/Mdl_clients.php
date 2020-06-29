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
 * Class Mdl_Clients
 */
class Mdl_Clients extends Response_Model
{
    public $table = 'ip_clients';
    public $primary_key = 'ip_clients.client_id';
    public $date_created_field = 'client_date_created';
    public $date_modified_field = 'client_date_modified';

    public function default_select()
    {
        $this->db->select(
            'SQL_CALC_FOUND_ROWS ' . $this->table . '.*, ' .
            'CONCAT(' . $this->table . '.client_name, " ", ' . $this->table . '.client_surname) as client_fullname, ip_users.user_id as u_id, ip_users.user_name as user_name ',
            false);
    }


    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'client_name';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_clients.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    public function default_join()
    {
        $this->db->join('ip_clients_groups', 'ip_clients.client_id = ip_clients_groups.client_id', 'left');
        $this->db->join('ip_users', 'ip_clients.client_user_id = ip_users.user_id', 'left');
        $this->db->join('ip_users as u', 'ip_clients.created_user_id = u.user_id', 'left')->select('u.user_name as username');
    }

    public function default_group_by()
    {

        $this->db->group_by('ip_clients.client_id');

/*        if ($this->session->userdata('user_type') == TYPE_ADMIN) {
            $this->db->group_by('ip_clients.client_id');
        }
        else {
            $this->load->model('users/mdl_users');
            $this->db->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))->group_by('ip_clients.client_id');

        }*/
    }

    public function default_condition()
    {
        $this->db->group_by('ip_clients.client_id');
    }

    public function read_groups($client_id)
    {
        $this->db->select(
            'ip_clients_groups.group_id',
            false);
        $this->db->from('ip_clients_groups');
        $this->db->join('ip_users_groups', 'ip_clients_groups.group_id = ip_users_groups.group_id', 'left');
        $this->db->where('ip_clients_groups.client_id', $client_id); // Produces: WHERE name = 'Joe'
        $query = $this->db->get();
        return $query->result_array();
    }

    public function validation_rules()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => trans('client_name'),
                'rules' => 'required'
            ),
            'client_surname' => array(
                'field' => 'client_surname',
                'label' => trans('client_surname')
            ),
            'client_category' => array(
                'field' => 'client_category',
                'label' => trans('client_category')
            ),
            'client_responsible' => array(
                'field' => 'client_responsible',
                'label' => trans('responsible')
            ),
            'client_sector' => array(
                'field' => 'client_sector',
                'label' => trans('sector')
            ),
            'client_first_name' => array(
                'field' => 'client_first_name',
                'label' => trans('client_first_name')
            ),
            'client_function_contactperson' => array(
                'field' => 'client_function_contactperson',
                'label' => trans('client_function_contactperson')
            ),
            'client_file' => array(
                'field' => 'client_function_contactperson',
                'label' => trans('client_file')
            ),
            'client_active' => array(
                'field' => 'client_active'
            ),
            'client_language' => array(
                'field' => 'client_language',
                'label' => trans('language'),
            ),
            'client_group_id' => array(
                'field' => 'client_group_id',
                'label' => trans('group_name'),
            ),
            'client_address_1' => array(
                'field' => 'client_address_1'
            ),
            'client_address_2' => array(
                'field' => 'client_address_2'
            ),
            'client_city' => array(
                'field' => 'client_city'
            ),
            'client_state' => array(
                'field' => 'client_state'
            ),
            'client_zip' => array(
                'field' => 'client_zip'
            ),
            'client_country' => array(
                'field' => 'client_country'
            ),
            'client_address_1_delivery' => array(
                'field' => 'client_address_1_delivery'
            ),
            'client_address_2_delivery' => array(
                'field' => 'client_address_2_delivery'
            ),
            'client_city_delivery' => array(
                'field' => 'client_city_delivery'
            ),
            'client_state_delivery' => array(
                'field' => 'client_state_delivery'
            ),
            'client_zip_delivery' => array(
                'field' => 'client_zip_delivery'
            ),
            'client_country_delivery' => array(
                'field' => 'client_country_delivery'
            ),
            'client_phone' => array(
                'field' => 'client_phone',
                'label' => trans('phone_number'),
                'rules' => 'regex_match[/^[0-9\-\(\)\/\+\s]*$/]|min_length[8]',
            ),
            'client_fax' => array(
                'field' => 'client_fax',
            ),
            'client_mobile' => array(
                'field' => 'client_mobile',
                'label' => trans('phone_number').' 2 / '.trans('fax_number'),
                'rules' => 'regex_match[/^[0-9\-\(\)\/\+\s]*$/]|min_length[8]',
            ),
            'client_email' => array(
                'field' => 'client_email'
            ),
            'client_web' => array(
                'field' => 'client_web'
            ),
            'client_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'client_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            // SUMEX
            'client_birthdate' => array(
                'field' => 'client_birthdate',
                'rules' => 'callback_convert_date'
            ),
            'client_gender' => array(
                'field' => 'client_gender'
            ),
            'client_avs' => array(
                'field' => 'client_avs',
                'label' => trans('sumex_ssn'),
                'rules' => 'callback_fix_avs'
            ),
            'client_insurednumber' => array(
                'field' => 'client_insurednumber',
                'label' => trans('sumex_insurednumber')
            ),
            'client_veka' => array(
                'field' => 'client_veka',
                'label' => trans('sumex_veka')
            ),
            'client_document_link' => array(
                'field' => 'client_document_link',
                'label' => trans('client_document_link')
            ),
            'client_guest_pass' => array(
                'field' => 'client_guest_pass',
                'label' => trans('pass'),
            ),
            'client_email2' => array(
                'field' => 'client_email2',
                'label' => trans('pass'),
            ),
            'client_additional_information' => array(
                'field' => 'client_additional_information',
                'label' => trans('client_additional_information'),
            ),
            'commission_rate_id' => array(
                'field' => 'commission_rate_id',
                'label' => trans('commission_rate_id'),
            ),
            'client_number_id' => array(
                'field' => 'client_number_id',
                'label' => trans('id'),
            ),
        );
    }

    /**
     * @param int $amount
     * @return mixed
     */
    function get_latest($amount = 10)
    {
        return $this->mdl_clients
            ->where('client_active', 1)
            ->order_by('client_id', 'DESC')
            ->limit($amount)
            ->get()
            ->result();
    }

    /**
     * @param $input
     * @return string
     */
    function fix_avs($input)
    {
        if ($input != "") {
            if (preg_match('/(\d{3})\.(\d{4})\.(\d{4})\.(\d{2})/', $input, $matches)) {
                return $matches[1] . $matches[2] . $matches[3] . $matches[4];
            } else if (preg_match('/^\d{13}$/', $input)) {
                return $input;
            }
        }

        return "";
    }

    function convert_date($input)
    {
        $this->load->helper('date_helper');

        if ($input == '') {
            return '';
        }

        return date_to_mysql($input);
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['created_user_id'] = $this->session->userdata('user_id');
        /*$db_array['commission_rate_id'] = json_encode($this->input->post('commission_rate_id'));*/

        if($this->input->post('notes_url_key') == null){
            $db_array['client_url_key'] =$this->get_url_key();
        }
        if (!isset($db_array['client_active'])) {
            $db_array['client_active'] = 0;

        }

        return $db_array;
    }
    public function invoice($id){
        $this->db->select('*');
        $this->db->where('client_id', $id);
        $this->db->from('ip_clients');
        $invoices = $this->db->get()->result_array();
        return $invoices;
    }
    public function notes($id){
        $this->db->select('*');
        $this->db->where('client_id', $id);
        $this->db->from('ip_client_notes');
        $notes = $this->db->get()->result_array();
        return $notes;
    }
    public function save($id = NULL, $db_array = NULL)
    {

        if ($id != NULL) {
            $this->db->where('client_id', $id);
            $this->db->delete('ip_clients_groups');
        }
        if ($this->input->post()){
            $data = array(
                'client_phone2' => $this->input->post('client_phone2'),
                'mailing_address' => $this->input->post('mailing_address'),
                'city_mailing_address' => $this->input->post('city_mailing_address'),
                'zip_code_mailing_address' => $this->input->post('zip_code_mailing_address'),
                'representative_id' => $this->input->post('representative_id'),
                'column_id' => $this->input->post('column_id'),
                'client_code'=> $this->input->post('client_code'),
                'debtor_code' => $this->input->post('debtor_code'),
                'visiting_address'=> $this->input->post('visiting_address'),
                'zip_code_visiting_address' =>$this->input->post('zip_code_visiting_address'),
                'city_visiting_address' =>$this->input->post('city_visiting_address'),
                'bln_purchasing_combination' => $this->input->post('bln_purchasing_combination'),
                'payment_condition' =>$this->input->post('payment_condition'),
                'txt_purchasing_combination' =>$this->input->post('txt_purchasing_combination'),
                'bln_removed' => $this->input->post('bln_removed'),
                'dbl_discount' => $this->input->post('dbl_discount'),
                'first_name_contact_person' => $this->input->post('first_name_contact_person'),
                'surname_contact_person' => $this->input->post('surname_contact_person'),
            );
            $this->db->where('client_id', $id);
            $this->db->update('ip_clients',$data);

        }
        if ($this->input->post('client_note')){
            $note = array(
                'client_id' => $id,
                'client_note' => $this->input->post('client_note'),
                'client_note2' => $this->input->post('client_note2'),
                'txt_source_of_note' => $this->input->post('txt_source_of_note'),
                'dtm_note' => $this->input->post('dtm_note'),

            );
            $this->db->insert('ip_client_notes',$note);

        }
//        if ($this->input->post('invoice')){
//            $note = array(
//                'client_id' => $id,
//                'client_note' => $this->input->post('client_note'),
//                'client_note2' => $this->input->post('client_note2'),
//                'txt_source_of_note' => $this->input->post('txt_source_of_note'),
//                'dtm_note' => $this->input->post('dtm_note'),
//
//            );
//            $this->db->insert('ip_client_notes',$note);
//
//        }

        $group_ids = array();
        if ($this->input->post('client_group_id')) {
            $group_ids = $this->input->post('client_group_id');
            unset($_POST['client_group_id']);
        }

        if(!$this->input->post('is_update')){
            $db_array = $this->input->post();
            $db_array['client_user_id'] = $this->session->userdata('user_id');
            unset($db_array['btn_submit']);
            unset($db_array['is_update']);
            $id = parent::save($id,$db_array);
        }else{
            $id = parent::save($id);
        }

        $data = array();
        foreach ($group_ids as $group_id)
        {
            $group = array(
                'client_id' => $id,
                'group_id' => $group_id
            );
            array_push($data, $group);
        }
        if (count($data) > 0) {
            $this->db->insert_batch('ip_clients_groups', $data);
        }

        return $id;


    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        parent::delete($id);
        $this->load->helper('orphan');
        delete_orphans();
    }


    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }
    /**
     * Returns client_id of existing client
     *
     * @param $client_name
     * @return int|null
     */
    public function client_lookup($client_name)
    {
        $client = $this->mdl_clients->where('client_name', $client_name)->get();

        if ($client->num_rows()) {
            $client_id = $client->row()->client_id;
        } else {
            $db_array = array(
                'client_name' => $client_name
            );

            $client_id = parent::save(null, $db_array);
        }

        return $client_id;
    }

    public function with_total()
    {
        $this->filter_select('IFnull((SELECT SUM(invoice_total) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_total', false);
        return $this;
    }

    public function with_total_paid()
    {
        $this->filter_select('IFnull((SELECT SUM(invoice_paid) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_paid', false);
        return $this;
    }

    public function with_total_balance()
    {
        $this->filter_select('IFnull((SELECT SUM(invoice_balance) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_balance', false);
        return $this;
    }

    public function is_inactive()
    {
        $this->filter_where('client_active', 0);
        return $this;
    }

    /**
     * @param $user_id
     * @return $this
     */
    public function get_not_assigned_to_user($user_id)
    {
        $this->load->model('user_clients/mdl_user_clients');
        $clients = $this->mdl_user_clients->select('ip_user_clients.client_id')
            ->assigned_to($user_id)->get()->result();

        $assigned_clients = [];
        foreach ($clients as $client) {
            $assigned_clients[] = $client->client_id;
        }

        if (count($assigned_clients) > 0) {
            $this->where_not_in('ip_clients.client_id', $assigned_clients);
        }

        $this->is_active();
        return $this->get()->result();
    }

    public function is_active()
    {
        $this->filter_where('client_active', 1);
        return $this;
    }

}

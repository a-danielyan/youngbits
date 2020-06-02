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
 * Class Mdl_Users
 */
class Mdl_Users extends Response_Model
{
    public $table = 'ip_users';
    public $primary_key = 'ip_users.user_id';
    public $date_created_field = 'user_date_created';
    public $date_modified_field = 'user_date_modified';

    /**
     * @return array
     */
    public function user_types()
    {
        return array(
            /*TYPE_QUEST => trans('guest_read_only'),
            TYPE_INTERNS => trans('intern'),
            TYPE_ADMINISTRATORS => trans('administrator'),
            TYPE_NORMAL_USER => trans('normal_user'),*/

            TYPE_ADMIN => trans('admin'), //TYPE_ADMIN
            TYPE_MANAGERS => trans('manager'),
            TYPE_FREELANCERS => trans('freelancer'),
            TYPE_EMPLOYEES => trans('employee'),
            TYPE_ADMINISTRATOR => trans('other_user'),//
            TYPE_ACCOUNTANT => trans('accountant'),
            TYPE_SALESPERSON => trans('seller'),
            TYPE_CLIENTS => trans('client'),

            // TYPE_JOB_INTERVIEWS => trans('job_interviews')
        );
    }

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS ip_users.*, ip_users_groups.group_name as group_name', false);
    }


    public function default_join()
    {
        $this->db->join('ip_users_groups', 'ip_users_groups.group_id = ip_users.user_group_id  ', 'left');

    }

    public function default_order_by()
    {
        $this->db->order_by('ip_users.user_name');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'user_type' => array(
                'field' => 'user_type',
                'label' => trans('user_type'),
            ),
            'user_email' => array(
                'field' => 'user_email',
                'label' => trans('email'),
                'rules' => 'required|callback_validate_email|is_unique[ip_users.user_email]'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('name'),
                'rules' => 'required'
            ),
            'user_password' => array(
                'field' => 'user_password',
                'label' => trans('password'),
                'rules' => 'required|min_length[8]'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => trans('verify_password'),
                'rules' => 'required|matches[user_password]'
            ),
            'default_hour_rate' => array(
                'field' => 'default_hour_rate',
                'label' => trans('default_hour_rate'),
                'rules' => ''
            ),
            'multiplier' => array(
                'field' => 'multiplier',
                'label' => trans('multiplier'),
                'rules' => ''
            ),
            'default_tax_rate_id' => array(
                'field' => 'default_tax_rate_id',
                'label' => trans('default_tax_rate_id'),
                'rules' => ''
            ),
            'user_document_link' => array(
                'field' => 'user_document_link',
                'label' => trans('user_document_link')
            ),
            'user_group_id' => array(
                'field' => 'user_group_id',
                'label' => trans('user_group_id'),
                'rules' => ''
            ),
            'user_language' => array(
                'field' => 'user_language',
                'label' => trans('language'),
                'rules' => 'required'
            ),
            'user_company' => array(
                'field' => 'user_company'
            ),
            'user_address_1' => array(
                'field' => 'user_address_1'
            ),
            'user_address_2' => array(
                'field' => 'user_address_2'
            ),
            'user_city' => array(
                'field' => 'user_city'
            ),
            'user_state' => array(
                'field' => 'user_state'
            ),
            'user_zip' => array(
                'field' => 'user_zip'
            ),
            'user_country' => array(
                'field' => 'user_country',
                'label' => trans('country'),
            ),
            'user_phone' => array(
                'field' => 'user_phone'
            ),
            'user_fax' => array(
                'field' => 'user_fax'
            ),
            'user_mobile' => array(
                'field' => 'user_mobile'
            ),
            'user_web' => array(
                'field' => 'user_web'
            ),
            'user_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'user_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'user_subscribernumber' => array(
                'field' => 'user_subscribernumber'
            ),
            'user_iban' => array(
                'field' => 'user_iban'
            ),
            'user_expertises_id' => array(
                'field' => 'user_expertises_id'
            ),
            'user_commerce_number' => array(
                'field' => 'user_commerce_number'
            ),
            # SUMEX
            'user_gln' => array(
                'field' => 'user_gln'
            ),
            'user_rcc' => array(
                'field' => 'user_rcc'
            )
        );
    }

    /**
     * @return array
     */
    public function validation_rules_existing()
    {
        return array(
            'user_type' => array(
                'field' => 'user_type',
                'label' => trans('user_type'),
            ),
            'user_email' => array(
                'field' => 'user_email',
                'label' => trans('email'),
                'rules' => 'required|callback_validate_email'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('name'),
                'rules' => 'required'
            ),
            'default_hour_rate' => array(
                'field' => 'default_hour_rate',
                'label' => trans('default_hour_rate'),
                'rules' => ''
            ),
            'multiplier' => array(
                'field' => 'multiplier',
                'label' => trans('multiplier'),
                'rules' => ''
            ),
            'default_tax_rate_id' => array(
                'field' => 'default_tax_rate_id',
                'label' => trans('default_tax_rate_id'),
                'rules' => ''
            ),
            'user_document_link' => array(
                'field' => 'user_document_link',
                'label' => trans('user_document_link')
            ),
            'user_group_id' => array(
                'field' => 'user_group_id',
                'label' => trans('user_group_id'),
                'rules' => ''
            ),
            'user_language' => array(
                'field' => 'user_language',
                'label' => trans('language'),
                'rules' => 'required'
            ),
            'user_company' => array(
                'field' => 'user_company'
            ),
            'user_address_1' => array(
                'field' => 'user_address_1'
            ),
            'user_address_2' => array(
                'field' => 'user_address_2'
            ),
            'user_city' => array(
                'field' => 'user_city'
            ),
            'user_state' => array(
                'field' => 'user_state'
            ),
            'user_zip' => array(
                'field' => 'user_zip'
            ),
            'user_country' => array(
                'field' => 'user_country',
                'label' => trans('country'),
            ),
            'user_phone' => array(
                'field' => 'user_phone'
            ),
            'user_fax' => array(
                'field' => 'user_fax'
            ),
            'user_mobile' => array(
                'field' => 'user_mobile'
            ),
            'user_web' => array(
                'field' => 'user_web'
            ),
            'user_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'user_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'user_subscribernumber' => array(
                'field' => 'user_subscribernumber'
            ),
            'user_iban' => array(
                'field' => 'user_iban'
            ),
            'user_commerce_number' => array(
                'field' => 'user_commerce_number'
            ),
            'user_expertises_id' => array(
                'field' => 'user_expertises_id'
            ),
            # SUMEX
            'user_gln' => array(
                'field' => 'user_gln'
            ),
            'user_rcc' => array(
                'field' => 'user_rcc'
            )
        );
    }

    /**
     * @return array
     */
    public function validation_rules_change_password()
    {
        return array(
            'user_password' => array(
                'field' => 'user_password',
                'label' => trans('password'),
                'rules' => 'required'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => trans('verify_password'),
                'rules' => 'required|matches[user_password]'
            )
        );
    }

    /**
     * @param string $str
     * @return bool
     */
    public function validate_email($str)
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        if (isset($db_array['user_password'])) {
            unset($db_array['user_passwordv']);

            $this->load->library('crypt');

            $user_psalt = $this->crypt->salt();

            $db_array['user_psalt'] = $user_psalt;
            $db_array['user_password'] = $this->crypt->generate_password($db_array['user_password'], $user_psalt);
        }

        if(!empty($_POST['user_expertises_id'])){

            $db_array['user_expertises_id'] = $_POST['user_expertises_id'];
        }

        return $db_array;
    }

    /**
     * @param $user_id
     * @param $password
     */
    public function save_change_password($user_id, $password)
    {
        $this->load->library('crypt');

        $user_psalt = $this->crypt->salt();
        $user_password = $this->crypt->generate_password($password, $user_psalt);

        $db_array = array(
            'user_psalt' => $user_psalt,
            'user_password' => $user_password
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('ip_users', $db_array);

        $this->session->set_flashdata('alert_success', trans('password_changed'));
    }

    /**
     * @param null $id
     * @param null $db_array
     * @return int|null
     */
    public function save($id = null, $db_array = null)
    {
        $id = parent::save($id, $db_array);

        if ($user_clients = $this->session->userdata('user_clients')) {
            $this->load->model('users/mdl_user_clients');

            foreach ($user_clients as $user_client) {
                $this->mdl_user_clients->save(null, array('user_id' => $id, 'client_id' => $user_client));
            }

            $this->session->unset_userdata('user_clients');
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

    public function get_username_by_id($id){

        $this->db->select('user_name');
        $this->db->where('user_id', $id);
        $query = $this->db->get('ip_users')->row();
        if(!empty($query)){
            $username = $query->user_name;
        }
        else{
            $username = '';
        }

        return $username;
    }

}

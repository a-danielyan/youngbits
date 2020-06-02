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
 * Class Mdl_Custom_Fields
 */
class Mdl_expertises_company extends MY_Model
{
    public $table = ' ip_expertises_company';
    public $primary_key = ' ip_expertises_company.expertises_company_id';




    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS  ip_expertises_company.*, ip_users.user_name', false);
    }


    public function default_order_by()
    {
        $this->db->order_by('ip_expertises_company.expertises_company_id DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_users', 'ip_users.user_id = ip_expertises_company.expertises_company_created_user_id', 'left');

    }

    public function validation_rules()
    {
        return array(
            'expertises_company_name' => array(
                'field' => 'expertises_company_name',
                'label' => trans('expertises_company_name'),
                'rules' => 'required'
            )
        );
    }



    /**
     * @param null $id
     * @param null $db_array
     * @return null
     */
    public function save($id = null, $db_array = null)
    {

        // Create the record
        $db_array = ($db_array) ? $db_array : $this->db_array();

        // Save the record to  ip_expertises_company
        $id = parent::save($id, $db_array);
        return $id;
    }

    /**
     * @param $column
     * @return $this
     */
    public function get_by_id($column)
    {
        $this->where('expertises_company_id', $column);
        return $this->get()->row();
    }

    /**
     * @return array
     */
    public function db_array()
    {


        // Get the default db array
        $db_array = parent::db_array();
        $db_array['expertises_company_created_user_id'] = $this->session->userdata('user_id');
        $db_array['expertises_company_created_date'] = date('Y-m-d');


        // Return the db array
        return $db_array;
    }


    /**
     * @param $id
     */
    public function delete($id)
    {
        $custom_field = $this->get_by_id($id);
        parent::delete($id);
    }





}

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
 * Class Mdl_Units
 */
class Mdl_Company_savings extends Response_Model
{
    public $table = 'ip_company_savings';
    public $primary_key = 'ip_company_savings.company_saving_id';






    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'company_saving_text' => array(
                'field' => 'company_saving_text',
                'label' => trans('company_saving_text'),
                'rules' => 'required'
            ),
            'company_saving_created_date' => array(
                'field' => 'company_saving_created_date',
                'label' => trans('company_saving_created_date'),

            ),
            'company_saving_created_by' => array(
                'field' => 'company_saving_created_by',
                'label' => trans('company_saving_created_by'),
            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['company_saving_text'] = $this->input->post('company_saving_text');
        $db_array['company_saving_created_date'] = date('Y-m-d H-i-s');
        $db_array['company_saving_created_by'] =$this->session->userdata('user_id');


        return $db_array;
    }

}

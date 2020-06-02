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
class Mdl_login_quotes extends Response_Model
{
    public $table = 'ip_login_quotes';
    public $primary_key = 'ip_login_quotes.quote_id';






    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'quote_text' => array(
                'field' => 'quote_text',
                'label' => trans('quote_text'),
                'rules' => 'required'
            ),
            'quote_created_date' => array(
                'field' => 'quote_created_date',
                'label' => trans('quote_created_date'),

            ),
            'quote_created_by' => array(
                'field' => 'quote_created_by',
                'label' => trans('quote_created_by'),
            ),
            'quote_document_link' => array(
                'field' => 'quote_document_link',
                'label' => lang('img')
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['quote_text'] = $this->input->post('quote_text');
        $db_array['quote_created_date'] = date('Y-m-d H-i-s');
        $db_array['quote_created_by'] =$this->session->userdata('user_id');


        return $db_array;
    }

}

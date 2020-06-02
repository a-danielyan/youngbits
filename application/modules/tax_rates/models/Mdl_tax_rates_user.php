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
 * Class Mdl_Tax_Rates
 */
class Mdl_tax_rates_user extends Response_Model
{
    public $table = 'ip_users';
    public $primary_key = 'ip_users.user_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }



    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'user_price_per_kilometer' => array(
                'field' => 'user_price_per_kilometer',
                'label' => trans('user_price_per_kilometer'),
                'rules' => 'required'
            ),
        );
    }






}

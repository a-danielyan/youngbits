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
 * Class Mdl_commission_rates
 */
class Mdl_commission_rates extends Response_Model
{
    public $table = 'ip_commission_rates';
    public $primary_key = 'ip_commission_rates.commission_rate_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_commission_rates.commission_rate_created', 'DESC');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'commission_rate_name' => array(
                'field' => 'commission_rate_name',
                'label' => trans('commission_rate_name'),
                'rules' => 'required'
            ),
            'commission_rate_percent' => array(
                'field' => 'commission_rate_percent',
                'label' => trans('commission_rate_percent'),
                'rules' => 'required'
            )
        );
    }


    public function default_commission_rate($user_id){
        $this->db->set('commission_rate_default',0, FALSE);
        $this->db->where('commission_rate_user_id', $user_id);
        $this->db->update('ip_commission_rates');
    }


}

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
 * Class Mdl_Families
 */
class Mdl_Families extends Response_Model
{
    public $table = 'ip_families';
    public $primary_key = 'ip_families.family_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    
    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'family_name';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_families.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'family_name' => array(
                'field' => 'family_name',
                'label' => trans('family_name'),
                'rules' => 'required'
            )
        );
    }

}

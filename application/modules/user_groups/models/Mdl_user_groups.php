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
 * Class Mdl_User_Groups
 */
class Mdl_User_Groups extends Response_Model
{
    public $table = 'ip_users_groups';
    public $primary_key = 'ip_users_groups.group_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_users_groups.group_id');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'group_name' => array(
                'field' => 'group_name',
                'label' => trans('group_name'),
                'rules' => 'required'
            ),
        );
    }

}

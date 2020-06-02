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
 * Class Mdl_distributor_Notes
 */
class Mdl_Distributor_Notes extends Response_Model
{
    public $table = 'ip_distributor_notes';
    public $primary_key = 'ip_distributor_notes.distributor_note_id';

    public function default_order_by()
    {
        $this->db->order_by('ip_distributor_notes.distributor_note_date DESC');
    }

    public function validation_rules()
    {
        return array(
            'distributor_id' => array(
                'field' => 'distributor_id',
                'label' => trans('distributor'),
                'rules' => 'required'
            ),
            'distributor_note' => array(
                'field' => 'distributor_note',
                'label' => trans('note'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['distributor_note_date'] = date('Y-m-d');

        return $db_array;
    }

}

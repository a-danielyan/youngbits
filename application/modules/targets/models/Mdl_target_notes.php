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
 * Class Mdl_target_Notes
 */
class Mdl_Target_Notes extends Response_Model
{
    public $table = 'ip_target_notes';
    public $primary_key = 'ip_target_notes.target_note_id';

    public function default_order_by()
    {
        $this->db->order_by('ip_target_notes.target_note_date DESC');
    }

    public function validation_rules()
    {
        return array(
            'target_id' => array(
                'field' => 'target_id',
                'label' => trans('target'),
                'rules' => 'required'
            ),
            'target_note' => array(
                'field' => 'target_note',
                'label' => trans('note'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['target_note_date'] = date('Y-m-d');

        return $db_array;
    }

}

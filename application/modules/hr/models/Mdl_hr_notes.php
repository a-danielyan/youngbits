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
 * Class Mdl_Hr_Notes
 */
class Mdl_Hr_Notes extends Response_Model
{
    public $table = 'ip_hr_notes';
    public $primary_key = 'ip_hr_notes.hr_note_id';

    public function default_order_by()
    {
        $this->db->order_by('ip_hr_notes.hr_note_date DESC');
    }

    public function validation_rules()
    {
        return array(
            'hr_id' => array(
                'field' => 'hr_id',
                'label' => trans('hr'),
                'rules' => 'required'
            ),
            'hr_note' => array(
                'field' => 'hr_note',
                'label' => trans('note'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['hr_note_date'] = date('Y-m-d');

        return $db_array;
    }

}

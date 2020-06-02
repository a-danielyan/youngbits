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
 * Class Mdl_lead_Notes
 */
class Mdl_Lead_Notes extends Response_Model
{
    public $table = 'ip_lead_notes';
    public $primary_key = 'ip_lead_notes.lead_note_id';

    public function default_order_by()
    {
        $this->db->order_by('ip_lead_notes.lead_note_date DESC');
    }

    public function validation_rules()
    {
        return array(
            'lead_id' => array(
                'field' => 'lead_id',
                'label' => trans('lead'),
                'rules' => 'required'
            ),
            'lead_note' => array(
                'field' => 'lead_note',
                'label' => trans('note'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['lead_note_date'] = date('Y-m-d');

        return $db_array;
    }

}

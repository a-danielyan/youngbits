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
 * Class Mdl_supplier_Notes
 */
class Mdl_Supplier_Notes extends Response_Model
{
    public $table = 'ip_supplier_notes';
    public $primary_key = 'ip_supplier_notes.supplier_note_id';

    public function default_order_by()
    {
        $this->db->order_by('ip_supplier_notes.supplier_note_date DESC');
    }

    public function validation_rules()
    {
        return array(
            'supplier_id' => array(
                'field' => 'supplier_id',
                'label' => trans('supplier'),
                'rules' => 'required'
            ),
            'supplier_note' => array(
                'field' => 'supplier_note',
                'label' => trans('note'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['supplier_note_date'] = date('Y-m-d');

        return $db_array;
    }

}

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
 * Class Mdl_Projects_Notes
 */
class Mdl_Projects_Notes extends Response_Model
{
    public $table = 'ip_notes';
    public $primary_key = 'ip_notes.project_id';

    public function default_order_by()
    {
        $this->db->order_by('ip_notes.created_date DESC');
    }


}

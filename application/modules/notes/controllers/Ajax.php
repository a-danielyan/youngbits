<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Spudu
 *
 * @author      Spudu Developers & Contributors
 * @copyright   Copyright (c) 2012 - 2017 Spudu.com
 * @license     https://Spudu.com/license.txt
 * @link        https://Spudu.com
 */

/**
 * Class Ajax
 */
class Ajax extends NormalUser_Controller
{
    public $ajax_controller = true;
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
        $this->load->model('notes/mdl_notes');
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_notes.project_id', 'left');
    }




    public function statuses()
    {
        return array(
            '0' => array(
                'label' => trans('not_started'),
                'class' => 'draft'
            ),
            '1' => array(
                'label' => trans('not_started'),
                'class' => 'draft'
            ),
            '2' => array(
                'label' => trans('in_progress'),
                'class' => 'viewed'
            ),
            '3' => array(
                'label' => trans('complete'),
                'class' => 'sent'
            ),
            '4' => array(
                'label' => trans('invoiced'),
                'class' => 'paid'
            ),
            '5' => array(
                'label' => trans('quoted'),
                'class' => 'paid'
            )
        );
    }

}

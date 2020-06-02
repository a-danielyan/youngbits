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
 * Class Units
 */
class Maps extends Admin_Controller
{
    /**
     * Units constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_company_savings');
    }

    /**
     * @param int $page
     */
    public function index()
    {
        $this->load->model('users/mdl_users');
        $users = $this->mdl_users->where('user_city !=','')->get()->result();
        $this->layout->set('users', $users);
        $this->layout->buffer('content', 'maps/index');
        $this->layout->render();

    }

}

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
 * Class Admin_Controller
 */
class NormalUser_Controller extends User_Controller
{
    public function __construct()
    {
        $users = array('user_type' => array(1,2, 3, 4, 5, 6));
        parent::__construct($users);
    }
}

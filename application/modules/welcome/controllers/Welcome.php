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
 * Class Welcome
 */
class Welcome extends CI_Controller
{
    public function index()
    {
        $this->load->helper('url');

        $this->load->view('welcome');
    }
}

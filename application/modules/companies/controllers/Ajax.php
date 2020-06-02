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
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    /**
     *
     */
    public function get_cron_key()
    {
        $this->load->helper('string');
        echo random_string('alnum', 16);
    }

    public function test_mail()
    {
        $this->load->helper('mailer');
        email_invoice(1, 'Spudu', 'denys@denv.it', 'denys@denv.it', 'Test', 'Some text');
    }

}

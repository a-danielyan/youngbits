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
 * Class User_Controller
 */
class User_Controller extends Base_Controller
{
    /**
     * User_Controller constructor.
     * @param string $required_key
     * @param integer $required_val
     */
    public function __construct($required_keys)
    {
        parent::__construct();

        if(!is_array($required_keys))
        {
            redirect('sessions/login');
        }
        if (count($required_keys) != 1)
        {
            redirect('sessions/login');
        }

        $ok = false;


        if(!empty($this->session->userdata()["user_type"]) || !is_null($this->input->get('fromWP')) ){
            $ok = true;
        }


        if ($ok == false)
        {
            redirect('sessions/login');
        }


    }
}

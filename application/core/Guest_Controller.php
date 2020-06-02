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
 * Class Guest_Controller
 */
class Guest_Controller extends User_Controller
{
    public $user_clients = array();

    public function __construct()
    {
        $users = array('user_type' => array(2));
        parent::__construct($users);

        $this->load->model('user_clients/mdl_user_clients');

        $user_clients = $this->mdl_user_clients->assigned_to($this->session->userdata('user_id'))->get()->result();

        if (!$user_clients) {
            ?>
            <html style="display:table;width:100%;">
            <body style="font-family:sans-serif;background:#B94A48;color:#fff;height:100vh;display:table-cell;vertical-align:middle;">
            <p style="font-size:20px;text-align:center;width:100%;"><?php echo trans('guest_account_denied'); ?></p>
            </body>
            </html>
            <?php
            exit;
        }

        foreach ($user_clients as $user_client) {
            $this->user_clients[$user_client->client_id] = $user_client->client_id;
        }
    }

}

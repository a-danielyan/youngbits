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
 * Returns
 *
 * @param $base_url
 * @param $model
 * @return string
 */
function allow_to_see_client_for_logged_user($client_id)
{
    $CI = &get_instance();
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('users/mdl_users');

    if ($CI->session->userdata('user_type') == TYPE_ADMIN) {
        return true;
    }

    $client_groups = $CI->mdl_clients->read_groups($client_id);

    if (!$client_groups)
        return false;

    if (count($client_groups) == 0)
        return false;

    $user_group = $CI->mdl_users->get_by_id($CI->session->userdata('user_id'));

    if (!$user_group)
        return false;

    foreach ($client_groups as $client_group){
        if ($client_group["group_id"] == $user_group->user_group_id) {
            return true;
        }
    }
    return false;
}

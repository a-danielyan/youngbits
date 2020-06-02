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
 * Class fleets
 */
class Rides extends Custom_Controller {

	/**
     * fleets constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
        $this->load->model('appointments/mdl_appointments');
    }

    /**
     * @param int $page
     */
    public function list_rides($page = 0)
    {
        $this->load->model('fleets/mdl_fleets');

        if(in_array($this->session->userdata('user_type'),[TYPE_ADMIN])){
            $this->mdl_appointments->paginate(site_url('rides/list_rides'), $page);
        }else{
            $this->mdl_appointments->where('ip_appointments.appointment_user_id', $this->session->userdata('user_id') )->paginate(site_url('rides/list_rides'), $page);
        }
        $list_rides = $this->mdl_appointments->result();
        //$list_rides['data'] = $this->mdl_fleets->where('fleet_default_car',1)->get()->row();
        $fleet = $this->mdl_fleets->where('fleet_default_car',1)->get()->row();

        $this->layout->set('list_rides', $list_rides);
        $this->layout->set('default_car', $fleet);
        $this->layout->buffer('content', 'rides/list_rides');
        $this->layout->render();
    }


    public function share_rides($page = 0)
    {
        $this->load->model('fleets/mdl_fleets');

        $this->mdl_appointments->paginate(site_url('rides/share_rides'), $page);
        $share_rides = $this->mdl_appointments->or_where('appointment_stayawaykey_checked',1)->get()->result();
        $fleet = $this->mdl_fleets->where('fleet_default_car',1)->get()->row();

        $this->layout->set('share_rides', $share_rides);
        $this->layout->set('default_car', $fleet);
        $this->layout->buffer('content', 'rides/share_rides');
        $this->layout->render();
    }

    /**
     * @param null $id
     */


    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_appointments->delete($id);
        redirect('fleets');
    }

}

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
class Calendars extends Custom_Controller {

	/**
     * fleets constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN));
        parent::__construct($users);
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {




        $this->load->model('appointments/mdl_appointments');
        $appointments =  $this->mdl_appointments->where('appointment_user_id',$this->session->userdata('user_id'))->get()->result();
        $calendars_data = [];
        foreach ($appointments as $key => $appointment) {
            $calendars_data['data'][$key]['title'] =$appointment->appointment_title;
            $calendars_data['data'][$key]['start'] = $appointment->appointment_date.'T'.$appointment->appointment_starting_time;
            $calendars_data['data'][$key]['end'] =$appointment->appointment_date.'T'.$appointment->appointment_end_time;
            $calendars_data['data'][$key]['backgroundColor'] = "#00a65a";

        }
        $this->layout->set(
            array(
                'calendar' => $calendars_data,
            )
        );
        $this->layout->buffer('content', 'calendars/index');
        $this->layout->render();
    }

}

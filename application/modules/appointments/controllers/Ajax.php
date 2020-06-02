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

class Ajax extends NormalUser_Controller
{
    /**
     * @param null|integer $invoice_id
     */
    public function modal_appointment_lookups($invoice_id = null)
    {
        $data['appointments'] = array();
        $this->load->model('mdl_appointments');

        if (!empty($invoice_id)) {
            $data['appointments'] = $this->mdl_appointments->get_appointments_to_invoice($invoice_id);
        }

        $this->layout->load_view('appointments/modal_appointment_lookups', $data);
    }

    public function process_appointment_selections()
    {
        $this->load->model('mdl_appointments');

        $appointments = $this->mdl_appointments->where_in('appointment_id', $this->input->post('appointment_ids'))->get()->result();
        foreach ($appointments as $appointment) {
            $appointment->appointment_price = format_amount($appointment->appointment_price);
        }

        echo json_encode($appointments);
    }
}

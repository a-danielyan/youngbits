<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Spudu
 *
 * @author      Spudu Developers & Contributors
 * @copyright   Copyright (c) 2012 - 2017 Spudu.com
 * @license     https://Spudu.com/license.txt
 * @link        https://Spudu.com
 */

/**
 * Class Mdl_fleets
 */
class Mdl_fleets extends Response_Model {

    public $table = 'ip_fleets';
    public $primary_key = 'ip_fleets.fleet_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,
          (CASE WHEN DATEDIFF(NOW(), fleet_create) > 0 THEN 1 ELSE 0 END) is_overdue
        ', false);
        $this->db->where('fleet_user_id',$this->session->userdata('user_id'));
    }

    public function default_order_by()
    {
        $this->db->order_by('fleet_updated','DESC');
    }

    public function get_latest()
    {
        $this->db->order_by('fleet_updated', 'DESC');
        return $this;
    }

    /**
     * @param string $match
     */
    public function by_fleet($match)
    {
        $this->db->like('fleet_make_car', $match);
        $this->db->or_like('fleet_model_car', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'fleet_make_car' => array(
                'field' => 'fleet_make_car',
                'label' => trans('Make car '),
                'rules' => 'required'
            ),
            'fleet_model_car' => array(
                'field' => 'fleet_model_car',
                'label' => trans('Model car'),
                'rules' => ''
            ),
            'fleet_first_registration' => array(
                'field' => 'fleet_first_registration',
                'label' => trans('First registration'),
                'rules' => ''
            ),
            'fleet_starting_mileage' => array(
                'field' => 'fleet_starting_mileage',
                'label' => trans('Starting mileage car'),
                'rules' => ''
            ),
            'fleet_current_mileage' => array(
                'field' => 'fleet_current_mileage',
                'label' => trans('Current mileage car'),
                'rules' => ''
            ),
            'fleet_mileage_car' => array(
                'field' => 'fleet_mileage_car',
                'label' => trans(' Last service data and mileage car'),
                'rules' => ''
            ),
            'fleet_buying_price' => array(
                'field' => 'fleet_buying_price',
                'label' => trans('Maintenance costs'),
                'rules' => ''
            ),
            'fleet_maintenance_costs' => array(
                'field' => 'fleet_maintenance_costs',
                'label' => trans('Buying price'),
                'rules' => ''
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        $db_array['fleet_first_registration'] = date('Y-m-d');
        $db_array['fleet_starting_mileage'] = $this->input->post('fleet_starting_mileage');
        $db_array['fleet_current_mileage'] = $this->input->post('fleet_current_mileage');
        $db_array['fleet_last_service_data'] = date('Y-m-d');
        $db_array['fleet_mileage_car'] = $this->input->post('fleet_mileage_car');
        $db_array['fleet_buying_price'] = $this->input->post('fleet_buying_price');
        $db_array['fleet_maintenance_costs'] = $this->input->post('fleet_maintenance_costs');
        $db_array['fleet_user_id'] =$this->session->userdata('user_id');

        if($this->input->post('fleet_default_car')){
            $this->default_car($db_array['fleet_user_id']);
        }

        if(empty($this->input->post('fleet_mileage_car_total'))){
            $db_array['fleet_mileage_car_total'] = $this->input->post('fleet_current_mileage');
        }

        $db_array['fleet_default_car'] = $this->input->post('fleet_default_car');




        $db_array['fleet_create'] =date('Y-m-d H:i:s');
        $db_array['fleet_updated'] = date('Y-m-d H:i:s');


        return $db_array;
    }


    public function default_car($user_id){
        $this->db->set('fleet_default_car',0, FALSE);
        $this->db->where('fleet_user_id', $user_id);
        $this->db->update('ip_fleets');
    }

    /**
     * @param null|integer $id
     * @return bool
     */
    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }

        if (!$id) {
            parent::set_form_value('fleet_first_registration', date('Y-m-d'));
            parent::set_form_value('fleet_last_service_data', date('Y-m-d'));
            parent::set_form_value('fleet_create', date('Y-m-d'));
            parent::set_form_value('fleet_updated', date('Y-m-d'));
        }

        return true;
    }

}
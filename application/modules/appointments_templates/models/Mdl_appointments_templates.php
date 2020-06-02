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
 * Class Mdl_appointments_templates
 */
class Mdl_appointments_templates extends Response_Model
{
    public $table = 'ip_appointments_templates';
    public $primary_key = 'ip_appointments_templates.appointment_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,
          (CASE WHEN DATEDIFF(NOW(), appointment_date) > 0 THEN 1 ELSE 0 END) is_overdue,
          ip_users.user_name
        ', false);

    }

    public function default_order_by()
    {
        $this->db->order_by('appointment_update_date','DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_projects', 'ip_projects.project_id = ip_appointments_templates.project_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_appointments_templates.appointment_user_id', 'left');
        $this->db->join('ip_products', 'ip_products.product_id = ip_appointments_templates.appointment_product_id', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('ip_appointments_templates.appointment_id', 'DESC');
        return $this;
    }

    /**
     * @param string $match
     */
    public function by_appointment($match)
    {
        $this->db->like('appointment_title', $match);
        $this->db->or_like('appointment_description', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'appointment_title' => array(
                'field' => 'appointment_title',
                'label' => trans('appointment_title'),
                'rules' => 'required'
            ),
            'appointment_description' => array(
                'field' => 'appointment_description',
                'label' => trans('appointment_description'),

            ), 'appointment_url_document' => array(
                'field' => 'appointment_url_document',
                'label' => lang('appointment_url_document')
            ), 'appointment_stayawaykey_price_per_kilometer' => array(
                'field' => 'appointment_stayawaykey_price_per_kilometer',
                'label' => lang('appointment_stayawaykey_price_per_kilometer')
            ),'appointment_stayawaykey_price_kilometor_total' => array(
                'field' => 'appointment_stayawaykey_price_kilometor_total',
                'label' => lang('appointment_stayawaykey_price_kilometor_total')
            ),'appointment_carpool_checked' => array(
                'field' => 'appointment_carpool_checked',
                'label' => lang('appointment_carpool_checked')
            ),'appointment_kilometers' => array(
                'field' => 'appointment_kilometers',
                'label' => lang('appointment_kilometers')
            ),'appointment_departure_end_location' => array(
                'field' => 'appointment_departure_end_location',
                'label' => lang('appointment_departure_end_location')
            ),'appointment_pickup_start_time' => array(
                'field' => 'appointment_pickup_start_time',
                'label' => lang('appointment_pickup_start_time')
            ),'appointment_pickup_end_time' => array(
                'field' => 'appointment_pickup_end_time',
                'label' => lang('appointment_pickup_end_time')
            ),'appointment_type' => array(
                'field' => 'appointment_type',
                'label' => lang('appointment_type')
            ),'appointment_client_id' => array(
                'field' => 'appointment_client_id',
                'label' => lang('appointment_client')
            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {

        $this->load->model('products/mdl_products');
        $this->load->model('users/mdl_users');
        $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));
        $db_array = parent::db_array();

        $db_array['appointment_recurring'] = $this->input->post('appointment_recurring');
        $db_array['appointment_recurring_checked'] = $this->input->post('appointment_recurring_checked');
        $db_array['appointments_recur_start_date'] = date_to_mysql($this->input->post('appointments_recur_start_date'));
        $db_array['appointments_recur_end_date'] = date_to_mysql($this->input->post('appointments_recur_end_date'));

        $db_array['appointment_address'] = $this->input->post('appointment_address');

        $db_array['appointment_date'] =(!empty($this->input->post('appointment_date'))) ? date_to_mysql($this->input->post('appointment_date')) : 0 ;

        $db_array['appointment_starting_time'] = $_POST['appointment_starting_time'];
        $db_array['appointment_end_time'] = $_POST['appointment_end_time'];
        $db_array['appointment_total_time_of'] =$this->input->post('appointment_total_time_of');

        $db_array['appointment_invoice_checked'] = $this->input->post('appointment_invoice_checked');

        $db_array['appointment_invoice_kilometer_checked'] = $this->input->post('appointment_invoice_kilometer_checked');
        $db_array['appointment_price_per_kilometer'] = $this->input->post('appointment_price_per_kilometer');
        $db_array['appointment_starting_price_per_kilometer'] = $this->input->post('appointment_starting_price_per_kilometer');

        $db_array['appointment_how_many_seats_can_you_offer'] = $this->input->post('appointment_how_many_seats_can_you_offer');

        $db_array['appointment_stayawaykey_checked'] = $this->input->post('appointment_stayawaykey_checked');

        $db_array['appointment_wek'] =json_encode($this->input->post('appointment_wek'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);




        $db_array['appointment_total_price_kilometer'] = $this->input->post('appointment_price_kilometor_total');

        $db_array['appointment_departure_location'] = $_POST['appointment_departure_location'];
        $db_array['appointment_stop_during_ride'] = $this->input->post('appointment_stop_during_ride');
        if(isset( $_POST['appointment_pickup_stop_time'])){
            $db_array['appointment_pickup_stop_time'] = $_POST['appointment_pickup_stop_time'];
        }


        $db_array['project_id'] = $_POST['project_id'];
        $db_array['create_date'] = date('Y-m-d');
        $db_array['appointment_update_date'] = date('Y-m-d H:i:s');
        $db_array['appointment_user_id'] = $this->session->userdata('user_id');
        $db_array['appointment_status'] = $_POST['appointment_status'];    
        $db_array['appointment_add_people'] = json_encode($this->input->post('appointment'));


        $appointment_product_id = $this->input->post('appointment_product_id');

        if(!empty($appointment_product_id )){

            $product_env = $this->mdl_products->where('product_id',$appointment_product_id)->get()->row();


                if($product_env->unit_id  == 3 ||$product_env->unit_id  == 8 ){
                    $db_array['appointment_price'] = $this->input->post('appointment_price');
                }else{
                    $db_array['appointment_price'] = 0;

                }

        }
        $db_array['appointment_product_id'] =$appointment_product_id;


        if(!empty($user->user_price_per_kilometer) && $user->user_price_per_kilometer>0){
            $db_array['appointment_expenses_tax_office'] =$user->user_price_per_kilometer*$_POST['appointment_kilometers'];
        }




        if(!empty($_POST['appointment_kilometers'])){
            $db_array['appointment_kilometers'] = $_POST['appointment_kilometers'];
            $db_array['appointment_current_mileage'] = $this->old_mileage($_POST['appointment_kilometers'])+$_POST['appointment_kilometers'];
            $this->default_car( $db_array['appointment_current_mileage']);
        }else{
            $db_array['appointment_kilometers'] = 0;
        }
        return $db_array;
    }


    public function old_mileage($kilometer = false){
        $query=$this->db->get_where('ip_fleets',array('fleet_user_id'=>$this->session->userdata('user_id'),'fleet_default_car'=>1))->row();

        if(!empty($query)){
          return $query->fleet_mileage_car_total;
        }

    }

    public function default_car($kilometer){
        $query=$this->db->get_where('ip_fleets',array('fleet_user_id'=>$this->session->userdata('user_id'),'fleet_default_car'=>1))->result();

        if(count($query)>0){
            $this->db->set('fleet_mileage_car_total', $kilometer, FALSE);
            $this->db->where('fleet_id', $query[0]->fleet_id);
            $this->db->update('ip_fleets');
        }

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

        if (!$id){
            $this->load->model('users/mdl_users');
            $this->load->model('products/mdl_products');
            parent::set_form_value('appointment_starting_time', date('Y-m-d'));
            parent::set_form_value('appointments_recur_start_date', date('Y-m-d'));
            parent::set_form_value('appointments_recur_end_date', date('Y-m-d'));
            parent::set_form_value('appointment_date', date('Y-m-d'));

          //  parent::set_form_value('appointment_price_per_kilometer', get_setting('default_hourly_rate'));
            $user = $this->mdl_users->get_by_id($this->session->userdata('user_id'));

            parent::set_form_value('default_hour_rate', $user->default_hour_rate);


        }
        return true;
    }


    /**
     * @param integer $invoice_id
     * @return array
     */
    public function get_appointments_to_invoice($invoice_id)
    {
        $result = array();

        if (!$invoice_id) {
            return $result;
        }

        // Get appointments without any project
        $query = $this->db->select($this->table . '.*')
            ->from($this->table)
            ->where($this->table . '.project_id', 0)
            ->where($this->table . '.appointment_status', 3)
            ->order_by($this->table . '.appointment_date', 'ASC')
            ->order_by($this->table . '.appointment_name', 'ASC')
            ->get();

        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        // Get appointments for this invoice
        $query = $this->db->select($this->table . '.*, ip_projects.project_name')
            ->from($this->table)
            ->join('ip_projects', 'ip_projects.project_id = ' . $this->table . '.project_id')
            ->join('ip_invoices', 'ip_invoices.client_id = ip_projects.client_id')
            ->where('ip_invoices.invoice_id', $invoice_id)
            ->where($this->table . '.appointment_status', 3)
            ->order_by($this->table . '.appointment_date', 'ASC')
            ->order_by('ip_projects.project_name', 'ASC')
            ->order_by($this->table . '.appointment_name', 'ASC')
            ->get();

        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param integer $invoice_id
     */
    public function update_on_invoice_delete($invoice_id)
    {
        if (!$invoice_id) {
            return;
        }
        $query = $this->db->select($this->table . '.*')
            ->from($this->table)
            ->join('ip_invoice_items', 'ip_invoice_items.item_appointment_id = ' . $this->table . '.appointment_id')
            ->where('ip_invoice_items.invoice_id', $invoice_id)
            ->get();

        foreach ($query->result() as $appointment) {
            $this->update_status(3, $appointment->appointment_id);
        }
    }

    /**
     * @param integer $quote_id
     */
    public function update_on_quote_delete($quote_id)
    {
        if (!$quote_id) {
            return;
        }
        $query = $this->db->select($this->table . '.*')
            ->from($this->table)
            ->join('ip_quote_items', 'ip_quote_items.item_appointment_id = ' . $this->table . '.appointment_id')
            ->where('ip_quote_items.quote_id', $quote_id)
            ->get();

        foreach ($query->result() as $appointment) {
            $this->update_status(3, $appointment);
        }
    }

    /**
     * @param integer $new_status
     * @param integer $appointment_id
     */
    public function update_status($new_status, $appointment_id)
    {
        $statuses_ok = $this->statuses();
        if (isset($statuses_ok[$new_status])) {
            parent::save($appointment_id, array('appointment_status' => $new_status));
        }
    }

    /**
     * @return array
     */
    public function statuses()
    {
        return array(
            '1' => array(
                'label' => trans('not_started'),
                'class' => 'draft'
            ),
            '2' => array(
                'label' => trans('in_progress'),
                'class' => 'viewed'
            ),
            '3' => array(
                'label' => trans('complete'),
                'class' => 'sent'
            ),
            '4' => array(
                'label' => trans('invoiced'),
                'class' => 'paid'
            ),
            '5' => array(
                'label' => trans('quoted'),
                'class' => 'paid'
            )
        );
    }

    /**
     * @param integer $project_id
     */
    public function update_on_project_delete($project_id)
    {
        if (!$project_id) {
            return;
        }

        $query = $this->db->select($this->table . '.*')
            ->from($this->table)
            ->where($this->table . '.project_id', $project_id)
            ->get();

        foreach ($query->result() as $appointment) {
            parent::save($appointment->appointment_id, array('project_id' => null));
        }
    }
}

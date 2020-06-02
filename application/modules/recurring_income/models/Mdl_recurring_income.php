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
 * Class Mdl_Recurring_income
 */
class Mdl_Recurring_income extends Response_Model
{
    public $table = 'ip_other_recurring_income';
    public $primary_key = 'ip_other_recurring_income.recurring_income_id';
    public $validation_rules = 'validation_rules';
    public $recur_frequencies = array(
        '7D' => 'calendar_week_1',
        '14D' => 'calendar_week_2',
        '21D' => 'calendar_week_3',
        '28D' => 'calendar_week_4',
        '1M' => 'calendar_month_1',
        '2M' => 'calendar_month_2',
        '3M' => 'calendar_month_3',
        '4M' => 'calendar_month_4',
        '5M' => 'calendar_month_5',
        '6M' => 'calendar_month_6',
        '1Y' => 'calendar_year_1',
    );

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_other_recurring_income.*", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_other_recurring_income.recurring_income_end_date DESC');
    }


    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'recurring_income_datew' => array(
                'field' => 'recurring_income_date',
                'label' => trans('date'),
                'rules' => 'required'
            ),
            'recurring_income_start_date' => array(
                'field' => 'recurring_income_start_date',
                'label' => trans('recurring_income_start_date'),
            ),
            'recurring_income_amount' => array(
                'field' => 'recurring_income_amount',
                'label' => trans('recurring_income'),
            ),
            'recurring_income_end_date' => array(
                'field' => 'recurring_income_end_date',
                'label' => trans('recurring_income_end_date'),
            ),
            'recurring_income_frequency' => array(
                'field' => 'recurring_income_frequency',
                'label' => trans('every'),
            ),
            'recurring_income_contact' => array(
                'field' => 'recurring_income_contact',
                'label' => trans('recurring_income_contact'),

            ),
            'recurring_income_username' => array(
                'field' => 'recurring_income_username',
                'label' => trans('recurring_income_username'),
            ),
            'recurring_income_note' => array(
                'field' => 'recurring_income_note',
                'label' => trans('note')
            ),
            'recurring_income_document_link' => array(
                'field' => 'recurring_income_document_link',
                'label' => lang('recurring_income_document_link')
            ),
            'recurring_income_category' => array(
                'field' => 'recurring_income_category',
                'label' => lang('recurring_income_category'),
            ),
            'recurring_income_name' => array(
                'field' => 'recurring_income_name',
                'label' => lang('recurring_income_name'),
            ),
            'recurring_income_contactperson_name' => array(
                'field' => 'recurring_income_name',
                'label' => trans('recurring_income_name'),
            ),
            'recurring_income_contactperson_email' => array(
                'field' => 'recurring_income_contactperson_email',
                'label' => trans('recurring_income_email'),
            ),
            'recurring_income_dontadd' => array(
                'field' => 'recurring_income_dontadd',
                'label' => trans('recurring_income_dontadd'),
            ),
            'recurring_income_outstanding_amount' => array(
                'field' => 'recurring_income_outstanding_amount',
                'label' => trans('total_outstanding_amount'),
            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        $recurring_income_dontadd = +$this->input->post('recurring_income_dontadd');
        if ($recurring_income_dontadd != 1) {
            $recurring_income_dontadd = 0;
        }


        if(empty($this->input->post('recurring_income_url_key'))){
            $db_array['recurring_income_url_key'] =$this->get_url_key();
        }


        $db_array['recurring_income_date'] = date_to_mysql($this->input->post('recurring_income_date'));
        $db_array['recurring_income_start_date'] = date_to_mysql($this->input->post('recurring_income_start_date'));
        $db_array['recurring_income_end_date'] = date_to_mysql($this->input->post('recurring_income_end_date'));
        $db_array['recurring_income_amount'] = standardize_amount($this->input->post('recurring_income_amount'));
        $db_array['recurring_income_dontadd'] =$recurring_income_dontadd;


// var_dump();
// die;
        return $db_array;
    }


    /**
     * @param null $id
     */
    public function delete($id = null)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    /**
     * @param null $id
     * @return bool
     */

    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }

        if (!$id) {
            parent::set_form_value('recurring_income_date', date('Y-m-d'));
            parent::set_form_value('recurring_income_start_date', date('Y-m-d'));
            parent::set_form_value('recurring_income_end_date', date('Y-m-d'));

            // parent::set_form_value('recurring_income_dontadd', '1');

            
        }

        return true;
    }

    public function by_client($client_id)
    {
        $this->filter_where('ip_clients.client_id', $client_id);
        return $this;
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }
}

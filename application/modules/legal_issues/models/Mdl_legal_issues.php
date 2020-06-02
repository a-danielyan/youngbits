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
 * Class Mdl_Inventory
 */
class Mdl_Legal_issues extends Response_Model
{
    public $table = 'ip_legal_issues';
    public $primary_key = 'ip_legal_issues.legal_issues_id';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_legal_issues.*", false);
    }

    public function default_order_by()
    {
        $orderType = $this->input->get('type') ? $this->input->get('type') : 'DESC';
        $orderField = $this->input->get('field') ? $this->input->get('field') : 'legal_issues_date';
        $orderTable = $this->input->get('table') ? ($this->input->get('table') === 'INDEPENDENT' ? '' : $this->input->get('table').'.') : 'ip_legal_issues.';
        $this->db->order_by($orderTable.$orderField.' '.$orderType);
    }


    /**
     * @return array
     */
    public function validation_rules()
    {//todo
        return array(
            'legal_issues_date' => array(
                'field' => 'legal_issues_date',
                'label' => trans('date'),
                'rules' => 'required'
            ),
            'legal_issues_amount' => array(
                'field' => 'legal_issues_amount',
                'label' => trans('legal_issues'),
            ),
            'legal_issues_note_german' => array(
                'field' => 'legal_issues_note_german',
                'label' => trans('legal_issues_note_german')
            ),
            'legal_issues_document_link' => array(
                'field' => 'legal_issues_document_link',
                'label' => lang('legal_issues_document_link')
            ),
            'legal_issues_category' => array(
                'field' => 'legal_issues_category',
                'label' => lang('legal_issues_category')
            ),
            'legal_issues_company_name' => array(
                'field' => 'legal_issues_company_name',
                'label' => lang('legal_issues_category')
            ),
            'legal_issues_location_address' => array(
                'field' => 'legal_issues_location_address',
                'label' => lang('legal_issues_location_address')
            ),
            'legal_issues_german_title' => array(
                'field' => 'legal_issues_german_title',
                'label' => lang('legal_issues_german_title')
            ),
            'legal_issues_dutch_title' => array(
                'field' => 'legal_issues_dutch_title',
                'label' => lang('legal_issues_dutch_title')
            ),
            'legal_issues_engilsh_title' => array(
                'field' => 'legal_issues_engilsh_title',
                'label' => lang('legal_issues_engilsh_title')
            ),
            'legal_issues_note_dutch' => array(
                'field' => 'legal_issues_note_dutch',
                'label' => lang('legal_issues_note_dutch')
            ),
            'legal_issues_note_engilsh' => array(
                'field' => 'legal_issues_note_engilsh',
                'label' => lang('legal_issues_note_engilsh')
            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['legal_issues_date'] = date_to_mysql($db_array['legal_issues_date']);
        $db_array['legal_issues_amount'] = standardize_amount($db_array['legal_issues_amount']);

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
            parent::set_form_value('legal_issues_date', date('Y-m-d'));
        }

        return true;
    }

    /**
     * @param $client_id
     * @return $this
     */
    public function by_client($client_id)
    {
        $this->filter_where('ip_clients.client_id', $client_id);
        return $this;
    }

}

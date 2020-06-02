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
 * Class Mdl_Offer_Tax_Rates
 */
class Mdl_Offer_Tax_Rates extends Response_Model
{
    public $table = 'ip_offer_tax_rates';
    public $primary_key = 'ip_offer_tax_rates.offer_tax_rate_id';

    public function default_select()
    {
        $this->db->select('ip_tax_rates.tax_rate_name AS offer_tax_rate_name');
        $this->db->select('ip_tax_rates.tax_rate_percent AS offer_tax_rate_percent');
        $this->db->select('ip_offer_tax_rates.*');
    }

    public function default_join()
    {
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_offer_tax_rates.tax_rate_id');
    }

    /**
     * @param null $id
     * @param null $db_array
     * @return void
     */
    public function save($id = null, $db_array = null)
    {
        parent::save($id, $db_array);

        $this->load->model('offers/mdl_offer_amounts');

        if (isset($db_array['offer_id'])) {
            $offer_id = $db_array['offer_id'];
        } else {
            $offer_id = $this->input->post('offer_id');
        }

        if ($offer_id) {
            $this->mdl_offer_amounts->calculate_offer_taxes($offer_id);
            $this->mdl_offer_amounts->calculate($offer_id);
        }

    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'offer_id' => array(
                'field' => 'offer_id',
                'label' => trans('offer'),
                'rules' => 'required'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => trans('tax_rate'),
                'rules' => 'required'
            ),
            'include_item_tax' => array(
                'field' => 'include_item_tax',
                'label' => trans('tax_rate_placement'),
                'rules' => 'required'
            )
        );
    }

}

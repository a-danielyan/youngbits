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
 * Class Mdl_Offers
 */
class Mdl_Offers extends Response_Model
{
    public $table = 'ip_offers';
    public $primary_key = 'ip_offers.offer_id';
    public $date_modified_field = 'offer_date_modified';

    /**
     * @return array
     */
    public function statuses()
    {
        return array(
            '1' => array(
                'label' => trans('draft'),
                'class' => 'draft',
                'href' => 'offers/status/draft'
            ),
            '2' => array(
                'label' => trans('sent'),
                'class' => 'sent',
                'href' => 'offers/status/sent'
            ),
            '3' => array(
                'label' => trans('viewed'),
                'class' => 'viewed',
                'href' => 'offers/status/viewed'
            ),
            '4' => array(
                'label' => trans('accepted'),
                'class' => 'approved',
                'href' => 'offers/status/accepted'
            ),
            '5' => array(
                'label' => trans('declined'),
                'class' => 'rejected',
                'href' => 'offers/status/declined'
            )
        );
    }

    public function default_select()
    {
        // SQL_CALC_FOUND_ROWS
        $this->db->select("
           SQL_CALC_FOUND_ROWS
            ip_users.user_name,
            ip_users.user_company,
            ip_users.user_address_1,
            ip_users.user_address_2,
            ip_users.user_city,
            ip_users.user_state,
            ip_users.user_zip,
            ip_users.user_country,
            ip_users.user_phone,
            ip_users.user_fax,
            ip_users.user_mobile,
            ip_users.user_email,
            ip_users.user_web,
            ip_users.user_vat_id,
            ip_users.user_tax_code,
            ip_users.user_subscribernumber,
            ip_users.user_iban,
            ip_users.user_gln,
            ip_users.user_rcc,
            ip_clients.*,
            ip_offers.*,
            item_tax_rates.tax_rate_percent AS transport_tax_rate_percent,
            ip_offer_amounts.offer_amount_id,
            IFnull(ip_offer_amounts.offer_item_subtotal, '0.00') AS offer_item_subtotal,
            IFnull(ip_offer_amounts.offer_item_tax_total, '0.00') AS offer_item_tax_total,
            IFnull(ip_offer_amounts.offer_tax_total, '0.00') AS offer_tax_total,
            IFnull(ip_offer_amounts.offer_total, '0.00') AS offer_total,
            IFnull(ip_offer_amounts.offer_paid, '0.00') AS offer_paid,
            IFnull(ip_offer_amounts.offer_balance, '0.00') AS offer_balance,
            IFnull(ip_offer_amounts.offer_transport, '0.00') AS offer_transport,
            IFnull(ip_offer_amounts.offer_transport_tax, '0.00') AS offer_transport_tax,
            ip_offer_amounts.offer_sign AS offer_sign,
            (CASE WHEN ip_offers.offer_status_id NOT IN (1,4,5) AND DATEDIFF(NOW(), offer_due_date) > 0 THEN 1 ELSE 0 END) is_overdue ", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_offers.offer_id DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_offers.client_id');
        $this->db->join('ip_users', 'ip_users.user_id = ip_offers.user_id');
        $this->db->join('ip_offer_amounts', 'ip_offer_amounts.offer_id = ip_offers.offer_id', 'left');
        //$this->db->join('ip_invoice_sumex', 'sumex_invoice = ip_invoices.invoice_id', 'left');
        //$this->db->join('ip_quotes', 'ip_quotes.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_tax_rates AS item_tax_rates', 'item_tax_rates.tax_rate_id = ip_offers.transport_tax_rate_id', 'left');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'client_id' => array(
                'field' => 'client_id',
                'label' => trans('client'),
                'rules' => 'required'
            ),
            'offer_date_created' => array(
                'field' => 'offer_date_created',
                'label' => trans('offer_date'),
                'rules' => 'required'
            ),
            'offer_time_created' => array(
                'rules' => 'required'
            ),
            'offer_password' => array(
                'field' => 'offer_password',
                'label' => trans('offer_password')
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => trans('user'),
                'rule' => 'required'
            )
        );
    }

    /**
     * @return array
     */
    public function validation_rules_save_offer()
    {
        return array(
            'offer_id' => array(
                'field' => 'offer_id',
                'label' => '',
                'rules' => 'required'
            )
        );
    }

    /**
     * @param null $db_array
     * @param bool $include_invoice_tax_rates
     * @return int|null
     */
    public function create($db_array = null, $include_invoice_tax_rates = true)
    {
        $offer_id = parent::save(null, $db_array);

        $inv = $this->where('ip_offers.offer_id', $offer_id)->get()->row();
        //$invoice_group = $inv->invoice_group_id;

        // Create an offer amount record
        $db_array = array(
            'offer_id' => $offer_id
        );

        return $offer_id;
    }

    /**
     * Copies offer items, tax rates, etc from source to target
     * @param int $source_id
     * @param int $target_id
     * @param bool $copy_recurring_items_only
     */
    public function copy_invoice($source_id, $target_id, $copy_recurring_items_only = false)
    {
        /*$this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        // Copy the items
        $invoice_items = $this->mdl_items->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_items as $invoice_item) {
            $db_array = array(
                'invoice_id' => $target_id,
                'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                'item_product_id' => $invoice_item->item_product_id,
                'item_task_id' => $invoice_item->item_task_id,
                'item_name' => $invoice_item->item_name,
                'item_description' => $invoice_item->item_description,
                'item_quantity' => $invoice_item->item_quantity,
                'item_price' => $invoice_item->item_price,
                'item_discount_amount' => $invoice_item->item_discount_amount,
                'item_order' => $invoice_item->item_order,
                'item_is_recurring' => $invoice_item->item_is_recurring,
                'item_product_unit' => $invoice_item->item_product_unit,
                'item_product_unit_id' => $invoice_item->item_product_unit_id,
            );

            if (!$copy_recurring_items_only || $invoice_item->item_is_recurring) {
                $this->mdl_items->save(null, $db_array);
            }
        }

        // Copy the tax rates
        $invoice_tax_rates = $this->mdl_invoice_tax_rates->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_tax_rates as $invoice_tax_rate) {
            $db_array = array(
                'invoice_id' => $target_id,
                'tax_rate_id' => $invoice_tax_rate->tax_rate_id,
                'include_item_tax' => $invoice_tax_rate->include_item_tax,
                'invoice_tax_rate_amount' => $invoice_tax_rate->invoice_tax_rate_amount
            );

            $this->mdl_invoice_tax_rates->save(null, $db_array);
        }

        // Copy the custom fields
        $this->load->model('custom_fields/mdl_invoice_custom');
        $custom_fields = $this->mdl_invoice_custom->where('invoice_id', $source_id)->get()->result();

        $form_data = array();
        foreach ($custom_fields as $field) {
            $form_data[$field->invoice_custom_fieldid] = $field->invoice_custom_fieldvalue;
        }
        $this->mdl_invoice_custom->save_custom($target_id, $form_data);
        */
    }

    /**
     * Copies invoice items, tax rates, etc from source to target
     * @param int $source_id
     * @param int $target_id
     */
    public function copy_credit_invoice($source_id, $target_id)
    {
        /*$this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        $invoice_items = $this->mdl_items->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_items as $invoice_item) {
            $db_array = array(
                'invoice_id' => $target_id,
                'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                'item_product_id' => $invoice_item->item_product_id,
                'item_task_id' => $invoice_item->item_task_id,
                'item_name' => $invoice_item->item_name,
                'item_description' => $invoice_item->item_description,
                'item_quantity' => $invoice_item->item_quantity,
                'item_price' => $invoice_item->item_price,
                'item_discount_amount' => $invoice_item->item_discount_amount,
                'item_order' => $invoice_item->item_order,
                'item_is_recurring' => $invoice_item->item_is_recurring,
                'item_product_unit' => $invoice_item->item_product_unit,
                'item_product_unit_id' => $invoice_item->item_product_unit_id,
            );

            $this->mdl_items->save(null, $db_array);
        }

        $invoice_tax_rates = $this->mdl_invoice_tax_rates->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_tax_rates as $invoice_tax_rate) {
            $db_array = array(
                'invoice_id' => $target_id,
                'tax_rate_id' => $invoice_tax_rate->tax_rate_id,
                'include_item_tax' => $invoice_tax_rate->include_item_tax,
                'invoice_tax_rate_amount' => -$invoice_tax_rate->invoice_tax_rate_amount
            );

            $this->mdl_invoice_tax_rates->save(null, $db_array);
        }

        // Copy the custom fields
        $this->load->model('custom_fields/mdl_invoice_custom');
        $db_array = $this->mdl_invoice_custom->where('invoice_id', $source_id)->get()->result();

        $form_data = array();
        foreach ($db_array as $val) {
            $form_data[$val->invoice_custom_fieldid] = $val->invoice_custom_fieldvalue;
        }
        $this->mdl_invoice_custom->save_custom($target_id, $form_data);
        */
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        // Get the client id for the submitted offer
        $this->load->model('clients/mdl_offers');

        // Check if is SUMEX
       // $this->load->model('invoice_groups/mdl_invoice_groups');

        $db_array['offer_date_created'] = date_to_mysql($db_array['offer_date_created']);
        //$db_array['offer_date_due'] = $this->get_date_due($db_array['offer_date_created']);
        $db_array['offer_terms'] = get_setting('default_offer_terms');

        if (!isset($db_array['offer_status_id'])) {
            $db_array['offer_status_id'] = 1;
        }

        //$generate_invoice_number = get_setting('generate_invoice_number_for_draft');

      /*  if ($db_array['offer_status_id'] === 1 && $generate_invoice_number == 1) {
            $db_array['invoice_number'] = $this->get_invoice_number($db_array['invoice_group_id']);
        } elseif ($db_array['invoice_status_id'] != 1) {
            $db_array['invoice_number'] = $this->get_invoice_number($db_array['invoice_group_id']);
        } else {
            $db_array['invoice_number'] = '';
        }
*/
        // Set default values
       // $db_array['payment_method'] = (empty($db_array['payment_method']) ? 0 : $db_array['payment_method']);

        // Generate the unique url key
        $db_array['offer_url_key'] = $this->get_url_key();

        return $db_array;
    }

    /**
     * @param $offer
     * @return mixed
     */
    public function get_payments($offer)
    {
        $this->load->model('payments/mdl_payments');

        $this->db->where('offer_id', $offer->offer_id);
        $payment_results = $this->db->get('ip_payments');

        if ($payment_results->num_rows()) {
            return $offer;
        }

        $offer->payments = $payment_results->result();

        return $offer;
    }

    /**
     * @param string $invoice_date_created
     * @return string
     */
    public function get_date_due($invoice_date_created)
    {
      /*  $invoice_date_due = new DateTime($invoice_date_created);
        $invoice_date_due->add(new DateInterval('P' . get_setting('invoices_due_after') . 'D'));
        return $invoice_date_due->format('Y-m-d');*/
    }

    /**
     * @param $invoice_group_id
     * @return mixed
     */
    public function get_invoice_number($invoice_group_id)
    {
      /*  $this->load->model('invoice_groups/mdl_invoice_groups');
        return $this->mdl_invoice_groups->generate_invoice_number($invoice_group_id);
    */
    }

    /**
     * @return string
     */
    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    /**
     * @param $invoice_id
     * @return mixed
     */
    public function get_invoice_group_id($invoice_id)
    {
       /* $invoice = $this->get_by_id($invoice_id);
        return $invoice->invoice_group_id;*/
    }

    /**
     * @param int $parent_invoice_id
     * @return mixed
     */
    public function get_parent_invoice_number($parent_invoice_id)
    {
       //// $parent_invoice = $this->get_by_id($parent_invoice_id);
       // return $parent_invoice->invoice_number;
    }

    /**
     * @return mixed
     */
    public function get_custom_values($id)
    {
     //   $this->load->module('custom_fields/Mdl_invoice_custom');
       // return $this->invoice_custom->get_by_invid($id);
    }


    /**
     * @param int $invoice_id
     */
    public function delete($invoice_id)
    {
        parent::delete($invoice_id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    // Used from the guest module, excludes draft and paid
    public function is_open()
    {
        $this->filter_where_in('offer_status_id', array(2, 3));
        return $this;
    }

    // Used to check if the invoice is Sumex
    public function is_sumex()
    {
       // $this->where('sumex_id is NOT NULL', null, false);
        //return $this;
    }

    public function guest_visible()
    {
        $this->filter_where_in('offer_status_id', array(2, 3, 4, 5));
        return $this;
    }

    public function is_draft()
    {
        $this->filter_where('offer_status_id', 1);
        return $this;
    }

    public function is_sent()
    {
        $this->filter_where('offer_status_id', 2);
        return $this;
    }

    public function is_viewed()
    {
        $this->filter_where('offer_status_id', 3);
        return $this;
    }

    public function is_accepted()
    {
        $this->filter_where('offer_status_id', 4);
        return $this;
    }

    public function is_declined()
    {
        $this->filter_where('offer_status_id', 5);
        return $this;
    }

    public function is_overdue()
    {
        $this->filter_having('is_overdue', 1);
        return $this;
    }

    public function by_client($client_id)
    {
        $this->filter_where('ip_offers.client_id', $client_id);
        return $this;
    }

    /**
     * @param $offer
     */
    public function offer_to_invoice($offer)
    {
        $this->load->model('offers/mdl_offer_items');
        $this->load->model('invoices/mdl_item_amounts');
        $this->load->model('invoices/mdl_invoice_amounts');

        $db_array = array();
        $db_array["user_id"] = $offer->user_id;
        $db_array["client_id"] = $offer->client_id;
        $db_array["invoice_password"] = $offer->offer_password;
        $db_array["invoice_date_created"] = date("Y-m-d");
        $db_array["invoice_date_due"] = $offer->invoice_due_date;
        $db_array["invoice_number"] = $offer->invoice_number;
        $db_array["invoice_discount_amount"] = $offer->offer_discount_amount;
        $db_array["invoice_discount_percent"] = $offer->offer_discount_percent;
        $db_array["invoice_terms"] = $offer->offer_terms;
        $db_array["invoice_group_id"] = get_setting('default_invoice_group');
        $db_array["payment_method"] = $offer->payment_method;
        $db_array["invoice_url_key"] = $this->get_url_key();
        $db_array["parrent_offer_id"] = $offer->offer_id;
        $db_array["offer_transport"] = $offer->offer_transport;
        $db_array["offer_transport_tax"] = $offer->offer_transport_tax;
        $this->db->insert("ip_invoices", $db_array);
        $invoice_id = $this->db->insert_id();

        $items = $this->mdl_offer_items->where('offer_id', $offer->offer_id)->get()->result();


        foreach ($items as $item)
        {
            $db_array = array();
            $db_array["invoice_id"] = $invoice_id;
            $db_array["item_tax_rate_id"] = $item->item_tax_rate_id;
            $db_array["item_date_added"] = $item->item_date_added;
            $db_array["item_name"] = $item->item_name;
            $db_array["item_product_SKU"] = $item->item_product_SKU;
            $db_array["item_description"] = $item->item_description;
            $db_array["item_quantity"] = $item->item_quantity;
            $db_array["item_price"] = $item->item_price;
            $db_array["item_discount_amount"] = $item->item_discount_amount;
            $db_array["item_order"] = $item->item_order;
            $db_array["item_is_recurring"] = 0;

            $this->db->insert("ip_invoice_items", $db_array);
            $item_id = $this->db->insert_id();

            $this->mdl_item_amounts->calculate($item_id);
        }

        $this->mdl_invoice_amounts->calculate($invoice_id);

    }

    /**
     * @param $offer_url_key
     */
    public function approve_offer_by_id($offer_id, $transport, $comment)
    {
        $offer = $this->get_by_id($offer_id);
        $transport_price = 0;
        if ($transport == "Tailgate")
        {
            $transport_price = $offer->transport_tailgate;
        }
        else if ($transport == "Without_tailgate")
        {
            $transport_price = $offer->transport_without_tailgate;
        }
        $transport_tax = 0;
        if ($offer->transport_tax_rate_id != 0)
        {
            $transport_tax = $transport_price * $offer->transport_tax_rate_percent / 100;
        }
        $this->db->where_in('offer_status_id', array(2, 3));
        $this->db->where('offer_id', $offer_id);
        $this->db->set('offer_status_id', 4);
        $this->db->set('offer_transport_selected_text', $transport);
        $this->db->set('offer_transport_selected', $transport_price);
        $this->db->set('offer_transport_selected_tax', $transport_tax);
        $this->db->set('client_comment', $comment);
        $this->db->update('ip_offers');

        $this->load->model('offers/mdl_offer_amounts');
        $this->mdl_offer_amounts->calculate($offer_id);
        $offer = $this->get_by_id($offer_id);
        $this->offer_to_invoice($offer);
    }

    /**
     * @param $offer_url_key
     */
    public function decline_offer_by_id($offer_id, $transport, $comment)
    {
        $offer = $this->get_by_id($offer_id);
        $transport_price = 0;
        if ($transport == "Tailgate")
        {
            $transport_price = $offer->transport_tailgate;
        }
        else if ($transport == "Without_tailgate")
        {
            $transport_price = $offer->transport_without_tailgate;
        }
        $transport_tax = 0;
        if ($offer->transport_tax_rate_id != 0)
        {
            $transport_tax = $transport_price * $offer->transport_tax_rate_percent / 100;
        }
        $this->db->where_in('offer_status_id', array(2, 3));
        $this->db->where('offer_id', $offer_id);
        $this->db->set('offer_status_id', 5);
        $this->db->set('offer_transport_selected_text', $transport);
        $this->db->set('offer_transport_selected', $transport_price);
        $this->db->set('offer_transport_selected_tax', $transport_tax);
        $this->db->set('client_comment', $comment);
        $this->db->update('ip_offers');

        $this->load->model('offers/mdl_offer_amounts');
        $this->mdl_offer_amounts->calculate($offer_id);
    }

    /**
     * @param $offer_id
     */
    public function mark_viewed($offer_id)
    {
        $offer = $this->get_by_id($offer_id);

        if (!empty($offer)) {
            if ($offer->offer_status_id == 2) {
                $this->db->where('offer_id', $offer_id);
                $this->db->set('offer_status_id', 3);
                $this->db->update('ip_offers');
            }
        }
    }

    /**
     * @param $offer_id
     */
    public function mark_sent($offer_id)
    {
        $offer = $this->mdl_offers->get_by_id($offer_id);

        if (!empty($offer)) {
            if ($offer->offer_status_id == 1) {
                // Set new date and save
                $this->db->where('offer_id', $offer_id);
                $this->db->set('offer_status_id', 2);
                $this->db->update('ip_offers');
            }
        }
    }

    /**
     * @param $offer_id
     */
    public function mark_accepted($offer_id)
    {
        $offer = $this->mdl_offers->get_by_id($offer_id);

        if (!empty($offer)) {
            if ($offer->offer_status_id == 1 || $offer->offer_status_id == 2 || $offer->offer_status_id == 3) {
                // Set new date and save
                $this->db->where('offer_id', $offer_id);
                $this->db->set('offer_status_id', 4);
                $this->db->update('ip_offers');
            }
        }
    }

    /**
     * @param $offer_id
     */
    public function mark_declined($offer_id)
    {
        $offer = $this->mdl_offers->get_by_id($offer_id);

        if (!empty($offer)) {
            if ($offer->offer_status_id == 1 || $offer->offer_status_id == 2 || $offer->offer_status_id == 3) {
                // Set new date and save
                $this->db->where('offer_id', $offer_id);
                $this->db->set('offer_status_id', 5);
                $this->db->update('ip_offers');
            }
        }
    }

}

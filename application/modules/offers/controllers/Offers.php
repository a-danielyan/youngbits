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
 * Class Offers
 */
class Offers extends Admin_Controller
{
    /**
     * Offers constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_offers');
    }

    public function index()
    {
        // Display all offers by default
        redirect('offers/status/all');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'all', $page = 0)
    {
        // Determine which group of invoices to load
        switch ($status) {
            case 'draft':
                $this->mdl_offers->is_draft();
                break;
            case 'sent':
                $this->mdl_offers->is_sent();
                break;
            case 'viewed':
                $this->mdl_offers->is_viewed();
                break;
            case 'accepted':
                $this->mdl_offers->is_accepted();
                break;
            case 'declined':
                $this->mdl_offers->is_declined();
                break;
        }


        $this->mdl_offers->paginate(site_url('offers/status/' . $status), $page);

        $offers = $this->mdl_offers->result();
        //$this->db->last_query();

        $this->layout->set(
            array(
                'offers' => $offers,
                'status' => $status,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_offers'),
                'filter_method' => 'filter_offers',
                'offer_statuses' => $this->mdl_offers->statuses()
            )
        );

        $this->layout->buffer('content', 'offers/index');
        $this->layout->render();
    }

    public function archive()
    {//todo
        $invoice_array = array();
        if (isset($_POST['invoice_number'])) {
            $invoiceNumber = $_POST['invoice_number'];
            $invoice_array = glob('./uploads/archive/*' . '_' . $invoiceNumber . '.pdf');
            $this->layout->set(
                array(
                    'invoices_archive' => $invoice_array
                ));
            $this->layout->buffer('content', 'invoices/archive');
            $this->layout->render();

        } else {
            foreach (glob('./uploads/archive/*.pdf') as $file) {
                array_push($invoice_array, $file);
            }
            rsort($invoice_array);
            $this->layout->set(
                array(
                    'invoices_archive' => $invoice_array
                ));
            $this->layout->buffer('content', 'invoices/archive');
            $this->layout->render();
        }
    }

    /**
     * @param $offer
     */
    public function download($offer)
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $offer . '"');
        readfile('./uploads/archive/' . $offer);
    }

    /**
     * @param $offer_id
     */
    public function view($offer_id)
    {
        $this->load->model(
            array(
                'mdl_offer_items',
                'tax_rates/mdl_tax_rates',
                'payment_methods/mdl_payment_methods',
                //'mdl_invoice_tax_rates',
                //'custom_fields/mdl_custom_fields',
            )
        );

        $this->load->helper("custom_values");
        $this->load->helper("client");
        $this->load->helper('country');
        $this->load->model('units/mdl_units');
        $this->load->module('payments');

        $this->load->model('custom_values/mdl_custom_values');
        //$this->load->model('custom_fields/mdl_invoice_custom');

        $this->db->reset_query();


        //$fields = $this->mdl_invoice_custom->by_id($invoice_id)->get()->result();
        $offer = $this->mdl_offers->get_by_id($offer_id);

        if (!$offer) {
            show_404();
        }

        /*$custom_fields = $this->mdl_custom_fields->by_table('ip_invoice_custom')->get()->result();
        $custom_values = [];
        foreach ($custom_fields as $custom_field) {
            if (in_array($custom_field->custom_field_type, $this->mdl_custom_values->custom_value_fields())) {
                $values = $this->mdl_custom_values->get_by_fid($custom_field->custom_field_id)->result();
                $custom_values[$custom_field->custom_field_id] = $values;
            }
        }

        foreach ($custom_fields as $cfield) {
            foreach ($fields as $fvalue) {
                if ($fvalue->invoice_custom_fieldid == $cfield->custom_field_id) {
                    // TODO: Hackish, may need a better optimization
                    $this->mdl_invoices->set_form_value(
                        'custom[' . $cfield->custom_field_id . ']',
                        $fvalue->invoice_custom_fieldvalue
                    );
                    break;
                }
            }
        }*/

        $this->layout->set(
            array(
                'offer' => $offer,
                'items' => $this->mdl_offer_items->where('offer_id', $offer_id)->get()->result(),
                'offer_id' => $offer_id,
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                //'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                'units' => $this->mdl_units->get()->result(),
                'payment_methods' => $this->mdl_payment_methods->get()->result(),
                //'custom_fields' => $custom_fields,
                //'custom_values' => $custom_values,
                'custom_js_vars' => array(
                    'currency_symbol' => get_setting('currency_symbol'),
                    'currency_symbol_placement' => get_setting('currency_symbol_placement'),
                    'decimal_point' => get_setting('decimal_point')
                ),
                'offer_statuses' => $this->mdl_offers->statuses()
            )
        );

        $this->layout->buffer(
            array(
                array('modal_delete_offer', 'offers/modal_delete_offer'),
                //array('modal_add_invoice_tax', 'offers/modal_add_invoice_tax'),
                array('modal_add_payment', 'payments/modal_add_payment'),
                array('content', 'offers/view')
            )
        );

        $this->layout->render();
    }

    /**
     * @param $offer_id
     */
    public function delete($offer_id)
    {
        // Get the status of the offer
        $offer = $this->mdl_offers->get_by_id($offer_id);
        $offer_status = $offer->offer_status_id;

        if ($offer_status == 1 || $this->config->item('enable_invoice_deletion') === true) {

            // Delete the offer
            $this->mdl_offers->delete($offer_id);
        } else {
            // Add alert that invoices can't be deleted
            $this->session->set_flashdata('alert_error', trans('invoice_deletion_forbidden'));
        }

        // Redirect to offer index
        redirect('offers/index');
    }

    /**
     * @param $offer_id
     * @param $item_id
     */
    public function delete_item($offer_id, $item_id)
    {
        // Delete invoice item
        $this->load->model('mdl_offer_items');
        $item = $this->mdl_offer_items->delete($item_id);


        // Redirect to invoice view
        redirect('offers/view/' . $offer_id);
    }

    /**
     * @param $offer_id
     * @param bool $stream
     * @param null $offer_template
     */
    public function generate_pdf($offer_id, $stream = true, $offer_template = null)
    {
        $this->load->helper('pdf');

        generate_offer_pdf($offer_id, $stream, $offer_template, null);
    }

    /**
     * @param $invoice_id
     * @param $invoice_tax_rate_id
     */
    public function delete_invoice_tax($invoice_id, $invoice_tax_rate_id)
    {
        $this->load->model('mdl_invoice_tax_rates');
        $this->mdl_invoice_tax_rates->delete($invoice_tax_rate_id);

        $this->load->model('mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($invoice_id);

        redirect('invoices/view/' . $invoice_id);
    }

    public function recalculate_all_offers()
    {
        $this->db->select('offer_id');
        $offer_ids = $this->db->get('ip_offers')->result();

        $this->load->model('mdl_offer_amounts');

        foreach ($offer_ids as $offer_id) {
            $this->mdl_offer_amounts->calculate($offer_id->offer_id);
        }
    }

}

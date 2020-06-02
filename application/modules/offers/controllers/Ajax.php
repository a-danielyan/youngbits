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
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function save()
    {
        $this->load->model('offers/mdl_offer_items');
        $this->load->model('offers/mdl_offers');
        $this->load->model('units/mdl_units');
        //$this->load->model('offers/mdl_offer_sumex');

        $offer_id = $this->input->post('offer_id');

        $this->mdl_offers->set_id($offer_id);

        if ($this->mdl_offers->run_validation('validation_rules_save_offer')) {
            $items = json_decode($this->input->post('items'));

            foreach ($items as $item) {
                // Check if an item has either a quantity + price or name or description
                if (!empty($item->item_name)) {
                    $item->item_quantity = ($item->item_quantity ? standardize_amount($item->item_quantity) : floatval(0));
                    $item->item_price = ($item->item_quantity ? standardize_amount($item->item_price) : floatval(0));
                    $item->item_discount_amount = ($item->item_discount_amount) ? standardize_amount($item->item_discount_amount) : null;
                    $item->item_product_id = ($item->item_product_id ? $item->item_product_id : null);

                    $item->item_product_unit_id = ($item->item_product_unit_id ? $item->item_product_unit_id : null);
                    $item->item_product_unit = $this->mdl_units->get_name($item->item_product_unit_id, $item->item_quantity);

                    $item_id = ($item->item_id) ?: null;
                    unset($item->item_id);

                    if (!$item->item_task_id) {
                        unset($item->item_task_id);
                    }

                    $this->mdl_offer_items->save($item_id, $item);
                } elseif (empty($item->item_name) && (!empty($item->item_quantity) || !empty($item->item_price))) {
                    // Throw an error message and use the form validation for that
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('item_name', trans('item'), 'required');
                    $this->form_validation->run();

                    $response = array(
                        'success' => 0,
                        'validation_errors' => array(
                            'item_name' => form_error('item_name', '', ''),
                        )
                    );

                    echo json_encode($response);
                    exit;
                }
            }

            if ($this->input->post('offer_discount_amount') === '') {
                $offer_discount_amount = floatval(0);
            } else {
                $offer_discount_amount = $this->input->post('offer_discount_amount');
            }

            if ($this->input->post('offer_discount_percent') === '') {
                $offer_discount_percent = floatval(0);
            } else {
                $offer_discount_percent = $this->input->post('offer_discount_percent');
            }

            /*$transport_tax_rate_percent = 0;
            if ($this->input->post('transport_tax_rate_id') != 0)
            {
                $transport_tax_rate_id = $this->input->post('transport_tax_rate_id');

                $this->load->model('tax_rates/mdl_tax_rates');
                $tax_rate = $this->mdl_tax_rates->get_by_id($transport_tax_rate_id);
                $transport_tax_rate_percent = $tax_rate->tax_rate_percent;
            }*/

            $db_array = array(
                'offer_id' => $offer_id,
                'offer_number' => $this->input->post('offer_number'),
                'offer_date_created' => date_to_mysql($this->input->post('offer_date_created')),
                'offer_due_date' => date_to_mysql($this->input->post('offer_due_date')),
                'invoice_number' => $this->input->post('invoice_number'),
                'invoice_due_date' => date_to_mysql($this->input->post('invoice_due_date')),
                'package_id' => $this->input->post('package_id'),
                'boxpallets' => $this->input->post('boxpallets'),
                'dimensions' => $this->input->post('dimensions'),
                //'offer_url_key' => $this->input->post('offer_url_key'),
                'offer_status_id' => $this->input->post('offer_status_id'),
                'offer_password' => $this->input->post('offer_password'),
                'offer_discount_amount' => standardize_amount($offer_discount_amount),
                'offer_discount_percent' => standardize_amount($offer_discount_percent),
                'offer_terms' => $this->input->post('offer_terms'),
                'payment_method' => $this->input->post('payment_method'),
                'transport_tailgate' => $this->input->post('transport_tailgate'),
                'transport_without_tailgate' => $this->input->post('transport_without_tailgate'),
                'transport_tax_rate_id' => $this->input->post('transport_tax_rate_id'),
            );

            $status_id = $this->input->post('offer_status_id');
            if ($status_id == 2 || $status_id == 3) {
                $db_array["offer_transport_selected_text"] = "None";
                $db_array["offer_transport_selected"] = 0;
            }

            $this->mdl_offers->save($offer_id, $db_array);
            

            // Recalculate for discounts
            $this->load->model('offers/mdl_offer_amounts');
            $this->mdl_offer_amounts->calculate($offer_id);

            $error_send_email = false;
            if ($status_id == 2 && false)
                // Disabled. In old version - we sent the email with invoice when we change status to sent.
                // Now we sent the email when click on button "sent email"
            {
                $new_offer = $this->mdl_offers->get_by_id($offer_id);

                // Set the email body, use default email template if available
                $this->load->model('email_templates/mdl_email_templates');

                $email_template_id = get_setting('email_offer_template');
                if (!$email_template_id) {
                    log_message('error', 'No email template set in the system settings for offers!');
                    $error_send_email = true;
                }
                else {
                    $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();
                    if ($email_template->num_rows() == 0) {
                        log_message('error', 'No email template set in the system settings for offers!');
                        $error_send_email = true;
                    }
                }

                if ($error_send_email == false)
                {
                    $tpl = $email_template->row();

                    // Prepare the attachments
                    $this->load->model('upload/mdl_uploads');
                    $this->load->helper('mailer');

                    // Prepare the body
                    $body = $tpl->email_template_body;
                    if (strlen($body) != strlen(strip_tags($body))) {
                        $body = htmlspecialchars_decode($body);
                    } else {
                        $body = htmlspecialchars_decode(nl2br($body));
                    }

                    $from = !empty($tpl->email_template_from_email) ?
                        array($tpl->email_template_from_email, $tpl->email_template_from_name) :
                        array($invoice->user_email, "");

                    $subject = !empty($tpl->email_template_subject) ?
                        $tpl->email_template_subject :
                        trans('offer') . ' #' . $new_invoice->invoice_number;

                    $pdf_template = $tpl->email_template_pdf_template;
                    $to = $new_offer->client_email;
                    $cc = $tpl->email_template_cc;
                    $bcc = $tpl->email_template_bcc;

                    $email_invoice = email_offer($offer_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, null);

                    if ($email_invoice) {
                        log_message('info', 'Offerid ' . $offer_id . 'sent to client.');
                    }
                }
            }

            $response = array(
                'success' => 1,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        // Save all custom fields
        /*if ($this->input->post('custom')) {
            $db_array = array();

            $values = [];
            foreach ($this->input->post('custom') as $custom) {
                if (preg_match("/^(.*)\[\]$/i", $custom['name'], $matches)) {
                    $values[$matches[1]][] = $custom['value'];
                } else {
                    $values[$custom['name']] = $custom['value'];
                }
            }

            foreach ($values as $key => $value) {
                preg_match("/^custom\[(.*?)\](?:\[\]|)$/", $key, $matches);
                if ($matches) {
                    $db_array[$matches[1]] = $value;
                }
            }


            $this->load->model('custom_fields/mdl_offer_custom');
            $result = $this->mdl_offer_custom->save_custom($offer_id, $db_array);
            if ($result !== true) {
                $response = array(
                    'success' => 0,
                    'validation_errors' => $result
                );

                echo json_encode($response);
                exit;
            }
        }
        */

        echo json_encode($response);
    }

    public function save_offer_tax_rate()
    {
        $this->load->model('offers/mdl_offer_tax_rates');

        if ($this->mdl_offer_tax_rates->run_validation()) {
            $this->mdl_offer_tax_rates->save();

            $response = array(
                'success' => 1
            );
        } else {
            $response = array(
                'success' => 0,
                'validation_errors' => $this->mdl_offer_tax_rates->validation_errors
            );
        }

        echo json_encode($response);
    }

    public function create()
    {
        $this->load->model('offers/mdl_offers');

        if ($this->mdl_offers->run_validation()) {
            $offer_id = $this->mdl_offers->create();

            $response = array(
                'success' => 1,
                'offer_id' => $offer_id
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function create_recurring()
    {
        $this->load->model('offers/mdl_offers_recurring');

        if ($this->mdl_offers_recurring->run_validation()) {
            $this->mdl_offers_recurring->save();

            $response = array(
                'success' => 1,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function get_item()
    {
        $this->load->model('offers/mdl_offer_items');

        $item = $this->mdl_offer_items->get_by_id($this->input->post('item_id'));

        echo json_encode($item);
    }

    public function modal_create_offer()
    {
        $this->load->module('layout');
       // $this->load->model('offer_groups/mdl_offer_groups');
        //$this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('clients/mdl_clients');

        $data = array(
            //'offer_groups' => $this->mdl_offer_groups->get()->result(),
            //'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'client' => $this->mdl_clients->get_by_id($this->input->post('client_id')),
            'clients' => $this->mdl_clients->get_latest(),
        );

        $this->layout->load_view('offers/modal_create_offer', $data);
    }
//ok
    public function modal_change_client()
    {
        $this->load->module('layout');
        $this->load->model('clients/mdl_clients');

        $data = array(
            'client_id' => $this->input->post('client_id'),
            'offer_id' => $this->input->post('offer_id'),
            'clients' => $this->mdl_clients->get_latest(),
        );

        $this->layout->load_view('offers/modal_change_client', $data);
    }
//ok
    public function change_client()
    {
        $this->load->model('offers/mdl_offers');
        $this->load->model('clients/mdl_clients');

        // Get the client ID
        $client_id = $this->input->post('client_id');
        $client = $this->mdl_clients->where('ip_clients.client_id', $client_id)->get()->row();

        if (!empty($client)) {
            $offer_id = $this->input->post('offer_id');

            $db_array = array(
                'client_id' => $client_id,
            );
            $this->db->where('offer_id', $offer_id);
            $this->db->update('ip_offers', $db_array);

            $response = array(
                'success' => 1,
                'offer_id' => $offer_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function modal_copy_offer()
    {
        $this->load->module('layout');

        $this->load->model('offers/mdl_offers');
        $this->load->model('offer_groups/mdl_offer_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
            'offer_groups' => $this->mdl_offer_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'offer_id' => $this->input->post('offer_id'),
            'offer' => $this->mdl_offers->where('ip_offers.offer_id', $this->input->post('offer_id'))->get()->row(),
        );

        $this->layout->load_view('offers/modal_copy_offer', $data);
    }

    public function copy_offer()
    {
        $this->load->model('offers/mdl_offers');
        $this->load->model('offers/mdl_offer_items');
        $this->load->model('offers/mdl_offer_tax_rates');

        if ($this->mdl_offers->run_validation()) {
            $target_id = $this->mdl_offers->save();
            $source_id = $this->input->post('offer_id');

            $this->mdl_offers->copy_offer($source_id, $target_id);

            $response = array(
                'success' => 1,
                'offer_id' => $target_id
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function modal_create_credit()
    {
        $this->load->module('layout');

        $this->load->model('offers/mdl_offers');
        $this->load->model('offer_groups/mdl_offer_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
            'offer_groups' => $this->mdl_offer_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'offer_id' => $this->input->post('offer_id'),
            'offer' => $this->mdl_offers->where('ip_offers.offer_id', $this->input->post('offer_id'))->get()->row()
        );

        $this->layout->load_view('offers/modal_create_credit', $data);
    }

    public function create_credit()
    {
        $this->load->model('offers/mdl_offers');
        $this->load->model('offers/mdl_offer_items');
        $this->load->model('offers/mdl_offer_tax_rates');

        if ($this->mdl_offers->run_validation()) {
            $target_id = $this->mdl_offers->save();
            $source_id = $this->input->post('offer_id');

            $this->mdl_offers->copy_credit_offer($source_id, $target_id);

            // Set source offer to read-only
            if ($this->config->item('disable_read_only') == false) {
                $this->mdl_offers->where('offer_id', $source_id);
                $this->mdl_offers->update('ip_offers', array('is_read_only' => '1'));
            }

            // Set target offer to credit offer
            $this->mdl_offers->where('offer_id', $target_id);
            $this->mdl_offers->update('ip_offers', array('creditoffer_parent_id' => $source_id));

            $this->mdl_offers->where('offer_id', $target_id);
            $this->mdl_offers->update('ip_offer_amounts', array('offer_sign' => '-1'));

            $response = array(
                'success' => 1,
                'offer_id' => $target_id
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

}

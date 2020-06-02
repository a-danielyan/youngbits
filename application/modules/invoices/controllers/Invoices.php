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
 * Class Invoices
 */
class Invoices extends Custom_Controller
{
    /**
     * Invoices constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
        $this->load->model('mdl_invoices');
        $this->load->model('mdl_invoices_currency');
    }


    public function index()
    {

        // Display all invoices by default
        redirect('invoices/status/all');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'all', $page = 0)
    {

        $this->session->set_userdata('previous_url', current_url());

        // Determine which group of invoices to load
        switch ($status) {
            case 'draft':
                $this->mdl_invoices->is_draft();
                break;
            case 'sent':
                $this->mdl_invoices->is_sent();
                break;
            case 'viewed':
                $this->mdl_invoices->is_viewed();
                break;
            case 'paid':
                $this->mdl_invoices->is_paid();
                break;
            case 'overdue':
                $this->mdl_invoices->is_overdue();
                break;
            case 'credit_invoice':
                $this->mdl_invoices->is_credit();
                break;
        }

        $this->mdl_invoices->paginate(site_url('invoices/status/' . $status), $page);
        $invoices = $this->mdl_invoices->result();
        $sum = 0;
        $total_not_paid = 0;



        if ($status == 'all') {
            $all_invoices = $this->mdl_invoices->get()->result();
            $all_invoices_not_paid = $this->mdl_invoices->where('invoice_status_id !=',4)->get()->result();

            foreach($all_invoices as $invoice){
                $sum += $invoice->invoice_total;
            }

            foreach($all_invoices_not_paid as $invoice_not_paid){
                if($invoice_not_paid->invoice_status_id != 1){
                    $total_not_paid += $invoice_not_paid->invoice_total;
                }
            }
            
        }


        if ($status == 'draft') {
            $draft = $this->mdl_invoices->where('invoice_status_id',1)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }

        if ($status == 'sent') {
            $draft = $this->mdl_invoices->where('invoice_status_id',2)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }

        if ($status == 'viewed') {
            $draft = $this->mdl_invoices->where('invoice_status_id',3)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }
        if ($status == 'credit_invoice') {
            $credit_invoice = $this->mdl_invoices->where('invoice_status_id',5)->get()->result();
            foreach($credit_invoice as $invoice){
                $sum += $invoice->invoice_total;
            }
        }
        if ($status == 'paid') {
            $draft = $this->mdl_invoices->where('invoice_status_id',4)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }
        if ($status == 'overdue') {
            $overdue = $this->mdl_invoices->get()->result();
            foreach($overdue as $invoice){
                if($invoice->is_overdue == 1){
                    $sum += $invoice->invoice_total;
                }
            }

        }




        $this->layout->set(
            array(
                'invoices' => $invoices,
                'sum' => $sum,
                'total_not_paid' => $total_not_paid,
                'status' => $status,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_invoices'),
                'filter_method' => 'filter_invoices',
                'invoice_statuses' => $this->mdl_invoices->statuses()
            )
        );


        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS  || $this->session->userdata('user_type') == TYPE_ACCOUNTANT ){
            $this->layout->buffer('content', 'invoices/index');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }

    }

    public function archive()
    {
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
     * @param $invoice
     */
    public function download($invoice)
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $invoice . '"');
        readfile('./uploads/archive/' . $invoice);
    }

    /**
     * @param $invoice
     */
    public function total_price($page = 0)
    {
        $url = $this->input->post()['url'];
        if (strripos($url,'status/draft')) {
            $this->mdl_invoices->is_draft()->get()->result();
             $status = 'draft';
        }elseif (strripos($url,'status/sent')) {
            $this->mdl_invoices->is_sent();
             $status = 'sent';
        }elseif (strripos($url,'status/viewed')) {
            $this->mdl_invoices->is_viewed();
             $status = 'viewed';
        }elseif (strripos($url,'status/paid')) {
            $this->mdl_invoices->is_paid();
             $status = 'paid';
        }elseif (strripos($url,'status/overdue')) {
            $this->mdl_invoices->is_overdue();
             $status = 'overdue';
        }else{
            $status = 'all';
        }

        if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
            $this->mdl_invoices->TYPE_MANAGER_IS_GROUP($this->session->userdata('user_group_id'));
        }
        $this->mdl_invoices->paginate(site_url('invoices/status/' . $status), $page);
        $invoices = $this->mdl_invoices->get()->result();
        $sum = 0;



        if ($status == 'all') {
//            $all_invoices = $this->mdl_invoices->get()->result();
            $all_invoices = $this->mdl_invoices->where('invoice_status_id',4)->get()->result();
            foreach($all_invoices as $invoice){
                $sum += $invoice->invoice_total;
            }
        }
        if ($status == 'draft') {
            $draft = $this->mdl_invoices->where('invoice_status_id',1)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }

        if ($status == 'sent') {
            $draft = $this->mdl_invoices->where('invoice_status_id',2)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }

        if ($status == 'viewed') {
            $draft = $this->mdl_invoices->where('invoice_status_id',3)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }
        if ($status == 'paid') {
            $draft = $this->mdl_invoices->where('invoice_status_id',4)->get()->result();
            foreach($draft as $invoice){
                $sum += $invoice->invoice_total;
            }
        }


        if ($status == 'overdue') {

            $draft = $this->mdl_invoices->get()->result();
            foreach($draft as $invoice){
                if($invoice->is_overdue == 1){
                    $sum += $invoice->invoice_total;
                }
            }
        }
        echo $sum;
    }


    /**
     * @param $invoice_id
     */
    public function view($invoice_id)
    {

        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            redirect('invoices');
        }

        $this->load->model(
            array(
                'mdl_invoices_recurring',
                'mdl_items',
                'tax_rates/mdl_tax_rates',
                'payment_methods/mdl_payment_methods',
                'mdl_invoice_tax_rates',
                'custom_fields/mdl_custom_fields',
                'offers/mdl_offers',
                'companies/mdl_companies',
            )
        );

        $this->load->helper("custom_values");
        $this->load->helper("client");
        $this->load->helper('country');
        $this->load->model('units/mdl_units');
        $this->load->module('payments');

        $this->load->model('custom_values/mdl_custom_values');
        $this->load->model('custom_fields/mdl_invoice_custom');

        $this->db->reset_query();

        $fields = $this->mdl_invoice_custom->by_id($invoice_id)->get()->result();
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        if (!$invoice) {
            show_404();
        }

        $custom_fields = $this->mdl_custom_fields->by_table('ip_invoice_custom')->get()->result();
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
        }

        $offer = null;
        if ($invoice->parrent_offer_id != 0)
        {
            $offer = $this->mdl_offers->get_by_id($invoice->parrent_offer_id);
        }
        $referer_url = $_SERVER['HTTP_REFERER'];

        // Selecting Companies
        $companies = $this->mdl_companies->getCompanies();

        //Ger Currency
        $currency = $this->mdl_invoices_currency->getCurrency($invoice_id);
//        var_dump($currency);die;
        //mdl_invoices_recurring
        $invoices_recurring = $this->mdl_invoices_recurring->where('ip_invoices_recurring.invoice_id',$invoice_id)->get()->row();

        $this->layout->set(
            array(
                'invoices_recurring' => (!empty($invoices_recurring)) ?$invoices_recurring :'',
                'invoice' => $invoice,
                'items' => $this->mdl_items->where('invoice_id', $invoice_id)->get()->result(),
                'invoice_id' => $invoice_id,
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                'units' => $this->mdl_units->get()->result(),
                'payment_methods' => $this->mdl_payment_methods->get()->result(),
                'custom_fields' => $custom_fields,
                'custom_values' => $custom_values,
                'custom_js_vars' => array(
                    'currency_symbol' => get_setting('currency_symbol'),
                    'currency_symbol_placement' => get_setting('currency_symbol_placement'),
                    'decimal_point' => get_setting('decimal_point')
                ),
                'invoice_statuses' => $this->mdl_invoices->statuses(),
                'offer' => $offer,
                'referer_url' => $referer_url,
                'companies' => $companies,
                'currency' => $currency,
            )
        );


        if ($invoice->sumex_id != null) {
            $this->layout->buffer(
                array(
                    array('modal_delete_invoice', 'invoices/modal_delete_invoice'),
                    array('modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'),
                    array('modal_add_payment', 'payments/modal_add_payment'),
                    array('content', 'invoices/view_sumex')
                )
            );
        } else {
            $this->layout->buffer(
                array(
                    array('modal_delete_invoice', 'invoices/modal_delete_invoice'),
                    array('modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'),
                    array('modal_add_payment', 'payments/modal_add_payment'),
                    array('content', 'invoices/view')
                )
            );
        }

        $this->layout->render();
    }

    /**
     * @param $invoice_id
     */
    public function delete($invoice_id)
    {
        // Get the status of the invoice
        /*if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
            $this->mdl_invoices->TYPE_MANAGER_IS_GROUP($this->session->userdata('user_group_id'));
        }*/
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);
        $invoice_status = $invoice->invoice_status_id;

        if ($invoice_status == 1 || $this->config->item('enable_invoice_deletion') === true) {
            // Delete the invoice
            $this->mdl_invoices->delete($invoice_id);
        } else {
            // Add alert that invoices can't be deleted
            $this->session->set_flashdata('alert_error', trans('invoice_deletion_forbidden'));
        }

        // Redirect to invoice index
        redirect('invoices/index');
    }

    /**
     * @param $invoice_id
     * @param $item_id
     */
    public function delete_item($invoice_id, $item_id)
    {
        // Delete invoice item
        $this->load->model('mdl_items');
        $item = $this->mdl_items->delete($item_id);


        // Redirect to invoice view
        redirect('invoices/view/' . $invoice_id);
    }

    /**
     * @param $invoice_id
     * @param bool $stream
     * @param null $invoice_template
     */
    public function generate_pdf($invoice_id, $stream = true, $invoice_template = null)
    {
        $this->load->helper('pdf');

        if (get_setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->mark_sent($invoice_id);
        }

        generate_invoice_pdf($invoice_id, $stream, $invoice_template, null);
    }
    public function generate_slip_pdf($invoice_id, $stream = true, $invoice_template = 'packing-slip')
    {
        $this->load->helper('pdf');

        if (get_setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->mark_sent($invoice_id);
        }

        generate_invoice_pdf($invoice_id, $stream, $invoice_template, null);
    }

    public function generate_multi_pdf($invoice_ids, $stream = true, $invoice_template = null)
    {
        $invoice_ids = explode('_', $invoice_ids);
        $this->load->helper('pdf');

        if (get_setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->mark_sent($invoice_ids);
        }



        generate_multi_invoice_pdf($invoice_ids, $stream, $invoice_template, null);
    }




    /**
     * @param $invoice_id
     */
    public function generate_zugferd_xml($invoice_id)
    {
        $this->load->model('invoices/mdl_items');
        $this->load->library('ZugferdXml', array(
            'invoice' => $this->mdl_invoices->get_by_id($invoice_id),
            'items' => $this->mdl_items->where('invoice_id', $invoice_id)->get()->result()
        ));

        $this->output->set_content_type('text/xml');
        $this->output->set_output($this->zugferdxml->xml());
    }

    public function generate_sumex_pdf($invoice_id)
    {
        $this->load->helper('pdf');

        generate_invoice_sumex($invoice_id);
    }

    public function generate_sumex_copy($invoice_id)
    {


        $this->load->model('invoices/mdl_items');
        $this->load->library('Sumex', array(
            'invoice' => $this->mdl_invoices->get_by_id($invoice_id),
            'items' => $this->mdl_items->where('invoice_id', $invoice_id)->get()->result(),
            'options' => array(
                'copy' => "1",
                'storno' => "0"
            )
        ));

        $this->output->set_content_type('application/pdf');
        $this->output->set_output($this->sumex->pdf());
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

    public function recalculate_all_invoices()
    {
        $this->db->select('invoice_id');
        $invoice_ids = $this->db->get('ip_invoices')->result();

        $this->load->model('mdl_invoice_amounts');

        foreach ($invoice_ids as $invoice_id) {
            $this->mdl_invoice_amounts->calculate($invoice_id->invoice_id);
        }
    }













    public function quarter_attachment_deleted(){
        if (!empty($this->input->post('quarter_id'))){
            $this->load->model('mdl_quarter');
            $this->mdl_quarter->delete($this->input->post('quarter_id'));
        }

    }


    public function quarter_attachment($id = null){
        $this->load->model('mdl_quarter');
            $files = [];
            if (!empty($_FILES['quarter_file']["size"][0])){
                $count = count($_FILES['quarter_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['quarter_file'.$i] = [
                        'name'=>$_FILES['quarter_file']['name'][$i],
                        'type'=>$_FILES['quarter_file']['type'][$i],
                        'tmp_name'=>$_FILES['quarter_file']['tmp_name'][$i],
                        'error'=>$_FILES['quarter_file']['error'][$i],
                        'size'=>$_FILES['quarter_file']['size'][$i]
                    ];
                }
                unset($_FILES['quarter_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/quarter/',
                        'allowed_types' => 'pdf|jpg|jpeg|png|xml|xlsx|csv',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);
                    $this->upload->do_upload($key);
                    $upload_data = $this->upload->data();
                    $files_new=  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['quarter_files'])){

                foreach ($_POST['quarter_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $_POST['quarter_attachment'] =$files[0];
                $data_quarter = [
                    'quarter_attachment'=>$_POST['quarter_attachment'],
                    'quarter_year'=>$this->input->post('quarter_year'),
                    'quarter_quarterly'=>$this->input->post('quarter_month')
                ];
                $result  = $this->mdl_quarter->save($id,$data_quarter);
            }







       if($result){
           redirect($_SERVER['HTTP_REFERER']);
       }
    }














    // TASK 37
     public function quarter($quarter){

        $title_quarter = str_replace('_',' ',$quarter);
        $quarters = [
            '1st' => [1,2,3],
            '2nd' => [4,5,6],
            '3th' => [7,8,9],
            '4th' => [10,11,12],
        ];

         $file_types = ['xml','xlsx','csv'];



         $quarter =explode( '_', $quarter);
         $this->load->model('mdl_invoices');
         $this->load->model('mdl_quarter');
         $this->load->model('mdl_invoice_amounts');
         $this->load->model('expenses/mdl_expenses');
         $this->load->model('appointments/mdl_appointments');

         $quarter_files = $this->mdl_quarter->where('quarter_year',$quarter[2])->where('quarter_quarterly',$quarter[0])->get()->result();

         $invoice_quarter = $this->mdl_invoices->where('year(invoice_date_created)',$quarter[2])->where_in('month(invoice_date_created)',$quarters[$quarter[0]])->get()->result();
         $invoices_quarter_amount           = $this->mdl_invoices->calculate_quarter_amount($invoice_quarter,'invoice_total');

         $appointments_quarter = $this->mdl_appointments->where('year(appointment_date)',$quarter[2])->where_in('month(appointment_date)',$quarters[$quarter[0]])->get()->result();

         $expenses_dollar_quarter = $this->mdl_expenses->where('year(ip_expenses.expenses_date)',$quarter[2])->where('expenses_currency','dollar')->where_in('month(ip_expenses.expenses_date)',$quarters[$quarter[0]])->get()->result();
         $dollar_expenses_quarter_amount    =  $this->mdl_invoices->calculate_quarter_amount($expenses_dollar_quarter,'expenses_amount');

         $expenses_euro_quarter = $this->mdl_expenses->where('year(ip_expenses.expenses_date)',$quarter[2])->where('expenses_currency','euro')->where_in('month(ip_expenses.expenses_date)',$quarters[$quarter[0]])->get()->result();
         $euro_expenses_quarter_amount      =  $this->mdl_invoices->calculate_quarter_amount($expenses_euro_quarter,'expenses_amount_euro');

         $this->layout->set(
             array(
                 'title_quarter' => $title_quarter,
                 'year' => $quarter[2],
                 'month' =>$quarter[0],
                 'quarter_files' =>$quarter_files,
                 'invoices' => $invoice_quarter,
                 'appointments_quarter' => $appointments_quarter,
                 'expenses_dollar' => $expenses_dollar_quarter,
                 'expenses_euro' => $expenses_euro_quarter,
                 'invoices_quarter_amount' => $invoices_quarter_amount,
                 'euro_expenses_quarter_amount' => $euro_expenses_quarter_amount,
                 'dollar_expenses_quarter_amount' => $dollar_expenses_quarter_amount,
                 'file_types' => $file_types,

             )
         );
         $this->layout->buffer('content', 'invoices/quarter_view');
         $this->layout->render();

     }

     public function reports($status = 'invoices', $page = 0)
    {
        $this->load->model('mdl_invoices');
        $this->load->model('mdl_invoice_amounts');
        $this->load->model('expenses/mdl_expenses');

        $categories_compbyning_by_year = [];


        $years = $this->mdl_invoices->get_years('desc');
        $years_expenses = $this->mdl_expenses->get_years('desc');
        $invoices_compbyning_by_year         = $this->mdl_invoices->compbyning_by_year($years, '', '');
        if ($status == "euro_expenses"){
            $euro_expenses_compbyning_by_year    = $this->mdl_invoices->compbyning_by_year($years_expenses, 'mdl_expenses', 'euro');
        }else{
            $dollar_expenses_compbyning_by_year  = $this->mdl_invoices->compbyning_by_year($years_expenses, 'mdl_expenses', 'dollar');
        }



        $current_model = 'mdl_invoices';
        // Determine which group of quotes to load
        if ($status == 'invoices') {
            $categories_compbyning_by_year['Invoices'] = $invoices_compbyning_by_year;
            $length = count($invoices_compbyning_by_year);

        } elseif ($status == 'euro_expenses') {
            $current_model = 'mdl_expenses';
            $categories_compbyning_by_year['Euro  Expenses'] = $euro_expenses_compbyning_by_year;

            $length = count($euro_expenses_compbyning_by_year);

        }elseif ($status == 'dollar_expenses') {
            $current_model = 'mdl_expenses';
            $categories_compbyning_by_year['Dollar Expenses'] = $dollar_expenses_compbyning_by_year;
            $length = count($dollar_expenses_compbyning_by_year);

        } else {
            $categories_compbyning_by_year['Invoices'] = $invoices_compbyning_by_year;
            $categories_compbyning_by_year['Euro  Expenses'] = $euro_expenses_compbyning_by_year;
            $categories_compbyning_by_year['Dollar Expenses'] = $dollar_expenses_compbyning_by_year;
            $length = count($invoices_compbyning_by_year) + count($euro_expenses_compbyning_by_year) + count($dollar_expenses_compbyning_by_year);
        }

        $this->mdl_invoices->paginate(site_url('invoices/reports/' . $status), $page);


        $this->layout->set(
            array(
                'financial_reports' => $categories_compbyning_by_year,
                'years' => $years,
                'status' => $status,
                'length' => $length,
                'start' => 1,
                'current_model' => $current_model,
                // 'config' => $config,
                // 'links' =>  $this->pagination->create_links(),
            )
        );


        $this->layout->buffer('content', 'invoices/reports');
        $this->layout->render();

    }

}


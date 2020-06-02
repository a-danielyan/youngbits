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
 * Class Dashboard
 */
class Dashboard extends NormalUser_Controller
{
    public function index()
    {
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->load->model('leads/mdl_leads');
        $this->load->model('quotes/mdl_quote_amounts');
        $this->load->model('invoices/mdl_invoices');
        //$this->load->model('invoices/mdl_item_amounts');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('projects/mdl_projects');
        $this->load->model('targets/mdl_targets');
        $this->load->model('products/mdl_products');
        $this->load->model('inventory/mdl_inventory');
        $this->load->model('todo_tickets/mdl_todo_tickets');
        $this->load->model('legal_issues/mdl_legal_issues');
        $this->load->model('subscriptions/mdl_subscriptions');
        $this->load->model('recurring_income/mdl_recurring_income');
        $this->load->model('invoices/mdl_invoices_recurring');
        $this->load->model('appointments/mdl_appointments');
        $this->load->model('login_quotes/mdl_login_quotes');
        $this->load->model('clients/mdl_clients');
        $this->load->model('company_savings/mdl_company_savings');
        $this->load->model('upfront_payments/mdl_upfront_payments');
        $this->load->model('users/mdl_users');
        $this->load->model('distributors/mdl_distributors');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->helper('allowance');

        $quote_overview_period = get_setting('quote_overview_period');
        $invoice_overview_period = get_setting('invoice_overview_period');

        $projects_groups =  $this->mdl_projects
            ->join('ip_projects_groups','ip_projects.project_id = ip_projects_groups.project_id','left');


        if ($this->session->userdata('user_type') == TYPE_ADMIN) {
            $projects_filtered =$this->mdl_projects->get_latest()->get()->result();
        }else {
            $projects_filtered = $projects_groups->where('group_id',$this->session->userdata('user_group_id'))->get()->result();
        }

        if (count($projects_filtered) > 10) {
            $projects_filtered = array_slice($projects_filtered, 0, 10);
        }





        else if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
            $this->load->model('projects/mdl_projects');
            $projects3 = $this->mdl_projects->get()->result();
            $projects_filterd_ids3 = array();
            $projects_groups3 = $this->mdl_projects->read_groups_for_project();
            foreach ($projects3 as $project3)
            {
                $projectgroup3 = array('project_id' => $project3->project_id, 'group_id' => $this->session->userdata('user_group_id'));

                $key = array_search($projectgroup3, $projects_groups3);
                if ($key !== false) {
                    array_push($projects_filterd_ids3, $project3->project_id);
                }
            }
            if (count($projects_filterd_ids3) == 0)
            {
                array_push($projects_filterd_ids3, -1);
            }

        }


        $new_tickets = array();
        $tickets = $this->mdl_todo_tickets->get_latest()->get()->result();
        foreach ($tickets as $ticket)
        {
            if (!$ticket) {
                continue;
            }

            if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
                $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') &&
                $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
            {
                continue;
            }
            if ($ticket->todo_ticket_created_user_id != $this->session->userdata('user_id') &&
                $ticket->todo_ticket_assigned_user_id != $this->session->userdata('user_id') &&
                !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
            {
                continue;
            }
            array_push($new_tickets, $ticket);
        }

        if (count($new_tickets) > 10) {
            $new_tickets = array_slice($new_tickets, 0, 10);
        }
        $subscription_amount_month = $this->mdl_subscriptions->get()->result();

        $draft_amount = $this->mdl_invoices->where( 'invoice_status_id',1)->get()->result();





        $invoice_amount_draft_year = $this->mdl_invoices->where( 'YEAR(invoice_date_created)=',date('Y'))->where( 'invoice_status_id',1)->get()->result();
        $invoice_amount_last_year  = $this->mdl_invoices->where( 'YEAR(invoice_date_created)=',date('Y'))->get()->result();
        $invoice_amount_paid_year  = $this->mdl_invoices->where( 'YEAR(invoice_date_created)=',date('Y'))->get()->result();



        $paid_quarter=0;
        $paid_4quarter  = [
            '1st' => 0,
            '2nd' => 0,
            '3nd' => 0,
            '4th' => 0,
        ];
        foreach ($invoice_amount_paid_year as $invoice_amount){
            $m=(int)date('m',strtotime($invoice_amount->invoice_date_created));

            if($m >=1 && $m<=3){
                $paid_4quarter['1st'] += $invoice_amount->invoice_total;
            }
            elseif($m >=4 && $m<=6){
                $paid_4quarter['2nd'] += $invoice_amount->invoice_total;
            }
            elseif($m >=7 && $m<=9){
                $paid_4quarter['3nd'] += $invoice_amount->invoice_total;
            }
            elseif($m >=10 && $m<=12){
                $paid_4quarter['4th'] += $invoice_amount->invoice_total;
            }
        }

        $invoice_overdues = $this->mdl_invoices->is_overdue()->get()->result();
        $recurring_invoices_year = $this->mdl_invoices_recurring->get()->result();
        $upfront_payments = $this->mdl_upfront_payments->get()->result();
        $recurring_income_amount_year  = $this->mdl_recurring_income->get()->result();
        $leads_count_year  = $this->mdl_leads->where( 'YEAR(lead_date_created)=',date('Y'))->get()->result();
        $targets_count_month = $this->mdl_targets->where( 'YEAR(target_date_created)=',date('Y'))->get()->result();
        $target_count=0;

        foreach ($targets_count_month as $target){
            $target_m=(int)date('m',strtotime($target->target_date_created));

            if(date('m') >= 1 && date('m') <= 3){
                if($target_m >=10 && $target_m<=12){
                    $target_count++;
                }
            }

            if(date('m') >= 4 && date('m') <= 6){
                if($target_m >=10 && $target_m<=12){
                    $target_count++;
                }
            }

            if(date('m') >= 7 && date('m') <= 9){
                if($target_m >=10 && $target_m<=12){
                    $target_count++;
                }
            }

            if(date('m') >= 10 && date('m') <= 12){
                if($target_m >=10 && $target_m<=12){
                    $target_count++;
                }
            }
        }

        $x = $this->mdl_login_quotes->get()->result();
        $i=rand(0,count($x)-1);
        if(!empty($x)){
            $login_quote = $x[$i];
        }else{
            $login_quote='';
        }



        $invoice_amount_paid_year  = $this->mdl_invoices->where( 'YEAR(invoice_date_created)=',date('Y')-1)->get()->result();

        $invoice_amount_revenue_year = $this->sum_prices($invoice_amount_paid_year,'invoice_total');

        foreach ($invoice_amount_last_year as $key => $invoice_amount) {
            if( $invoice_amount->invoice_status_id == 1){
                unset($invoice_amount_last_year[$key]);
            }
        }


        $invoice_amount_last_year = $this->sum_prices($invoice_amount_last_year,'invoice_total');

        if(empty($invoice_amount_revenue_year)){
            $invoice_amount_revenue_year = 1;
        }

        if(empty($invoice_amount_last_year)){
            $invoice_amount_last_year = 0;
        }
        $revenue_results = $invoice_amount_last_year / $invoice_amount_revenue_year * 100;

        $invoice_amount_overdue_year =$this->sum_prices($invoice_overdues,'invoice_total');
        $upfront_payments_amount_overdue_year =$this->sum_prices($upfront_payments,'upfront_payments_amount');


        $invoice_amount_draft_year =$this->sum_prices($invoice_amount_draft_year,'invoice_total');
        $percentage_overdue =  (!empty($invoice_amount_overdue_year) && !empty($invoice_amount_last_year))?  $invoice_amount_overdue_year / $invoice_amount_last_year * 100 : 0;


        $clients_count_year = count($this->mdl_clients->get()->result());
        $leads_count_year = count($leads_count_year);
        if(empty($leads_count_year)){
            $leads_count_year =1;
        }
        $count_leads_clients = $leads_count_year + $clients_count_year;
        $sales_pipeline_results= $leads_count_year / $count_leads_clients * 100;

//$recurring_invoices_total = sprintf('%0.2f',$this->sum_prices($recurring_invoices_year,'invoice_total') / 3);
        $recurring_invoices_total = sprintf('%0.2f',$this->recurring_total_price_quarter($recurring_invoices_year) / 3);
        $other_recurring_invoices_total = $this->sum_prices($recurring_income_amount_year, 'recurring_income_amount');
        $subscriptions_amount_month = $this->sum_prices($subscription_amount_month,'subscriptions_amount');
        $result_monthly =($recurring_invoices_total + $other_recurring_invoices_total) - $subscriptions_amount_month;

        $total_users = $this->db->count_all('ip_users');


        $company_saving =  $this->mdl_company_savings->limit(1)->get()->row();

        $company_saving_total =0;
        if (!empty($company_saving->company_saving_text)){
            $company_saving_total = $company_saving->company_saving_text;
        }
        if (empty($subscriptions_amount_month)){
            $subscriptions_amount_month =1;
        }
        $runway = ( $invoice_amount_overdue_year + $company_saving_total) + ($recurring_invoices_total + $other_recurring_invoices_total);



        $suppliers=$this->mdl_suppliers->get()->result();
        $distributors=$this->mdl_distributors->get()->result();

        $appointments=$this->mdl_appointments->limit(10)->get()->result();

        $this->layout->set(
            array(
                'legal_issues_total_amount' =>  sprintf('%0.2f', $this->sum_prices($this->mdl_legal_issues->get()->result(),'legal_issues_amount')),
                'suppliers_count' =>  count($suppliers),
                'distributors_count' =>  count($distributors),
                'invoice_amount_last_year' =>  $invoice_amount_last_year,
                'total_expenses' =>  $this->total_price_expenses(),
                'total_kilometers' =>  $this->total_kilometers(),
                'upfront_payments_amount_overdue_year' =>  sprintf('%0.2f', $upfront_payments_amount_overdue_year),
                'invoice_amount_revenue_year' =>  $invoice_amount_revenue_year,
                'invoice_amount_draft_year' =>  $invoice_amount_draft_year,
                'invoice_paid_quarter' => $paid_quarter,
                'revenue_results' => sprintf('%0.2f', $revenue_results),
                'percentage_overdue' => sprintf('%0.2f', $percentage_overdue),
                'sales_pipeline_results' => sprintf('%0.2f', $sales_pipeline_results),
                'invoice_amount_overdue' => sprintf('%0.2f', $invoice_amount_overdue_year),
                'recurring_invoices_quarter' => $recurring_invoices_total,
//                'other_recurring_income_total_quarter' =>   $this->total_price_quarter($recurring_income_amount_year),
                'other_recurring_income_total_quarter' =>   $other_recurring_invoices_total,
                'leads_count_year' =>  $leads_count_year,
                'appointments_count_year' =>  count($this->mdl_appointments->get()->result()),
                'clients_count_year' => $clients_count_year,
                'subscription_amount_month' =>  $this->sum_prices($subscription_amount_month,'subscriptions_amount'),
                'products_count' =>  count($this->mdl_products->get()->result()),
                'inventory_total_amount' =>  sprintf('%0.2f',$this->sum_prices($this->mdl_inventory->get()->result(), 'inventory_regular_price')),
                'inventory_total_sale_price' =>  sprintf('%0.2f',$this->sum_prices($this->mdl_inventory->get()->result(), 'inventory_sale_price')),
                'inventory_total_sold' =>  sprintf('%0.2f',$this->sum_prices($this->mdl_inventory->where('inventory_sold','yes')->get()->result(), 'inventory_regular_price')),
                'count_inventory' =>  count($this->mdl_inventory->get()->result()),
                'company_saving' => $company_saving,
                'result_monthly' => $result_monthly,

                'inventory_count' =>  count($this->mdl_inventory->get()->result()),
                'draft_total' =>  $this->sum_prices($draft_amount,'invoice_total'),

                'paid_4quarter' => $paid_4quarter ,
                'login_quote' => $login_quote ,
                'total_users' => $total_users  ,


                'invoice_status_totals' => $this->total_price($this->mdl_invoice_amounts->get_status_totals($invoice_overview_period)),
                'quote_status_totals' => $this->mdl_quote_amounts->get_status_totals($quote_overview_period),
                // 'quote_status_totals' => $this->mdl_quote_amounts->get_status_totals_all(),
                'invoice_status_period' => str_replace('-', '_', $invoice_overview_period),
                'quote_status_period' => str_replace('-', '_', $quote_overview_period),
                'invoices' => $this->mdl_invoices->limit(10)->get()->result(),
                'quotes' => $this->mdl_quotes->limit(10)->get()->result(),
                'invoice_statuses' => $this->mdl_invoices->statuses(),
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'overdue_invoices' => $this->mdl_invoices->is_overdue()->get()->result(),
                'projects' => $projects_filtered,
                'tickets' => $new_tickets,
                'appointments' => $appointments,
                'appointment_statuses' =>  $this->mdl_appointments->statuses(),

                'ticket_statuses' => $this->mdl_todo_tickets->statuses(),
                'runway' =>sprintf('%0.2f',$runway / $subscriptions_amount_month),
            )
        );

        $this->layout->buffer('content', 'dashboard/index');
        $this->layout->render();
    }

    public function total_price_expenses($sum  = []){

        $this->load->model('expenses/mdl_expenses');
        $expenses = $this->mdl_expenses->get()->result();

        $sum['dollar'] = 0;
        $sum['euro'] = 0;
        foreach ($expenses as $s){
            if($s->expenses_currency == 'euro'){
                $sum['euro']+= $s->expenses_amount_euro;
            }else{
                $sum['dollar']+= $s->expenses_amount;
            }
        }

        return $sum;
    }

    public function total_price_quarter($arr,$recurring_income = 0){
        foreach ($arr as $key => $recurring){
            $m=(int)date('m',strtotime($recurring->recurring_income_date));

            if(date('m') >= 1 && date('m') <= 3){
                if($m >=1 && $m<=3){
                    $recurring_income+=$recurring->recurring_income_amount;
                }
            }
            if(date('m') >= 4 && date('m') <= 6){
                if($m >=4 && $m<=6){
                    $recurring_income+=$recurring->recurring_income_amount;
                }
            }
            if(date('m') >= 7 && date('m') <= 9){
                if($m >=7 && $m<=9){
                    $recurring_income+=$recurring->recurring_income_amount;
                }
            }

            if(date('m') >= 10 && date('m') <= 12){
                if($m >=10 && $m<=12){
                    $recurring_income+=$recurring->recurring_income_amount;
                }
            }
        }
        return $recurring_income;


    }

    public function recurring_total_price_quarter($arr,$recurring_income = 0){
        foreach ($arr as $key => $recurring){
            $m=(int)date('m',strtotime($recurring->recur_next_date));

            if(date('m') >= 1 && date('m') <= 3){

                if($m >=4 && $m<=6){
                    $recurring_income+=$recurring->invoice_total;
                }
            }
            if(date('m') >= 4 && date('m') <= 6){
                if($m >=7 && $m<=9){
                    $recurring_income+=$recurring->invoice_total;
                }
            }
            if(date('m') >= 7 && date('m') <= 9){
                if($m >=10 && $m<=12){
                    $recurring_income+=$recurring->invoice_total;
                }
            }

            if(date('m') >= 10 && date('m') <= 12){
                if($m >=1 && $m<=3){
                    $recurring_income+=$recurring->invoice_total;
                }
            }
        }
        return $recurring_income;


    }

    public function total_kilometers($total_kl =  0)
    {
        $this->load->model('appointments/mdl_appointments');
        $appointments = $this->mdl_appointments->get()->result();
        foreach ($appointments as $appointment){
            $total_kl += $appointment->appointment_kilometers;
        }


        if(!empty($_POST['status'])){
            echo $total_kl;
        }
        return  $total_kl;

    }

    public function total_price($arr, $sum= 0){

        foreach ($arr as $key => $s){
            $status=$s['class'];

            if ($status == 'draft') {
                $draft = $this->mdl_invoices->where('invoice_status_id',1)->where( 'YEAR(invoice_date_created)=',date('Y'))->where( 'MONTH(invoice_date_created)=',date('m'))->get()->result();
                foreach($draft as $invoice){
                    $sum+= $invoice->invoice_total;
                }
                $arr[$key]['sum_total'] = $sum;
                $sum=0;
            }

            if ($status == 'sent') {
                $draft = $this->mdl_invoices->where('invoice_status_id',2)->where( 'YEAR(invoice_date_created)=',date('Y'))->where( 'MONTH(invoice_date_created)=',date('m'))->get()->result();
                foreach($draft as $invoice){
                    $sum+= $invoice->invoice_total;
                }
                $arr[$key]['sum_total']=$sum;
                $sum=0;
            }
            if ($status == 'viewed') {
                $draft = $this->mdl_invoices->where('invoice_status_id',3)->where( 'YEAR(invoice_date_created)=',date('Y'))->where( 'MONTH(invoice_date_created)=',date('m'))->get()->result();
                foreach($draft as $invoice){
                    $sum += $invoice->invoice_total;
                }
                $arr[$key]['sum_total'] = $sum;
                $sum=0;
            }
            if ($status == 'paid') {
                $draft = $this->mdl_invoices->where('invoice_status_id',4)->where( 'YEAR(invoice_date_created)=',date('Y'))->where( 'MONTH(invoice_date_created)=',date('m'))->get()->result();
                foreach($draft as $invoice){
                    $sum += $invoice->invoice_total;
                }
                $arr[$key]['sum_total'] = $sum;
                $sum=0;
            }
        }


        return $arr;

    }

    public function sum_prices($array,$key){
        $final_price = 0;

        foreach ($array as $sum){
            $final_price+=$sum->$key;
        }

        return $final_price;
    }


    public function total_overdue($array,$key){
        $final_price = 0;

        foreach ($array as $sum){
            if($sum->invoice_date_due >= date('Y-m-d')){
                $final_price+=$sum->$key;
            }
        }

        return $final_price;
    }



}

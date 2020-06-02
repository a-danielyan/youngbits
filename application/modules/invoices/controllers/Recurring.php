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
 * Class Recurring
 */
class Recurring extends Custom_Controller
{
    /**
     * Invoices constructor.
     */
    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
        $this->load->model('mdl_invoices_recurring');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {



      /*  if ($this->session->userdata('user_type') == TYPE_MANAGERS) {
            $this->mdl_invoices_recurring->TYPE_MANAGER_IS_GROUP($this->session->userdata('user_group_id'));
        }*/

        $this->mdl_invoices_recurring

                ->paginate(site_url('invoices/recurring'), $page);
        $recurring_invoices = $this->mdl_invoices_recurring->result();

        $invoices_recurring = $this->mdl_invoices_recurring
           ->get()->result();



        $this->layout->set( 'sum',$this->sum($invoices_recurring));
        $this->layout->set( 'sum_quarter',$this->total_price_quarter($invoices_recurring));
        $this->layout->set( 'sum_month',$this->total_price_quarter($invoices_recurring)/3);
        $this->layout->set('recur_frequencies', $this->mdl_invoices_recurring->recur_frequencies);
        $this->layout->set('recurring_invoices', $recurring_invoices);

        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT || $this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS){
            $this->layout->buffer('content', 'invoices/index_recurring');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }

    }

    public function sum_month($invoices_recurring,$sum = 0){



        foreach ($invoices_recurring as $i){
            $m=(int)date('m',strtotime($i->recur_start_date));
            if(date('m') == $m){
                $sum+= $i->invoice_total;
            }

        }
        return $sum;
    }
    public function sum($invoices_recurring,$sum = 0){
        foreach ($invoices_recurring as $i){
            $sum+= $i->invoice_total;
        }
        return $sum;
    }

    public function total_price_quarter($arr,$recurring_income = 0){
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

    public function total_price($sum = 0){

        $invoices_recurring = $this->mdl_invoices_recurring->join('ip_invoice_amounts', 'ip_invoices_recurring.invoice_id = ip_invoice_amounts.invoice_id')
            ->select('ip_invoice_amounts.*')->get()->result();
        foreach ($invoices_recurring as $i){
            $sum+= $i->invoice_total;
        }
        echo $sum;
    }
    /**
     * @param $invoice_recurring_id
     */
    public function stop($invoice_recurring_id)
    {
        $this->mdl_invoices_recurring->stop($invoice_recurring_id);
        redirect('invoices/recurring/index');
    }

    /**
     * @param $invoice_recurring_id
     */
    public function delete($invoice_recurring_id)
    {
        $this->mdl_invoices_recurring->delete($invoice_recurring_id);
        redirect('invoices/recurring/index');
    }

}

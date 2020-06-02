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
 * Class subscriptions
 */
class Subscriptions extends Admin_Controller
{
    /**
     * subscriptions constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_subscriptions');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_subscriptions->paginate(site_url('subscriptions/index'), $page);


        $this->layout->set('recur_frequencies', $this->mdl_subscriptions->recur_frequencies);
        $this->layout->set(
            array(
                'records' => $this->mdl_subscriptions->result(),
                'filter_display' => false,
                'sum' =>$this->sum(),
                'filter_placeholder' => trans('filter_subscriptions'),
                'filter_method' => 'filter_subscriptions'
            )
        );

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_ACCOUNTANT || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){
            $this->layout->buffer('content', 'subscriptions/index');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }

    }

    /**
     * @param null $id
     */

    public function sum($sum = 0){

        $subscriptions = $this->mdl_subscriptions->get()->result();
        foreach ($subscriptions as $i){
            $sum+= $i->subscriptions_amount;
        }
        return $sum;
    }

    public function total_price($sum = 0){

        $subscriptions = $this->mdl_subscriptions->get()->result();
        foreach ($subscriptions as $i){
            $sum+= $i->subscriptions_amount;
        }
        echo $sum;
    }
    public function form($id = null)
    {

        $success = [TYPE_ACCOUNTANT,TYPE_EMPLOYEES,TYPE_FREELANCERS];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('subscriptions');
        }




        if ($this->mdl_subscriptions->run_validation()) {

            // Check for invoice logo upload
            if ($_FILES['subscriptions_file']['name']) {

                $new_name = time().$_FILES["subscriptions_file"]['name'];
                $upload_config = array(
                    'upload_path' => './uploads/subscriptions/',
                    'allowed_types' => 'pdf|jpg|jpeg|png',
                    'file_name' => $new_name
                );
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('subscriptions_file')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('tasks');
                }

                $upload_data = $this->upload->data();

                $_POST['subscriptions_document_link'] = base_url() . "uploads/subscriptions/" . $upload_data['file_name'];
            }


            $id = $this->mdl_subscriptions->save($id);

            redirect('subscriptions');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_subscriptions->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }


        $this->load->model('payment_methods/mdl_payment_methods');

        $amounts = array();

        $this->layout->set('recur_frequencies', $this->mdl_subscriptions->recur_frequencies);
        $this->layout->set(
            array(
                'subscriptions_id' => $id,
            )
        );

        $this->layout->buffer('content', 'subscriptions/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_subscriptions->delete($id);
        redirect('subscriptions');
    }

}

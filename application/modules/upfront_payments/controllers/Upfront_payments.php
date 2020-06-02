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
 * Class Upfront Payments
 */
class Upfront_payments extends Admin_Controller
{
    /**
     * expenses constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_upfront_payments');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $success = [TYPE_ACCOUNTANT];
        // if(in_array($this->session->userdata('user_type'),$success)){
        //     redirect('dashboard');
        // }
        $this->mdl_upfront_payments->paginate(site_url('upfront_payments/index'), $page);
        $upfront_payments = $this->mdl_upfront_payments->result();
        foreach ($upfront_payments as $upfront_payment){
            $upfront_payment->upfront_payments_document_link = unserialize($upfront_payment->upfront_payments_document_link);
        }




        $this->layout->set(
            array(
                'records' => $upfront_payments,
                'filter_display' => false,
                'sum' => $this->sum(),
            )
        );

            $this->layout->buffer('content', 'upfront_payments/index');
            $this->layout->render();

    }

    /**
     * @param null $id
     */


    public function sum($sum = 0){

        $upfront_payments = $this->mdl_upfront_payments->get()->result();

        foreach ($upfront_payments as $s){
            $sum+= $s->upfront_payments_amount;
        }
        return $sum;
    }

    public function total_price($sum  = 0){
        $upfront_payments = $this->mdl_upfront_payments->get()->result();

        foreach ($upfront_payments as $s){
            $sum+= $s->upfront_payments_amount;
        }
        echo $sum;
    }




    public function form($id = null)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }


        if ($this->input->post('btn_cancel')) {
            redirect('upfront_payments');
        }

        if ($this->mdl_upfront_payments->run_validation()) {
            $upfront_payments_files = $this->input->post('upfront_payments_document_link');
            $files = [];
            $arr =[];


            if (!empty($_FILES['upfront_payments_file']["size"][0])){
                $count = count($_FILES['upfront_payments_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['upfront_payments_file'.$i] = [
                        'name'=>$_FILES['upfront_payments_file']['name'][$i],
                        'type'=>$_FILES['upfront_payments_file']['type'][$i],
                        'tmp_name'=>$_FILES['upfront_payments_file']['tmp_name'][$i],
                        'error'=>$_FILES['upfront_payments_file']['error'][$i],
                        'size'=>$_FILES['upfront_payments_file']['size'][$i]
                    ];
                }
                unset($_FILES['upfront_payments_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/upfront_payments/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/upfront_payments/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['upfront_payments_files'])){
                foreach ($_POST['upfront_payments_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $_POST['upfront_payments_document_link'] = serialize($files);
            }else{
                $_POST['upfront_payments_document_link'] = serialize('');
            }

            $id = $this->mdl_upfront_payments->save($id);
            redirect('upfront_payments');

        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_upfront_payments->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }


        $this->load->model('payment_methods/mdl_payment_methods');

        $amounts = array();


        $files = $this->mdl_upfront_payments->where('upfront_payments_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->upfront_payments_document_link);
        }else{
            $upload_files= [];
        }


        $this->layout->set(
            array(
                'upload_files'=>$upload_files,
                'upfront_payments_id' => $id,
            )
        );

            $this->layout->buffer('content', 'upfront_payments/form');
            $this->layout->render();


    }

    /**
     * @param $id
     */
    public function delete($id)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $this->mdl_upfront_payments->delete($id);
        redirect('upfront_payments');
    }

}

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
 * Class Recurring_income
 */
class Recurring_income extends Admin_Controller
{
    /**
     * Recurring_income constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_recurring_income');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {


        $success = [TYPE_EMPLOYEES,TYPE_FREELANCERS,TYPE_MANAGERS];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }


        $this->mdl_recurring_income->paginate(site_url('recurring_income/index'), $page);
        $this->layout->set('recur_frequencies', $this->mdl_recurring_income->recur_frequencies);

        $this->layout->set(
            array(
                'recurring_incomes' => $this->mdl_recurring_income->result(),
                'sum' => $this->sum(),
                'filter_display' => false,
                'filter_placeholder' => trans('filter_subscriptions'),
                'filter_method' => 'filter_subscriptions'
            )
        );



        $this->layout->buffer('content', 'recurring_income/index');
        $this->layout->render();

    }

    /**
     * @param null $id
     */

    public function sum($sum = 0){

        $recurring_income = $this->mdl_recurring_income->get()->result();
        foreach ($recurring_income as $i){
            $sum+=$i->recurring_income_amount;
        }
        return $sum;
    }

    public function total_price($sum  = 0){
        $recurring_income = $this->mdl_recurring_income->get()->result();
        foreach ($recurring_income as $i){
            $sum+=$i->recurring_income_amount;
        }
        echo $sum;
    }

    public function form($id = null)
    {

        if ($this->input->post('btn_cancel')) {
            redirect('recurring_income');
        }

        if ($this->mdl_recurring_income->run_validation()) {
            $files = [];

            if (!empty($_FILES['recurring_income_file']["size"][0])){
                $count = count($_FILES['recurring_income_file']['name']);
                for($i=0;$i<$count;$i++){
                    $_FILES['recurring_income_file'.$i] = [
                        'name'=>$_FILES['recurring_income_file']['name'][$i],
                        'type'=>$_FILES['recurring_income_file']['type'][$i],
                        'tmp_name'=>$_FILES['recurring_income_file']['tmp_name'][$i],
                        'error'=>$_FILES['recurring_income_file']['error'][$i],
                        'size'=>$_FILES['recurring_income_file']['size'][$i]
                    ];
                }
                unset($_FILES['recurring_income_file']);

                foreach ($_FILES as $key => $file){
                    $new_name = time().$file['name'];
                    $upload_config = array(
                        'upload_path' => './uploads/recurring_income/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'file_name' => $new_name
                    );

                    $this->load->library('upload', $upload_config);

                    $this->upload->do_upload($key);

                    $upload_data = $this->upload->data();

                    $files_new= base_url() . "uploads/recurring_income/" .  $upload_data['file_name'];
                    array_push($files,$files_new);
                }
            }

            if(!empty($_POST['recurring_income_files'])){

                foreach ($_POST['recurring_income_files'] as $file){
                    array_push($files,$file);
                }
            }

            if(!empty($files)){
                $_POST['recurring_income_document_link'] = serialize($files);
            }else{
                $_POST['recurring_income_document_link'] = serialize('');
            }

            $id = $this->mdl_recurring_income->save($id);
            if(!empty($id)){
                $this->session->unset_userdata('recurring_income_documents');
            }



            redirect('recurring_income');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_recurring_income->prep_form($id);

            if ($id and !$prep_form) {
                show_404();
            }
        }

        $this->load->model('payment_methods/mdl_payment_methods');


        $files = $this->mdl_recurring_income->where('recurring_income_id',$id)->get()->row();
        if(!empty($files)){
            $upload_files= unserialize($files->recurring_income_document_link);
        }else{
            $upload_files= [];
        }


        $amounts = array();

        $this->layout->set('recur_frequencies', $this->mdl_recurring_income->recur_frequencies);
        $this->load->model('mdl_recurring_income');

        $this->layout->set(
            array(
                'tablet_files'=>$this->session->userdata('recurring_income_documents'),
                'recurring_income_id' => $id,
                'upload_files'=>$upload_files
            )
        );

        if ($this->input->post('recurring_income_dontadd')=='') {
              $this->layout->set(
              array(
               'recurring_income_dontadd' => '1',
              )
            );
        }

        if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS){
            $this->layout->buffer('content', 'recurring_income/form');
            $this->layout->render();
        }else{
            redirect('dashboard');
        }


    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_recurring_income->delete($id);
        redirect('recurring_income');
    }

}

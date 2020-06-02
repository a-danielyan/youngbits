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
 * Class Products
 */
class Products extends Admin_Controller
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_products');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {

        $success = [TYPE_EMPLOYEES,TYPE_FREELANCERS];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('dashboard');
        }

        $this->mdl_products->paginate(site_url('products/index'), $page);
        $products = $this->mdl_products->result();
        $this->layout->set('products', $products);

        $this->layout->buffer('content', 'products/index');
        $this->layout->render();


    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('products');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('products');
        }

        if ($this->mdl_products->run_validation()) {
            // Get the db array
            $db_array = $this->mdl_products->db_array();
            if(!empty($this->input->post('supplier_id'))){
                $db_array['purchase_price_supplier'] = ($this->input->post('supplier_multiplier') * $this->input->post('supplier_purchase_price')) + $this->input->post('product_price');
            }

            if(!empty($this->input->post('product_distributors'))){
                $db_array['selling_price_distributor'] = ($this->input->post('product_distributors_multiplier') * $this->input->post('product_distributors_purchase_price')) + $this->input->post('product_price');
            }

            $new_product_id= $this->mdl_products->save($id, $db_array);
            $this->load->model('mdl_products_suppliers');

            if(!empty($this->input->post('supplier_id'))){

                $product_supplier['supplier_id']= $this->input->post('supplier_id');
                $product_supplier['supplier_product_id']= $new_product_id;
                $product_supplier['supplier_multiplier']= $this->input->post('supplier_multiplier');
                $product_supplier['supplier_purchase_price']= $this->input->post('supplier_purchase_price');


                 $this->mdl_products_suppliers->save($id, $product_supplier);

            }

            redirect('products');
        }



        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_products->prep_form($id)) {
                show_404();
            }
        }

        $this->load->model('families/mdl_families');
        $this->load->model('units/mdl_units');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('distributors/mdl_distributors');

        $product_distributors = '';
        if(!is_null($id)){
            $suppliers = $this->mdl_suppliers->where('ip_products_suppliers.supplier_product_id',$id)->or_where('ip_products_suppliers.supplier_product_id',NULL)->get()->result();
            $product_distributors = $this->mdl_products->where('ip_products.product_id',$id)->get()->row();
            $product_distributors->product_distributors = unserialize($product_distributors->product_distributors);
        }else{
            $suppliers = $this->mdl_suppliers->where('ip_products_suppliers.supplier_product_id',NULL)->get()->result();

        }
        $distributors = $this->mdl_distributors->get()->result();


//var_dump($product_distributors);die;
        $this->layout->set(
            array(
                'product_distributors' => $product_distributors,
                'distributors' => $distributors,
                'suppliers' => $suppliers,
                'families' => $this->mdl_families->get()->result(),
                'units' => $this->mdl_units->get()->result(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );

        $this->layout->buffer('content', 'products/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('products');
        }

        $this->load->model('mdl_products_suppliers');

        $this->db->where('supplier_product_id',$id)->delete('ip_products_suppliers');
        $this->mdl_products->delete($id);
        redirect('products');
    }

}

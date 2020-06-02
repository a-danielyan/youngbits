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
 * Class Mdl_Companies
 */
class Mdl_website_access extends Response_Model
{

    public $table = 'ip_website_access';
    public $primary_key = 'ip_website_access.website_access_id';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_website_access.*, ip_clients.client_name", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_website_access.website_access_created DESC');
    }



    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_website_access.website_access_client_id', 'left');
    }



    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'website_access_domain_name' => array(
                'field' => 'website_access_domain_name',
                'label' => trans('website_access_domain_name'),
                'rules' => 'required'
            ),
            'website_access_category' => array(
                'field' => 'website_access_category',
                'label' => trans('website_access_category'),
            ),
            'website_access_client_id' => array(
                'field' => 'website_access_client_id',
                'label' => trans('client')
            ),
            'website_access_control_panel_web' => array(
                'field' => 'website_access_control_panel_web',
                'label' => trans('website_access_control_panel_web')
            ),
            'website_access_mijndomeinreseller' => array(
                'field' => 'website_access_mijndomeinreseller',
                'label' => trans('website_access_mijndomeinreseller')
            ),
            'website_access_admin' => array(
                'field' => 'website_access_admin',
                'label' => trans('website_access_admin')
            ),
            'website_access_project_id' => array(
                'field' => 'website_access_project_id',
                'label' => trans('project')
            ),
            'website_access_user_account' => array(
                'field' => 'website_access_user_account',
                'label' => trans('user_account')
            ),
            'website_access_user_login' => array(
                'field' => 'website_access_user_login',
                'label' => trans('user_login')
            ),
            'website_access_directadmin_account' => array(
                'field' => 'website_access_directadmin_account',
                'label' => trans('website_access_directadmin_account')
            ),
            'website_access_directadmin_login' => array(
                'field' => 'website_access_directadmin_login',
                'label' => trans('website_access_directadmin_login')
            ),
            'website_access_product_domain_name' => array(
                'field' => 'website_access_product_domain_name',
                'label' => trans('website_access_product_domain_name')
            ),
            'website_access_product_webhosting' => array(
                'field' => 'website_access_product_webhosting',
                'label' => trans('website_access_product_webhosting')
            ),
            'website_access_ssl_protected' => array(
                'field' => 'website_access_ssl_protected',
                'label' => trans('website_access_ssl_protected')
            ),
            'website_access_date_domain_name_reg' => array(
                'field' => 'website_access_date_domain_name_reg',
                'label' => trans('website_access_date_domain_name_reg')
            )
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        return $db_array;
    }


    /**
     * @param null $id
     */
    public function delete($id = null)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }


    public function statuses()
    {
        return array(
            '0' => array(
                'label' => trans('no_website'),
                'class' => 'draft',
                'href' => 'website_access/status/no_website'
            ),
            '1' => array(
                'label' => trans('wordpress_website'),
                'class' => 'sent',
                'href' => 'website_access/status/wordpress_website'
            ),
            '2' => array(
                'label' => trans('other_website'),
                'class' => 'viewed',
                'href' => 'website_access/status/viewed'
            )
        );
    }


    public function no_website()
    {
        $this->filter_where('website_access_category', 0);
        return $this;
    }

    /**
     * @return $this
     */
    public function wordpress_website()
    {
        $this->filter_where('website_access_category',1);
        return $this;
    }

    /**
     * @return $this
     */
    public function other_website()
    {
        $this->filter_where('website_access_category', 2);
        return $this;
    }


    /**
     * @param null $id
     * @return bool
     */
    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }


        return true;
    }



}

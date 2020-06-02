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
class Mdl_Companies extends Response_Model
{

    public $table = 'ip_companies';
    public $primary_key = 'ip_companies.id';

    public function getCompanies()
    {
        $result = $this->db->get('ip_companies')->result();
        return $result;
    }

    public function addCompany($data)
    {
        if($this->db->insert('ip_companies',$data)){
            return true;
        }
    }

    public function delete($id)
    {
        $this->db->where('id',$id)->delete('ip_companies');
    }

    public function getCompany($id = 0)
    {
        return $this->db->where('id',$id)->get('ip_companies')->row();
    }

    public function editCompany($id, $data)
    {
        if($this->db->where('id',$id)->update('ip_companies', $data)){
            if($data['default_company']){
                $this->db->where('default_company',1)->where('id !=', $id)->update('ip_companies', array('default_company' => 0));
            }
            return true;
        }
    }

}

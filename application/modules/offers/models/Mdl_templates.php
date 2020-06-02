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
 * Class Mdl_Templates
 */
class Mdl_Templates extends CI_Model
{
    /**
     * @param string $type
     * @return array
     */
    public function get_offer_templates($type = 'pdf')
    {
        $this->load->helper('directory');

        if ($type == 'pdf') {
            $templates = directory_map(APPPATH . '/views/offer_templates/pdf', true);
        } elseif ($type == 'public') {
            $templates = directory_map(APPPATH . '/views/offer_templates/public', true);
        }

        $templates = $this->remove_extension($templates);

        return $templates;
    }

    /**
     * @param $files
     * @return mixed
     */
    private function remove_extension($files)
    {
        foreach ($files as $key => $file) {
            $files[$key] = str_replace('.php', '', $file);
        }

        return $files;
    }


}

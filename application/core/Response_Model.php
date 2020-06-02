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
 * Class Response_Model
 */
class Response_Model extends Form_Validation_Model
{
    /**
     * @param null|int $id
     * @param null|array $db_array
     * @return null|int
     */
    public function save($id = null, $db_array = null)
    {
        if ($id) {
            $this->session->set_flashdata('alert_success', trans('record_successfully_updated'));
            parent::save($id, $db_array);
        } else {
            $this->session->set_flashdata('alert_success', trans('record_successfully_created'));
            $id = parent::save(null, $db_array);
        }

        return $id;
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        parent::delete($id);

        $this->session->set_flashdata('alert_success', trans('record_successfully_deleted'));
    }
}

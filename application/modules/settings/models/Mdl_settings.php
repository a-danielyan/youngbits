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
 * Class Mdl_Settings
 */
class Mdl_Settings extends CI_Model
{
    public $settings = array();

    /**
     * @param $key
     * @param $value
     */
    public function save($key, $value)
    {
        $set = $this->input->post('set');
        $s = $this->input->post("settings");

        $db_array = array(
            'setting_key' => $key,
            'setting_value' => $value,
        );

        if ($this->get($key) !== null) {
            $this->db->where('setting_key', $key);
            $this->db->update('ip_settings', $db_array);
        } else {
            $this->db->insert('ip_settings', $db_array);
        }
        $this->db->update('ip_certains_part_spudu', [
            'part_status' => 'unchecked',
        ]);
        if ($set !== null) {
            foreach ($set as $s) {

                $this->db->where('part_name', $s);
                $this->db->update('ip_certains_part_spudu', [
                    'part_status' => 'checked',
                ]);
            }
        } elseif ($set == null) {
            $this->db->update('ip_certains_part_spudu', [
                'part_status' => 'unchecked',
            ]);
        }

    }

    public function CertainPart()
    {


        $status = $this->db->get('ip_certains_part_spudu')->result_array();
        $this->session->set_userdata("statuses", $status);
        return $status;
    }

    public function GetStatus()
    {
        $this->db->select('*');
        $this->db->from('ip_certains_part_spudu');
        $status = $this->db->get()->result_array();
        return $status;
    }
    public function SelectTemplate($mytemplate)
    {
        $this->db->select('*');
        $this->db->from('ip_menu_parts_template');
        $this->db->where('template_name',$mytemplate);
        $mytemp = $this->db->get()->result_array();
        $this->session->set_userdata("mytemp", $mytemp);
//        var_dump($mytemp);die;
        return $mytemp;
    }
    public function MakeTemplate($st, $template)
    {

        if ($template !== '') {

            $status = json_encode($st);
            $this->db->insert('ip_menu_parts_template', [
                'template_name' => $template,
                'template_data' => $status

            ]);
            $this->session->set_userdata("templates", [
                'template_name' => $template,
                'template_data' => $status

            ]);
        }

    }
    public function updateCertainParts($mytemplate)
    {
        $mytemplate = json_decode($mytemplate[0]['template_data']);
        foreach ($mytemplate as $temp) {

//            echo '<pre>';
//            var_dump($temp->id);die;
            $db_array =[
                'part_status' => $temp->part_status,
            ];
            $this->db->where('part_name', $temp->part_name);
            $this->db->update('ip_certains_part_spudu',$db_array);

        }
    }
    public function Template($mytemplate =null)
    {

        $this->db->select('*');
        $this->db->from('ip_menu_parts_template');
        $template = $this->db->get()->result_array();

        return $template;
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        $this->db->select('setting_value');
        $this->db->where('setting_key', $key);
        $query = $this->db->get('ip_settings');

        if ($query->row()) {
            return $query->row()->setting_value;
        } else {
            return null;
        }
    }

    public function CertainParts($set)
    {
        $this->db->select('part_status');
        $query = $this->db->get('ip_certains_part_spudu');

    }

    /**
     * @param $key
     */
    public function delete($key)
    {
        $this->db->where('setting_key', $key);
        $this->db->delete('ip_settings');
    }

    public function load_settings()
    {
        $ip_settings = $this->db->get('ip_settings')->result();

        foreach ($ip_settings as $data) {
            $this->settings[$data->setting_key] = $data->setting_value;
        }
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public function setting($key, $default = '')
    {
        return (isset($this->settings[$key])) ? $this->settings[$key] : $default;
    }

    /**
     * @param string $key
     * @return mixed|string
     */
    public function gateway_settings($key)
    {
        return $this->db->like('setting_key', 'gateway_' . strtolower($key), 'after')->get('ip_settings')->result();
    }

    /**
     * @param $key
     * @param $value
     */
    public function set_setting($key, $value)
    {
        $this->settings[$key] = $value;
    }

    /**
     * Returns all available themes
     * @return array
     */
    public function get_themes()
    {
        $this->load->helper('directory');

        $found_folders = directory_map(THEME_FOLDER, 1);

        $themes = [];

        foreach ($found_folders as $theme) {
            if ($theme == 'core') {
                continue;
            }

            // Get the theme info file
            $theme = str_replace('/', '', $theme);
            $info_path = THEME_FOLDER . $theme . '/';
            $info_file = $theme . '.theme';

            if (file_exists($info_path . $info_file)) {
                $theme_info = new \Dotenv\Dotenv($info_path, $info_file);
                $theme_info->overload();
                $themes[$theme] = env('TITLE');
            }
        }

        return $themes;
    }

    public  function  addPartItem($item_name, $group_name){
        $this->db->insert('ip_certains_part_spudu', [
            'part_name' => $item_name,
            'group_name' => $group_name

        ]);
    }

}

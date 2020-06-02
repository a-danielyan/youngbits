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
 * Class User_Groups
 */
class User_Groups extends Admin_Controller
{
    /**
     * User_Groups constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_user_groups');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_user_groups->paginate(site_url('user_groups/index'), $page);
        $user_groups = $this->mdl_user_groups->result();

        $this->layout->set('user_groups', $user_groups);
        $this->layout->buffer('content', 'user_groups/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('user_groups');
        }

        if ($this->mdl_user_groups->run_validation()) {

            // We need to use the correct decimal point for sql IPT-310
            $db_array = $this->mdl_user_groups->db_array();

            $this->mdl_user_groups->save($id, $db_array);

            redirect('user_groups');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_user_groups->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->buffer('content', 'user_groups/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_user_groups->delete($id);
        redirect('user_groups');
    }

}

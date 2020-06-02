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
 * Class Notes
 */
class Notes extends Custom_Controller {

	/**
     * Notes constructor.
     */


    public function __construct()
    {
        $users = array('user_type' => array(TYPE_ADMIN, TYPE_MANAGERS));
        parent::__construct($users);
        $this->load->model('mdl_notes');
    }

    /**
     * @param int $page
     */

    public function index($page = 0)
    {
        $this->mdl_notes->paginate(site_url('notes/index'), $page);
        $this->load->model('projects/mdl_projects');

        if ($this->session->userdata('user_type') == TYPE_ADMIN) {
            $notes = $this->mdl_notes->group_by('ip_notes.project_id')->get()->result();

            foreach ($notes as $key => $note){
                $notes[$key]->total_notes=$this->total_notes($note->project_id);
                $notes[$key]->last_note=$this->last_note($note->project_id)['notes_title'];
                $notes[$key]->created_date =$this->last_note($note->project_id)['created_date'];
            }
        } else {
            $projects_groups = $this->mdl_notes->join('ip_projects_groups', 'ip_notes.project_id = ip_projects_groups.project_id', 'left');
            $notes = $projects_groups->group_by('ip_notes.project_id')->get()->result();


            $uniqueArray = [];
            foreach ($notes as $key => &$note) {
                if ( $note->group_id == $this->session->userdata('user_group_id')){
                    $notes[$key]->total_notes=$this->total_notes($note->project_id);
                    $notes[$key]->last_note=$this->last_note($note->project_id)['notes_title'];
                    $notes[$key]->created_date =$this->last_note($note->project_id)['created_date'];

                }

                if (empty($note->group_id) || $note->group_id != $this->session->userdata('user_group_id')) {
                    unset($notes[$key]);
                }


            }

        }





        $this->layout->set('notes',$notes);
        $this->layout->buffer('content', 'notes/index');
        $this->layout->render();


    }

    /**
     * @param null $id
     */




    public function last_note($project_id = null){
        $notes = $this->mdl_notes->limit(1)->where('ip_notes.project_id',$project_id)->get()->row();
        $arr['notes_title']=$notes->notes_title;
        $arr['created_date']=$notes->created_date;
        return $arr;


    }

    public function total_notes($id = null){
        $notes = $this->db->from('ip_notes')->where('project_id',$id)->get()->result();
        return count($notes);

    }



    public function project_notes($id = null){
        $notes = $this->mdl_notes->where('ip_notes.project_id',$id)->get()->result();
        $this->load->model('projects/mdl_projects');
        $this->mdl_notes->paginate(site_url('notes/index'), $id);
        $project_name =$this->mdl_projects->where('ip_projects.project_id',$id)->get()->row();

        $data=[
            'notes'=>$notes,
            'project_name'=>$project_name->project_name,
            'notes_statuses'=>$this->mdl_notes->statuses(),
        ];

        $this->layout->set($data);
        $this->layout->buffer('content', 'notes/project_notes');
        $this->layout->render();

    }



    public function form($id = null)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('notes');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('notes');
        }

        if ($this->mdl_notes->run_validation()) {
            $this->mdl_notes->save($id);
            redirect('notes');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_notes->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }



        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');

        $projects = $this->mdl_projects->get()->result();
        $projects_filtered = array();
        $projects_groups = $this->mdl_projects->read_groups_for_project();




        foreach ($projects as $project)
        {
            if ($this->session->userdata('user_type') != TYPE_ADMIN) {
                $projectgroup = array('project_id' => $project->project_id, 'group_id' => $this->session->userdata('user_group_id'));

                $key = array_search($projectgroup, $projects_groups);
                if ($key !== false || $this->session->userdata('user_type') == TYPE_ADMIN) {
                    array_push($projects_filtered, $project);
                }


            }
            else if ($this->session->userdata('user_type') == TYPE_ADMIN) {
                array_push($projects_filtered, $project);
            }
        }

        $this->layout->set(
            array(
                'projects' => $projects_filtered,
                'notes_statuses' => $this->mdl_notes->statuses(),
            )
        );

        $this->layout->buffer('content', 'notes/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {

        $success = [TYPE_ACCOUNTANT];
        if(in_array($this->session->userdata('user_type'),$success)){
            redirect('notes');
        }
        $this->mdl_notes->delete($id);
        redirect('notes');
    }

}

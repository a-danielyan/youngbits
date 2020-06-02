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
 * Class Tickets
 */
class Tickets extends NormalUser_Controller
{
    /**
     * Tickets constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_tickets');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        redirect('tickets/status/all');
    }

    public function status($status = 'all', $page = 0)
    {
        $this->load->helper('allowance');
        // Determine which group of invoices to load
        switch ($status) {
            case 'draft':
                $this->mdl_tickets->is_draft();
                break;
            case 'closed':
                $this->mdl_tickets->is_closed();
                break;
            case 'accepted':
                $this->mdl_tickets->is_accepted();
                break;
            case 'within_guarantee_warranty':
                $this->mdl_tickets->is_within_guarantee_warranty();
                break;
        }

        $this->mdl_tickets->paginate(site_url('tickets/status/' . $status), $page);
        $tickets = $this->mdl_tickets->result();
        $new_tickets = array();
        $new_ticket_ids = array();

        foreach ($tickets as $ticket)
        {
            if (!$ticket) {
                continue;
            }

            if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
                $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
                $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
            {
                continue;
            }
            if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
                $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
                !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
            {
                continue;
            }
            array_push($new_tickets, $ticket);
            array_push($new_ticket_ids, $ticket->ticket_id);
        }

        if (count($new_ticket_ids) == 0)
        {
            array_push($new_ticket_ids, -1);
        }

        $this->mdl_tickets->where_in('ip_tickets.ticket_id', $new_ticket_ids)->paginate(site_url('tickets/status/' . $status), $page);

        $this->layout->set('tickets', $new_tickets);
        $this->layout->set('ticket_statuses', $this->mdl_tickets->statuses());
        $this->layout->set('status', $status);
        $this->layout->buffer('content', 'tickets/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if($this->session->userdata('user_type') == TYPE_ACCOUNTANT){
            redirect('dashboard');
        }


        $this->load->model('users/mdl_users');
        $this->load->helper('allowance');
        if ($id != null)
        {
            if ($this->session->userdata('user_type') <> TYPE_ADMIN)
            {
                $ticket = $this->mdl_tickets->get_by_id($id);
                if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
                    $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
                    $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
                {
                    redirect('tickets/status/all');
                }
                if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
                    $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
                    !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
                {
                    redirect('tickets/status/all');
                }
            }
        }
        if ($this->input->post('btn_cancel')) {
            redirect('tickets/status/all');
        }

        if ($id == null && !empty($_POST)) {
            $_POST['ticket_created_user_id'] = $this->session->userdata('user_id');
            $_POST['ticket_insert_time'] = date("Y-m-d H:i:s");
            if ($this->session->userdata('user_type') <> TYPE_ADMIN && $this->session->userdata('user_type') <> TYPE_MANAGERS) {
                $_POST['ticket_assigned_user_id'] = $this->session->userdata('user_id');
            }
        }

        $user;
        if (!empty($_POST['ticket_assigned_user_id'])) {
            $user = $this->mdl_users->get_by_id($_POST['ticket_assigned_user_id']);
        }

        $ticket_number = $this->input->post('ticket_number');
        if (!empty($_POST) && empty($ticket_number)) {
            $this->load->model('invoice_groups/mdl_invoice_groups');

            if ($id && isset($user)) {
                $_POST['ticket_number'] = "Ticket-" . $id . "-" . $user->user_name;
            }
            else {
                $_POST['ticket_number'] = "Ticket-" . $id;
            }
        }

        if ($this->mdl_tickets->run_validation()) {
            $need_to_update_ticket_number = false;
            if ($id == null)
            {
                $need_to_update_ticket_number = true;
            }
            $id = $this->mdl_tickets->save($id);

            if ($need_to_update_ticket_number)
            {
                if (isset($user)) {
                    $this->mdl_tickets->save($id, array('ticket_number' => "Ticket-" . $id . "-" . $user->user_name));
                }
                else
                {
                    $this->mdl_tickets->save($id, array('ticket_number' => "Ticket-" . $id));
                }
            }
            redirect('tickets/status/all');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_tickets->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }

        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('clients/mdl_clients');
        $this->load->model('invoice_groups/mdl_invoice_groups');

        $projects = null;

        if ($this->session->userdata('user_type') == TYPE_ADMIN )
        {
            $projects = $this->mdl_projects->get()->result();
        }
        else
        {
            $all_projects = $this->mdl_projects->get()->result();

            $projects = array();

            foreach ($all_projects as $project)
            {
                if (!$project) {
                    continue;
                }

                if ($project->client_id == null)
                {
                    continue;
                }
                if (!allow_to_see_client_for_logged_user($project->client_id))
                {
                    continue;
                }
                array_push($projects, $project);
            }
        }

        $not_admin_not_administrators = array('ip_users.user_type <>' => TYPE_ADMIN, 'ip_users.user_type !=' => TYPE_ADMIN);

        $this->layout->set(
            array(
                'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
                'projects' => $projects,
                'clients' => $this->session->userdata('user_type') <> TYPE_ADMIN ? $this->mdl_clients->where('ip_clients_groups.group_id', $this->session->userdata('user_group_id'))->get()->result()
                    : $this->mdl_clients->get()->result(),
                'users' =>  $this->session->userdata('user_type') <> TYPE_ADMIN ? $this->mdl_users->where($not_admin_not_administrators)->get()->result()
                    : $this->mdl_users->get()->result(),
                'ticket_statuses' => $this->mdl_tickets->statuses(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );
        $this->layout->buffer('content', 'tickets/form');
        $this->layout->render();
    }


    /**
     * @param int $ticket_id
     */
    public function view($ticket_id)
    {
        $this->load->model('tickets/mdl_tickets');
        $this->load->helper('allowance');

        $ticket = $this->mdl_tickets->where('ip_tickets.ticket_id', $ticket_id)->get()->row();

        if (!$ticket) {
            show_404();
        }

        if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
            $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
        {
            redirect('tickets/status/all');
        }
        if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
            !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
        {
            redirect('tickets/status/all');
        }

        $this->layout->set(
            array(
                'ticket' => $ticket,
                'ticket_statuses' => $this->mdl_tickets->statuses()
            )
        );

        $this->layout->buffer('content', 'tickets/view');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->load->model('tickets/mdl_tickets');
        $this->load->helper('allowance');

        $ticket = $this->mdl_tickets->where('ip_tickets.ticket_id', $id)->get()->row();

        if (!$ticket) {
            show_404();
        }
        if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
            $this->session->userdata('user_type') != TYPE_ADMIN && $ticket->client_id == null && $ticket->project_client_id == null)
        {
            redirect('tickets/status/all');
        }
        if ($ticket->ticket_created_user_id != $this->session->userdata('user_id') &&
            $ticket->ticket_assigned_user_id != $this->session->userdata('user_id') &&
            !allow_to_see_client_for_logged_user($ticket->client_id) && !allow_to_see_client_for_logged_user($ticket->project_client_id))
        {
            redirect('tickets/status/all');
        }

        $this->mdl_tickets->delete($id);
        redirect('tickets/status/all');
    }
}

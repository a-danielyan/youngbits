<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('tickets'); ?></h1>

    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('tickets/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php endif; ?>


    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('tickets/status/' . $this->uri->segment(3)), 'mdl_tickets'); ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('tickets/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
            <a href="<?php echo site_url('tickets/status/draft'); ?>"
               class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('draft'); ?>
            </a>
            <a href="<?php echo site_url('tickets/status/accepted'); ?>"
               class="btn  <?php echo $status == 'accepted' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('accepted'); ?>
            </a>
            <a href="<?php echo site_url('tickets/status/closed'); ?>"
               class="btn  <?php echo $status == 'closed' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('closed'); ?>
            </a>
            <a href="<?php echo site_url('tickets/status/within_guarantee_warranty'); ?>"
               class="btn  <?php echo $status == 'within_guarantee_warranty' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('within_guarantee_warranty'); ?>
            </a>
        </div>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'ticket_status', 'ip_tickets'); ?>><?php _trans('status'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'ticket_number', 'ip_tickets'); ?>><?php _trans('ticket_number'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'ticket_name', 'ip_tickets'); ?>><?php _trans('ticket_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'user_name', 'ip_users'); ?>><?php _trans('assign_to'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'project_name', 'ip_projects'); ?>><?php _trans('project_or_client'); ?></a></th>
                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <th><?php _trans('options'); ?></th>
                <?php endif; ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($tickets as $ticket) { ?>
                <tr>
                    <td>
                        <span class="label <?php echo $ticket_statuses["$ticket->ticket_status"]['class']; ?>">
                            <?php echo $ticket_statuses["$ticket->ticket_status"]['label']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($ticket->ticket_number != "")
                        {
                            echo anchor('tickets/view/' . $ticket->ticket_id, $ticket->ticket_number);
                        } ?>
                    </td>
                    <td>
                        <?php echo anchor('tickets/view/' . $ticket->ticket_id, $ticket->ticket_name); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($ticket->ticket_assigned_user_name); ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($ticket->project_id)) {
                            echo anchor('projects/view/' . $ticket->project_id, $ticket->project_name);
                        }
                        else if (!empty($ticket->client_id )) {
                            echo anchor('clients/view/' . $ticket->client_id, $ticket->client_name);
                        }
                        ?>
                    </td>
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('tickets/view/' . $ticket->ticket_id); ?>"
                                           title="<?php _trans('view'); ?>">
                                            <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('mailer/tickets/' . $ticket->ticket_id); ?>">
                                            <i class="fa fa-send fa-margin"></i>
                                            <?php _trans('send_email'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('tickets/form/' . $ticket->ticket_id); ?>"
                                           title="<?php _trans('edit'); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('tickets/delete/' . $ticket->ticket_id); ?>"
                                           title="<?php _trans('delete'); ?>"
                                           onclick="return confirm('<?php echo trans('delete_record_warning') ?>')"
                                        >
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>

</div>

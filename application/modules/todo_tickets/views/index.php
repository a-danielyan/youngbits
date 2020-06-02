<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('todo_ticets'); ?></h1>

    <?php if (!in_array( $this->session->userdata('user_type'), array(TYPE_ACCOUNTANT, TYPE_FREELANCERS) )): ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('todo_tickets/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php endif; ?>


    <div class="headerbar-item pull-right">
        <?= $links; ?>
    </div>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('todo_tickets/status/in_progress'); ?>"
               class="btn  <?php echo $status == 'in_progress' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('in_progress'); ?>
            </a>
            <a href="<?php echo site_url('todo_tickets/status/draft'); ?>"
               class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('draft'); ?>
            </a>
            <a href="<?php echo site_url('todo_tickets/status/accepted'); ?>"
               class="btn  <?php echo $status == 'accepted' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('accepted'); ?>
            </a>
            <a href="<?php echo site_url('todo_tickets/status/closed'); ?>"
               class="btn  <?php echo $status == 'closed' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('closed'); ?>
            </a>
            <a href="<?php echo site_url('todo_tickets/status/paid'); ?>"
               class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('paid'); ?>
            </a>
            <a href="<?php echo site_url('todo_tickets/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
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

                <th><a <?= orderableTH($this->input->get(), 'todo_ticket_status', 'ip_todo_tickets'); ?>><?php _trans('status'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'todo_ticket_number', 'ip_todo_tickets'); ?>><?php _trans('todo_number'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'todo_ticket_name', 'ip_todo_tickets'); ?>><?php _trans('todo_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'todo_ticket_number_of_hours', 'ip_todo_tickets'); ?>><?php _trans('total_number_of_hours'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'todo_ticket_assigned_user_id', 'ip_todo_tickets'); ?>><?php _trans('assign_to'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'todo_ticket_url_key', 'ip_todo_tickets'); ?>><?php _trans('guest_url'); ?></a></th>

                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <th><?php _trans('options'); ?></th>
                <?php endif; ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($todo_tickets as $ticket) { ?>
                <tr>
                    <td>
                        <span class="label <?php echo $ticket_statuses["$ticket->todo_ticket_status"]['class']; ?>">
                            <?php echo $ticket_statuses["$ticket->todo_ticket_status"]['label']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($ticket->todo_ticket_number != "")
                        {
                            echo anchor('todo_tickets/view/' . $ticket->todo_ticket_id, $ticket->todo_ticket_number);
                        } ?>
                    </td>
                    <td>
                        <?php echo anchor('todo_tickets/view/' . $ticket->todo_ticket_id, $ticket->todo_ticket_name); ?>
                    </td>
                    <td>
                        <?= (!empty($ticket->todo_ticket_number_of_hours))?$ticket->todo_ticket_number_of_hours: 0 ; ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($ticket->todo_ticket_assigned_user_name); ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('guest/view/todo_ticket/' .$ticket->todo_ticket_url_key) ?>"><?php echo site_url('guest/view/todo_ticket/' .$ticket->todo_ticket_url_key) ?></a>
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
                                        <a href="<?php echo site_url('todo_tickets/view/' . $ticket->todo_ticket_id); ?>"
                                           title="<?php _trans('view'); ?>">
                                            <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('todo_tickets/form/' . $ticket->todo_ticket_id); ?>"
                                           title="<?php _trans('edit'); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('todo_tickets/delete/' . $ticket->todo_ticket_id); ?>"
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

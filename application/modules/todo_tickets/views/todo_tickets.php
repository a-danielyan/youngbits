<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('todo_tickets'); ?></h1>
    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('tickets/todo_tickets/status/' . $this->uri->segment(3)), 'ip_todo_tickets'); ?>
    </div>

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('tickets/todo_tickets/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
            <a href="<?php echo site_url('tickets/todo_tickets/status/draft'); ?>"
               class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('draft'); ?>
            </a>
            <a href="<?php echo site_url('tickets/todo_tickets/status/accepted'); ?>"
               class="btn  <?php echo $status == 'accepted' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('accepted'); ?>
            </a>
            <a href="<?php echo site_url('tickets/todo_tickets/status/closed'); ?>"
               class="btn  <?php echo $status == 'closed' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('closed'); ?>
            </a>
            <a href="<?php echo site_url('tickets/todo_tickets/status/within_guarantee_warranty'); ?>"
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
                <th><a <?= orderableTH($this->input->get(), 'ticket_status', 'ip_todo_tickets'); ?>><?php _trans('status'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'ticket_number', 'ip_todo_tickets'); ?>><?php _trans('todo_number'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'ticket_name', 'ip_tickets'); ?>><?php _trans('todo_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'user_name', 'ip_todo_tickets'); ?>><?php _trans('assign_to'); ?></a></th>
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
                            echo anchor('tickets/todo_tickets/view/' . $ticket->ticket_id, $ticket->ticket_number);
                        } ?>
                    </td>
                    <td>
                        <?php echo anchor('tickets/todo_tickets/view/' . $ticket->ticket_id, $ticket->ticket_name); ?>
                    </td>







                    <td>
                        <?php echo htmlspecialchars($ticket->ticket_assigned_user_name); ?>
                    </td>


                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>

</div>

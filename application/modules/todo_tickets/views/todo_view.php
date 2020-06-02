<script>
    $(function () {
        // Creates the task
        $('#ticket_to_task').click(function () {
            $.post("<?php echo site_url('tickets/ajax/ticket_to_task'); ?>", {

                    project_id: $('#project_id').val(),
                    user_id : '<?=$ticket->ticket_assigned_user_id ? $ticket->ticket_assigned_user_id : 0;?>',
                    task_name : '<?=$ticket->ticket_name ? json_encode($ticket->ticket_name) : '';?>',
                    task_description : '<?=$ticket->ticket_description ? json_encode($ticket->ticket_description) : '';?>',
                    insert_time : '<?=$ticket->ticket_insert_time ? $ticket->ticket_insert_time : date('Y-m-d H:i:s'); ?>',
                    total_hours_spent : 0,
                    hour_rate : 0,
                    multiplier : 0,
                    task_price : 0,
                    task_finish_date : '<?php echo date_from_mysql(date('Y-m-d')); ?>',
                    task_status : 0,
                    task_invoice_link : '',
                    tax_rate_id : 0
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        alert('<?php echo json_encode(trans('task_successfully_updated')); ?>');
                        window.location = "<?php echo site_url('tasks/form'); ?>/" + response.task_id;
                    }
                    else {
                        // The validation was not successful
                        $('.control-group').removeClass('has-error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('has-error');
                        }
                    }
                });
        });
    });
</script>

<style>
    /* The container */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        /*margin-bottom: 12px;*/
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
    }

    .container-checkbox label {
        margin-bottom: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #5cb85c;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<div id="headerbar">
    <h1 class="headerbar-title"><?php echo $ticket->ticket_name; ?></h1>

    <div class="headerbar-item pull-right">
        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <div class="btn-group btn-group-sm">
                <a href="<?php echo site_url('tickets/form/'); ?>" class="btn btn-default">
                    <i class="fa fa-check-square-o fa-margin"></i><?php _trans('new_ticket'); ?>
                </a>
                <a href="<?php echo site_url('tickets/form/' . $ticket->ticket_id); ?>" class="btn btn-default">
                    <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
                </a>
                <a href="<?php echo site_url('mailer/tickets/' . $ticket->ticket_id); ?>" class="btn btn-default">
                    <i class="fa fa-send fa-margin"></i>
                    <?php _trans('send_email'); ?>
                </a>
                <a href="#" id="ticket_to_task" class="btn btn-default">
                    <i class="fa fa-refresh fa-margin"></i>
                    <?php _trans('ticket_to_task'); ?>
                </a>
                <a class="btn btn-danger"
                   href="<?php echo site_url('tickets/delete/' . $ticket->ticket_id); ?>"
                   onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                    <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>


<div id="content">
    <?php if ($this->session->flashdata('alert_success')) { ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
    <?php } ?>
    <div class="row">

        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default no-margin">
                <div class="panel-heading"><?php _trans('ticket'); ?></div>
                <div class="panel-body table-content">
                    <table class="table no-margin">
                        <tr>
                            <th><?php _trans('ticket_id'); ?></th>
                            <td><?php _htmlsc($ticket->ticket_id); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('ticket_number'); ?></th>
                            <td><?php _htmlsc($ticket->ticket_number); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('ticket_name'); ?></th>
                            <td><?php _htmlsc($ticket->ticket_name); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('status'); ?></th>
                            <td><?php _htmlsc($ticket_statuses["$ticket->ticket_status"]['label']); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('assign_to'); ?></th>
                            <td><?php echo anchor('users/form/' . $ticket->ticket_assigned_user_id, $ticket->ticket_assigned_user_name); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('ticket_created_by'); ?></th>
                            <td><?php _htmlsc($ticket->ticket_insert_time); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>

</div>

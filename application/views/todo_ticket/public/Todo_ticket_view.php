<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
        <?php echo get_setting('custom_title', 'Spudu', true); ?>
        - <?php echo trans('recurring_income'); ?> <?php echo $recurring_income->recurring_income_name; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
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

        .mt-5{
            margin-top: 5rem;

        }

        .confirm{
            color: limegreen;
            font-size: 30px;
            margin: auto;
        }
        .in_progress{
            color: #ff9b00;
            font-size: 30px;
            margin: auto;
        }
    </style>
</head>
<body>



<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('ticket'); ?></h1>

</div>


<div id="content">

    <div class="row">

        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default no-margin">
                <div class="panel-body table-content">
                    <table class="table no-margin">
                        <tr>
                            <th><?php _trans('status'); ?></th>
                            <td><?php _htmlsc($ticket_statuses["$ticket->todo_ticket_status"]['label']); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('todo_number'); ?></th>
                            <td><?php _htmlsc($ticket->todo_ticket_number); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('todo_name'); ?></th>
                            <td><?php _htmlsc($ticket->todo_ticket_name); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('assign_to'); ?></th>
                            <td><?= $ticket->todo_ticket_assigned_user_name; ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('todo_description'); ?></th>
                            <td><?php _htmlsc($ticket->todo_ticket_description); ?></td>
                        </tr>
                        <tr>
                            <th><?php _trans('attachment'); ?></th>
                            <td><a href="<?php echo $ticket->ticket_document_link; ?>"><?php echo $ticket->ticket_document_link; ?></a></td>
                        </tr>
                    </table>
                </div>
            </div>
            </form>
        </div>

    </div>



    <div class="mt-5" >
        <h2><?php _trans('todo_tasks'); ?></h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?php _trans('id'); ?></th>
                <th ><?php _trans('todo_task'); ?></th>
                <th ><?php _trans('project'); ?></th>
                <th><?php _trans('todo_task_number_of_hours'); ?></th>
                <th><?php _trans('deadline'); ?></th>
                <th><?php _trans('attachment'); ?></th>
                <th><?php _trans('status'); ?></th>
            </tr>
            </thead>
            <tbody>

            <?php


            foreach ($todo_tasks as $key => $todo_task) {
                ?>
                <tr>
                    <td><?=$key+1;?></td>
                    <td width="950"><?=$todo_task->todo_task_text;?></td>
                    <td><?=$todo_task->project_name;?></td>
                    <td  class="text-center"><?=$todo_task->todo_task_number_of_hours;?></td>
                    <td  class="text-center"><?=(!empty($todo_task->todo_task_deadline))?date('Y-m-d', strtotime($todo_task->todo_task_deadline)):'';?></td>
                    <td><?= ($todo_task->todo_task_document_link ? '<a href="' . $todo_task->todo_task_document_link . '">' . $todo_task->todo_task_document_link . '</a>' : '' )?> </td>
                    <td class="text-center">


                        <?php

                        $todo_task_time = explode(':',$todo_task->todo_task_number_of_hours);
                        if($todo_task_time[0] > 0 || $todo_task_time[1] > 0): ?>

                            <?php if($todo_task->todo_task_status == 0): ?>
                                <?php _trans('in_progress'); ?>
                            <?php endif;?>
                            <?php if($todo_task->todo_task_status == 1): ?>
                                <span class="in_progress"><i class="fa fa-spinner" aria-hidden="true"></i></span>
                            <?php endif;?>


                            <?php if($todo_task->todo_task_status == 2): ?>
                                <i class="fa fa-check-circle-o confirm" aria-hidden="true"></i>
                            <?php endif;?>



                        <?php else: ?>
                            <span class="text-danger"><b><?_trans('not_started_yet'); ?></b></span>
                        <?php endif;?>







                    </td>
                </tr>
            <?php } ?>





            </tbody>
        </table>
    </div>





</body>
</html>
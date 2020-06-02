<script>
    $(function () {
        $('#save_project_note').click(function () {
            $.post('<?php echo site_url('projects/ajax/save_project_note'); ?>',
                {
                    project_id: $('#project_id').val(),
                    project_note: $('#project_note').val()
                }, function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful
                        $('.control-group').removeClass('error');
                        $('#project_note').val('');

                        // Reload all notes
                        $('#notes_list').load("<?php echo site_url('projects/ajax/load_project_notes'); ?>",
                            {
                                project_id: <?php echo $project->project_id; ?>
                            }, function (response) {
                                <?php echo(IP_DEBUG ? 'console.log(response);' : ''); ?>
                            });
                    } else {
                        // The validation was not successful
                        $('.control-group').removeClass('error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().addClass('has-error');
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
    <h1 class="headerbar-title"><?php echo $project->project_name; ?></h1>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm">
            <?php
            if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
            ?>
            <a href="<?php echo site_url('projects/form/' . $project->project_id); ?>" class="btn btn-default">
                <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
            </a>
            <a class="btn btn-danger"
               href="<?php echo site_url('projects/delete/' . $project->project_id); ?>"
               onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
            </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>


<div id="content">
    <?php if ($this->session->flashdata('alert_success')) { ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('alert_success'); ?></div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-12 col-md-4">

            <?php if (!empty($project->client_name)) : ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo format_client($project); ?></strong>
                    </div>
                    <div class="panel-body">
                        <div class="client-address">
                            <?php $this->layout->load_view('clients/partial_client_address', array('client' => $project)); ?>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="alert alert-info"><?php _trans('alert_no_client_assigned'); ?></div>

            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('group_name'); ?>
                </div>
                <div class="panel-body">
                    <div class="client-address">
                        <?php
                        $groups = array();
                        foreach ($user_groups as $user_group) {
                            foreach ($project_groups as $project_group) {
                                if ($project_group["group_id"] == $user_group->group_id) {
                                    array_push($groups, $user_group->group_name);
                                }
                            }
                        }
                        if (count($groups) > 0)
                        {
                            echo ucfirst(implode(", ", $groups));
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('notes'); ?>
                </div>
                <div class="panel-body">
                    <div id="notes_list">
                        <?=$partial_project; ?>
                    </div>

                </div>
            </div>



            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('additional_information'); ?>
                </div>
                <div class="panel-body">
                    <div id="notes_list">
                        <b><?_trans('project_image_url')?></b>:<br> <img src="<?=$project->project_image_url?>" alt="" width="150" style="margin-bottom: 15px ">
                    </div>
                    <div id="notes_list">
                        <b><?_trans('project_financial_needs')?></b>: €<?=(!empty($project->project_financial_needs)?$project->project_financial_needs:0)?>
                    </div>
                    <div id="notes_list">
                        <b><?_trans('project_description')?></b>: <?=$project->project_description?>

                    </div>

                </div>
            </div>


            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('total_numbers'); ?>
                </div>
                <div class="panel-body">
                    <div id="notes_list">
                        <b><?_trans('total_expenses')?></b>: $<?=$sum_expenses['dollar']?>
                    </div>
                    <div id="notes_list">
                        <b><?_trans('total_expenses')?></b>: €<?=$sum_expenses['euro']?>
                    </div>

                </div>
            </div>

            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('domain_names'); ?>
                </div>
                <div class="panel-body">

                    <? foreach ($website_access as $domain): ?>
                        <div>
                            <b><?=$domain->website_access_domain_name?></b>
                        </div>
                    <? endforeach; ?>

                </div>
            </div>


        </div>
        <form action="<?php echo site_url('projects/view/' . $project->project_id); ?>" method = "get" name="form-tasks" id="form-tasks">

        <div class="col-xs-12 col-md-8">



            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('appointments'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th><?php _trans('appointment_title'); ?></th>
                                <th><?php _trans('appointment_date'); ?></th>
                                <th><?php _trans('appointment_kilometers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($appointments as $appointment) { ?>

                                    <tr>



                                        <td>
                                            <label><?= htmlsc($appointment->appointment_id)?></label>
                                        </td>
                                        <td>
                                            <label class="container-checkbox"><?= htmlsc($appointment->appointment_title)?>
                                            <?php if($appointment->appointment_invoice_kilometer_checked == 1){ ?>
                                                <input type="checkbox" name="appointment_id[]" value="<?php echo $appointment->appointment_id; ?>">
                                                <span class="checkmark"></span>
                                            <?php } ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label><?= date('Y-m-d', strtotime($appointment->created_date))?></label>
                                        </td>
                                        <td>
                                            <label><?= htmlsc($appointment->appointment_kilometers)?></label>
                                        </td>
                                    </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('expenses'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                            <tr>
                                <th><?php _trans('id'); ?></th>
                                <th><?php _trans('expenses_name'); ?></th>
                                <th><?php _trans('user'); ?></th>
                                <th><?php _trans('expenses_category'); ?></th>
                                <th><?php _trans('date'); ?></th>
                                <th><?php _trans('expenses_amount'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($expenses as $expense) { ?>
                                    <tr>
                                        <td>
                                            <label><?= htmlsc($expense->expenses_id)?></label>
                                        </td>
                                        <td>
                                            <label class="container-checkbox"><?= htmlsc($expense->expenses_name)?>
                                                <input type="checkbox" name="expenses_id[]" value="<?php echo $expense->expenses_id; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label><?= htmlsc($expense->user_name)?></label>
                                        </td>
                                        <td>
                                            <label><?= $expense->expenses_category?></label>
                                        </td>
                                        <td>
                                            <label><?= htmlsc($expense->expenses_date)?></label>
                                        </td>
                                        <td>
                                            <label>  <?=($expense->expenses_currency == 'dollar')? '$'.format_amount($expense->expenses_amount) : '€'.format_amount($expense->expenses_amount_euro) ; ?></label>
                                        </td>
                                    </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>



            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php _trans('todo_tickets'); ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped no-margin">
                            <thead>
                                <tr>
                                    <th class="text-center"><?php _trans('id'); ?></th>
                                    <th><?php _trans('todo_task'); ?></th>
                                    <th><?php _trans('todo_task_number_of_hours'); ?></th>
                                    <th><?php _trans('amount'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($todo_tasks as $key => $todo_task) { ?>
                                    <tr>

                                        <td>
                                            <label class="container-checkbox"><?= htmlsc($key+1)?>
                                                <input type="checkbox" name="todo_task_id[]" value="<?= $todo_task->todo_task_id; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label><?= htmlsc($todo_task->todo_task_text)?></label>
                                        </td>
                                        <td>
                                            <label><?= $todo_task->todo_task_number_of_hours?></label>

                                        </td>
                                        <td>
                                            <label><?= format_currency($todo_task->default_hour_rate)?></label>
                                        </td>
                                    </tr>
                            <?php } ?>
                            </tbody>
                        </table>


                        <?php if (empty($todo_tasks)) : ?>
                            <br>
                            <div class="alert alert-info"><?php echo trans('alert_no_tasks_found') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>






            <?php
            if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
                if (USE_QUOTES) {
            ?>
                <button id="btn-submit-tasks" name="btn_submit_tasks" class="btn btn-success" value="create_quote"
                        type="submit" value="submit" form="form-tasks">
                    <i class="fa fa-check"></i> <?php _trans('generate_quote'); ?>
                </button>
            <?php
                }
            ?>
            <button id="btn-submit-tasks" name="btn_submit_tasks" class="btn btn-success pull-right" value="create_invoice"
                    type="submit" value="submit" form="form-tasks">
                <i class="fa fa-check"></i> <?php _trans('generate_invoice'); ?>
            </button>
            <?php
            }
            ?>
        </div>
        </form>
    </div>

</div>

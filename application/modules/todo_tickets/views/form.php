<style>
    .mb-5{
        margin-bottom: 3rem;
    }

    .fa.fa-margin{
        margin: 0;
    }

    .to_do{
        border: solid 1px #e7e7e7;
        padding: 3% 0;
    }

    .panel.panel-default i.fa.fa-trash-o.fa-margin{
        color: #fff;
    }

    .panel-body {
        border: solid 1px #e7e7e7;
        margin-bottom: 3%;
    }

</style>

<input type="hidden" id="last_task_id_in_table" value="<?php echo $last_task_id_in_table; ?>">

<form method="post" enctype="multipart/form-data" id="ticket-form">
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('ticket_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if ($this->mdl_todo_tickets->form_value('todo_ticket_id')) : ?>
                            <?php echo $this->mdl_todo_tickets->form_value('todo_ticket_id'); ?>&nbsp;
                            <?php echo $this->mdl_todo_tickets->form_value('todo_ticket_name', true); ?>
                        <?php else : ?>
                            <?php _trans('new_ticket'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="todo_ticket_number"><?php _trans('id'); ?></label>
                            <input type="text" name="todo_ticket_number" id="todo_ticket_number" class="form-control"
                                   value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_number', true); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="todo_ticket_category"><?php _trans('category'); ?></label>
                            <input type="text" name="todo_ticket_category" id="todo_ticket_category" class="form-control"
                                   value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_category', true); ?>" >
                        </div>

                        <div class="form-group">
                            <label for="todo_ticket_description"><?php _trans('title'); ?></label>
                            <input type="text" name="todo_ticket_description" id="todo_ticket_description" class="form-control"
                                   value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_description', true); ?>" >

                        </div>
                        <div class="form-group">
                            <label for="todo_ticket_status"><?php _trans('status'); ?></label>
                            <select name="todo_ticket_status" id="todo_ticket_status" class="form-control simple-select" <?=($allow_edit ==  false && $this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id') == $this->session->userdata('user_id'))? 'disabled' : '' ; ?>>
                                <?php foreach ($ticket_statuses as $key => $status) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php check_select($key, $this->mdl_todo_tickets->form_value('todo_ticket_status')); ?>>
                                        <?php echo $status['label']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">



                            <label for="todo_ticket_assigned_user_id"><?php _trans('assign_to'); ?>: </label>
                            <select name="todo_ticket_assigned_user_id" id="todo_ticket_assigned_user_id" class="form-control simple-select" <?=($allow_edit ==  false )? 'disabled' : '' ; ?> <?= ( $this->session->userdata('user_type') == TYPE_MANAGERS )?'disabled':'' ?>>
                                <?php
                                if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
                                ?>
                                <option value=""><?php _trans('select_user'); ?></option>
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?php echo $user->user_id; ?>"
                                        <?php check_select($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id'), $user->user_id); ?>  >
                                        <?php echo htmlspecialchars($user->user_name); ?>
                                    </option>
                                <?php }
                                }
                                else {
                                ?>
                                <option value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id'); ?>"
                                    <?php check_select($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id'), $this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id')); ?>>
                                    <?php echo htmlspecialchars($this->mdl_todo_tickets->form_value('ticket_assigned_user_name')); ?>
                                    <?=$this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id')?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="todo_ticket_assigned_manager_id"><?php _trans('assign_to'); ?>: <?php _trans('manager'); ?></label>
                            <select name="todo_ticket_assigned_manager_id" id="todo_ticket_assigned_manager_id" class="form-control simple-select" <?=($allow_edit ==  false )? 'disabled' : '' ; ?> <?= ($this->session->userdata('user_type') != TYPE_ADMIN)? 'disabled':''?>>
                                <option value=""><?php _trans('select_manager'); ?></option>
                                <?php foreach ($mangers as $manger) { ?>
                                    <option value="<?php echo $manger->user_id; ?>"
                                        <?php check_select($this->mdl_todo_tickets->form_value('todo_ticket_assigned_manager_id'), $manger->user_id); ?>>
                                        <?php echo htmlspecialchars($manger->user_name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="todo_ticket_number_of_hours_managers"><?php _trans('number_of_hours_managers'); ?>:</label>
                            <input type="text" name="todo_ticket_number_of_hours_managers" id="todo_ticket_number_of_hours_managers" class="form-control"
                                   value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_number_of_hours_managers', true); ?>" <?=($allow_edit ==  false )? 'readonly' : '' ; ?>>
                        </div>

                        <div class="form-group">
                            <label for="todo_ticket_assigned_user_group_id"><?php _trans('assign_group'); ?>: </label>
                            <select name="todo_ticket_assigned_user_group_id" id="todo_ticket_assigned_user_group_id" class="form-control simple-select" <?=($this->session->userdata('user_type') != TYPE_ADMIN && $this->session->userdata('user_type') != TYPE_MANAGERS) ? 'disabled' :''?>>
                                <?php
                                if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
                                ?>
                                <option value=""><?php _trans('select_group'); ?></option>
                                <?php foreach ($user_groups as $user_group) { ?>
                                    <option value="<?php echo $user_group->group_id; ?>"
                                        <?php check_select($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_group_id'), $user_group->group_id); ?>>
                                        <?php echo htmlspecialchars($user_group->group_name); ?>
                                    </option>
                                <?php }
                                }else{
                                    foreach ($user_groups as $user_group) {
                                ?>
                                    <option value="<?php echo $user_group->group_id; ?>"
                                        <?php check_select($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_group_id'), $user_group->group_id); ?>>
                                        <?php echo htmlspecialchars($user_group->group_name); ?>
                                    </option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="todo_ticket_created_user_id"><?php _trans('todo_created_by'); ?></label>
                            <input type="text" name="todo_ticket_created_user_id" id="todo_ticket_created_user_id" class="form-control"
                                   value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_created_user_name', true); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="todo_ticket_insert_time"><?php _trans('todo_insert_time'); ?></label>
                            <input type="text" name="todo_ticket_insert_time" id="todo_ticket_insert_time" class="form-control"
                                   value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_insert_time', true); ?>" readonly>
                        </div>


                        <div class="form-group ticket_file" >
                            <div class="col-xs-12">
                                <label for="ticket_document_link"><?php _trans('attachment'); ?></label>
                            </div>

                            <div class="col-xs-12">
                                <div class="col-xs-10 col-sm-10 no-padding">
                                    <input type="text" name="ticket_document_link" id="ticket_document_link" class="form-control ticket_document_link" readonly value="<?php echo $this->mdl_todo_tickets->form_value('ticket_document_link', true); ?>" >
                                </div>
                                <div class="col-xs-2 col-sm-2" style="padding-right:0 !important" >
                                    <input type="hidden" name="todo_ticket_number_of_hours"  class="form-control" value="<?php echo $this->mdl_todo_tickets->form_value('todo_ticket_number_of_hours', true); ?>" >
                                    <input type="button" id="loadFile"  class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php _trans('attachments'); ?>"  <?=($allow_edit ==  false )? '' : 'onclick="get_file_url_ticket(this)"' ; ?>  />
                                    <input type="file" style="display:none;"  id="ticket_file" name="ticket_file" accept=".jpeg, .jpg, .png, .pdf, .csv, .xlsx, .xml" onchange="save_url_ticket(this)"/>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        <?php if (!is_null($this->mdl_todo_tickets->form_value('todo_ticket_url_key', false)) && !empty($this->mdl_todo_tickets->form_value('todo_ticket_url_key', false))) { ?>
                            <div class="form-group" >
                                <label for="invoice-guest-url"><?php _trans('guest_url'); ?></label>
                                <div class="input-group">
                                    <input type="text" id="invoice-guest-url" name="todo_ticket_url_key" readonly class="form-control"
                                           value="<?php echo site_url('guest/view/todo_ticket/' .$this->mdl_todo_tickets->form_value('todo_ticket_url_key', false)) ?>">
                                        <span class="input-group-addon to-clipboard cursor-pointer"
                                          data-clipboard-target="#invoice-guest-url">
                                              <i class="fa fa-clipboard fa-fw"></i>
                                        </span>
                                </div>
                            </div>
                        <?php } ?>



                    </div>






                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('invoice'); ?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_name" class="control-label"><?php _trans('name'); ?></label>
                            </div>
                            <div class="col-xs-12">
                                <input type="text" name="expenses_name" id="expenses_name" class="form-control"
                                       value="<?=(!empty($expenses->expenses_name))?$expenses->expenses_name:''?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="todo_ticket_phone_number" class="control-label"><?php _trans('phone_number'); ?></label>
                            </div>

                            <div class="col-xs-12 ">
                                <input type="text" name="todo_ticket_phone_number" id="todo_ticket_phone_number" class="form-control"
                                       value="<?=$this->mdl_todo_tickets->form_value('todo_ticket_phone_number')?>"
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="todo_ticket_email_address" class="control-label"><?php _trans('email_address'); ?></label>
                            </div>

                            <div class="col-xs-12 ">
                                <input type="text" name="todo_ticket_email_address" id="todo_ticket_email_address" class="form-control"
                                       value="<?=$this->mdl_todo_tickets->form_value('todo_ticket_email_address')?>"
                            </div>
                        </div>  


                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_category" class="control-label"><?php _trans('category'); ?></label>
                            </div>

                            <div class="col-xs-12 ">
                                <input type="text" name="expenses_category" id="expenses_category" class="form-control"
                                       value="<?=(!empty($expenses->expenses_category))?$expenses->expenses_category:''?>"
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_project_id"><?php _trans('project'); ?>: </label>
                            </div>
                            <div class="col-xs-12 ">
                                <select name="expenses_project_id" id="expenses_project_id" class="form-control simple-select">
                                    <option value=""><?php _trans('select_project'); ?></option>
                                    <?php foreach ($projects as $project) { ?>

                                        <?php if(!empty($expenses->expenses_project_id)): ?>
                                            <option value="<?=$project->project_id; ?>"
                                                <?php check_select($expenses->expenses_project_id, $project->project_id); ?>>
                                                <?=htmlspecialchars($project->project_name); ?>
                                            </option>
                                        <?php else: ?>
                                            <option value="<?=$project->project_id; ?>" >
                                                <?=htmlspecialchars($project->project_name); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_user_id">
                                    <?php _trans('user'); ?>
                                </label>
                            </div>
                            <div class="col-xs-12 ">
                                <select name="expenses_user_id" id="expenses_user_id" class="form-control simple-select" >
                                    <option value="" >
                                        <?= _trans('no_selected')?>
                                    </option>

                                    <?php foreach ($users as $user) { ?>
                                    <?php if(!empty($user->expenses_user_id)): ?>
                                            <option value="<?php echo $user->user_id; ?>"
                                                <?php check_select($user->user_id, $expenses->expenses_user_id);?>>
                                                <?=$user->user_name;?>
                                            </option>
                                    <?php else: ?>
                                            <option value="<?php echo $user->user_id; ?>" >
                                                <?=$user->user_name;?>
                                            </option>
                                    <?php endif; ?>


                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <div class="col-xs-12">
                                <label for="expenses_date" class="control-label"><?php _trans('date'); ?></label>
                            </div>
                            <div class="col-xs-12 ">
                                <div class="input-group">
                                    <input name="expenses_date" id="expenses_date"
                                           class="form-control datepicker"
                                           value=" <?= (!empty($expenses->expenses_date))?date_from_mysql($expenses->expenses_date):'' ?> " >
                                    <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_currency"><?php _trans('currency'); ?>: </label>
                            </div>
                            <div class="col-xs-12 ">
                                <select name="expenses_currency" id="expenses_currency" class="form-control simple-select">
                                    <?php if(!empty($expenses->expenses_currency) && $expenses->expenses_currency == 'dollar'):?>
                                        <option value="dollar"  selected>$</option>
                                        <option value="euro" >€</option>
                                    <?php else:?>
                                        <option value="dollar">$</option>
                                        <option value="euro" selected>€</option>
                                    <?php endif;?>


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_amount_euro" class="control-label"><?php _trans('amount'); ?></label>
                            </div>
                            <div class="col-xs-12 ">
                                <div class="input-group">
                                    <input type="number" min="0" step="0.01" name="expenses_amount_euro" id="expenses_amount_euro" class="form-control"
                                           value="<?=(!empty($expenses->expenses_amount_euro))?$expenses->expenses_amount_euro:''?>">
                                    <div class="input-group-addon">
                                        <?php echo get_setting('currency_symbol') ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_amount" class="control-label"><?php _trans('amount'); ?></label>
                            </div>
                            <div class="col-xs-12 ">
                                <div class="input-group">
                                    <input type="number" min="0" step="0.01" name="expenses_amount" id="expenses_amount" class="form-control"
                                           value="<?=(!empty($expenses->expenses_amount))?$expenses->expenses_amount:''?>">
                                    <div class="input-group-addon">
                                        $
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="expenses_notes" class="control-label"><?php _trans('notes'); ?></label>
                            </div>
                            <div class="col-xs-12">
                                <textarea name="expenses_notes" class="form-control"><?=(!empty($expenses->expenses_notes))?$expenses->expenses_notes:''?></textarea>
                            </div>

                        </div>


                        <div class="form-group expenses_file" >
                            <div class="col-xs-12">
                                <label for="expenses_document_link"><?php _trans('expenses_document_link'); ?></label>
                            </div>

                            <div class="col-xs-12">
                                <div class="col-xs-10 col-sm-10 no-padding">
                                    <input type="text" name="expenses_document_link" id="expenses_document_link" class="form-control expenses_document_link" readonly value="<?= (!empty($expenses->expenses_document_link))? $expenses->expenses_document_link:''; ?>" >
                                </div>
                                <div class="col-xs-2 col-sm-2" style="padding-right:0 !important" >
                                    <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php _trans('attachments'); ?>" onclick="get_file_url_expenses(this)" />
                                    <input type="file" style="display:none;"  id="expenses_file" name="expenses_file" accept=".jpeg, .jpg, .png, .pdf, .csv, .xlsx, .xml" onchange="save_url_expenses(this)"/>

                                </div>
                            </div>
                        </div>



                        <input type="hidden" name="expenses_id" value="<?=(!empty($expenses->expenses_id))? $expenses->expenses_id: ''; ?>">
                    </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php _trans('extra_information'); ?></div>


            <div class="form-group mb-5">
                <hr>
                <div class="col-xs-12 text-right">
                    <button class="btn btn-primary add_to_do_task" type="button">+ <?php _trans('add_to_do_tickets'); ?></button>
                </div>
                <div class="clearfix"></div>
            </div>


            <div class="todo_block">
                <?php

                if(!empty($to_do_tasks )){
                    foreach ($to_do_tasks  as $key => $to_do_task) { ?>
                        <div class="panel-body">
                            <input type="hidden" name="todo_ticket_todo_task_id[]" value="<?= (!empty($to_do_task->todo_ticket_todo_task_id)?$to_do_task->todo_ticket_todo_task_id: $key+1)?>" >

                            <div class="form-group to_do_task" >
                                <div class="col-xs-12 col-sm">
                                    <label for="to_do_task"><?php _trans('todo_task'); ?></label>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="col-xs-11 col-sm-11 no-padding">
                                        <input type="text" name="todo_task_text[]" id="to_do_task" class="form-control to_do_task" value="<?=$to_do_task->todo_task_text?>">
                                    </div>
                                    <div class="col text-right" style="padding-right:0 !important" >
                                        <button class="btn btn-danger to_do_task_delete" data-id="<?=$to_do_task->todo_task_id ?>" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </div>



                            <div class="form-group">
                                <div class="col-xs-12 text-left-xs">
                                    <label for="todo_task_project_id"><?php _trans('project'); ?>: </label>
                                </div>
                                <div class="col-xs-12">
                                    <select name="todo_task_project_id[]" id="todo_task_project_id" class="form-control simple-select">
                                        <option value=""><?php _trans('select_project'); ?></option>
                                        <?php foreach ($projects as $project) { ?>
                                            <option value="<?=$project->project_id; ?>"
                                                <?php check_select($to_do_task->todo_task_project_id, $project->project_id); ?>>
                                                <?=htmlspecialchars($project->project_name); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group" >
                                <div class="col-xs-12 col-sm">
                                    <label for="todo_task_created_date"><?php _trans('created_date'); ?></label>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <input type="date" name="todo_task_created_date[]" id="to_do_task" class="form-control" value="<?=$to_do_task->todo_task_created_date; ?>" readonly>
                                </div>
                                <div class="clearfix"></div>
                            </div>



                            <div class="form-group">
                                <div class="col-xs-12 text-left-xs">
                                    <label for="todo_task_number_of_hours"><?php _trans('todo_task_number_of_hours'); ?>: </label>
                                </div>
                                <div class="col-xs-12 time_block">



                                    <?php if(!empty($to_do_task->todo_task_number_of_hours)){ $time = explode(':',$to_do_task->todo_task_number_of_hours); }?>
                                    <?php if(!empty($to_do_task->todo_task_number_of_hours_manager)){ $time_manager = explode(':',$to_do_task->todo_task_number_of_hours_manager); }?>


                                    <?php if($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id') == $this->session->userdata('user_id')): ?>

                                        <?php if($to_do_task->todo_task_number_of_hours != '00:00'){ ?>
                                            <div class="col-md-3">
                                                <div><?php _trans('hours'); ?></div>
                                                <input type="text" class="hourse" value="<?= $time[0]?>">
                                            </div>
                                            <div class="col-md-3">
                                                <div><?php _trans('minutes'); ?></div>
                                                <input type="text" class="minute" value="<?=$time[1]?>">
                                            </div>

                                            <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours; ?>" >
                                            <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours_manager; ?>" >
                                        <?php }else{ ?>
                                            <?php if($to_do_task->todo_task_number_of_hours_manager != '0:00'){ ?>
                                                <div class="col">
                                                    <label for=""><?php _trans('suggestion_manager'); ?> <b><?=$to_do_task->todo_task_number_of_hours_manager; ?></b></label>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-success manager_time_accepted" type="button" value="<?=$to_do_task->todo_task_id?>"><?php _trans('accepted'); ?></button>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-danger manager_time_declined" type="button"><?php _trans('declined'); ?></button>
                                                </div>
                                                <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >
                                                <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours_manager; ?>" >


                                            <?php }else{ ?>
                                                <div class="col-md-3">
                                                    <div><?php _trans('hours'); ?></div>
                                                    <input type="text" class="hourse" value="<?= $time[0]?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <div><?php _trans('minutes'); ?></div>
                                                    <input type="text" class="minute" value="<?=$time[1]?>">
                                                </div>

                                                <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours; ?>" >

                                            <?php } ?>

                                        <?php } ?>





                                    <?php else: ?>
                                        <!--If login manager, that user when assigned manager-->
                                        <?php if($to_do_task->todo_task_number_of_hours != '00:00'){ ?>
                                            <!--IF isset estimate user -->
                                            <div class="col-md-3">
                                                <div><?php _trans('hours'); ?></div>
                                                <input type="text" class="hourse" value="<?= $time[0]?>" <?= ($this->session->userdata('user_type') == TYPE_ADMIN)?'disabled':''?>>
                                            </div>
                                            <div class="col-md-3">
                                                <div><?php _trans('minutes'); ?></div>
                                                <input type="text" class="minute" value="<?=$time[1]?>"  <?= ($this->session->userdata('user_type') == TYPE_ADMIN)?'disabled':''?>>
                                            </div>

                                            <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours; ?>" >
                                            <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours_manager; ?>" >

                                        <?php }else{ ?>
                                            <!--IF empty estimate user -->
                                            <div class="col-md-3">
                                                <div><?php _trans('hours'); ?>  </div>
                                                <input type="text" class="hours_manager" value="<?=$time_manager[0]?>">
                                            </div>
                                            <div class="col-md-3">
                                                <div><?php _trans('minutes'); ?></div>
                                                <input type="text" class="minute_manager" value="<?=$time_manager[1]?>">
                                            </div>

                                            <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >
                                            <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="<?=$to_do_task->todo_task_number_of_hours_manager; ?>" >

                                        <?php } ?>

                                    <?php endif; ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) { ?>
                                <div class="form-group" style="padding: 0 15px">
                                    <label for="todo_task_deadline"><?php _trans('deadline'); ?></label>
                                    <div class="input-group">
                                        <input name="todo_task_deadline[]" id="todo_task_deadline" class="form-control datepicker"
                                               value="<?=$to_do_task->todo_task_deadline; ?>">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group todo_task_file">

                                <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                    <label for="todo_task_document_link"><?php _trans('attachment'); ?></label>
                                    <input type="text" name="todo_task_document_link[]" id="todo_task_document_link" class="form-control todo_task_document_link" readonly  value="<?=$to_do_task->todo_task_document_link; ?>">
                                </div>
                                <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                    <label for="todo_task_document_link">&nbsp;</label>
                                    <br />
                                    <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                                    <input type="file" style="display:none;"  id="todo_task_file" name="todo_task_file[]" accept=".jpeg, .jpg, .png, .pdf, .csv, .xlsx, .xml" onchange="save_url(this)"/>

                                </div>
                            </div>
                            <input type="hidden" name="todo_task_id[]" value="<?= (!empty($to_do_task->todo_task_id)?$to_do_task->todo_task_id:'')?>" >
                        </div>
                        <?php
                    }
                }else{ ?>

                    <div class="panel-body">
                        <input type="hidden" name="todo_ticket_todo_task_id[]" value="1" >

                        <div class="form-group to_do_task" >
                            <div class="col-xs-12 col-sm">
                                <label for="to_do_task"><?php _trans('todo_task'); ?></label>
                            </div>

                            <div class="col-xs-12 col-sm-12">
                                <div class="col-xs-11 col-sm-11 no-padding">
                                    <input type="text" name="todo_task_text[]" id="to_do_task" class="form-control to_do_task" value="">
                                </div>
                                <div class="col text-right" style="padding-right:0 !important" >
                                    <button class="btn btn-danger to_do_task_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>



                        <div class="form-group">
                            <div class="col-xs-12 text-left-xs">
                                <label for="todo_task_project_id"><?php _trans('project'); ?>: </label>
                            </div>
                            <div class="col-xs-12">
                                <select name="todo_task_project_id[]" id="todo_task_project_id" class="form-control simple-select">
                                    <option value=""><?php _trans('select_project'); ?></option>
                                    <?php foreach ($projects as $project) { ?>
                                        <option value="<?=$project->project_id; ?>">
                                            <?=htmlspecialchars($project->project_name); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group" >
                            <div class="col-xs-12 col-sm">
                                <label for="todo_task_created_date"><?php _trans('created_date'); ?></label>
                            </div>

                            <div class="col-xs-12 col-sm-12">
                                <input type="date" name="todo_task_created_date[]" id="to_do_task" class="form-control" value="<?=date('Y-m-d'); ?>" readonly>
                            </div>

                            <div class="clearfix"></div>
                        </div>


                        <div class="form-group">
                            <div class="col-xs-12 text-left-xs">
                                <label for="todo_task_number_of_hours"><?php _trans('todo_task_number_of_hours'); ?>: </label>
                            </div>
                            <?php if ($this->mdl_todo_tickets->form_value('todo_ticket_assigned_manager_id') == $this->session->userdata('user_id') && $this->mdl_todo_tickets->form_value('todo_task_number_of_hours') == null){
                                ?>
                                <div class="col-xs-12 time_block">
                                    <div class="col-md-3">
                                        <div><?php _trans('hours'); ?>  </div>
                                        <input type="text" class="hours_manager" value="">
                                    </div>
                                    <div class="col-md-3">
                                        <div><?php _trans('minutes'); ?></div>
                                        <input type="text" class="minute_manager" value="">
                                    </div>

                                    <input type="" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="00:00" >
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-xs-12 time_block">

                                <?php if($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id') == $this->session->userdata('user_id')): ?>


                                    <div class="col-md-3">
                                        <div><?php _trans('hours'); ?>  </div>
                                        <input type="text" class="hourse" value="">
                                    </div>
                                    <div class="col-md-3">
                                        <div><?php _trans('minutes'); ?></div>
                                        <input type="text" class="minute" value="">
                                    </div>

                                    <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >

                                <?php else: ?>

                                    <div class="col-md-3">
                                        <div><?php _trans('hours'); ?>  </div>
                                        <input type="text" class="hourse" value="" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <div><?php _trans('minutes'); ?></div>
                                        <input type="text" class="minute" value="" disabled>
                                    </div>

                                    <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >

                                <?php endif; ?>









                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) { ?>
                            <div class="form-group" style="padding: 0 15px">
                                <label for="todo_task_deadline"><?php _trans('deadline'); ?></label>
                                <div class="input-group">
                                    <input name="todo_task_deadline[]" id="todo_task_deadline" class="form-control datepicker"
                                           value="">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!--ATTACHMENT-->

                        <div class="form-group todo_task_file">

                            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
                                <label for="todo_task_document_link"><?php _trans('attachment'); ?></label>
                                <input type="text" name="todo_task_document_link[]" id="todo_task_document_link" class="form-control todo_task_document_link" readonly  value="">
                            </div>
                            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
                                <label for="todo_task_document_link">&nbsp;</label>
                                <br />
                                <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
                                <input type="file" style="display:none;"  id="todo_task_file" name="todo_task_file[]" accept=".jpeg, .jpg, .png, .pdf, .csv, .xlsx, .xml" onchange="save_url(this)"/>

                            </div>
                        </div>




                        <input type="hidden" name="todo_task_id[]" value="" >

                    </div   >

                <?php }  ?>
            </div>


        </div>
    </div>

</form>


<script>

    var time = '';
    var minute = '';
    var hourse = '';


    $(document).on('input', '.hourse', function(){
         hourse = $(this).val();
        minute = $(this).parents('.time_block').find('.minute').val();


        if(minute.length < 2){
            minute  =  '0'+minute
        }
        if(hourse.length < 2){
            hourse  =  '0'+hourse
        }
        if(hourse.length >= 3 && hourse[0]==0 ){
            hourse =hourse.substring(1, hourse);
        }
        if(minute.length >= 3 && minute[0]==0 ){
            minute =minute.substring(1, minute);
        }




        if(minute !== ''){
            time  = hourse + ':' + minute
        }else{
            time  = hourse + ':' + '00'
        }

        // $(this).parent().find('#todo_task_number_of_hours').val(time);
        $(this).parents('.time_block').find('#todo_task_number_of_hours').val(time);
        $(this).parents('.time_block').find('#todo_task_number_of_hours_manager').val(time);

    });

    $(document).on('input', '.minute', function(){
       if($(this).val() > 59){
           $(this).val(59)
       }
    })

    $(document).on('input', '.minute', function(){
        minute = $(this).val();
        hourse = $(this).parents('.time_block').find('.hourse').val()

        if(minute.length < 2){
            minute  =  '0'+minute
        }
        if(hourse.length < 2){
            hourse  =  '0'+hourse
        }
        if(hourse.length >= 3 && hourse[0]==0 ){
            hourse =hourse.substring(1, hourse);
        }
        if(minute.length >= 3 && minute[0]==0 ){
            minute =minute.substring(1, minute);
        }






        if(hourse !== ''){
            time  = hourse + ':' + minute
        }else{
            time  = '00' + ':'+ minute
        }

        $(this).parents('.time_block').find('#todo_task_number_of_hours').val(time);
        $(this).parents('.time_block').find('#todo_task_number_of_hours_manager').val(time);

    });

    /*manager time*/
    var time_manager = '';
    var minute_manager = '';
    var hours_manager = '';


    $(document).on('input', '.hours_manager', function(){
         hours_manager = $(this).val();
        minute_manager = $(this).parents('.time_block').find('.minute_manager').val();


        if(minute_manager.length < 2){
            minute_manager  =  '0'+minute_manager
        }
        if(hours_manager.length < 2){
            hours_manager  =  '0'+hours_manager
        }


        if(hours_manager.length >= 3 && hours_manager[0] == 0 ){
            hours_manager =hours_manager.substring(1, hours_manager);
        }
        if(minute_manager.length >= 3 && minute_manager[0]==0 ){
            minute_manager =minute_manager.substring(1, minute_manager);
        }




        if(minute_manager !== ''){
            time_manager  = hours_manager + ':' + minute_manager
        }else{
            time_manager  = hours_manager + ':' + '00'
        }

        // $(this).parent().find('#todo_task_number_of_hours').val(time);
        $(this).parents('.time_block').find('#todo_task_number_of_hours_manager').val(time_manager);

    });

    $(document).on('input', '.minute_manager', function(){
       if($(this).val() > 59){
           $(this).val(59)
       }
    })

    $(document).on('change', '.minute_manager', function(){
        minute_manager = $(this).val();
        hours_manager = $(this).parents('.time_block').find('.hours_manager').val()

        if(minute_manager.length < 2){
            minute_manager  =  '0'+minute_manager
        }
        if(hours_manager.length < 2){
            hours_manager  =  '0'+hours_manager
        }
        if(hours_manager.length >= 3 && hours_manager[0]==0 ){
            hours_manager =hours_manager.substring(1, hours_manager);
        }
        if(minute_manager.length >= 3 && minute_manager[0]==0 ){
            minute_manager =minute_manager.substring(1, minute_manager);
        }






        if(hours_manager !== ''){
            time_manager  = hours_manager + ':' + minute_manager

        }else{
            time_manager  = '00' + ':'+ minute_manager
            console.log(2222,time_manager)

        }


        $(this).parents('.time_block').find('#todo_task_number_of_hours_manager').val(time_manager);
    });


function get_file_url_ticket(_this = null){
        $(_this).parents('.ticket_file').find('#ticket_file').click()
    }

    function save_url_ticket(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.ticket_file').find('.ticket_document_link').val(pdf_url)
    }


    function get_file_url_expenses(_this = null){
        $(_this).parents('.expenses_file').find('#expenses_file').click()
    }

    function save_url_expenses(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.expenses_file').find('.expenses_document_link').val(pdf_url)
    }



    function get_file_url(_this = null){
        $(_this).parents('.todo_task_file').find('#todo_task_file').click()
    }

    function save_url(_this = null){

        var pdf_url = $(_this).val();
        $(_this).parents('.todo_task_file').find('.todo_task_document_link').val(pdf_url)
    }


    $(document).on('click', '.add_to_do_task', function () {

        var todo_block_count = $('.todo_block .panel-body').length
        // var last_task_id_in_table = $('#last_task_id_in_table').val();
        // $('#last_task_id_in_table').(last_task_id_in_table + 1);
        var elm_amount = `<div class="panel-body">
                                    <input type="hidden" name="todo_ticket_todo_task_id[]" value="${todo_block_count+1}" >
                                <div class="form-group to_do_task" >
                                    <div class="col-xs-12 col-sm">
                                        <label for="to_do_task"><?php _trans('todo_task'); ?></label>
                                    </div>

                                    <div class="col-xs-12 col-sm-12">
                                        <div class="col-xs-11 col-sm-11 no-padding">
                                            <input type="text" name="todo_task_text[]" id="to_do_task" class="form-control to_do_task" value="">
                                        </div>
                                        <div class="col text-right" style="padding-right:0 !important" >
                                            <button class="btn btn-danger to_do_task_delete" style="cursor:pointer;margin-left:5px">  <i class="fa fa-trash-o fa-margin"></i>  </button>

                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>



                                    <div class="form-group">
                                        <div class="col-xs-12 text-left-xs">
                                            <label for="todo_task_project_id"><?php _trans('project'); ?>: </label>
                                        </div>
                                        <div class="col-xs-12">
                                            <select name="todo_task_project_id[]" id="todo_task_project_id" class="form-control simple-select">
                                                <option value=""><?php _trans('select_project'); ?></option>
                                                <?php foreach ($projects as $project) { ?>
                                                    <option value="<?=$project->project_id; ?>">
                                                        <?=htmlspecialchars($project->project_name); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                <div class="form-group" >
                                    <div class="col-xs-12 col-sm">
                                        <label for="todo_task_created_date"><?php _trans('created_date'); ?></label>
                                    </div>

                                    <div class="col-xs-12 col-sm-12">
                                        <input type="date" name="todo_task_created_date[]" id="to_do_task" class="form-control" value="<?=date('Y-m-d'); ?>" readonly>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>

                                    <div class="form-group">
                                        <div class="col-xs-12 text-left-xs">
                                            <label for="todo_task_number_of_hours"><?php _trans('todo_task_number_of_hours'); ?>: </label>
                                        </div>
                                        <div class="col-xs-12 time_block">

                                      <?php if($this->mdl_todo_tickets->form_value('todo_ticket_assigned_user_id') == $this->session->userdata('user_id')): ?>


                                            <div class="col-md-3">
                                                <div><?php _trans('hours'); ?>  </div>
                                                <input type="text" class="hourse" value="">
                                            </div>
                                            <div class="col-md-3">
                                                <div><?php _trans('minutes'); ?></div>
                                                <input type="text" class="minute" value="">
                                            </div>

                                            <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >
                                            <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="0:00" >

                                        <?php else: ?>

                                            <div class="col-md-3">
                                                <div><?php _trans('hours'); ?>  </div>
                                                <input type="text" class="hourse" value="" disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <div><?php _trans('minutes'); ?></div>
                                                <input type="text" class="minute" value="" disabled>
                                            </div>

                                             <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >
                                             <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="0:00" >


                                        <?php endif; ?>




                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) { ?>
                                             <div class="form-group" style="padding: 0 15px">
                                                <label for="todo_task_deadline"><?php _trans('deadline'); ?></label>
                                                <div class="input-group">
                                                    <input name="todo_task_deadline[]" id="todo_task_deadline" class="form-control datepicker"
                                                           value="">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar fa-fw"></i>
                                                    </div>
                                                </div>
                                            </div>
                                         <?php } ?>
 <!--ATTACHMENT-->

            <div class="form-group todo_task_file">

            <div class="col-xs-10 col-md-10 col-lg-10 no-padding">
            <label for="todo_task_document_link"><?php _trans('attachment'); ?></label>
            <input type="text" name="todo_task_document_link[]" id="todo_task_document_link" class="form-control todo_task_document_link" readonly  value="">
            </div>
            <div class="col-xs-2 col-md-2 col-lg-2" style="padding-right:0 !important">
            <label for="todo_task_document_link">&nbsp;</label>
            <br />
            <input type="button" id="loadFile" class="btn btn-success col-xs-12 col-md-12 col-lg-12" value="<?php _trans('attachments'); ?>" onclick="get_file_url(this)" />
            <input type="file" style="display:none;"  id="todo_task_file" name="todo_task_file[]" accept=".jpeg, .jpg, .png, .pdf, .csv, .xlsx, .xml" onchange="save_url(this)"/>

            </div>
            </div>

                                <input type="hidden" name="todo_task_id[]" value="" >

                            </div>`;

        $('.todo_block').prepend(elm_amount);

    });


    $(document).on('click', '.to_do_task_delete', function () {
        $(this).parents('.panel-body').remove();

        var todo_task_id = $(this).data('id')
        $.ajax({
            url:"../../todo_tickets/todo_task_delete",
            type:'post',
            data:{todo_task_id:todo_task_id},

            success: function(data) {

                console.log(data)
                // window.location.href='http://spudu.loc/index.php/invoices/download_pdf_zip'
            }
        });
    })


    $(document).on('input','input[name="todo_task_number_of_hours[]"]', function () {
        var _this = $(this)
        var time = _this.val();

            console.log(hourses)
    })

    $(document).on('input','input[name="todo_task_number_of_hours_manager[]"]', function () {
        var _this = $(this)
        var time = _this.val();

            console.log(hourses)
    })


    $(document).on('click','.manager_time_accepted', function () {
        var _this = this;
        var task_id = $(this).val();
        var parent = $(_this).parents('.time_block');

        $(_this).parents('.time_block').empty();


        $.ajax({
            url:"../../todo_tickets/accepted_suggestion_time_manager",
            type:'post',
            data:{todo_task_id:task_id},

            success: function(data) {
               var hours_manager =data.split(":")
                parent.append(`<div class="col-md-3">
                            <div><?php _trans('hours'); ?> </div>
                            <input type="text" class="hourse" value="${hours_manager[0]}" disabled>
                        </div>
                        <div class="col-md-3">
                            <div><?php _trans('minutes'); ?></div>
                            <input type="text" class="minute" value="${hours_manager[1]}" disabled>
                        </div>

                        <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="${data}" >
                        <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="${data}" >`
                );
                console.log(data)
                // window.location.href='http://spudu.loc/index.php/invoices/download_pdf_zip'
            }
        });
    })

    $(document).on('click','.manager_time_declined', function () {
        var _this = this;
        var parent = $(_this).parents('.time_block');
        $(_this).parents('.time_block').empty();
        parent.append(`<div class="col-md-3">
                            <div><?php _trans('hours'); ?> </div>
                            <input type="text" class="hourse" value="00">
                        </div>
                        <div class="col-md-3">
                            <div><?php _trans('minutes'); ?></div>
                            <input type="text" class="minute" value="00">
                        </div>

                        <input type="hidden" name="todo_task_number_of_hours[]" id="todo_task_number_of_hours" class="form-control" min="0" value="00:00" >
                        <input type="hidden" name="todo_task_number_of_hours_manager[]" id="todo_task_number_of_hours_manager" class="form-control" min="0" value="0:00" >`)
    })



</script>

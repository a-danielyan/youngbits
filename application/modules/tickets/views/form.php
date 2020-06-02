<form method="post" enctype="multipart/form-data" id="ticket-form">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

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
                        <?php if ($this->mdl_tickets->form_value('ticket_id')) : ?>
                            #<?php echo $this->mdl_tickets->form_value('ticket_id'); ?>&nbsp;
                            <?php echo $this->mdl_tickets->form_value('ticket_name', true); ?>
                        <?php else : ?>
                            <?php _trans('new_ticket'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="ticket_number"><?php _trans('ticket_number'); ?></label>
                            <input type="text" name="ticket_number" id="ticket_number" class="form-control"
                                   value="<?php echo $this->mdl_tickets->form_value('ticket_number', true); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ticket_name"><?php _trans('ticket_name'); ?></label>
                            <input type="text" name="ticket_name" id="ticket_name" class="form-control"
                                   value="<?php echo $this->mdl_tickets->form_value('ticket_name', true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="ticket_description"><?php _trans('ticket_description'); ?></label>
                            <textarea name="ticket_description" id="ticket_description" class="form-control" rows="3"
                            ><?php echo $this->mdl_tickets->form_value('ticket_description', true); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ticket_status"><?php _trans('status'); ?></label>
                            <select name="ticket_status" id="ticket_status" class="form-control simple-select">
                                <?php foreach ($ticket_statuses as $key => $status) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php check_select($key, $this->mdl_tickets->form_value('ticket_status')); ?>>
                                        <?php echo $status['label']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ticket_assigned_user_id"><?php _trans('assign_to'); ?>: </label>
                            <select name="ticket_assigned_user_id" id="ticket_assigned_user_id" class="form-control simple-select" <?=($this->session->userdata('user_type') != TYPE_ADMIN && $this->session->userdata('user_type') != TYPE_MANAGERS) ? 'disabled' :''?>>
                                <?php
                                if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
                                ?>
                                <option value=""><?php _trans('select_user'); ?></option>
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?php echo $user->user_id; ?>"
                                        <?php check_select($this->mdl_tickets->form_value('ticket_assigned_user_id'), $user->user_id); ?>>
                                        <?php echo htmlspecialchars($user->user_name); ?>
                                    </option>
                                <?php }
                                }
                                else {
                                ?>
                                <option value="<?php echo $this->mdl_tickets->form_value('ticket_assigned_user_id'); ?>"
                                    <?php check_select($this->mdl_tickets->form_value('ticket_assigned_user_id'), $this->mdl_tickets->form_value('ticket_assigned_user_id')); ?>>
                                    <?php echo htmlspecialchars($this->mdl_tickets->form_value('ticket_assigned_user_name')); ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ticket_created_user_id"><?php _trans('ticket_created_by'); ?></label>
                            <input type="text" name="ticket_created_user_id" id="ticket_created_user_id" class="form-control"
                                   value="<?php echo $this->mdl_tickets->form_value('ticket_created_user_name', true); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ticket_insert_time"><?php _trans('ticket_insert_time'); ?></label>
                            <input type="text" name="ticket_insert_time" id="ticket_insert_time" class="form-control"
                                   value="<?php echo $this->mdl_tickets->form_value('ticket_insert_time', true); ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('extra_information'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="project_id"><?php _trans('project'); ?>: </label>
                            <select name="project_id" id="project_id" class="form-control simple-select" <?=($this->session->userdata('user_type') != TYPE_ADMIN && $this->session->userdata('user_type') != TYPE_MANAGERS) ? 'disabled' :''?>>
                                <?php
                                if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
                                    ?>
                                    <option value=""><?php _trans('select_project'); ?></option>
                                    <?php
                                    foreach ($projects as $project) { ?>
                                        <option value="<?php echo $project->project_id; ?>"
                                            <?php check_select($this->mdl_tickets->form_value('project_id'), $project->project_id); ?>>
                                            <?php echo htmlspecialchars($project->project_name); ?>
                                        </option>
                                    <?php }
                                }
                                else
                                {?>
                                <option value="<?php echo $this->mdl_tickets->form_value('project_id'); ?>"
                                    <?php check_select($this->mdl_tickets->form_value('project_id'), $this->mdl_tickets->form_value('project_id')); ?>>
                                    <?php echo htmlspecialchars($this->mdl_tickets->form_value('project_name')); ?>
                                </option>
                                <?php
                                }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="client_id"><?php _trans('client'); ?></label>
                            <select name="client_id" id="client_id" class="form-control simple-select" <?=($this->session->userdata('user_type') != TYPE_ADMIN && $this->session->userdata('user_type') != TYPE_MANAGERS) ? 'disabled' :''?>>
                                <?php
                                if ($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS) {
                                    ?>
                                    <option value=""><?php _trans('select_client'); ?></option>
                                    <?php
                                    foreach ($clients as $client) { ?>
                                        <option value="<?php echo $client->client_id; ?>"
                                            <?php check_select($this->mdl_tickets->form_value('client_id'), $client->client_id); ?>>
                                            <?php echo htmlspecialchars($client->client_name); ?>
                                        </option>
                                    <?php }
                                }
                                else {
                                    ?>
                                    <option value="<?php echo $this->mdl_tickets->form_value('client_id'); ?>"
                                        <?php check_select($this->mdl_tickets->form_value('client_id'), $this->mdl_tickets->form_value('client_id')); ?>>
                                        <?php echo htmlspecialchars($this->mdl_tickets->form_value('client_name')); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</form>

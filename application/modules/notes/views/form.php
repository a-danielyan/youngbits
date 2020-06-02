<form method="post" id="notes-form">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('note_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if ($this->mdl_notes->form_value('notes_id')) : ?>
                            #<?php echo $this->mdl_notes->form_value('notes_id'); ?>&nbsp;
                            <?php echo $this->mdl_notes->form_value('notes_title', true); ?>
                        <?php else : ?>
                            <?php _trans('new_note'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="task_name"><?php _trans('note_title'); ?></label>
                            <input type="text" name="notes_title" id="notes_title" class="form-control"
                                   value="<?php echo $this->mdl_notes->form_value('notes_title', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="notes_description"><?php _trans('note_descriptione'); ?></label>
                            <textarea name="notes_description" id="notes_description" class="form-control" rows="3"
                            ><?php echo $this->mdl_notes->form_value('notes_description', true); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notes_category"><?php _trans('note_category'); ?></label>
                            <input type="text" name="notes_category" id="notes_category" class="form-control"
                                   value="<?=$this->mdl_notes->form_value('notes_category', true); ?>">
                        </div>

                    <div class="form-group">
                            <label for="task_status"><?php _trans('status'); ?></label>
                            <select name="note_status" id="task_status" class="form-control simple-select">
                                <?php


                                foreach ($notes_statuses as $key => $status) {
                                    if ($this->mdl_notes->form_value('note_status') != 4 && ($key == 4 || $key == 5|| $key == 1)) {
                                        continue;
                                    } ?>
                                    <option value="<?php echo $key; ?>" <?php check_select($key, $this->mdl_notes->form_value('note_status')); ?>>
                                        <?php echo $status['label']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php if (!is_null($this->mdl_notes->form_value('notes_url_key', false)) && !empty($this->mdl_notes->form_value('notes_url_key', false))) { ?>
                            <div class="form-group">
                                <label for="invoice-guest-url"><?php _trans('guest_url'); ?></label>
                                <div class="input-group">
                                    <input type="text" id="invoice-guest-url" name="notes_url_key" readonly class="form-control"
                                           value="<?php echo site_url('guest/view/notes/' .$this->mdl_notes->form_value('notes_url_key', false)) ?>">
                                    <span class="input-group-addon to-clipboard cursor-pointer"
                                          data-clipboard-target="#invoice-guest-url">
                                          <i class="fa fa-clipboard fa-fw"></i>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
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
                            <select name="project_id" id="project_id" class="form-control simple-select">
                                <option value=""><?php _trans('select_project'); ?></option>
                                <?php foreach ($projects as $project) { ?>
                                    <option value="<?php echo $project->project_id; ?>"
                                        <?php check_select($this->mdl_notes->form_value('project_id'), $project->project_id); ?>>
                                        <?php echo htmlspecialchars($project->project_name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</form>

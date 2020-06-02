<script>
    $(function () {
        <?php $this->layout->load_view('clients/script_select2_client_id.js'); ?>
    });
</script>

<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">


        <div id="headerbar">
            <h1 class="headerbar-title"><?php _trans('projects_form'); ?></h1>
            <?php if(count($project_groups) >= 1 && +$this->session->userdata('user_type') != TYPE_ADMIN){?>
                <?php $this->layout->load_view('layout/header_buttons'); ?>
            <?php }else{ ?>
                <?php $this->layout->load_view('layout/header_buttons'); ?>
            <?php } ?>
        </div>



    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <label for="project_name"><?php _trans('project_name'); ?></label>
            <input type="text" name="project_name" id="project_name" class="form-control"
                   value="<?php echo $this->mdl_projects->form_value('project_name', true); ?>">
        </div>


        <div class="form-group">
            <label for="client_id"><?php _trans('client'); ?></label>
            <div class="input-group">
                <select name="client_id" id="client_id" class="client-id-select form-control"
                        autofocus="autofocus">
                    <?php if (!empty($client)) : ?>
                        <option value="<?=$client->client_id; ?>"><?php _htmlsc(format_client($client)); ?></option>
                    <?php endif; ?>
                </select>
                <span id="toggle_permissive_search_clients" class="input-group-addon"
                      title="<?php _trans('enable_permissive_search_clients'); ?>" style="cursor:pointer;">
                    <i class="fa fa-toggle-<?php echo get_setting('enable_permissive_search_clients') ? 'on' : 'off' ?> fa-fw"></i>
                </span>
            </div>
        </div>





        <?php if($this->session->userdata('user_type') == TYPE_ADMIN){ ?>
            <div class="form-group no-margin">
                <label for="project_group_id">
                    <?php _trans('group_name'); ?>
                </label>
                <select name="project_group_id[]" id="project_group_id" class="form-control simple-select" multiple required>
                    <?php foreach ($user_groups as $user_group) { ?>
                        <option value="<?php echo $user_group->group_id; ?>"
                            <?php
                            foreach ($project_groups as $project_group){
                                if ($project_group["group_id"] == $user_group->group_id)
                                {
                                    check_select($user_group->group_id, $user_group->group_id);
                                    break;
                                }
                            }?>>
                            <?=$user_group->group_name;?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        <?php }else{ ?>
            <div class="form-group no-margin">
                <label for="project_group_id">
                    <?php _trans('group_name'); ?>
                </label>
                <select name="project_group_id[]" id="project_group_id" class="form-control simple-select">
                    <?php foreach ($user_groups as $user_group) { ?>
                        <?php if(+$this->session->userdata('user_group_id') == $user_group->group_id){ ?>
                            <option value="<?=$user_group->group_id; ?>"
                                <?php check_select(+$this->session->userdata('user_group_id'), $user_group->group_id); ?>>
                                <?=$user_group->group_name?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>

        <?php if (!is_null($this->mdl_projects->form_value('project_notes_key', false)) && !empty($this->mdl_projects->form_value('project_notes_key', false))) { ?>
            <div class="form-group">
                <label for="invoice-guest-url"><?php _trans('guest_url'); ?></label>
                <div class="input-group">
                    <input type="text" id="invoice-guest-url" name="project_notes_key" readonly class="form-control"
                           value="<?php echo site_url('guest/view/project/' .$this->mdl_projects->form_value('project_notes_key', false)) ?>">
                    <span class="input-group-addon to-clipboard cursor-pointer"
                          data-clipboard-target="#invoice-guest-url">
                                              <i class="fa fa-clipboard fa-fw"></i>
                                        </span>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="project_url_google_drive"><?php _trans('project_url_google_drive'); ?></label>
            <div class="input-group">
                <input type="text" id="project_url_google_drive" name="project_url_google_drive" class="form-control"
                       value="<?=$this->mdl_projects->form_value('project_url_google_drive', true)?>">
                <span class="input-group-addon to-clipboard cursor-pointer"
                      data-clipboard-target="#project_url_google_drive">
                                              <i class="fa fa-clipboard fa-fw"></i>
                                        </span>
            </div>
        </div>

        <div class="form-group">
            <label for="project_image_url"><?php _trans('project_image_url'); ?></label>
            <div class="input-group">
                <input type="text" id="project_image_url" name="project_image_url" class="form-control"
                       value="<?=$this->mdl_projects->form_value('project_image_url', true)?>">
                <span class="input-group-addon to-clipboard cursor-pointer"
                      data-clipboard-target="#project_image_url">
                                              <i class="fa fa-clipboard fa-fw"></i>
                                        </span>
            </div>
        </div>

        <div class="form-group">
            <label for="project_financial_needs"><?php _trans('project_financial_needs'); ?></label>
            <input type="text" name="project_financial_needs" id="project_financial_needs" class="form-control"
                   value="<?php echo $this->mdl_projects->form_value('project_financial_needs', true); ?>">
        </div>


        <div class="form-group">
            <label for="project_description" class="control-label"><?php _trans('project_description'); ?></label>

            <textarea name="project_description"
                      class="form-control"><?php echo $this->mdl_projects->form_value('project_description', true); ?></textarea>
        </div>

        <div class="form-group">
            <label for="project_url_trello"><?php _trans('project_url_trello'); ?></label>
            <div class="input-group">
                <input type="text" id="project_url_trello" name="project_url_trello" class="form-control"
                       value="<?=$this->mdl_projects->form_value('project_url_trello', true)?>">
                <span class="input-group-addon to-clipboard cursor-pointer" data-clipboard-target="#project_url_trello">
                      <i class="fa fa-clipboard fa-fw"></i>
                </span>
            </div>
        </div>

        <div class="form-group has-feedback">
            <label for="project_guest_pass">Password</label>
            <div class="input-group">
                <input type="password" name="project_guest_pass" min="4" id="project_guest_pass" class="form-control" value="<?php echo $this->mdl_projects->form_value('project_guest_pass', true); ?>" >
                <span class="input-group-addon show_pass">
                   <i class="fa fa-eye-slash" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    </div>

</form>


<script>
    $(document).on('click', '.show_pass', function () {
        $('#project_guest_pass').attr('type','text')
        $(this).removeClass('show_pass')
        $(this).addClass('hidden_pass')

    } )
    $(document).on('click', '.hidden_pass', function () {
        $('#project_guest_pass').attr('type','password')
        $(this).removeClass('hidden_pass')
        $(this).addClass('show_pass')
    } )
</script>

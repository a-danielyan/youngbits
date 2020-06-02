<form method="post" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('domain_name_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">


        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
            </div>
            <div class="col-xs-12 col-sm-6">


                <div class="form-group">
                    <label for="website_access_domain_name">
                        <?php _trans('domain_name'); ?>
                    </label>
                    <input name="website_access_domain_name" id="website_access_domain_name" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_domain_name'); ?>">
                </div>

                <div class="form-group">
                    <label for="website_access_product_domain_name">
                        <?php _trans('website_access_product_domain_name'); ?>
                    </label>
                    <input name="website_access_product_domain_name" id="website_access_product_domain_name" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_product_domain_name'); ?>">
                </div>

                <div class="form-group">
                    <label for="website_access_product_webhosting">
                        <?php _trans('website_access_product_webhosting'); ?>
                    </label>
                    <input name="website_access_product_webhosting" id="website_access_product_webhosting" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_product_webhosting'); ?>">
                </div>

                <div class="form-group">
                    <label for="website_access_client_id">
                        <?php _trans('client'); ?>
                    </label>
                    <select name="website_access_client_id" id="website_access_client_id" class="form-control simple-select" >
                        <?php foreach ($clients as $client) { ?>
                            <option value="<?php echo $client->client_id; ?>"
                                <?php check_select($client->client_id, $this->mdl_website_access->form_value('website_access_client_id'));?>>
                                <?=$client->client_name;?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="website_access_project_id"><?php _trans('project'); ?>: </label>
                    <select name="website_access_project_id" id="website_access_project_id" class="form-control simple-select">
                        <option value=""><?php _trans('select_project'); ?></option>
                        <?php foreach ($projects as $project) { ?>
                            <option value="<?=$project->project_id; ?>"
                                <?php check_select($this->mdl_website_access->form_value('website_access_project_id'), $project->project_id); ?>>
                                <?=htmlspecialchars($project->project_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="website_access_category"><?php _trans('website_access_category'); ?>: </label>
                    <select name="website_access_category" id="website_access_category" class="form-control simple-select">
                        <?php foreach ($website_access_status as $key => $status) { ?>
                            <option value="<?=$key; ?>"
                                <?php check_select($key,$this->mdl_website_access->form_value('website_access_category')); ?>>
                                <?=htmlspecialchars($status['label']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="website_access_ssl_protected">
                        <?php _trans('website_access_ssl_protected'); ?>
                    </label>
                    <input name="website_access_ssl_protected" id="website_access_ssl_protected" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_ssl_protected'); ?>">
                </div>

                <div class="form-group">
                    <label for="website_access_mijndomeinreseller">
                        <?php _trans('website_access_mijndomeinreseller'); ?>
                    </label>
                    <input name="website_access_mijndomeinreseller" id="website_access_mijndomeinreseller" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_mijndomeinreseller'); ?>">
                </div>

                <div class="form-group">
                    <label for="website_access_date_domain_name_reg">
                        <?php _trans('website_access_date_domain_name_reg'); ?>
                    </label>
                    <input name="website_access_date_domain_name_reg" id="website_access_date_domain_name_reg" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_date_domain_name_reg'); ?>">
                </div>

                <div class="form-group">
                    <label for="website_access_control_panel_web">
                        <?php _trans('access_control_panel_web'); ?>
                    </label>
                    <input name="website_access_control_panel_web" id="website_access_control_panel_web" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_control_panel_web'); ?>">
                </div>
                <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                    <div class="form-group">
                        <label for="website_access_user_account">
                            <?php _trans('user_account'); ?>
                        </label>
                        <input name="website_access_user_account" id="website_access_user_account" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_user_account'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="website_access_user_login">
                            <?php _trans('user_login'); ?>
                        </label>
                        <input name="website_access_user_login" id="website_access_user_login" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_user_login'); ?>">
                    </div>
                <?php } ?>
                <input type="hidden" name="website_access_admin" id="website_access_admin" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_admin'); ?>">
                <input type="hidden" name="website_access_directadmin_account" id="website_access_directadmin_account" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_directadmin_account'); ?>">
                <input type="hidden" name="website_access_directadmin_login" id="website_access_directadmin_login" class="form-control"  value="<?php echo $this->mdl_website_access->form_value('website_access_directadmin_login'); ?>">


            </div>

        </div>

    </div>

</form>



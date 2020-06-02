<script>
    $(function () {
        var template_fields = ["body", "subject", "from_name", "from_email"];

        $('#email_template').change(function () {
            var email_template_id = $(this).val();

            if (email_template_id === '') return;

            $.post("<?php echo site_url('email_templates/ajax/get_content'); ?>", {
                email_template_id: email_template_id
            }, function (data) {
                <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                inject_email_template(template_fields, JSON.parse(data));
            });
        });

        var selected_email_template = <?php echo $email_template ?>;
        inject_email_template(template_fields, selected_email_template);
    });
</script>

<form method="post" action="<?php echo site_url('mailer/prospect_email_address') ?>">
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('email_prospect'); ?></h1>

        <div class="headerbar-item pull-right">
            <div class="btn-group btn-group-sm">
                <button class="btn btn-primary ajax-loader" name="btn_send" value="1">
                    <i class="fa fa-send"></i>
                    <?php _trans('send'); ?>
                </button>
                <button class="btn btn-danger" name="btn_cancel" value="1">
                    <i class="fa fa-times"></i>
                    <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>
    </div>

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">

                <?php $this->layout->load_view('layout/alerts'); ?>

                <div class="form-group">
                    <label for="to_email"><?php _trans('to_email'); ?></label>
                    <input type="text" name="to_email" id="to_email" class="form-control" required
                           value="<?php
                                       foreach ($prospects as $prospect){
                                            echo $prospect->lead_email.', ';
                                       }
                                   ?>">
                </div>

                <hr>

                <div class="form-group">
                    <label for="email_template"><?php _trans('email_template'); ?></label>
                    <select name="email_template" id="email_template" class="form-control simple-select">
                        <option value=""><?php _trans('none'); ?></option>
                        <?php foreach ($email_templates as $email_template): ?>
                            <option value="<?php echo $email_template->email_template_id; ?>"
                                <?php check_select($selected_email_template, $email_template->email_template_id); ?>>
                                <?php _htmlsc($email_template->email_template_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="from_name"><?php _trans('from_name'); ?></label>
                    <input type="text" name="from_name" id="from_name" class="form-control"
                           value="<?=$this->session->userdata('user_name'); ?>">
                </div>

                <div class="form-group">
                    <label for="from_email"><?php _trans('from_email'); ?></label>
                    <input type="email" name="from_email" id="from_email" class="form-control"
                           value="<?=$this->session->userdata('user_email'); ?>">
                </div>



                <div class="form-group">
                    <label for="subject"><?php _trans('subject'); ?></label>
                    <input type="text" name="subject" id="subject" class="form-control"
                           value="6487526784">
                </div>


            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-12 col-md-6">

                <div class="form-group">
                    <label for="body"><?php _trans('body'); ?></label>

                    <br>

                    <div class="html-tags btn-group btn-group-sm">
                        <span class="html-tag btn btn-default" data-tag-type="text-paragraph">
                            <i class="fa fa-paragraph"></i>
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-bold">
                            <i class="fa fa-bold"></i>
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-italic">
                            <i class="fa fa-italic"></i>
                        </span>
                    </div>
                    <div class="html-tags btn-group btn-group-sm">
                        <span class="html-tag btn btn-default" data-tag-type="text-h1">H1</span>
                        <span class="html-tag btn btn-default" data-tag-type="text-h2">H2</span>
                        <span class="html-tag btn btn-default" data-tag-type="text-h3">H3</span>
                        <span class="html-tag btn btn-default" data-tag-type="text-h4">H4</span>
                    </div>
                    <div class="html-tags btn-group btn-group-sm">
                        <span class="html-tag btn btn-default" data-tag-type="text-code">
                            <i class="fa fa-code"></i>
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-hr">
                            &lt;hr/&gt;
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-css">
                            CSS
                        </span>
                    </div>

                    <textarea name="body" id="body" rows="8"
                              class="email-template-body form-control taggable"></textarea>

                    <br>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php _trans('preview'); ?>
                            <div id="email-template-preview-reload" class="pull-right cursor-pointer">
                                <i class="fa fa-refresh"></i>
                            </div>
                        </div>
                        <div class="panel-body">
                            <iframe id="email-template-preview"></iframe>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-xs-12 col-md-6">

                <?php $this->layout->load_view('email_templates/template-tags-prospect'); ?>

            </div>
        </div>

        <br>



    </div>

</form>


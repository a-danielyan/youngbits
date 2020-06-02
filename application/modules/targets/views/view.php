<script>
    $(function () {
        $('#save_target_note').click(function () {
            $.post('<?php echo site_url('targets/ajax/save_target_note'); ?>',
                {
                    target_id: $('#target_id').val(),
                    target_note: $('#target_note').val()
                }, function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful
                        $('.control-group').removeClass('error');
                        $('#target_note').val('');

                        // Reload all notes
                        $('#notes_list').load("<?php echo site_url('targets/ajax/load_target_notes'); ?>",
                            {
                                target_id: <?php echo $target->target_id; ?>
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

<div id="headerbar">
    <h1 class="headerbar-title"><?php _htmlsc(format_target($target)); ?></h1>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm">
            <?php echo form_open(site_url('targets/view/' . $target->target_id) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
            <form method="post" action="<?php echo site_url('targets/view/' . $target->target_id); ?>" name="form-generate-client" id="form-generate-client">
                <input type="hidden" value="<?php echo $target->target_id;?>" name="generate_target_id">
                <button id="btn-submit-tasks" name="btn_generate_client" class="btn btn-default" value="generate_client"
                        type="submit" value="submit">
                    <i class="fa fa-user"></i> <?php _trans('generate_client'); ?>
                </button>
                <a href="<?php echo site_url('targets/form/' . $target->target_id); ?>"
                   class="btn btn-default">
                    <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
                </a>
                <a class="btn btn-danger"
                   href="<?php echo site_url('targets/delete/' . $target->target_id); ?>"
                   onclick="return confirm('<?php _trans('delete_target_warning'); ?>');">
                    <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
                </a>
            </form>
        </div>
    </div>

</div>

<ul id="submenu" class="nav nav-tabs nav-tabs-noborder">
    <li class="active"><a data-toggle="tab" href="#targetDetails"><?php _trans('details'); ?></a></li>
</ul>

<div id="content" class="tabbable tabs-below no-padding">
    <div class="tab-content no-padding">

        <div id="targetDetails" class="tab-pane tab-rich-content active">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <h3><?php _htmlsc(format_target($target)); ?></h3>
                    <p>
                        <?php $this->layout->load_view('targets/partial_target_address'); ?>
                    </p>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <table class="table table-bordered no-margin">
                        <tr>
                            <th>
                                <?php _trans('language'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($target->target_language); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('group_name'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($target->group_name); ?>
                            </td>
                        </tr>




                        <tr>
                            <th>
                                <?php _trans('client_created_by'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($target->target_date_created); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('created_by'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($target->username); ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading"><?php _trans('contact_information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php if ($target->target_email) : ?>
                                    <tr>
                                        <th><?php _trans('email'); ?></th>
                                        <td><?php _auto_link($target->target_email, 'email'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($target->target_phone) : ?>
                                    <tr>
                                        <th><?php _trans('phone'); ?></th>
                                        <td><?php _htmlsc($target->target_phone); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($target->target_mobile) : ?>
                                    <tr>
                                        <th><?php _trans('mobile'); ?></th>
                                        <td><?php _htmlsc($target->target_mobile); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($target->target_fax) : ?>
                                    <tr>
                                        <th><?php _trans('fax'); ?></th>
                                        <td><?php _htmlsc($target->target_fax); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($target->target_web) : ?>
                                    <tr>
                                        <th><?php _trans('web'); ?></th>
                                        <td><?php _auto_link($target->target_web, 'url', true); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($target->target_file) : ?>
                                    <tr>
                                        <th><?php _trans('file'); ?></th>
                                        <td><?php _auto_link($target->target_file, 'url', true); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default no-margin">

                        <div class="panel-heading"><?php _trans('tax_information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php if ($target->target_vat_id) : ?>
                                    <tr>
                                        <th><?php _trans('vat_id'); ?></th>
                                        <td><?php _htmlsc($target->target_vat_id); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($target->target_tax_code) : ?>
                                    <tr>
                                        <th><?php _trans('tax_code'); ?></th>
                                        <td><?php _htmlsc($target->target_tax_code); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


            <hr>

            <div class="row">

                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading"><?php _trans('delivery_address'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <tr>
                                    <th><?php _trans('street_address'); ?></th>
                                    <td><?php _htmlsc($target->target_address_1_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('city'); ?></th>
                                    <td><?php _htmlsc($target->target_city_delivery); ?></td>
                                </tr>

                                <tr>
                                    <th><?php _trans('state'); ?></th>
                                    <td><?php _htmlsc($target->target_state_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('zip_code'); ?></th>
                                    <td><?php _htmlsc($target->target_zip_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('country'); ?></th>
                                    <td><?php _htmlsc(get_country_name(trans('cldr'), $target->target_country_delivery)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <?php if ($target->target_surname != ""): //target is not a company ?>
                    <div class="col-xs-12 col-md-6">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('personal_information'); ?>
                            </div>

                            <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <tr>
                                        <th><?php _trans('birthdate'); ?></th>
                                        <td><?php echo format_date($target->target_birthdate); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('gender'); ?></th>
                                        <td><?php echo format_gender($target->target_gender) ?></td>
                                    </tr>
                                    <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>
                                        <tr>
                                            <th><?php _trans('sumex_ssn'); ?></th>
                                            <td><?php echo format_avs($target->target_avs) ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php _trans('sumex_insurednumber'); ?></th>
                                            <td><?php _htmlsc($target->target_insurednumber) ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php _trans('sumex_veka'); ?></th>
                                            <td><?php _htmlsc($target->target_veka) ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>

                    </div>

                <?php endif; ?>
            </div>

            <hr>

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading">
                            <?php _trans('notes'); ?>
                        </div>
                        <div class="panel-body">
                            <div id="notes_list">
                                <?php echo $partial_notes; ?>
                            </div>
                            <input type="hidden" name="target_id" id="target_id"
                                   value="<?php echo $target->target_id; ?>">
                            <div class="input-group">
                                <textarea id="target_note" class="form-control" rows="2" style="resize:none"></textarea>
                                <span id="save_target_note" class="input-group-addon btn btn-default">
                                    <?php _trans('add_note'); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

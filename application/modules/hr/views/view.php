<script>
    $(function () {
        $('#save_hr_note').click(function () {
            $.post('<?php echo site_url('hr/ajax/save_hr_note'); ?>',
                {
                    hr_id: $('#hr_id').val(),
                    hr_note: $('#hr_note').val()
                }, function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful
                        $('.control-group').removeClass('error');
                        $('#hr_note').val('');

                        // Reload all notes
                        $('#notes_list').load("<?php echo site_url('hr/ajax/load_hr_notes'); ?>",
                            {
                                hr_id: <?php echo $hr->hr_id; ?>
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

<?php if($this->session->userdata('user_type') == TYPE_ADMIN ){ ?>
<div id="headerbar">
    <h1 class="headerbar-title"><?php _htmlsc(format_hr($hr)); ?></h1>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm">
            <a href="<?php echo site_url('hr/form/' . $hr->hr_id); ?>"
               class="btn btn-default">
                <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
            </a>
            <a class="btn btn-danger"
               href="<?php echo site_url('hr/delete/' . $hr->hr_id); ?>"
               onclick="return confirm('<?php _trans('delete_hr_warning'); ?>');">
                <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
            </a>
        </div>
    </div>

</div>
<?php } ?>
<ul id="submenu" class="nav nav-tabs nav-tabs-noborder">
    <li class="active"><a data-toggle="tab" href="#hrDetails"><?php _trans('details'); ?></a></li>
</ul>

<div id="content" class="tabbable tabs-below no-padding">
    <div class="tab-content no-padding">

        <div id="hrDetails" class="tab-pane tab-rich-content active">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <h3><?php _htmlsc(format_hr($hr)); ?></h3>
                    <p>
                        <?php $this->layout->load_view('hr/partial_hr_address'); ?>
                    </p>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <table class="table table-bordered no-margin">
                        <tr>
                            <th>
                                <?php _trans('language'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($hr->hr_language); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('group_name'); ?>
                            </th>
                            <td class="td-amount">
                                <?php
                                switch ($hr->hr_type) {
                                    case '1':
                                        _trans('administrator');
                                        break;
                                    case TYPE_PROMOTERS:
                                        _trans('Influancers');
                                        break;
                                    case TYPE_ADMINISTRATOR:
                                        _trans('other_users');
                                        break;
                                    case TYPE_MANAGERS:
                                        _trans('managers');
                                        break;
                                    case TYPE_FREELANCERS:
                                        _trans('freelancers');
                                        break;
                                    case TYPE_EMPLOYEES:
                                        _trans('employees');
                                        break;
                                    case TYPE_ACCOUNTANT:
                                        _trans('accountant');
                                        break;
                                    default:
                                        break;
                                }?>
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
                                <?php if ($hr->hr_email) : ?>
                                    <tr>
                                        <th><?php _trans('email'); ?></th>
                                        <td><?php _auto_link($hr->hr_email, 'email'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($hr->hr_phone) : ?>
                                    <tr>
                                        <th><?php _trans('phone'); ?></th>
                                        <td><?php _htmlsc($hr->hr_phone); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($hr->hr_mobile) : ?>
                                    <tr>
                                        <th><?php _trans('mobile'); ?></th>
                                        <td><?php _htmlsc($hr->hr_mobile); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($hr->hr_fax) : ?>
                                    <tr>
                                        <th><?php _trans('fax'); ?></th>
                                        <td><?php _htmlsc($hr->hr_fax); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($hr->hr_web) : ?>
                                    <tr>
                                        <th><?php _trans('web'); ?></th>
                                        <td><?php _auto_link($hr->hr_web, 'url', true); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                </div>

                <?php if (!empty($hr->hr_vat_id) || !empty($hr->hr_tax_code )) { ?>
                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default no-margin">

                        <div class="panel-heading"><?php _trans('tax_information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php if ($hr->hr_vat_id) : ?>
                                    <tr>
                                        <th><?php _trans('vat_id'); ?></th>
                                        <td><?php _htmlsc($hr->hr_vat_id); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($hr->hr_tax_code) : ?>
                                    <tr>
                                        <th><?php _trans('tax_code'); ?></th>
                                        <td><?php _htmlsc($hr->hr_tax_code); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>

                    </div>
                </div>
                <?php } ?>
                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default no-margin">

                        <div class="panel-heading"><?php _trans('tax_information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <tr>
                                    <th><?php _trans('hr_followers'); ?></th>
                                    <td><?php _htmlsc($hr->hr_followers); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('address'); ?></th>
                                    <td><?php _htmlsc($hr->hr_city); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('hr_social_link'); ?></th>
                                    <td><?php _htmlsc($hr->hr_social_link); ?></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


            <hr>

            <div class="row">
                <?php if ($hr->hr_surname != ""): //hr is not a company ?>
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php _trans('personal_information'); ?>
                        </div>

                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <tr>
                                    <th><?php _trans('birthdate'); ?></th>
                                    <td><?php echo format_date($hr->hr_birthdate); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('gender'); ?></th>
                                    <td><?php echo format_gender($hr->hr_gender) ?></td>
                                </tr>
                                <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>
                                    <tr>
                                        <th><?php _trans('sumex_ssn'); ?></th>
                                        <td><?php echo format_avs($hr->hr_avs) ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('sumex_insurednumber'); ?></th>
                                        <td><?php _htmlsc($hr->hr_insurednumber) ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('sumex_veka'); ?></th>
                                        <td><?php _htmlsc($hr->hr_veka) ?></td>
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
                            <input type="hidden" name="hr_id" id="hr_id"
                                   value="<?php echo $hr->hr_id; ?>">
                            <?php if($this->session->userdata('user_type') == TYPE_ADMIN ){ ?>
                            <div class="input-group">
                                <textarea id="hr_note" class="form-control" rows="2" style="resize:none"></textarea>

                                <span id="save_hr_note" class="input-group-addon btn btn-default">
                                    <?php _trans('add_note'); ?>
                                </span>

                            </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

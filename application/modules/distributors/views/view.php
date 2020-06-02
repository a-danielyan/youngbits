<script>
    $(function () {
        $('#save_distributor_note').click(function () {
            $.post('<?php echo site_url('distributors/ajax/save_distributor_note'); ?>',
                {
                    distributor_id: $('#distributor_id').val(),
                    distributor_note: $('#distributor_note').val()
                }, function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful
                        $('.control-group').removeClass('error');
                        $('#distributor_note').val('');

                        // Reload all notes
                        $('#notes_list').load("<?php echo site_url('distributors/ajax/load_distributor_notes'); ?>",
                            {
                                distributor_id: <?php echo $distributor->distributor_id; ?>
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
    <h1 class="headerbar-title"><?php _htmlsc(format_distributor($distributor)); ?></h1>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm">
            <?php echo form_open(site_url('distributors/view/' . $distributor->distributor_id) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
            <form method="post" action="<?php echo site_url('distributors/view/' . $distributor->distributor_id); ?>" name="form-generate-client" id="form-generate-client">
                <?php if($this->session->userdata('user_type') !== TYPE_ADMINISTRATOR){ ?>
                <input type="hidden" value="<?php echo $distributor->distributor_id;?>" name="generate_distributor_id">
                <button id="btn-submit-tasks" name="btn_generate_client" class="btn btn-default" value="generate_client"
                        type="submit" value="submit">
                    <i class="fa fa-user"></i> <?php _trans('generate_client'); ?>
                </button>
                <?php } ?>
                <a href="<?php echo site_url('distributors/form/' . $distributor->distributor_id); ?>"
                   class="btn btn-default">
                    <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
                </a>
                <a class="btn btn-danger"
                   href="<?php echo site_url('distributors/delete/' . $distributor->distributor_id); ?>"
                   onclick="return confirm('<?php _trans('delete_distributor_warning'); ?>');">
                    <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
                </a>
            </form>
        </div>
    </div>

</div>

<ul id="submenu" class="nav nav-tabs nav-tabs-noborder">
    <li class="active"><a data-toggle="tab" href="#distributorDetails"><?php _trans('details'); ?></a></li>
</ul>

<div id="content" class="tabbable tabs-below no-padding">
    <div class="tab-content no-padding">

        <div id="distributorDetails" class="tab-pane tab-rich-content active">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <h3><?php _htmlsc(format_distributor($distributor)); ?></h3>
                    <p>
                        <?php $this->layout->load_view('distributors/partial_distributor_address'); ?>
                    </p>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <table class="table table-bordered no-margin">
                        <tr>
                            <th>
                                <?php _trans('language'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($distributor->distributor_language); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('group'); ?>
                            </th>
                            <td class="td-amount">
                                <?php
                                if(is_array($distributor->group_name)) {
                                    echo join(' , ', $distributor->group_name);
                                }else{
                                    _htmlsc($distributor->group_name);
                                }
                                ?>
                            </td>
                        </tr>




                        <tr>
                            <th>
                                <?php _trans('client_created_by'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($distributor->distributor_date_created); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('created_by'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($distributor->username); ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            <hr>

            <div class="row">
                <?php if ($distributor->distributor_surname != ""): //distributor is not a company ?>
                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('personal_information'); ?>
                            </div>

                            <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <?php if ($distributor->distributor_surname_contactperson) : ?>
                                        <tr>
                                            <th><?php _trans('distributor_surname_contactperson'); ?></th>
                                            <td><?php _htmlsc($distributor->distributor_surname_contactperson); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($distributor->distributor_function_contactperson) : ?>
                                        <tr>
                                            <th><?php _trans('distributor_function_contactperson'); ?></th>
                                            <td><?php _htmlsc($distributor->distributor_function_contactperson); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($distributor->distributor_email) : ?>
                                        <tr>
                                            <th><?php _trans('email'); ?></th>
                                            <td><?php _auto_link($distributor->distributor_email, 'email'); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($distributor->distributor_phone) : ?>
                                        <tr>
                                            <th><?php _trans('phone'); ?></th>
                                            <td><?php _htmlsc($distributor->distributor_phone); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($distributor->distributor_mobile) : ?>
                                        <tr>
                                            <th><?php _trans('phone_number'); ?> 2 / <?php _trans('fax_number'); ?> </th>
                                            <td><?php _htmlsc($distributor->distributor_mobile); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($distributor->distributor_web) : ?>
                                        <tr>
                                            <th><?php _trans('web'); ?></th>
                                            <td><?php _auto_link($distributor->distributor_web, 'url', true); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading"><?php _trans('contact_information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php if ($distributor->distributor_name) : ?>
                                    <tr>
                                        <th><?php _trans('company_name'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_name); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($distributor->distributor_surname) : ?>
                                    <tr>
                                        <th><?php _trans('first_name_contactperson'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_surname); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($distributor->distributor_surname_contactperson) : ?>
                                    <tr>
                                        <th><?php _trans('surname_contactperson'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_surname_contactperson); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($distributor->distributor_surname_contactperson) : ?>
                                    <tr>
                                        <th><?php _trans('email_sent'); ?></th>
                                        <td><?=($distributor->distributor_email_sent == 1)? '<img src="'.base_url().'assets/core/img/check_file.png" style="min-width: 30px;max-width: 30px"">' : '' ?></td>
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
                                    <th><?php _trans('city'); ?></th>
                                    <td><?php _htmlsc($distributor->distributor_city_delivery); ?></td>
                                </tr>

                                <tr>
                                    <th><?php _trans('state'); ?></th>
                                    <td><?php _htmlsc($distributor->distributor_state_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('zip_code'); ?></th>
                                    <td><?php _htmlsc($distributor->distributor_zip_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('country'); ?></th>
                                    <td><?php _htmlsc(get_country_name(trans('cldr'), $distributor->distributor_country_delivery)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php _trans('personal_information'); ?>
                        </div>

                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <tr>
                                    <th><?php _trans('birthdate'); ?></th>
                                    <td><?php echo format_date($distributor->distributor_birthdate); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('gender'); ?></th>
                                    <td><?php echo format_gender($distributor->distributor_gender) ?></td>
                                </tr>
                                <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>
                                    <tr>
                                        <th><?php _trans('sumex_ssn'); ?></th>
                                        <td><?php echo format_avs($distributor->distributor_avs) ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('sumex_insurednumber'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_insurednumber) ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('sumex_veka'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_veka) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>




            </div>

            <hr>

            <div class="row">

                    <div class="col-xs-12 col-md-6 ">
                        <?php if(!empty($distributor->distributor_file)){ ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('client_additional_information'); ?>
                            </div>
                            <div class="panel-body table-content text-center">
                                <div class="col margin-top">
                                    <a href="<?= base_url('/prospects/'.$distributor->distributor_file) ?>" download>
                                        <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 100px"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <?php } ?>
                    </div>



                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default no-margin">

                        <div class="panel-heading"><?php _trans('tax_information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php if ($distributor->distributor_vat_id) : ?>
                                    <tr>
                                        <th><?php _trans('vat_id'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_vat_id); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($distributor->distributor_tax_code) : ?>
                                    <tr>
                                        <th><?php _trans('tax_code'); ?></th>
                                        <td><?php _htmlsc($distributor->distributor_tax_code); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>

                    </div>

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading">
                            <?php _trans('notes'); ?>
                        </div>
                        <div class="panel-body">
                            <div id="notes_list">
                                <?php echo $partial_notes; ?>
                            </div>
                            <input type="hidden" name="distributor_id" id="distributor_id"
                                   value="<?php echo $distributor->distributor_id; ?>">
                            <div class="input-group">
                                <textarea id="distributor_note" class="form-control" rows="2" style="resize:none"></textarea>
                                <span id="save_distributor_note" class="input-group-addon btn btn-default">
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

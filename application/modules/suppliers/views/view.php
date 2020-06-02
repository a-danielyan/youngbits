<script>
    $(function () {
        $('#save_supplier_note').click(function () {
            $.post('<?php echo site_url('suppliers/ajax/save_supplier_note'); ?>',
                {
                    supplier_id: $('#supplier_id').val(),
                    supplier_note: $('#supplier_note').val()
                }, function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful
                        $('.control-group').removeClass('error');
                        $('#supplier_note').val('');

                        // Reload all notes
                        $('#notes_list').load("<?php echo site_url('suppliers/ajax/load_supplier_notes'); ?>",
                            {
                                supplier_id: <?php echo $supplier->supplier_id; ?>
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
    <h1 class="headerbar-title"><?php _htmlsc(format_supplier($supplier)); ?></h1>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm">
            <?php echo form_open(site_url('suppliers/view/' . $supplier->supplier_id) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
            <form method="post" action="<?php echo site_url('suppliers/view/' . $supplier->supplier_id); ?>" name="form-generate-client" id="form-generate-client">
                <?php if($this->session->userdata('user_type') !== TYPE_ADMINISTRATOR){ ?>
                <input type="hidden" value="<?php echo $supplier->supplier_id;?>" name="generate_supplier_id">
                <button id="btn-submit-tasks" name="btn_generate_client" class="btn btn-default" value="generate_client"
                        type="submit" value="submit">
                    <i class="fa fa-user"></i> <?php _trans('generate_client'); ?>
                </button>
                <?php } ?>
                <a href="<?php echo site_url('suppliers/form/' . $supplier->supplier_id); ?>"
                   class="btn btn-default">
                    <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
                </a>
                <a class="btn btn-danger"
                   href="<?php echo site_url('suppliers/delete/' . $supplier->supplier_id); ?>"
                   onclick="return confirm('<?php _trans('delete_supplier_warning'); ?>');">
                    <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
                </a>
            </form>
        </div>
    </div>

</div>

<ul id="submenu" class="nav nav-tabs nav-tabs-noborder">
    <li class="active"><a data-toggle="tab" href="#supplierDetails"><?php _trans('details'); ?></a></li>
</ul>

<div id="content" class="tabbable tabs-below no-padding">
    <div class="tab-content no-padding">

        <div id="supplierDetails" class="tab-pane tab-rich-content active">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <h3><?php _htmlsc(format_supplier($supplier)); ?></h3>
                    <p>
                        <?php $this->layout->load_view('suppliers/partial_supplier_address'); ?>
                    </p>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <table class="table table-bordered no-margin">
                        <tr>
                            <th>
                                <?php _trans('language'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($supplier->supplier_language); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('group'); ?>
                            </th>
                            <td class="td-amount">
                                <?php
                                if(is_array($supplier->group_name)) {
                                    echo join(' , ', $supplier->group_name);
                                }else{
                                    _htmlsc($supplier->group_name);
                                }
                                ?>
                            </td>
                        </tr>




                        <tr>
                            <th>
                                <?php _trans('client_created_by'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($supplier->supplier_date_created); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _trans('created_by'); ?>
                            </th>
                            <td class="td-amount">
                                <?php echo ucfirst($supplier->username); ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            <hr>

            <div class="row">
                <?php if ($supplier->supplier_surname != ""): //supplier is not a company ?>
                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('personal_information'); ?>
                            </div>

                            <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <?php if ($supplier->supplier_surname_contactperson) : ?>
                                        <tr>
                                            <th><?php _trans('supplier_surname_contactperson'); ?></th>
                                            <td><?php _htmlsc($supplier->supplier_surname_contactperson); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($supplier->supplier_function_contactperson) : ?>
                                        <tr>
                                            <th><?php _trans('supplier_function_contactperson'); ?></th>
                                            <td><?php _htmlsc($supplier->supplier_function_contactperson); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($supplier->supplier_email) : ?>
                                        <tr>
                                            <th><?php _trans('email'); ?></th>
                                            <td><?php _auto_link($supplier->supplier_email, 'email'); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($supplier->supplier_phone) : ?>
                                        <tr>
                                            <th><?php _trans('phone'); ?></th>
                                            <td><?php _htmlsc($supplier->supplier_phone); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($supplier->supplier_mobile) : ?>
                                        <tr>
                                            <th><?php _trans('phone_number'); ?> 2 / <?php _trans('fax_number'); ?> </th>
                                            <td><?php _htmlsc($supplier->supplier_mobile); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($supplier->supplier_web) : ?>
                                        <tr>
                                            <th><?php _trans('web'); ?></th>
                                            <td><?php _auto_link($supplier->supplier_web, 'url', true); ?></td>
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
                                <?php if ($supplier->supplier_name) : ?>
                                    <tr>
                                        <th><?php _trans('company_name'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_name); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_surname) : ?>
                                    <tr>
                                        <th><?php _trans('first_name_contactperson'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_surname); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_surname_contactperson) : ?>
                                    <tr>
                                        <th><?php _trans('surname_contactperson'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_surname_contactperson); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_surname_contactperson) : ?>
                                    <tr>
                                        <th><?php _trans('email_sent'); ?></th>
                                        <td><?=($supplier->supplier_email_sent == 1)? '<img src="'.base_url().'assets/core/img/check_file.png" style="min-width: 30px;max-width: 30px"">' : '' ?></td>
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
                                    <td><?php _htmlsc($supplier->supplier_city_delivery); ?></td>
                                </tr>

                                <tr>
                                    <th><?php _trans('state'); ?></th>
                                    <td><?php _htmlsc($supplier->supplier_state_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('zip_code'); ?></th>
                                    <td><?php _htmlsc($supplier->supplier_zip_delivery); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('country'); ?></th>
                                    <td><?php _htmlsc(get_country_name(trans('cldr'), $supplier->supplier_country_delivery)); ?></td>
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
                                    <td><?php echo format_date($supplier->supplier_birthdate); ?></td>
                                </tr>
                                <tr>
                                    <th><?php _trans('gender'); ?></th>
                                    <td><?php echo format_gender($supplier->supplier_gender) ?></td>
                                </tr>
                                <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>
                                    <tr>
                                        <th><?php _trans('sumex_ssn'); ?></th>
                                        <td><?php echo format_avs($supplier->supplier_avs) ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('sumex_insurednumber'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_insurednumber) ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('sumex_veka'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_veka) ?></td>
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
                        <?php if(!empty($supplier->supplier_file)){ ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('client_additional_information'); ?>
                            </div>
                            <div class="panel-body table-content text-center">
                                <div class="col margin-top">
                                    <a href="<?= base_url('/suppliers/'.$supplier->supplier_file) ?>" download>
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
                                <?php if ($supplier->supplier_vat_id) : ?>
                                    <tr>
                                        <th><?php _trans('vat_id'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_vat_id); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_tax_code) : ?>
                                    <tr>
                                        <th><?php _trans('tax_code'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_tax_code); ?></td>
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
                            <input type="hidden" name="supplier_id" id="supplier_id"
                                   value="<?php echo $supplier->supplier_id; ?>">
                            <div class="input-group">
                                <textarea id="supplier_note" class="form-control" rows="2" style="resize:none"></textarea>
                                <span id="save_supplier_note" class="input-group-addon btn btn-default">
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

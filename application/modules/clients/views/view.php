

    <?php
    $locations = array();
    foreach ($custom_fields as $custom_field) {
        if (array_key_exists($custom_field->custom_field_location, $locations)) {
            $locations[$custom_field->custom_field_location] += 1;
        } else {
            $locations[$custom_field->custom_field_location] = 1;
        }
    }
    ?>

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _htmlsc(format_client($client)); ?></h1>

        <div class="headerbar-item pull-right">
            <div class="btn-group btn-group-sm">




    <?php if ($this->session->userdata('user_type') == TYPE_ADMIN) {
            if (USE_QUOTES) {  ?>
                <a href="<?= base_url().'index.php/payment_arrangements/form'?>" class="btn btn-default"
                   data-client-id="<?= $client->client_id; ?>">
                    <i class="fa fa-file"></i> <?php _trans('payment_arrangement_create'); ?>
                </a>
                <a href="#" class="btn btn-default client-create-quote"
                   data-client-id="<?= $client->client_id; ?>">
                    <i class="fa fa-file"></i> <?php _trans('create_quote'); ?>
                </a>
            <?php } ?>
                <a href="#" class="btn btn-default client-create-invoice"
                   data-client-id="<?php echo $client->client_id; ?>">
                    <i class="fa fa-file-text"></i> <?php _trans('create_invoice'); ?></a>

        <?php if ($this->session->userdata('user_type') == TYPE_ADMIN ): ?>
            <a href="<?php echo site_url('clients/form/' . $client->client_id); ?>"
               class="btn btn-default">
                <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
            </a>
        <?php endif; ?>
    <?php }else{
        if(count($client_groups) == 1){ ?>
            <?php if ($this->session->userdata('user_type') == TYPE_ADMIN ): ?>
                <a href="<?php echo site_url('clients/form/' . $client->client_id); ?>"
                   class="btn btn-default">
                    <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
                </a>
            <?php endif; ?>

        <?php }
    }

    if ($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                <a class="btn btn-danger"
                   href="<?php echo site_url('clients/delete/' . $client->client_id); ?>"
                   onclick="return confirm('<?php _trans('delete_client_warning'); ?>');">
                    <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
                </a>
    <?php } ?>
            </div>
        </div>

    </div>

    <ul id="submenu" class="nav nav-tabs nav-tabs-noborder">
        <li class="active"><a data-toggle="tab" href="#clientDetails"><?php _trans('details'); ?></a></li>
    <?php
    if ($this->session->userdata('user_type') == TYPE_ADMIN) {
        if (USE_QUOTES) {
    ?>
        <li><a data-toggle="tab" href="#clientQuotes"><?php _trans('quotes'); ?></a></li>
    <?php
        }
    ?>
        <li><a data-toggle="tab" href="#clientInvoices"><?php _trans('invoices'); ?></a></li>
        <li><a data-toggle="tab" href="#clientPayments"><?php _trans('payments'); ?></a></li>
<!--        <li><a data-toggle="tab" href="#clientOrders">--><?php //_trans('Orders'); ?><!--</a></li>-->
        <li><a data-toggle="tab" href="#clientPaymentArrangement"><?php _trans('payment_arrangement'); ?></a></li>
    <?php
    }
    ?>
    </ul>

    <div id="content" class="tabbable tabs-below no-padding">
        <div class="tab-content no-padding">

            <div id="clientDetails" class="tab-pane tab-rich-content active">

                <?php $this->layout->load_view('layout/alerts'); ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">

                        <h3><?php _htmlsc(format_client($client)); ?></h3>
                        <p>
                        <div style="display: flex">
                            <?php if ($client->first_name_contact_person): ?>
                                <div>
                                    <?php _auto_link($client->first_name_contact_person); ?>
                                </div>
                            <?php endif; ?>&nbsp;
                            <?php if ($client->surname_contact_person): ?>
                                <div>
                                    <?php _auto_link($client->surname_contact_person); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                            <?php
                            if ($this->session->userdata('user_type') == TYPE_ADMIN)
                            {
                                $this->layout->load_view('clients/partial_client_address');
                            }?>
                        </p>

                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">

                        <table class="table table-bordered no-margin">
                            <tr>
                                <th>
                                    <?php _trans('language'); ?>
                                </th>
                                <td class="td-amount">
                                    <?php echo ucfirst($client->client_language); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php _trans('group'); ?>
                                </th>
                                <td class="td-amount">
                                    <?php
                                    $groups = array();
                                    foreach ($user_groups as $user_group) {
                                        foreach ($client_groups as $client_group) {
                                            if ($client_group["group_id"] == $user_group->group_id) {
                                                array_push($groups, $user_group->group_name);
                                            }
                                        }
                                    }
                                    if (count($groups) > 0)
                                    {
                                        echo ucfirst(implode(", ", $groups));
                                    }
                                    ?>
                                </td>
                            </tr>



                            <tr>
                                <th>
                                    <?php _trans('client_created_by'); ?>
                                </th>
                                <td class="td-amount">
                                    <?= $client->client_date_created ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php _trans('client_added_by'); ?>
                                </th>
                                <td class="td-amount">
                                    <?= $client->user_name ?>
                                </td>
                            </tr>
                            <?php
                            if ($this->session->userdata('user_type') == TYPE_ADMIN) {
                            ?>
                            <tr>
                                <th>
                                    <?php _trans('total_billed'); ?>
                                </th>
                                <td class="td-amount">
                                    <?php echo format_currency($client->client_invoice_total); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <?php _trans('total_paid'); ?>
                                </th>
                                <th class="td-amount">
                                    <?php echo format_currency($client->client_invoice_paid); ?>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <?php _trans('total_balance'); ?>
                                </th>
                                <td class="td-amount">
                                    <?php echo format_currency($client->client_invoice_balance); ?>
                                </td>
                            </tr>
                                <tr>
                                    <th>
                                        <?php _trans('commission_rate'); ?>
                                    </th>
                                    <td class="td-amount">
                                        <?php if (!empty($commission_rate)){?>
                                            <?=$commission_rate->commission_rate_name; ?> - <?= ucfirst($commission_rate->commission_rate_percent); ?>%
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?php _trans('url_client_profile'); ?>
                                    </th>
                                    <td class="td-amount">
                                           <span>
                                                <?= base_url('/index.php/guest/view/client/'.$client->client_url_key)?>
                                            </span>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>

                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('personal_information'); ?>
                            </div>

                                <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <tr>
                                        <th><?php _trans('client_surname'); ?></th>
                                        <td><?php _htmle($client->client_surname)?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('email'); ?></th>
                                        <td><?php _auto_link($client->client_email, 'email'); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('email'); ?> 2</th>
                                        <td><?php _auto_link($client->client_email2, 'email'); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('web'); ?></th>
                                        <td><?php _auto_link($client->client_web, 'url', true); ?></td>
                                    </tr>

                                    <?php /*foreach ($custom_fields as $custom_field) : */?><!--
                                        <?php /*if ($custom_field->custom_field_location != 3) {
                                            continue;
                                        } */?>
                                        <tr>
                                            <?php
/*                                            $column = $custom_field->custom_field_label;
                                            $value = $this->mdl_client_custom->form_value('cf_' . $custom_field->custom_field_id);
                                            */?>
                                            <th><?php /*_htmlsc($column); */?></th>
                                            <td><?php /*_htmlsc($value); */?></td>
                                        </tr>
                                    --><?php /*endforeach; */?>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default no-margin">
                            <div class="panel-heading"><?php _trans('contact_information'); ?></div>
                            <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <?php if ($client->client_name) : ?>
                                        <tr>
                                            <th><?php _trans('company_name'); ?></th>
                                            <td><?php _htmlsc($client->client_name); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($client->first_name_contact_person) : ?>
                                        <tr>
                                            <th><?php _trans('first_name_contactperson'); ?></th>
                                            <td><?php _htmlsc($client->first_name_contact_person); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($client->surname_contact_person) : ?>
                                        <tr>
                                            <th><?php _trans('surname_contactperson'); ?></th>
                                            <td><?php _htmlsc($client->surname_contact_person); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th><?php _trans('phone_number'); ?></th>
                                        <td><?= $client->client_phone?></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <hr>

                <div class="row">

                <?php
                    if ($this->session->userdata('user_type') == TYPE_ADMIN) {
                ?>
                    <div class="col-xs-12 col-md-6">

                        <div class="panel panel-default no-margin">
                            <div class="panel-heading"><?php _trans('delivery_address'); ?></div>
                            <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <tr>
                                        <th><?php _trans('city'); ?></th>
                                        <td><?php _htmlsc($client->client_city_delivery); ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php _trans('state'); ?></th>
                                        <td><?php _htmlsc($client->client_state_delivery); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('zip_code'); ?></th>
                                        <td><?php _htmlsc($client->client_zip_delivery); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('country'); ?></th>
                                        <td><?php _htmlsc(get_country_name(trans('cldr'), $client->client_country_delivery)); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                <?php
                    }
                ?>

                    <div class="col-xs-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('personal_information'); ?>
                            </div>

                            <div class="panel-body table-content">
                                <table class="table no-margin">
                                    <tr>
                                        <th><?php _trans('birthdate'); ?></th>
                                        <td><?php echo format_date($client->client_birthdate); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('gender'); ?></th>
                                        <td><?php echo format_gender($client->client_gender) ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>

                <?php
                if ($custom_fields) : ?>
                    <hr>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="panel panel-default no-margin">

                                <div class="panel-heading">
                                    <?php _trans('custom_fields'); ?>
                                </div>
                                <div class="panel-body table-content">
                                    <table class="table no-margin">
                                        <?php foreach ($custom_fields as $custom_field) : ?>
                                            <?php if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            } ?>
                                            <tr>
                                                <?php
                                                $column = $custom_field->custom_field_label;
                                                $value = $this->mdl_client_custom->form_value('cf_' . $custom_field->custom_field_id);
                                                ?>
                                                <th><?php _htmlsc($column); ?></th>
                                                <td><?php _htmlsc($value); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <hr>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <?php if(!empty($client->client_file)){ ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php _trans('client_additional_information'); ?>
                                </div>
                                <div class="panel-body table-content text-center">
                                    <div class="col margin-top">
                                        <a href="<?= base_url('/clients/'.$client->client_file) ?>" download>
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
                                    <?php if ($client->client_vat_id) : ?>
                                        <tr>
                                            <th><?php _trans('vat_id'); ?></th>
                                            <td><?php _htmlsc($client->client_vat_id); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($client->client_tax_code) : ?>
                                        <tr>
                                            <th><?php _trans('tax_code'); ?></th>
                                            <td><?php _htmlsc($client->client_tax_code); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php foreach ($custom_fields as $custom_field) : ?>
                                        <?php if ($custom_field->custom_field_location != 4) {
                                            continue;
                                        } ?>
                                        <tr>
                                            <?php
                                            $column = $custom_field->custom_field_label;
                                            $value = $this->mdl_client_custom->form_value('cf_' . $custom_field->custom_field_id);
                                            ?>
                                            <th><?php _htmlsc($column); ?></th>
                                            <td><?php _htmlsc($value); ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr>
                                        <th><?php _trans('birthdate'); ?></th>
                                        <td><?php echo format_date($client->client_birthdate); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('gender'); ?></th>
                                        <td><?php echo format_gender($client->client_gender) ?></td>
                                    </tr>
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
                                <input type="hidden" name="client_id" id="client_id"
                                       value="<?php echo $client->client_id; ?>">
                                <div class="input-group">
                                    <textarea id="client_note" class="form-control" rows="2" style="resize:none"></textarea>
                                    <span id="save_client_note" class="input-group-addon btn btn-default">
                                        <?php _trans('add_note'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
    <?php
        if (USE_QUOTES) {
    ?>
            <div id="clientQuotes" class="tab-pane table-content">
                <?php echo $quote_table; ?>
            </div>
    <?php
        }
    ?>

            <div id="clientInvoices" class="tab-pane table-content">
                <?php echo $invoice_table; ?>
            </div>

            <div id="clientPayments" class="tab-pane table-content">
                <?php echo $payment_table; ?>
            </div>
<!--            <div id="clientOrders" class="tab-pane table-content">-->
<!---->
<!--            </div>-->
            <div id="clientPaymentArrangement" class="tab-pane table-content">
                <?php echo $payment_arrangements; ?>
            </div>
        </div>

    </div>

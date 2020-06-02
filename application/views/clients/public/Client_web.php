<div id="show_client" style="display: none">
<?php echo $menu?>
<script>
    $(function () {
        $('#save_client_note').click(function () {
            $.post('<?php echo site_url('clients/ajax/save_client_note'); ?>',
                {
                    client_id: $('#client_id').val(),
                    client_note: $('#client_note').val()
                }, function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful
                        $('.control-group').removeClass('error');
                        $('#client_note').val('');

                        // Reload all notes
                        $('#notes_list').load("<?php echo site_url('clients/ajax/load_client_notes'); ?>",
                            {
                                client_id: <?php echo $client->client_id; ?>
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
</div>

<ul id="submenu" class="nav nav-tabs nav-tabs-noborder">
    <li class="active"><a data-toggle="tab" href="#clientDetails"><?php _trans('details'); ?></a></li>


        <?php if (USE_QUOTES) {  ?>
            <li><a data-toggle="tab" href="#clientQuotes"><?php _trans('quotes'); ?></a></li>
        <?php } ?>
        <li><a data-toggle="tab" href="#clientInvoices"><?php _trans('invoices'); ?></a></li>
        <li><a data-toggle="tab" href="#clientRecurringInvoices"><?php _trans('recurring_invoices'); ?></a></li>
        <li><a data-toggle="tab" href="#clientPayments"><?php _trans('payments'); ?></a></li>
        <li><a data-toggle="tab" href="#clientProjects"><?php _trans('projects'); ?></a></li>
        <li><a data-toggle="tab" href="#clientPaymentArrangements"><?php _trans('payment_arrangements'); ?></a></li>

</ul>

<div id="content" class="tabbable tabs-below no-padding"  >
    <div class="tab-content no-padding">

        <div id="clientDetails" class="tab-pane tab-rich-content active">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">

                    <h3><?php _htmlsc(format_client($client)); ?></h3>
                    <p>
                        <?php
                            $this->layout->load_view('clients/partial_client_address');
                        ?>
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
                                <?php _trans('group_name'); ?>
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

                                    <tr>
                                        <th><?php _trans('email'); ?></th>
                                        <td><?php _auto_link($client->client_email, 'email'); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('email'); ?></th>
                                        <td><?php _auto_link($client->client_email2, 'email'); ?></td>
                                    </tr>


                                    <tr>
                                        <th><?php _trans('phone'); ?></th>
                                        <td><?php _htmlsc($client->client_phone); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('mobile'); ?></th>
                                        <td><?php _htmlsc($client->client_mobile); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('fax'); ?></th>
                                        <td><?php _htmlsc($client->client_fax); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _trans('web'); ?></th>
                                        <td><?php _auto_link($client->client_web, 'url', true); ?></td>
                                    </tr>

                                <?php foreach ($custom_fields as $custom_field) : ?>
                                    <?php if ($custom_field->custom_field_location != 2) {
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

                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading"><?php _trans('delivery_address'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <tr>
                                    <th><?php _trans('street_address'); ?></th>
                                    <td><?php _htmlsc($client->client_address_1_delivery); ?></td>
                                </tr>
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
                <!--<div class="col-xs-12 col-md-6">
                    <div class="panel panel-default no-margin">
                        <div class="panel-heading"><?php /*_trans('tax_information'); */?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php /*if ($client->client_vat_id) : */?>
                                    <tr>
                                        <th><?php /*_trans('vat_id'); */?></th>
                                        <td><?php /*_htmlsc($client->client_vat_id); */?></td>
                                    </tr>
                                <?php /*endif; */?>
                                <?php /*if ($client->client_tax_code) : */?>
                                    <tr>
                                        <th><?php /*_trans('tax_code'); */?></th>
                                        <td><?php /*_htmlsc($client->client_tax_code); */?></td>
                                    </tr>
                                <?php /*endif; */?>

                                <?php /*foreach ($custom_fields as $custom_field) : */?>
                                    <?php /*if ($custom_field->custom_field_location != 4) {
                                        continue;
                                    } */?>
                                    <tr>
                                        <?php
/*                                        $column = $custom_field->custom_field_label;
                                        $value = $this->mdl_client_custom->form_value('cf_' . $custom_field->custom_field_id);
                                        */?>
                                        <th><?php /*_htmlsc($column); */?></th>
                                        <td><?php /*_htmlsc($value); */?></td>
                                    </tr>
                                <?php /*endforeach; */?>
                            </table>
                        </div>

                    </div>
                </div>-->
            </div>


            <hr>

            <div class="row">




                <?php if ($client->client_surname != ""): //Client is not a company ?>
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
                                    <?php if ($this->mdl_settings->setting('sumex') == '1'): ?>
                                        <tr>
                                            <th><?php _trans('sumex_ssn'); ?></th>
                                            <td><?php echo format_avs($client->client_avs) ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php _trans('sumex_insurednumber'); ?></th>
                                            <td><?php _htmlsc($client->client_insurednumber) ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php _trans('sumex_veka'); ?></th>
                                            <td><?php _htmlsc($client->client_veka) ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php foreach ($custom_fields as $custom_field) : ?>
                                        <?php if ($custom_field->custom_field_location != 3) {
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

                <?php endif; ?>
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
        <div id="clientRecurringInvoices" class="tab-pane table-content">
            <?php echo $invoices_recurring_table; ?>
        </div>

        <div id="clientPayments" class="tab-pane table-content">
            <?php echo $payment_table; ?>
        </div>
        <div id="clientProjects" class="tab-pane table-content">
            <?php echo $project_table; ?>
        </div>
        <div id="clientPaymentArrangements" class="tab-pane table-content">
            <?php echo $payment_arrangements; ?>
        </div>
    </div>

</div>

</div>

<script>

    localStorage.clear()
    function passWord() {
        var testV = true;

        var password = "<?=$client->client_guest_pass?>"

        if(password != ''){
            var pass1 = prompt('Please Enter Your Password','');
            while (testV) {
                /*if (!pass1)
                    history.go(-1);*/
                if (pass1== password) {
                    // .toLowerCase()
                    //     testV = false
                    /*alert('Password is correct');*/
                    localStorage.setItem('user',<?=+$client->client_id?> );
                    document.getElementById("show_client").style.display = "block";

                    return
                }
                pass1 =
                    prompt('Access Denied - Password Incorrect, Please Try Again.','');
            }
            if (pass1.toLowerCase()!= "password" && !testV){
                history.go(-1);
            }
        }else{
            document.getElementById("show_client").style.display = "block";
        }

    }

    passWord()



</script>
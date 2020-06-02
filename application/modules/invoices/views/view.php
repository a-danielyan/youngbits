<?php
$cv = $this->controller->view_data["custom_values"];
?>

<script>
    $(function () {
        $('.item-task-id').each(function () {
            // Disable client chaning if at least one item already has a task id assigned
            if ($(this).val().length > 0) {
                $('#invoice_change_client').hide();
                return false;
            }
        });

        $('.btn_add_product').click(function () {
            $('#modal-placeholder').load(
                "<?php echo site_url('products/ajax/modal_product_lookups'); ?>/" + Math.floor(Math.random() * 1000)
            );
        });

        $('.btn_add_task').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('tasks/ajax/modal_task_lookups/' . $invoice_id); ?>/" + Math.floor(Math.random() * 1000));
        });

        $('.btn_add_row').click(function () {
            $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        });

        <?php if (!$items) { ?>
        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>

        $('#btn_create_recurring').click(function () {
            $('#modal-placeholder').load(
                "<?php echo site_url('invoices/ajax/modal_create_recurring'); ?>",
                {
                    invoice_id: <?php echo $invoice_id; ?>
                }
            );
        });

        $('#invoice_change_client').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_change_client'); ?>", {
                invoice_id: <?php echo $invoice_id; ?>,
                client_id: "<?php echo $this->db->escape_str($invoice->client_id); ?>"
            });
        });

        $('#btn_save_invoice').click(function () {
            var items = [];
            var item_order = 1;
            $('table tbody.item').each(function () {
                var row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        row[$(this).attr('name')] = $(this).val();
                    }
                });
                row['item_order'] = item_order;
                item_order++;
                items.push(row);
            });
            $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
                    invoice_id: <?php echo $invoice_id; ?>,
                    invoice_number: $('#invoice_number').val(),
                    invoice_date_created: $('#invoice_date_created').val(),
                    invoice_date_due: $('#invoice_date_due').val(),
                    invoice_status_id: $('#invoice_status_id').val(),
                    invoice_company_id: $('#invoice_company_id').val(),
                    invoice_password: $('#invoice_password').val(),
                    items: JSON.stringify(items),
                    invoice_discount_amount: $('#invoice_discount_amount').val(),
                    invoice_discount_percent: $('#invoice_discount_percent').val(),
                    invoice_extra_description: $('#invoice_extra_description').val(),
                    invoice_terms: $('#invoice_terms').val(),
                    custom: $('input[name^=custom],select[name^=custom]').serializeArray(),
                    payment_method: $('#payment_method').val(),
                    customer_contact: $('#customer_contact').val(),
                    order_date: $('#order_date').val(),
                    order: $('#order').val(),
                    purchase_order: $('#purchase_order').val(),
                    currency: $('#currency').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        //window.location = "<?php //echo site_url('invoices/view'); ?>///" + <?php //echo $invoice_id; ?>//;
                        window.location = "<?php echo $referer_url; ?>";
                    } else {
                        $('#fullpage-loader').hide();
                        $('.control-group').removeClass('has-error');
                        $('div.alert[class*="alert-"]').remove();
                        var resp_errors = response.validation_errors,
                            all_resp_errors = '';
                        for (var key in resp_errors) {
                            $('#' + key).parent().addClass('has-error');
                            all_resp_errors += resp_errors[key];
                        }
                        $('#invoice_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
                    }
                });
        });

        $('#btn_generate_pdf').click(function () {
            window.open('<?php echo site_url('invoices/generate_pdf/' . $invoice_id); ?>', '_blank');
        });

        <?php if ($invoice->is_read_only != 1): ?>
        var fixHelper = function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width())
            });
            return $helper;
        };

        $("#item_table").sortable({
            items: 'tbody',
            helper: fixHelper
        });

        if ($('#invoice_discount_percent').val().length > 0) {
            $('#invoice_discount_amount').prop('disabled', true);
        }
        /*if ($('#invoice_discount_amount').val().length > 0) {
            $('#invoice_discount_percent').prop('disabled', true);
        }*/

        $('#invoice_discount_amount').keyup(function () {
            if (this.value.length > 0) {
                $('#invoice_discount_percent').prop('disabled', true);
            } else {
                $('#invoice_discount_percent').prop('disabled', false);
            }
        });
        $('#invoice_discount_percent').keyup(function () {
            if (this.value.length > 0) {
                $('#invoice_discount_amount').prop('disabled', true);
            } else {
                $('#invoice_discount_amount').prop('disabled', false);
            }
        });
        <?php endif; ?>

        <?php if ($invoice->invoice_is_recurring) : ?>
        $(document).on('click', '.js-item-recurrence-toggler', function () {
            var itemRecurrenceState = $(this).next("input").val();
            if (itemRecurrenceState === ("1")) {
                $(this).next("input").val("0");
                $(this).removeClass("fa-calendar-check-o text-success");
                $(this).addClass("fa-calendar-o text-muted");
            } else {
                $(this).next("input").val("1");
                $(this).removeClass("fa-calendar-o text-muted");
                $(this).addClass("fa-calendar-check-o text-success");
            }
        });
        <?php endif; ?>

    });
</script>

<?php
echo $modal_delete_invoice;
echo $modal_add_invoice_tax;
if ($this->config->item('disable_read_only') == true) {
    $invoice->is_read_only = 0;
}
?>

<div id="headerbar">
    <h1 class="headerbar-title">
        <?php
        echo trans('invoice') . ' ';
        echo($invoice->invoice_number ? '#' . $invoice->invoice_number : $invoice->invoice_id);
        ?>
    </h1>


    <div class="headerbar-item pull-right <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) { ?>btn-group<?php } ?>">

        <div class="options btn-group btn-group-sm">
            <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-caret-down no-margin"></i> <?php _trans('options'); ?>
            </a>
            <ul class="dropdown-menu">
                <?php if ($invoice->is_read_only != 1) { ?>
                    <li>
                        <a href="#add-invoice-tax" data-toggle="modal">
                            <i class="fa fa-plus fa-margin"></i> <?php _trans('add_invoice_tax'); ?>
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="#" id="btn_create_credit" data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-minus fa-margin"></i> <?php _trans('create_credit_invoice'); ?>
                    </a>
                </li>
                <?php if ($invoice->invoice_balance != 0 && $this->session->userdata('user_type') != TYPE_MANAGERS) : ?>
                    <li>
                        <a href="#" class="invoice-add-payment"
                           data-invoice-id="<?php echo $invoice_id; ?>"
                           data-invoice-balance="<?php echo $invoice->invoice_balance; ?>"
                           data-invoice-payment-method="<?php echo $invoice->payment_method; ?>">
                            <i class="fa fa-credit-card fa-margin"></i>
                            <?php _trans('enter_payment'); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="#" id="btn_generate_pdf"
                       data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-print fa-margin"></i>
                        <?php _trans('download_pdf'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                        <i class="fa fa-send fa-margin"></i>
                        <?php _trans('send_email'); ?>
                    </a>
                </li>
                <li class="divider"></li>
                <li <?= (!empty($invoices_recurring))? "class='disabled'": ''; ?>>
                    <a href="#" id="btn_create_recurring"
                       data-invoice-id="<?php echo $invoice_id; ?>" >
                        <i class="fa fa-repeat fa-margin"></i>
                        <?php _trans('create_recurring'); ?>
                    </a>
                </li>
                <li>
                    <a href="#" id="btn_copy_invoice"
                       data-invoice-id="<?php echo $invoice_id; ?>">
                        <i class="fa fa-copy fa-margin"></i>
                        <?php _trans('copy_invoice'); ?>
                    </a>
                </li>
                <?php if ($invoice->invoice_status_id == 1 || ($this->config->item('enable_invoice_deletion') === true && $invoice->is_read_only != 1)) { ?>
                    <li>
                        <a href="#delete-invoice" data-toggle="modal">
                            <i class="fa fa-trash-o fa-margin"></i>
                            <?php _trans('delete'); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

<!--        --><?php //if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) { ?>
            <a href="#" class="btn btn-sm btn-success ajax-loader" id="btn_save_invoice">
                <i class="fa fa-check"></i> <?php _trans('save'); ?>
            </a>
<!--        --><?php //} ?>
    </div>

    <div class="headerbar-item invoice-labels pull-right">
        <?php if ($invoice->invoice_is_recurring) { ?>
            <span class="label label-info"><?php _trans('recurring'); ?></span>
        <?php } ?>
        <?php if ($invoice->is_read_only == 1) { ?>
            <span class="label label-danger">
                <i class="fa fa-read-only"></i> <?php _trans('read_only'); ?>
            </span>
        <?php } ?>
    </div>

</div>

<div id="content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <form id="invoice_form">
        <div class="invoice">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5">

                    <h3>
                        <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>">
                            <?php _htmlsc(format_client($invoice)) ?>
                        </a>
                        <?php if ($invoice->invoice_status_id == 1 && !$invoice->creditinvoice_parent_id) { ?>
                            <span id="invoice_change_client" class="fa fa-edit cursor-pointer small"
                                  data-toggle="tooltip" data-placement="bottom"
                                  title="<?php _trans('change_client'); ?>"></span>
                        <?php } ?>
                    </h3>
                    <br>
                    <div class="client-address">
                        <?php $this->layout->load_view('clients/partial_client_address', array('client' => $invoice)); ?>
                    </div>
                    <?php if ($invoice->client_phone || $invoice->client_email) : ?>
                        <hr>
                    <?php endif; ?>
                    <?php if ($invoice->client_phone): ?>
                        <div>
                            <?php _trans('phone'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_phone); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_email): ?>
                        <div>
                            <?php _trans('email'); ?>:&nbsp;
                            <?php _auto_link($invoice->client_email); ?>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <b><?php _trans('delivery_address'); ?></b>
                    <?php if ($invoice->client_address_1_delivery): ?>
                        <div>
                            <?php _trans('street_address'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_address_1_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_address_2_delivery): ?>
                        <div>
                            <?php _trans('street_address_2'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_address_2_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_city_delivery): ?>
                        <div>
                            <?php _trans('city'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_city_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_state_delivery): ?>
                        <div>
                            <?php _trans('state'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_state_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_zip_delivery): ?>
                        <div>
                            <?php _trans('zip_code'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_zip_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_country_delivery): ?>
                        <div>
                            <?php _trans('country'); ?>:&nbsp;
                            <?php _htmlsc(get_country_name(trans('cldr'), $invoice->client_country_delivery)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-xs-12 visible-xs"><br></div>

                <div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1">
                    <div class="details-box panel panel-default panel-body">
                        <div class="row">

                            <?php if ($invoice->invoice_sign == -1) { ?>
                                <div class="col-xs-12">
                                    <div class="alert alert-warning small">
                                        <i class="fa fa-credit-invoice"></i>&nbsp;
                                        <?php
                                        echo trans('credit_invoice_for_invoice') . ' ';
                                        $parent_invoice_number = $this->mdl_invoices->get_parent_invoice_number($invoice->creditinvoice_parent_id);
                                        echo anchor('/invoices/view/' . $invoice->creditinvoice_parent_id, $parent_invoice_number);
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="col-xs-12 col-md-6">

                                <div class="invoice-properties">
                                    <label><?php _trans('invoice'); ?> #</label>
                                    <input type="text" id="invoice_number" class="form-control input-sm"
                                        <?php if ($invoice->invoice_number) : ?>
                                            value="<?php echo $invoice->invoice_number; ?>"
                                        <?php else : ?>
                                            placeholder="<?php _trans('not_set'); ?>"
                                        <?php endif; ?>>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php _trans('invoice_created_by'); ?> </label>
                                    <input type="text" class="form-control input-sm"
                                           value="<?php _htmlsc($invoice->user_name); ?>"
                                            >
                                </div>

                                <div class="invoice-properties has-feedback">
                                    <label><?php _trans('date'); ?></label>

                                    <div class="input-group">
                                        <input name="invoice_date_created" id="invoice_date_created"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($invoice->invoice_date_created); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="invoice-properties has-feedback">
                                    <label><?php _trans('due_date'); ?></label>

                                    <div class="input-group">
                                        <input name="invoice_date_due" id="invoice_date_due"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($invoice->invoice_date_due); ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>


                                <!-- Custom fields -->
                                <?php foreach ($custom_fields as $custom_field): ?>
                                    <?php if ($custom_field->custom_field_location != 1) {
                                        continue;
                                    } ?>
                                    <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                <?php endforeach; ?>
                                <?php if ($invoice->invoice_status_id != 1) { ?>

                                        <div class="invoice-properties has-feedback">
                                            <label for="invoice-guest-url"><?php _trans('guest_url'); ?></label>
                                            <div class="input-group">
                                                <input type="text" id="invoice-guest-url" readonly class="form-control"
                                                       value="<?php echo site_url('guest/view/invoice/' . $invoice->invoice_url_key) ?>">
                                                <span class="input-group-addon to-clipboard cursor-pointer"
                                                      data-clipboard-target="#invoice-guest-url">
                                                <i class="fa fa-clipboard fa-fw"></i>
                                            </span>
                                            </div>
                                        </div>

                                <?php } ?>
                                <div class="invoice-properties has-feedback">
                                    <label><?php _trans('Order date'); ?></label>

                                    <div class="input-group">
                                        <input name="order_date" id="order_date"
                                               class="form-control input-sm datepicker"
                                               value=""
                                        >
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="invoice-properties">
                                    <label><?php _trans('Purchase Order'); ?> </label>
                                    <input name="purchase_order" id="purchase_order" type="text" class="form-control input-sm"
                                           value="<?php _htmlsc($invoice->purchase_order); ?>"
                                    >
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6">

                                <div class="invoice-properties">
                                    <label>
                                        <?php _trans('status');
                                        if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) {
                                            echo ' <span class="small">(' . trans('can_be_changed') . ')</span>';
                                        } ?>
                                    </label>
                                    <select name="invoice_status_id" id="invoice_status_id"
                                            class="form-control input-sm simple-select">
                                        <?php foreach ($invoice_statuses as $key => $status) { ?>
                                            <option value="<?php echo $key; ?>"
                                                    <?php if ($key == $invoice->invoice_status_id) { ?>selected="selected"<?php } ?>>
                                                <?php echo $status['label']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php _trans('payment_method'); ?></label>
                                    <select name="payment_method" id="payment_method"
                                            class="form-control input-sm simple-select">
                                        <option value="0"><?php _trans('select_payment_method'); ?></option>
                                        <?php foreach ($payment_methods as $payment_method) { ?>
                                            <option <?php if ($invoice->payment_method == $payment_method->payment_method_id) echo "selected" ?>
                                                    value="<?php echo $payment_method->payment_method_id; ?>">
                                                <?php echo $payment_method->payment_method_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php _trans('invoice_password'); ?></label>
                                    <input type="text" id="invoice_password" class="form-control input-sm"
                                           value="<?php echo $invoice->invoice_password; ?>">
                                </div>

                                <div class="invoice-properties">
                                    <label><?php _trans('company'); ?></label>
                                    <select name="invoice_company_id" id="invoice_company_id"
                                            class="form-control input-sm simple-select">
                                        <option value="0"><?php _trans('no_company'); ?></option>
                                        <?php foreach ($companies as $company) { ?>
                                            <option <?php if ($invoice->invoice_company_id == $company->id) echo "selected" ?>
                                                    value="<?php echo $company->id; ?>">
                                                <?php echo $company->name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="invoice-properties">
                                    <label><?php _trans('Ship To'); ?></label>
                                    <select name="ship_to" id="ship_to"
                                            class="form-control input-sm simple-select">
                                        <option value="0"><?php _trans('no_company'); ?></option>
                                        <?php foreach ($companies as $company) { ?>
                                            <option <?php if ($invoice->invoice_company_id == $company->id) echo "selected" ?>
                                                    value="<?php echo $company->id; ?>">
                                                <?php echo $company->name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="invoice-properties">
                                    <label><?php _trans('Order'); ?></label>
                                    <input type="text" id="order" class="form-control input-sm"
                                           value="<?php echo $invoice->order; ?>">
                                </div>
                                <div class="invoice-properties">
                                    <label><?php _trans('Customer Contact'); ?></label>
                                    <input type="text" id="customer_contact" class="form-control input-sm"
                                           value="<?php echo $invoice->customer_contact; ?>">
                                </div>
                                <div class="invoice-properties">
                                    <label><?php _trans('Currency'); ?></label>
                                    <?php $invoice_currency = $currency ? $currency->currency :'EUR'; ?>
                                    <select name="currency" id="currency"
                                            class="form-control input-sm simple-select">
                                        <?php foreach (get_currencies() as $cur) { ?>
                                            <option <?php if ($invoice_currency == $cur) echo "selected" ?>
                                                    value="<?= $cur ?>">
                                                <?= $cur; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>




                            <?php if ($offer != null) { ?>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="offer-url"><?php _trans('offer'); ?></label>
                                        <div class="input-group">
                                            <input type="text" id="offer-url" readonly class="form-control"
                                                   value="<?php echo site_url('offers/view/' . $offer->offer_id) ?>">
                                            <span class="input-group-addon to-clipboard cursor-pointer"
                                                  data-clipboard-target="#offer-url">
                                                <i class="fa fa-clipboard fa-fw"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </div>

            <br>

            <?php $this->layout->load_view('invoices/partial_item_table'); ?>

            <hr/>

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading">
                            <?php _trans('invoice_terms'); ?>
                        </div>
                        <div class="panel-body">
                            <textarea id="invoice_terms" name="invoice_terms" class="form-control" rows="3"
                            ><?php _htmlsc($invoice->invoice_terms); ?></textarea>
                        </div>
                    </div>

                    <div class="col-xs-12 visible-xs visible-sm"><br></div>

                </div>
                <div class="col-xs-12 col-md-6">

                    <?php $this->layout->load_view('upload/dropzone-invoice-html'); ?>

                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading">
                            <?php _trans('extra_description'); ?>
                        </div>
                        <div class="panel-body">
                            <textarea id="invoice_extra_description" name="invoice_extra_description" class="form-control" rows="3"><?php _htmlsc($invoice->invoice_extra_description); ?></textarea>
                        </div>
                    </div>


                </div>
            </div>

            <?php if ($custom_fields): ?>
                <div class="row">
                    <div class="col-xs-12">

                        <hr>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('custom_fields'); ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-xs-12 col-md-6">
                                        <?php $i = 0; ?>
                                        <?php foreach ($custom_fields as $custom_field): ?>
                                            <?php if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            } ?>
                                            <?php $i++; ?>
                                            <?php if ($i % 2 != 0): ?>
                                                <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <?php $i = 0; ?>
                                        <?php foreach ($custom_fields as $custom_field): ?>
                                            <?php if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            } ?>
                                            <?php $i++; ?>
                                            <?php if ($i % 2 == 0): ?>
                                                <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

        </div>

    </form>
</div>

<?php $this->layout->load_view('upload/dropzone-invoice-scripts'); ?>
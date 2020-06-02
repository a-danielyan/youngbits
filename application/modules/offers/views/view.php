<?php
// todo - OK all
// needs more to do save button, options...
?>
<script>
    $(function () {
        $('.item-task-id').each(function () {
            // Disable client chaning if at least one item already has a task id assigned
            if ($(this).val().length > 0) {
                $('#offer_change_client').hide();
                return false;
            }
        });

        $('.btn_add_product').click(function () {
            $('#modal-placeholder').load(
                "<?php echo site_url('products/ajax/modal_product_lookups'); ?>/" + Math.floor(Math.random() * 1000)
            );
        });

        $('.btn_add_task').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('tasks/ajax/modal_task_lookups/' . $offer_id); ?>/" + Math.floor(Math.random() * 1000));
        });

        $('.btn_add_row').click(function () {
            $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
            return false;
        });

        <?php if (!$items) { ?>
        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>

        $('#offer_change_client').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('offers/ajax/modal_change_client'); ?>", {
                offer_id: <?php echo $offer_id; ?>,
                client_id: "<?php echo $this->db->escape_str($offer->client_id); ?>"
            });
        });

        $('#btn_save_offer').click(function () {
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
            $.post("<?php echo site_url('offers/ajax/save'); ?>", {
                    offer_id: <?php echo $offer_id; ?>,
                    offer_number: $('#offer_number').val(),
                    offer_date_created: $('#offer_date_created').val(),
                    offer_due_date: $('#offer_due_date').val(),
                    invoice_number: $('#invoice_number').val(),
                    invoice_due_date: $('#invoice_due_date').val(),
                    package_id: $('#package_id').val(),
                    boxpallets: $('#boxpallets').val(),
                    dimensions: $('#dimensions').val(),
                    offer_url_key: $('#offer_url_key').val(),
                    offer_status_id: $('#offer_status_id').val(),
                    offer_password: $('#offer_password').val(),
                    items: JSON.stringify(items),
                    offer_discount_amount: $('#offer_discount_amount').val(),
                    offer_discount_percent: $('#offer_discount_percent').val(),
                    offer_terms: $('#offer_terms').val(),
                    payment_method: $('#payment_method').val(),
                    transport_tailgate: $('#transport_tailgate').val(),
                    transport_without_tailgate: $('#transport_without_tailgate').val(),
                    transport_tax_rate_id: $('#transport_tax_rate_id').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        window.location = "<?php echo site_url('offers/view'); ?>/" + <?php echo $offer_id; ?>;
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
                        $('#offer_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
                    }
                });
        });

        $('#btn_generate_pdf').click(function () {
            window.open('<?php echo site_url('offers/generate_pdf/' . $offer_id); ?>', '_blank');
        });

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

        if ($('#offer_discount_percent').val().length > 0) {
            $('#offer_discount_amount').prop('disabled', true);
        }
        if ($('#offer_discount_amount').val().length > 0) {
            $('#offer_discount_percent').prop('disabled', true);
        }

        $('#offer_discount_amount').keyup(function () {
            if (this.value.length > 0) {
                $('#offer_discount_percent').prop('disabled', true);
            } else {
                $('#offer_discount_percent').prop('disabled', false);
            }
        });
        $('#offer_discount_percent').keyup(function () {
            if (this.value.length > 0) {
                $('#offer_discount_amount').prop('disabled', true);
            } else {
                $('#offer_discount_amount').prop('disabled', false);
            }
        });
    });
</script>

<?php
echo $modal_delete_offer;
?>

<div id="headerbar">
    <h1 class="headerbar-title">
        <?php
        echo trans('offer') . ' ';
        echo($offer->offer_number ? '#' . $offer->offer_number : $offer->offer_id);
        ?>
    </h1>

    <div class="headerbar-item pull-right btn-group">
        <div class="options btn-group btn-group-sm">
            <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-caret-down no-margin"></i> <?php _trans('options'); ?>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" id="btn_generate_pdf"
                       data-offer-id="<?php echo $offer_id; ?>">
                        <i class="fa fa-print fa-margin"></i>
                        <?php _trans('download_pdf'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('mailer/offer/' . $offer->offer_id); ?>">
                        <i class="fa fa-send fa-margin"></i>
                        <?php _trans('send_email'); ?>
                    </a>
                </li>
                <?php if ($offer->offer_status_id == 1 || ($this->config->item('enable_offer_deletion') === true)) { ?>
                    <li>
                        <a href="#delete-offer" data-toggle="modal">
                            <i class="fa fa-trash-o fa-margin"></i>
                            <?php _trans('delete'); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <a href="#" class="btn btn-sm btn-success ajax-loader" id="btn_save_offer">
            <i class="fa fa-check"></i> <?php _trans('save'); ?>
        </a>
    </div>
    <div class="headerbar-item offer-labels pull-right"></div>
</div>

<div id="content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <form id="offer_form">
        <div class="offer">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <h3>
                        <a href="<?php echo site_url('clients/view/' . $offer->client_id); ?>">
                            <?php _htmlsc(format_client($offer)) ?>
                        </a>
                        <?php if ($offer->offer_status_id == 1) { ?>
                            <span id="offer_change_client" class="fa fa-edit cursor-pointer small"
                                  data-toggle="tooltip" data-placement="bottom"
                                  title="<?php _trans('change_client'); ?>"></span>
                        <?php } ?>
                    </h3>
                    <br>
                    <div class="client-address">
                        <?php $this->layout->load_view('clients/partial_client_address', array('client' => $offer)); ?>
                    </div>
                    <?php if ($offer->client_phone || $offer->client_email) : ?>
                        <hr>
                    <?php endif; ?>
                    <?php if ($offer->client_phone): ?>
                        <div>
                            <?php _trans('phone'); ?>:&nbsp;
                            <?php _htmlsc($offer->client_phone); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($offer->client_email): ?>
                        <div>
                            <?php _trans('email'); ?>:&nbsp;
                            <?php _auto_link($offer->client_email); ?>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <b><?php _trans('delivery_address'); ?></b>
                    <?php if ($offer->client_address_1_delivery): ?>
                        <div>
                            <?php _trans('street_address'); ?>:&nbsp;
                            <?php _htmlsc($offer->client_address_1_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($offer->client_address_2_delivery): ?>
                        <div>
                            <?php _trans('street_address_2'); ?>:&nbsp;
                            <?php _htmlsc($offer->client_address_2_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($offer->client_city_delivery): ?>
                        <div>
                            <?php _trans('city'); ?>:&nbsp;
                            <?php _htmlsc($offer->client_city_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($offer->client_state_delivery): ?>
                        <div>
                            <?php _trans('state'); ?>:&nbsp;
                            <?php _htmlsc($offer->client_state_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($offer->client_zip_delivery): ?>
                        <div>
                            <?php _trans('zip_code'); ?>:&nbsp;
                            <?php _htmlsc($offer->client_zip_delivery); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($offer->client_country_delivery): ?>
                        <div>
                            <?php _trans('country'); ?>:&nbsp;
                            <?php _htmlsc(get_country_name(trans('cldr'), $offer->client_country_delivery)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-xs-12 visible-xs"><br></div>

                <div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1">
                    <div class="details-box panel panel-default panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="offer-properties">
                                    <label>
                                        <?php _trans('status');
                                        if ($offer->offer_status_id != 4) {
                                            echo ' <span class="small">(' . trans('can_be_changed') . ')</span>';
                                        } ?>
                                    </label>
                                    <select name="offer_status_id" id="offer_status_id"
                                            class="form-control input-sm simple-select">
                                        <?php foreach ($offer_statuses as $key => $status) { ?>
                                            <option value="<?php echo $key; ?>"
                                                    <?php if ($key == $offer->offer_status_id) { ?>selected="selected"<?php } ?>>
                                                <?php echo $status['label']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="offer-properties">
                                    <label><?php _trans('offer_number'); ?> #</label>
                                    <input type="text" id="offer_number" class="form-control input-sm"
                                        <?php if ($offer->offer_number) : ?>
                                            value="<?php echo $offer->offer_number; ?>"
                                        <?php else : ?>
                                            placeholder="<?php _trans('not_set'); ?>"
                                        <?php endif; ?>>
                                </div>

                                <div class="offer-properties">
                                    <label><?php _trans('invoice_number'); ?> #</label>
                                    <input type="text" id="invoice_number" class="form-control input-sm"
                                        <?php if ($offer->invoice_number) : ?>
                                            value="<?php echo $offer->invoice_number; ?>"
                                        <?php else : ?>
                                            placeholder="<?php _trans('not_set'); ?>"
                                        <?php endif; ?>>
                                </div>

                                <div class="offer-properties has-feedback">
                                    <label><?php _trans('package_id'); ?></label>
                                    <input type="text" id="package_id" class="form-control input-sm"
                                           value="<?php echo $offer->package_id; ?>">
                                </div>

                                <div class="offer-properties has-feedback">
                                    <label><?php _trans('boxpallets'); ?></label>
                                    <input type="text" id="boxpallets" class="form-control input-sm"
                                           value="<?php echo $offer->boxpallets; ?>">
                                </div>

                                <div class="offer-properties has-feedback">
                                    <label><?php _trans('date'); ?></label>

                                    <div class="input-group">
                                        <input name="offer_date_created" id="offer_date_created"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($offer->offer_date_created); ?>"
                                               >
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6">

                                <div class="offer-properties">
                                    <label><?php _trans('payment_method'); ?></label>
                                    <select name="payment_method" id="payment_method"
                                            class="form-control input-sm simple-select"
                                        <?php if ($offer->offer_status_id == 4) {
                                            echo 'disabled="disabled"';
                                        } ?>>
                                        <option value="0"><?php _trans('select_payment_method'); ?></option>
                                        <?php foreach ($payment_methods as $payment_method) { ?>
                                            <option <?php if ($offer->payment_method == $payment_method->payment_method_id) echo "selected" ?>
                                                    value="<?php echo $payment_method->payment_method_id; ?>">
                                                <?php echo $payment_method->payment_method_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="offer-properties">
                                    <label>
                                        <?php _trans('offer_due_date'); ?>
                                    </label>

                                    <div class="input-group">
                                        <input name="offer_due_date" id="offer_due_date"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($offer->offer_due_date); ?>"
                                               >
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="offer-properties">
                                    <label>
                                        <?php _trans('invoice_due_date'); ?>
                                    </label>

                                    <div class="input-group">
                                        <input name="invoice_due_date" id="invoice_due_date"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($offer->invoice_due_date); ?>"
                                               >
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="offer-properties">
                                    <label><?php _trans('dimensions'); ?></label>
                                    <input type="text" id="dimensions" class="form-control input-sm"
                                           value="<?php echo $offer->dimensions; ?>">
                                </div>

                                 <div class="offer-properties">
                                    <label><?php _trans('offer_password'); ?></label>
                                    <input type="text" id="offer_password" class="form-control input-sm"
                                           value="<?php echo $offer->offer_password; ?>">
                                </div>
                            </div>

                            <?php if ($offer->offer_status_id != 1) { ?>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="offer-guest-url"><?php _trans('guest_url'); ?></label>
                                        <div class="input-group">
                                            <input type="text" id="offer_url_key" readonly class="form-control"
                                                   value="<?php echo site_url('guest/view/offer/' . $offer->offer_url_key) ?>">
                                            <span class="input-group-addon to-clipboard cursor-pointer"
                                                  data-clipboard-target="#offer-guest-url">
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

            <?php $this->layout->load_view('offers/partial_item_table'); ?>

            <hr>
            <div class="col-xs-12 col-sm-12 col-md-12">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="offer-properties">
                    <label><?php _trans('transport_tailgate_price'); ?></label>
                    <input type="text" id="transport_tailgate" class="form-control input-sm"
                           value="<?php echo $offer->transport_tailgate; ?>">
                </div>
                <div class="offer-properties">
                    <label><?php _trans('transport_without_tailgate_price'); ?></label>
                    <input type="text" id="transport_without_tailgate" class="form-control input-sm"
                           value="<?php echo $offer->transport_without_tailgate; ?>">
                </div>
                <div class="offer-properties">
                    <label><?php _trans('transport_tax_rate'); ?></label>
                    <select name="transport_tax_rate_id" id="transport_tax_rate_id" class="form-control input-sm" >
                        <option value="0"><?php _trans('none'); ?></option>
                        <?php foreach ($tax_rates as $tax_rate) { ?>
                            <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                <?php check_select($offer->transport_tax_rate_id, $tax_rate->tax_rate_id); ?>>
                                <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="offer-properties">
                    <label><?php _trans('offer_transport_selected_text_by_client'); ?>: <?php echo $offer->offer_transport_selected_text; ?></label>
                </div>
                <div class="offer-properties">
                    <label><?php _trans('offer_transport_price'); ?>: <?php echo format_currency($offer->offer_transport); ?></label>
                </div>
                <div class="offer-properties">
                    <label><?php _trans('offer_client_comment'); ?>: <?php echo $offer->client_comment; ?></label>
                </div>
            </div>


            <br>
            <hr>
            <div class="clearfix clear-both">
            </div>


        </div>
    </form>
</div>

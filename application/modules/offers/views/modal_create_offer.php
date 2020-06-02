<?php
//ok
?>
<script>
    $(function () {
        // Display the create offer modal
        $('#create-offer').modal('show');

        // Enable select2 for all selects
        $('.simple-select').select2();

        <?php $this->layout->load_view('clients/script_select2_client_id.js'); ?>

        // Toggle on/off permissive search on clients names
        $('#toggle_permissive_search_clients').click(function () {
            if ($('input#input_permissive_search_clients').val() == ('1')) {
                $.get("<?php echo site_url('clients/ajax/save_preference_permissive_search_clients'); ?>", {
                    permissive_search_clients: '0'
                });
                $('input#input_permissive_search_clients').val('0');
                $('span#toggle_permissive_search_clients i').removeClass('fa-toggle-on');
                $('span#toggle_permissive_search_clients i').addClass('fa-toggle-off');
            } else {
                $.get("<?php echo site_url('clients/ajax/save_preference_permissive_search_clients'); ?>", {
                    permissive_search_clients: '1'
                });
                $('input#input_permissive_search_clients').val('1');
                $('span#toggle_permissive_search_clients i').removeClass('fa-toggle-off');
                $('span#toggle_permissive_search_clients i').addClass('fa-toggle-on');
            }
        });

        // Creates the offer
        $('#offer_create_confirm').click(function () {
            // Posts the data to validate and create the offer;
            // will create the new client if necessar
            $.post("<?php echo site_url('offers/ajax/create'); ?>", {
                    client_id: $('#create_offer_client_id').val(),
                    offer_date_created: $('#offer_date_created').val(),
                    offer_time_created: '<?php echo date('H:i:s') ?>',
                    offer_password: $('#offer_password').val(),
                    user_id: '<?php echo $this->session->userdata('user_id'); ?>',
                    payment_method: $('#payment_method_id').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful and offer was created
                        window.location = "<?php echo site_url('offers/view'); ?>/" + response.offer_id;
                    }
                    else {
                        // The validation was not successful
                        $('.control-group').removeClass('has-error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('has-error');
                        }
                    }
                });
        });
    });

</script>

<div id="create-offer" class="modal modal-lg"
     role="dialog" aria-labelledby="modal_create_offer" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('create_offer'); ?></h4>
        </div>
        <div class="modal-body">

            <input class="hidden" id="payment_method_id"
                   value="<?php echo get_setting('offer_default_payment_method'); ?>">

            <input class="hidden" id="input_permissive_search_clients"
                   value="<?php echo get_setting('enable_permissive_search_clients'); ?>">

            <div class="form-group has-feedback">
                <label for="create_offer_client_id"><?php _trans('client'); ?></label>
                <div class="input-group">
                    <select name="client_id" id="create_offer_client_id" class="client-id-select form-control"
                            autofocus="autofocus">
                        <?php if (!empty($client)) : ?>
                            <option value="<?php echo $client->client_id; ?>"><?php _htmlsc(format_client($client)); ?></option>
                        <?php endif; ?>
                    </select>
                    <span id="toggle_permissive_search_clients" class="input-group-addon"
                          title="<?php _trans('enable_permissive_search_clients'); ?>" style="cursor:pointer;">
                        <i class="fa fa-toggle-<?php echo get_setting('enable_permissive_search_clients') ? 'on' : 'off' ?> fa-fw"></i>
                    </span>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label for="offer_date_created"><?php _trans('date'); ?></label>

                <div class="input-group">
                    <input name="offer_date_created" id="offer_date_created"
                           class="form-control datepicker"
                           value="<?php echo date(date_format_setting()); ?>">
                    <span class="input-group-addon">
                    <i class="fa fa-calendar fa-fw"></i>
                </span>
                </div>
            </div>

            <div class="form-group">
                <label for="offer_password"><?php _trans('offer_password'); ?></label>
                <input type="text" name="offer_password" id="offer_password" class="form-control"
                       value="<?php echo get_setting('offer_pre_password') == '' ? '' : get_setting('offer_pre_password'); ?>"
                       style="margin: 0 auto;" autocomplete="off">
            </div>

        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-success ajax-loader" id="offer_create_confirm" type="button">
                    <i class="fa fa-check"></i> <?php _trans('submit'); ?>
                </button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>

    </form>

</div>

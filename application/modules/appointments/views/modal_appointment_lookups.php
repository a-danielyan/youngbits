<script>
    $(function () {
        // Display the create invoice modal
        $('#modal-choose-items').modal('show');

        var selectedAppointments = [];
        $('.item-appointment-id').each(function () {
            var currentVal = $(this).val();
            if (currentVal.length) {
                selectedAppointments.push(parseInt(currentVal));
            }
        });

        var hiddenAppointments = 0;
        $('.modal-appointment-id').each(function () {
            var currentId = parseInt($(this).attr('id').replace('appointment-id-', ''));
            if (selectedAppointments.indexOf(currentId) !== -1) {
//                $('#appointment-id-' + currentId).prop('disabled', true);
                $('#appointment-id-' + currentId).parent().parent().hide();
                hiddenAppointments++;
            }
        });

        if (hiddenAppointments >= $('.appointment-row').length) {
            $('#appointment-modal-submit').hide();
        }

        // Creates the invoice
        $('.select-items-confirm').click(function () {
            var appointment_ids = [];

            $("input[name='appointment_ids[]']:checked").each(function () {
                appointment_ids.push(parseInt($(this).val()));
            });

            $.post("<?php echo site_url('appointments/ajax/process_appointment_selections'); ?>", {
                appointment_ids: appointment_ids
            }, function (data) {
                <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                var items = JSON.parse(data);

                for (var key in items) {
                    // Set default tax rate id if empty
                    if (!items[key].tax_rate_id) items[key].tax_rate_id = 0;

                    if ($('#item_table tbody:last input[name=item_name]').val() !== '') {
                        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
                    }
                    $('#item_table tbody:last input[name=item_appointment_id]').val(items[key].appointment_id);
                    $('#item_table tbody:last input[name=item_name]').val(items[key].appointment_name);
                    $('#item_table tbody:last textarea[name=item_description]').val(items[key].appointment_description);
                    $('#item_table tbody:last input[name=item_price]').val(items[key].appointment_price);
                    $('#item_table tbody:last input[name=item_quantity]').val('1');
                    $('#item_table tbody:last select[name=item_tax_rate_id]').val(items[key].tax_rate_id);

                    $('#modal-choose-items').modal('hide');
                    $('#invoice_change_client').hide();
                }
            });
        });

        // Toggle checkbox when click on row
        $('#appointments_table tr').click(function (event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

    });
</script>

<div id="modal-choose-items" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="modal-choose-items" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('add_appointment'); ?></h4>
        </div>

        <div class="modal-body">
            <?php $this->layout->load_view('appointments/partial_appointment_table_modal'); ?>
        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button id="appointment-modal-submit" class="select-items-confirm btn btn-success" type="button">
                    <i class="fa fa-check"></i>
                    <?php echo lang('submit'); ?>
                </button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php echo lang('cancel'); ?>
                </button>
            </div>
        </div>

    </form>

</div>
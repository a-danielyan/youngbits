<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('list_rides'); ?></h1>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('rides/list_rides'), 'mdl_appointments'); ?>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><?php _trans('appointment_date'); ?></th>
                <th><?php _trans('appointment_time'); ?></th>
                <th><?php _trans('appointment_title'); ?></th>
                <th><?php _trans('rides_departure_location'); ?></th>



                <th><?php _trans('appointment_departure_end_location'); ?></th>
                <th><?php _trans('appointment_kilometers'); ?></th>
                <th><?php _trans('fleet_starting_mileage'); ?></th>
                <th><?php _trans('fleet_end_mileage'); ?></th>
                <th><?php _trans('travel_expenses_tax_office'); ?></th>

            </tr>
            </thead>

            <tbody>


            <?php foreach ($list_rides as $ride) { ?>
                <tr>

                    <td>
                        <?=$ride->appointment_date; ?>
                    </td>
                    <td>
                        <?=$ride->appointment_total_time_of; ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($ride->appointment_title); ?>
                    </td>
                    <td>
                        <?=htmlspecialchars($ride->appointment_departure_location); ?>
                    </td>
                    <td>
                        <?=htmlspecialchars($ride->appointment_departure_end_location); ?>
                    </td>

                    <td>
                        <?=$ride->appointment_kilometers; ?>
                    </td>
                    <td>
                        <?=$ride->appointment_old_mileage; ?>
                    </td>
                    <td>
                        <?=$ride->appointment_current_mileage; ?>
                    </td>
                    <td>
                        $<?=($ride->appointment_price != 0)?format_amount($ride->appointment_price):format_amount($ride->appointment_expenses_tax_office) ; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>

</div>

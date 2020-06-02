<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('rides_staywaykey'); ?></h1>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('rides/share_rides'), 'mdl_appointments'); ?>
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
                <th><?php _trans('available_seats'); ?></th>
                <th><?php _trans('total_kilometers'); ?></th>
                <th><?php _trans('potentially_money_earned'); ?></th>

            </tr>
            </thead>

            <tbody>


            <?php foreach ($share_rides as $ride) { ?>
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
                        <?=$ride->appointment_how_many_seats_can_you_offer; ?>
                    </td>
                    <td>
                        <?=$ride->appointment_kilometers; ?>
                    </td>
                    <td>
                        <?=$ride->appointment_stayawaykey_price_kilometor_total; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>

    </div>

</div>

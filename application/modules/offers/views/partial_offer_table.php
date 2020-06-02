<?php
//ok
?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php _trans('status'); ?></th>
            <th><?php _trans('offer'); ?></th>
            <th><?php _trans('created'); ?></th>
            <th><?php _trans('due_date'); ?></th>
            <th><?php _trans('client_name'); ?></th>
            <th style="text-align: right;"><?php _trans('amount'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $offer_idx = 1;
        $offer_count = count($offers);
        $offer_list_split = $offer_count > 3 ? $offer_count / 2 : 9999;

        foreach ($offers as $offer) {
            // Disable read-only if not applicable
            if ($this->config->item('disable_read_only') == true) {
                $offer->is_read_only = 0;
            }
            // Convert the dropdown menu to a dropup if offer is after the offer split
            $dropup = $offer_idx > $offer_list_split ? true : false;
            ?>
            <tr>
                <td>
                    <span class="label <?php echo $offer_statuses[$offer->offer_status_id]['class']; ?>">
                        <?php echo $offer_statuses[$offer->offer_status_id]['label'];?>
                    </span>
                </td>

                <td>
                    <a href="<?php echo site_url('offers/view/' . $offer->offer_id); ?>"
                       title="<?php _trans('edit'); ?>">
                        <?php echo($offer->offer_number ? $offer->offer_number : $offer->offer_id); ?>
                    </a>
                </td>

                <td>
                    <?php echo date_from_mysql($offer->offer_date_created); ?>
                </td>

                <td>
                    <span class="<?php if ($offer->is_overdue) { ?>font-overdue<?php } ?>">
                        <?php echo date_from_mysql($offer->offer_due_date); ?>
                    </span>
                </td>

                <td>
                    <a href="<?php echo site_url('clients/view/' . $offer->client_id); ?>"
                       title="<?php _trans('view_client'); ?>">
                        <?php _htmlsc(format_client($offer)); ?>
                    </a>
                </td>

                <td class="amount">
                    <?php echo format_currency($offer->offer_total); ?>
                </td>

                <td>
                    <div class="options btn-group<?php echo $dropup ? ' dropup' : ''; ?>">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('offers/view/' . $offer->offer_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('offers/generate_pdf/' . $offer->offer_id); ?>"
                                   target="_blank">
                                    <i class="fa fa-print fa-margin"></i> <?php _trans('download_pdf'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('mailer/offer/' . $offer->offer_id); ?>">
                                    <i class="fa fa-send fa-margin"></i> <?php _trans('send_email'); ?>
                                </a>
                            </li>
                            <?php if ($offer->offer_status_id == 1 || ($this->config->item('enable_offer_deletion') === true)) { ?>
                                <li>
                                    <a href="<?php echo site_url('offers/delete/' . $offer->offer_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_offer_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php
            $offer_idx++;
        } ?>
        </tbody>

    </table>
</div>
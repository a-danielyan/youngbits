<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
        <?php echo get_setting('custom_title', 'Spudu', true); ?>
        - <?php echo trans('recurring_income'); ?> <?php echo $recurring_income->recurring_income_name; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">

</head>
<body>


<div id="content">

    <div class="webpreview-header">

        <h2><?=$recurring_income->recurring_income_name; ?></h2>

    </div>

    <hr>
    <div class="quote">

        <div class="quote-items">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th><?php echo trans('name'); ?></th>
                        <th><?php echo trans('contact'); ?></th>
                        <th class="text-right"><?php echo trans('category'); ?></th>
                        <th class="text-right"><?php echo trans('date'); ?></th>

                        <th class="text-right"><?php echo trans('every'); ?></th>

                        <th class="text-right"><?php echo trans('amount'); ?></th>
                        <th class="text-right"><?php echo trans('total_outstanding_amount'); ?></th>
                        <th class="text-right"><?php echo trans('start_date'); ?></th>
                        <th class="text-right"><?php echo trans('attachment'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php _htmlsc($recurring_income->recurring_income_name); ?></td>
                        <td><?php _htmlsc($recurring_income->recurring_income_contact); ?></td>
                        <td><?php _htmlsc($recurring_income->recurring_income_category); ?></td>
                        <td><?= $recurring_income->recurring_income_date; ?></td>
                        <td><?= $recurring_income->recurring_income_frequency; ?></td>
                        <td class="amount"><?php echo format_currency($recurring_income->recurring_income_amount); ?></td>
                        <td class="amount"><?php echo format_currency($recurring_income->recurring_income_outstanding_amount); ?></td>
                        <td class="amount"><?= $recurring_income->recurring_income_start_date; ?></td>
                        <td class="amount"><?= $recurring_income->recurring_income_document_link; ?></td>
                    </tr>




                    </tbody>
                </table>
            </div>



        </div><!-- .quote-items -->
    </div><!-- .quote -->
</div><!-- #content -->
</body>
</html>

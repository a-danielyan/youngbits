<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        <?php echo get_setting('custom_title', 'NotesPlane', true); ?>
        - <?php echo trans('notes'); ?> <?php echo $notes->notes_id; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
</head>
<body>
    <div class="container">
        <div id="content">
            <div class="webpreview-header">

                <h2><?php echo trans('note'); ?>&nbsp;<?php echo $notes->notes_id; ?></h2>
            </div>
        </div>

        <hr>

        <?php echo $this->layout->load_view('layout/alerts'); ?>

        <div class="notes">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-5"></div>
                <div class="col-lg-2"></div>
                <div class="col-xs-12 col-md-6 col-lg-5">

                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td><?php echo trans('Note Date'); ?></td>
                                <td style="text-align:right;"><?=$notes->created_date; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div class=row>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php _trans('note_title'); ?></th>
                                <th><?php _trans('note_description'); ?></th>
                                <th><?php _trans('project'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $notes->notes_title ?></td>
                                <td><?php echo $notes->notes_description ?></td>
                                <td><?php echo !empty($notes->project_id) ?htmlsc($notes->project_name) : ''; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

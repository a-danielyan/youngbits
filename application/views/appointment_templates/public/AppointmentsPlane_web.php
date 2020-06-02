<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        <?php echo get_setting('custom_title', 'AppointmentsPlane', true); ?>
        -  <?=$appointments->appointment_title; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
</head>
<body>
<div class="container-fluid">
    <div id="content">
        <div class="webpreview-header">

            <h2><?=_htmle($appointments->appointment_title); ?></h2>
        </div>
    </div>

    <hr>

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <div class="appointments">

        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th><?php _trans('type'); ?></th>



                    <th><?php _trans('user'); ?></th>
                    <th><?php _trans('project'); ?></th>
                    <th><?php _trans('date'); ?></th>
                    <th><?php _trans('appointment_starting_time'); ?></th>
                    <th><?php _trans('appointment_end_time'); ?></th>
                    <th><?php _trans('address'); ?></th>
                    <th><?php _trans('appointment_departure_location'); ?></th>
                    <th><?php _trans('appointment_kilometers'); ?></th>
                    <th><?php _trans('appointment_kilometers_vehicle'); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td><?=$appointments->appointment_type ?>1</td>
                    <td><?=$appointments->user_name ?></td>
                    <td><?=!empty($appointments->project_id) ?htmlsc($appointments->project_name) : ''; ?></td>
                    <td><?=$appointments->appointment_date ?></td>
                    <td><?=$appointments->appointment_starting_time ?></td>
                    <td><?=$appointments->appointment_end_time ?></td>
                    <td><?_htmle($appointments->appointment_address) ?></td>
                    <td><?_htmle($appointments->appointment_departure_location) ?></td>
                    <td><?_htmle($appointments->appointment_kilometers) ?></td>
                    <td></td>

                </tr>
                </tbody>
            </table>

            <div class="col-md-5">
                <div class="col" style="padding: 3% 0">
                    <h4><?php _trans('appointment_people_attending'); ?></h4>
                </div>
               <div class="col">
                   <table class="table table-striped table-bordered">
                       <thead>
                       <tr>
                           <th><?php _trans('name'); ?></th>
                           <th><?php _trans('email'); ?></th>
                       </tr>
                       </thead>
                       <tbody>
                       <tr>

                           <?php
                           foreach (json_decode($appointments->appointment_add_people) as $appointment_add_person) {
                               ?>
                               <td><?=$appointment_add_person->name; ?>1</td>
                               <td><?=$appointment_add_person->email ?></td>


                           <?php } ?>

                       </tr>
                       </tbody>
                   </table>
               </div>
            </div>

        </div>
    </div>
</div>
</body>

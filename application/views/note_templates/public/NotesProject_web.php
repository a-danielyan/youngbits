<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>
        <?php echo get_setting('custom_title', 'NotesProject', true); ?>
        - <?php echo trans('project').' '.$project->project_id; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoiceplane/css/new_style.css">
    <style>
        h4{
            margin: 5px;
        }
        .note_item {
            border: 2px solid #dce4ec;
            margin: 0 3px 11px;
        }
        div#notes_block {
            display: grid;
        }
        a.view_note {
            display: block;
            height: 100%;
            width: 100%;
            color: #4f6b6d;
            text-decoration: none;
        }

        a.view_note:hover {
            color: black;
        }


        .note_item:nth-child(odd) {
            float: left;
        }
        .note_item:nth-child(even) {
            float: right;
            margin-left: 74%;
        }


    </style>
</head>
<body>
<div class="container">
    <div id="content">

        <div class="webpreview-header">
            <h2><?=trans('notes_project').' '.$project->project_name; ?></h2>
        </div>
    </div>

    <hr>

    <?php echo $this->layout->load_view('layout/alerts'); ?>


        <div id="notes_block" class="row justify-content-between">


        <?php foreach ($notes as $note){
            ?>
            <div class="col-md-2 col-xs-4 text-center note_item">
                <a href="<?=base_url().'index.php/guest/view/notes/'.$note->notes_url_key?>" class="view_note" target="_blank">
                    <h4><?=$note->notes_title?></h4>
                    <h4><?=$note->notes_category?></h4>
                    <div class="col-md" style="margin: 10px 0;">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> <?=$note->created_time?> <?=$note->created_date?>
                    </div>
                </a>

            </div>
        <?php }?>
    </div>
</div>
</body>

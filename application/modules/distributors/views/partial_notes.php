<?php foreach ($distributor_notes as $distributor_note) : ?>
    <div class="panel panel-default small">
        <div class="panel-body">
            <?php echo nl2br(htmlsc($distributor_note->distributor_note)); ?>
        </div>
        <div class="panel-footer text-muted">
            <?php echo date_from_mysql($distributor_note->distributor_note_date, true); ?>
        </div>
    </div>
<?php endforeach; ?>

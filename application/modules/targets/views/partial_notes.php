<?php foreach ($target_notes as $target_note) : ?>
    <div class="panel panel-default small">
        <div class="panel-body">
            <?php echo nl2br(htmlsc($target_note->target_note)); ?>
        </div>
        <div class="panel-footer text-muted">
            <?php echo date_from_mysql($target_note->target_note_date, true); ?>
        </div>
    </div>
<?php endforeach; ?>

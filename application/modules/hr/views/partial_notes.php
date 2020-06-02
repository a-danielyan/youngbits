<?php foreach ($hr_notes as $hr_note) : ?>
    <div class="panel panel-default small">
        <div class="panel-body">
            <?php echo nl2br(htmlsc($hr_note->hr_note)); ?>
        </div>
        <div class="panel-footer text-muted">
            <?php echo date_from_mysql($hr_note->hr_note_date, true); ?>
        </div>
    </div>
<?php endforeach; ?>

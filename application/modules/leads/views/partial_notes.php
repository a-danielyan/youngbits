<?php foreach ($lead_notes as $lead_note) : ?>
    <div class="panel panel-default small">
        <div class="panel-body">
            <?php echo nl2br(htmlsc($lead_note->lead_note)); ?>
        </div>
        <div class="panel-footer text-muted">
            <?php echo date_from_mysql($lead_note->lead_note_date, true); ?>
        </div>
    </div>
<?php endforeach; ?>

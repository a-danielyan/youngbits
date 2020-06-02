<?php foreach ($projects_notes as $project_note) : ?>
    <div class="panel-default small">
        <div class="panel-body">
            <?=nl2br(htmlsc($project_note->notes_title)); ?>
            <span class="text-muted" style="margin-left: 5%">
                <?php echo date_from_mysql($project_note->created_date, true); ?>
            </span>
        </div>

    </div>
<?php endforeach; ?>

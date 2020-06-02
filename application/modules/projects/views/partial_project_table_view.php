<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'project_name', 'ip_projects'); ?>><?php _trans('project_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client_name'); ?></a></th>

            </tr>
            </thead>

            <tbody>
            <?php foreach ($projects as $project) { ?>
                <tr>
                    <td><?php echo anchor('guest/view/project/' . $project->project_notes_key, htmlsc($project->project_name)); ?></td>
                    <td><?php echo ($project->client_id) ? htmlsc($project->client_name) : trans('none'); ?></td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>

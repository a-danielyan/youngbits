<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('projects'); ?></h1>

    <?php if($this->session->userdata('user_type') == TYPE_ADMIN  || $this->session->userdata('user_type') == TYPE_MANAGERS   || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('projects/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('projects/index'), 'mdl_projects'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'project_name', 'ip_projects'); ?>><?php _trans('project_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'client_name', 'ip_clients'); ?>><?php _trans('client_name'); ?></a></th>

                <th>
                    <?php if($this->session->userdata('user_type') == TYPE_ADMIN  || $this->session->userdata('user_type') == TYPE_MANAGERS   || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES){
                        _trans('options');
                    } ?>
                </th>
            </tr>
            </thead>

            <tbody>


            <?php foreach ($projects as $project) { ?>
                <tr>
                    <td>
                    <?=anchor('projects/view/' . $project->project_id, htmlsc($project->project_name)); ?>
                    </td>
                    <td><?php echo ($project->client_id) ? htmlsc($project->client_name) : trans('none'); ?></td>
                    <?php if($this->session->userdata('user_type') == TYPE_ADMIN  || $this->session->userdata('user_type') == TYPE_MANAGERS   || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('projects/form/' . $project->project_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('projects/delete/' . $project->project_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>


<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('bank_statements'); ?></h1>
    <button class="btn btn-danger delete_sel_statements d-none">Delete</button>
    <div class="action_add_record">
        <button class="btn btn-primary add_record"><?php _trans('add_record'); ?></button>
        <button class="btn btn-primary save_record hidden"><?php _trans('save'); ?></button>
    </div>

    <div class="action_edit_statement"></div>

    <div class="headerbar-item pull-right">
        <div class="headerbar-item pull-right visible-lg"></div>

        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('bank_statements/export'); ?>">
                <i class="fa fa-download"></i> <?php _trans('export_csv'); ?>
            </a>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('bank_statements/form'); ?>">
                <i class="fa fa-file"></i> <?php _trans('import_rabobank'); ?>
            </a>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('bank_statements/import_abn'); ?>">
                <i class="fa fa-file"></i> <?php _trans('import_abn'); ?>
            </a>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('bank_statements/import_26'); ?>">
                <i class="fa fa-file"></i> <?php _trans('import_26'); ?>
            </a>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('bank_statements/add'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('bank_statements/index'), 'mdl_statements'); ?>
    </div>
    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt dollar"><p class="amount_val dollar" style="display: inline;"></p></span>
        <span class="selected_amt euro"><p class="amount_val euro" style="display: inline;"></p></span>
    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <div class="table-responsive">
            <table id = "statement_table" class="table table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" class="checkAllSelStatements"></th>
                    <th><a <?= orderableTH($this->input->get(), 'id', 'ip_statements'); ?>><?= _trans('id'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'date', 'ip_statements'); ?>><?= _trans('date'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'amount', 'ip_statements'); ?>><?= _trans('amount'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'type', 'ip_statements'); ?>><?= _trans('type'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'user_id', 'ip_statements'); ?>><?= _trans('user'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'project_id', 'ip_statements'); ?>><?= _trans('project'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'parent_id', 'ip_statements'); ?>><?= _trans('parent'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'category', 'ip_statements'); ?>><?= _trans('category'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'account_name', 'ip_statements'); ?>><?= _trans('account_name'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'description', 'ip_statements'); ?>><?= _trans('description'); ?></a></th>
                    <th><a class="order_passive"><?= _trans('file'); ?></a></th>

                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <th><?php _trans('options'); ?></th>
                    <?php endif; ?>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($statements as $stat) { ?>
                    <tr>
                        <td>
                            <input type="checkbox" value="<?= $stat->id ?>" class="selStatements">
                        </td>
                        <td><?=_htmlsc($stat->id);?></td>
                        <td><?=_htmlsc($stat->date); ?></td>
                        <td><?=_htmlsc($stat->amount); ?></td>
                        <td>
                            <span class="s_type"><?=_htmlsc($stat->type); ?></span>
                            <select name = "stat_type" class="stat_type form-control hidden">
                                <option value = ""></option>
                                <option value="paypal" <?= ($stat->type === 'paypal') ? 'selected' : '' ?> >Paypal</option>
                                <option value="bank" <?= ($stat->type === 'bank') ? 'selected' : '' ?> >Bank</option>
                                <option value="cash" <?= ($stat->type === 'cash') ? 'selected' : '' ?> >Cash</option>
                            </select>
                        </td>
                        <td>
                            <span class="s_user">
                                <?=_htmlsc($stat->username); ?>
                            </span>
                            <select name = "stat_user" class="stat_user form-control hidden">
                                <option value=""></option>
                                <?php foreach ($users as $user) { ?>
                                    <option <?= $user->user_id === $stat->user_id ? 'selected' : '' ?> value="<?php echo $user->user_id; ?>">
                                        <?php echo $user->user_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <span class="s_project">
                                <?=_htmlsc($stat->project_name); ?>
                            </span>
                            <select name="stat_project" class="stat_project form-control hidden">
                                <option value=""></option>
                                <?php foreach ($projects as $project) { ?>
                                    <option <?= $project->project_id === $stat->project_id ? 'selected' : '' ?> value="<?php echo $project->project_id; ?>">
                                        <?php echo $project->project_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <span class="s_parent">
                                <?=_htmlsc($stat->parent_id); ?>
                            </span>
                            <select name = "stat_parent" class="stat_parent form-control hidden">
                                <option value="0"></option>
                                <?php foreach ($statements as $val) { ?>
                                    <option <?= $val->id === $stat->parent_id ? 'selected' : '' ?> value="<?php echo $val->id; ?>">
                                        <?php echo $val->id; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <span class="s_category">
                                <?=_htmlsc($stat->category); ?>                            
                            </span>
                            <input type="text" name="stat_category" class="form-control stat_category hidden" value = "<?= $stat->category?>">
                        </td>
                        <td><?=_htmlsc($stat->account_name); ?></td>
                        <td>
                            <span class="s_desc">
                                <?=_htmlsc($stat->description); ?>
                            </span>
                            <input type = "text" name = "stat_desc" class="stat_desc form-control hidden" value="<?= $stat->description?>">
                        </td>
                        <td>
                            <form class = "attachment_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bank_statements/attach_file'); ?>">
                                <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
                                <input type="hidden" name="statement_id" value="<?= $stat->id; ?>">
                                <div class="attach_group">
                                    <input type="file" name="image" class="attach_file" onchange="form.submit()">
                                </div>
                                <button class="btn btn-success upload_file"><?php _trans('upload'); ?></button>
                            </form>
                        </td>
                        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                            <td>
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('bank_statements/edit/' . $stat->id); ?>">
                                                <i class="fa fa-edit fa-margin"></i>
                                                <?php _trans('edit'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('bank_statements/delete/' . $stat->id); ?>"
                                               onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i>
                                                <?php _trans('delete'); ?>
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
        <input type="hidden" name="url" value="<?=base_url().'index.php/bank_statements/index'?>">
    </div>

    <input type="hidden" name="url_statements"  class="url_statements" value="<?=site_url('bank_statements/delete_sel_statements')?>">
    <input type="hidden" name="url_fields"  class="url_fields" value="<?=site_url('bank_statements/get_record_fields')?>">
</div>

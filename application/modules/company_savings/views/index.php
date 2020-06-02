<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('company_savings'); ?></h1>

    <div class="headerbar-item pull-right">
        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('company_savings/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>


    </div>
</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'company_saving_text', 'ip_company_savings'); ?>><?php _trans('company_saving_text'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'company_saving_created_date', 'ip_company_savings'); ?>><?php _trans('company_saving_created_date'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'company_saving_created_by', 'ip_company_savings'); ?>><?php _trans('company_saving_created_by'); ?></a></th>
                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <th><?php _trans('options'); ?></th>
                <?php endif; ?>

            </tr>
            </thead>

            <tbody>
            <?php foreach ($company_savings as $company_saving) { ?>
                <tr>
                    <td><?php _htmlsc($company_saving->company_saving_text); ?></td>
                    <td><?= date($company_saving->company_saving_created_date); ?></td>
                    <td><?php _htmlsc($company_saving->user_name); ?></td>

                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('company_savings/form/' . $company_saving->company_saving_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('company_savings/delete/' . $company_saving->company_saving_id); ?>"
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

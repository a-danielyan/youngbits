<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><input type="checkbox" class="checkAllSel"></th>
            <th><a <?= orderableTH($this->input->get(), 'legal_issues_engilsh_title', 'ip_legal_issues'); ?>><?php _trans('legal_issues_engilsh_title'); ?></a></th>

            <th><a <?= orderableTH($this->input->get(), 'legal_issues_category', 'ip_legal_issues'); ?>><?php _trans('legal_issues_category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'legal_issues_company_name', 'ip_legal_issues'); ?>><?php _trans('legal_issues_company_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'legal_issues_location_address', 'ip_legal_issues'); ?>><?php _trans('legal_issues_location_address'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'legal_issues_date', 'ip_legal_issues'); ?>><?php _trans('date'); ?></a></th>

            <th><a <?= orderableTH($this->input->get(), 'legal_issues_amount', 'ip_legal_issues'); ?>><?php _trans('amount'); ?></a></th>

            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES  || $this->session->userdata('user_type') == TYPE_MANAGERS): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($records as $legal_issues) { ?>
            <tr>
                <td><input type="checkbox" value="<?= $legal_issues->legal_issues_id ?>" class="sel" data-amount="<?=$legal_issues->legal_issues_amount?>"></td>
                <td><?php  _htmlsc($legal_issues->legal_issues_engilsh_title); ?></td>

                <td><?php  _htmlsc($legal_issues->legal_issues_category); ?></td>
                <td><?php  _htmlsc($legal_issues->legal_issues_company_name); ?></td>
                <td><?php  _htmlsc($legal_issues->legal_issues_location_address); ?></td>
                <td><?php echo date_from_mysql($legal_issues->legal_issues_date); ?></td>

                <td><?php echo format_currency($legal_issues->legal_issues_amount); ?></td>
                <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('legal_issues/form/' . $legal_issues->legal_issues_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i>
                                        <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('legal_issues/delete/' . $legal_issues->legal_issues_id); ?>"
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
<input type="hidden" name="url" value="<?=base_url().'index.php/legal_issues/'?>">
<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><a <?= orderableTH($this->input->get(), 'expenses_id', 'ip_expenses'); ?>><?= _trans('id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_date', 'ip_expenses'); ?>><?= _trans('expenses_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_name', 'ip_expenses'); ?>><?= _trans('expenses_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_user_id', 'ip_expenses'); ?>><?= _trans('user'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_category', 'ip_expenses'); ?>><?= _trans('expenses_category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_parent_id', 'ip_expenses'); ?>><?= _trans('parent_id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_projects', 'ip_expenses'); ?>><?= _trans('projects'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_amount', 'ip_expenses'); ?>><?= _trans('expenses_amount'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_document_link', 'ip_expenses'); ?>><?= _trans('url'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_taxes', 'ip_expenses'); ?>><?= _trans('expenses_taxes'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'expenses_taxes', 'ip_expenses'); ?>><?= _trans('type'); ?></a></th>

            <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($records as $expense) { ?>
            <tr>
                <td><?=_htmlsc($expense->expenses_id);?></td>
                <td><?=_htmlsc($expense->expenses_date);?></td>
                <td><?=_htmlsc($expense->expenses_name); ?></td>
                <td><?=_htmlsc($expense->user_name); ?></td>
                <td><?=_htmlsc($expense->expenses_category); ?></td>
                <td><?=_htmlsc($expense->expenses_parent_id); ?></td>
                <td><?=_htmlsc($expense->project_name); ?></td>


                <td>  <?=($expense->expenses_currency == 'dollar')? '$'.format_amount($expense->expenses_amount) : '€'.format_amount($expense->expenses_amount_euro) ; ?></td>
                <td>  <?=(!empty($expense->expenses_document_link))? "<a href='$expense->expenses_document_link' target='_blank'>$expense->expenses_document_link</a>"  : '' ; ?></td>

                <td><?=_htmlsc($expense->expenses_taxes); ?></td>
                <td><?= (!is_null($expense->expenses_cash_bank))? _htmlsc($cash_banks[$expense->expenses_cash_bank]) : '' ; ?></td>


                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('expenses_templates/form/' . $expense->expenses_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i>
                                        <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <?php if($this->session->userdata('user_type') != TYPE_ADMINISTRATOR): ?>
                                    <li>
                                        <a href="<?php echo site_url('expenses_templates/delete/' . $expense->expenses_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i>
                                            <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>

<input type="hidden" name="url" value="<?=base_url().'index.php/expenses_templates/'?>">
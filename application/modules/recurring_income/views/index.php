<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('recurring_income'); ?></h1>


    <div class="headerbar-item pull-right">
        <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('recurring_income/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('recurring_income/index'), 'mdl_recurring_income'); ?>
    </div>

    <div class="btn-group btn-group-sm index-options sum_content pull-right">
        <span class="selected_amt"><?php echo _trans('selected') ?> : <p class="amount_val" style="display: inline;"></p></span>
        <span class="total_amt"><?php echo _trans('total'); ?> : <?php echo format_currency($sum); ?></span>
    </div>
</div>

<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th><input type="checkbox" class="checkAllSel"></th>
                    <th><a <?= orderableTH($this->input->get(), 'recurring_income_name', 'ip_other_recurring_income'); ?>><?php _trans('subscriptions_name'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recurring_income_category', 'ip_other_recurring_income'); ?>><?php _trans('subscriptions_category'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recurring_income_date', 'ip_other_recurring_income'); ?>><?php _trans('subscriptions_date'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recurring_income_amount', 'ip_other_recurring_income'); ?>><?php _trans('subscriptions_amount'); ?></a></th>
                    <th><a <?= orderableTH($this->input->get(), 'recurring_income_every', 'ip_other_recurring_income'); ?>><?php _trans('subscriptions_every'); ?></a></th>
                    <th><?php _trans('url'); ?></th>
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <th><?php _trans('options'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($recurring_incomes as $recurring_income) { ?>
                <tr>
                    <td><input type="checkbox" value="<?= $recurring_income->recurring_income_id ?>" class="sel" data-amount="<?=$recurring_income->recurring_income_amount?>"></td>
                    <td><?php echo _htmlsc($recurring_income->recurring_income_name); ?></td>
                    <td><?php echo _htmlsc($recurring_income->recurring_income_category); ?></td>
                    <td><?php echo date_from_mysql($recurring_income->recurring_income_date); ?></td>
                    <td><?php echo '€'.format_amount($recurring_income->recurring_income_amount); ?></td>

                    <td>
                        <?php foreach ($recur_frequencies as $key => $lang) { ?>
                            <?php // echo $key . '--' . $recurring_income->recurring_income_frequency ; ?>
                            <?php if($key == $recurring_income->recurring_income_frequency){ echo _trans($lang); }; ?>
                        <?php } ?>
                    </td>
                    <td>
                        <? if(!empty($recurring_income->recurring_income_url_key)):?>
                            <a href="<?=base_url('/index.php/guest/view/recurring_income/'.$recurring_income->recurring_income_url_key); ?>" target="_blank"><?=base_url('/index.php/guest/view/recurring_income/'.$recurring_income->recurring_income_url_key); ?></a>
                        <? endif; ?>
                    </td>
                    <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                   data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('recurring_income/form/' . $recurring_income->recurring_income_id); ?>" title="<?php _trans('edit'); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('recurring_income/delete/' . $recurring_income->recurring_income_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_recurring_warning'); ?>');">
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


<input type="hidden" name="url" value="<?=base_url().'index.php/recurring_income/'?>">
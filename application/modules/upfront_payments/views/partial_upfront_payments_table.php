<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><input type="checkbox" class="checkAllSelUpfrontPayments"></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_id', 'ip_upfront_payments'); ?>><?= _trans('id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_date', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_name', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_name'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_category', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_description', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_description'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_amount', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_amount'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_discount', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_discount'); ?> (%)</a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_discount_total', 'ip_upfront_payments'); ?>><?= _trans('upfront_payments_discount_total'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'upfront_payments_document_link', 'ip_upfront_payments'); ?>><?= _trans('url'); ?></a></th>

            <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($records as $upfront) { ?>
            <tr>
                <td>
                    <input type="checkbox" value="<?= $upfront->upfront_payments_id ?>" class="selUpfrontPayments sel" data-amount="<?=format_amount($upfront->upfront_payments_amount); ?>">
                </td>
                <td><?=_htmlsc($upfront->upfront_payments_id);?></td>
                <td><?=_htmlsc($upfront->upfront_payments_date);?></td>
                <td><?=_htmlsc($upfront->upfront_payments_name); ?></td>
                <td><?=_htmlsc($upfront->upfront_payments_category); ?></td>
                <td><?=_htmlsc($upfront->upfront_payments_description); ?></td>


                <td> €  <?=format_amount($upfront->upfront_payments_amount); ?></td>
                <td> % <?=format_amount($upfront->upfront_payments_discount); ?></td>
                <td> €  <?=format_amount($upfront->upfront_payments_discount_total); ?></td>
                <td>  <?=(!empty($upfront->upfront_payments_document_link[0]))? $upfront->upfront_payments_document_link[0] : '' ; ?></td>



                <?php if ($this->session->userdata('user_type') != TYPE_ACCOUNTANT): ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('upfront_payments/form/' . $upfront->upfront_payments_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i>
                                        <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <?php if($this->session->userdata('user_type') != TYPE_ADMINISTRATOR): ?>
                                    <li>
                                        <a href="<?php echo site_url('upfront_payments/delete/' . $upfront->upfront_payments_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i>
                                            <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                <?php  endif; ?>
                            </ul>
                        </div>
                    </td>
                <?php endif; ?>

            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>

<input type="hidden" name="url" value="<?=base_url().'index.php/upfront_payments/'?>">
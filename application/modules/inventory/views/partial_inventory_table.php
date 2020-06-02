<div class="table-responsive">
    <table class="table table-striped">

        <thead>
        <tr>
            <th><input type="checkbox" class="checkAllSel"></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_id', 'ip_inventory'); ?>><?php _trans('id'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_post_title', 'ip_inventory'); ?>><?php _trans('inventory_post_title'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_date', 'ip_inventory'); ?>><?php _trans('date'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_created_user', 'ip_inventory'); ?>><?php _trans('user'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_regular_price', 'ip_inventory'); ?>><?php _trans('inventory_regular_price'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_project_id', 'ip_inventory'); ?>><?php _trans('support_project'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_location', 'ip_inventory'); ?>><?php _trans('inventory_location'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_category', 'ip_inventory'); ?>><?php _trans('inventory_category'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_status', 'ip_inventory'); ?>><?php _trans('status'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_document_link', 'ip_inventory'); ?>><?php _trans('attachment'); ?></a></th>
            <th><a <?= orderableTH($this->input->get(), 'inventory_sold', 'ip_inventory'); ?>><?php _trans('inventory_sold'); ?></th>
            <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES  || $this->session->userdata('user_type') == TYPE_MANAGERS): ?>
                <th><?php _trans('options'); ?></th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($records as $inventory) { ?>
            <tr>
                <td><input type="checkbox" value="<?= $inventory->inventory_id ?>" class="sel" data-amount="<?=$inventory->inventory_regular_price?>"></td>
                <td><?_htmlsc($inventory->inventory_id); ?></td>
                <td><?php _htmlsc($inventory->inventory_post_title); ?></td>
                <td><?_htmlsc($inventory->inventory_date); ?></td>
                <td><?_htmlsc($inventory->user_name) ?></td>
                <td><?= format_currency($inventory->inventory_regular_price); ?></td>
                <td><?_htmlsc($inventory->project_name); ?></td>
                <td><?php _htmlsc($inventory->inventory_location); ?></td>
                <td><?= $categories[$inventory->inventory_category]; ?></td>
                <td><?= $inventory_statuses[$inventory->inventory_status]['label']; ?></td>

                <td><a href="<?= (!empty(unserialize($inventory->inventory_document_link)[0]))?unserialize($inventory->inventory_document_link)[0]:''; ?>"><?= (!empty(unserialize($inventory->inventory_document_link)[0]))?unserialize($inventory->inventory_document_link)[0]:''; ?></a></td>
                <td><? ($inventory->inventory_sold === 'yes')?_trans('yes'): _trans('no')?></td>
                <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_FREELANCERS  || $this->session->userdata('user_type') == TYPE_EMPLOYEES): ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('inventory/form/' . $inventory->inventory_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i>
                                        <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('inventory/delete/' . $inventory->inventory_id); ?>"
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
<input type="hidden" name="url" value="<?=base_url().'index.php/inventory/'?>">

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('products'); ?></h1>

    <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){ ?>
        <div class="headerbar-item pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('products/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>
    <?php } ?>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('products/index'), 'mdl_products'); ?>
    </div>

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><a <?= orderableTH($this->input->get(), 'family_name', 'ip_families'); ?>><?php _trans('family'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'product_sku', 'ip_products'); ?>><?php _trans('product_sku'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'product_name', 'ip_products'); ?>><?php _trans('product_name'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'product_description', 'ip_products'); ?>><?php _trans('product_description'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'purchase_price_supplier', 'ip_products'); ?>><?php _trans('purchase_price_supplier'); ?></a></th>

                <th><a <?= orderableTH($this->input->get(), 'unit_id', 'ip_units'); ?>><?php _trans('product_unit'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'selling_price_distributor', 'ip_products'); ?>><?php _trans('selling_price_distributor'); ?></a></th>
                <th><a <?= orderableTH($this->input->get(), 'tax_rate_id', 'ip_tax_rates'); ?>><?php _trans('tax_rate'); ?></a></th>
                <?php if (get_setting('sumex')) : ?>
                    <th><a <?= orderableTH($this->input->get(), 'product_tariff', 'ip_products'); ?>><?php _trans('product_tariff'); ?></a></th>
                <?php endif; ?>
                <th><a <?= orderableTH($this->input->get(), 'product_price', 'ip_products'); ?>><?php _trans('advice_selling_price'); ?></a></th>
                <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR || $this->session->userdata('user_type') == TYPE_MANAGERS){ ?>
                    <th><?php _trans('options'); ?></th>
                <?php } ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>



                    <td><?php _htmlsc($product->family_name); ?></td>
                    <td><?php _htmlsc($product->product_sku); ?></td>
                    <td><?php _htmlsc($product->product_name); ?></td>
                    <td><?php echo nl2br(htmlsc($product->product_description)); ?></td>
                    <td class="text-center"><?= format_currency($product->purchase_price_supplier); ?></td>

                    <td><?php _htmlsc($product->unit_name); ?></td>
                    <td><?= format_currency($product->selling_price_distributor); ?></td>
                    <td><?php echo ($product->tax_rate_id) ? htmlsc($product->tax_rate_name) : trans('none'); ?></td>
                    <?php if (get_setting('sumex')) : ?>
                        <td><?php _htmlsc($product->product_tariff); ?></td>
                    <?php endif; ?>
                    <td class="amount " style="text-align: left"><?php echo format_currency($product->product_price); ?></td>






                    <?php if($this->session->userdata('user_type') == TYPE_ADMIN || $this->session->userdata('user_type') == TYPE_MANAGERS || $this->session->userdata('user_type') == TYPE_EMPLOYEES || $this->session->userdata('user_type') == TYPE_FREELANCERS || $this->session->userdata('user_type') == TYPE_ADMINISTRATOR){ ?>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('products/form/' . $product->product_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('products/delete/' . $product->product_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>

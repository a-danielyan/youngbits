<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('products_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-md-6">

                <?php $this->layout->load_view('layout/alerts'); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">

                        <?php if ($this->mdl_products->form_value('product_id')) : ?>
                            #<?php echo $this->mdl_products->form_value('product_id'); ?>&nbsp;
                            <?php echo $this->mdl_products->form_value('product_name', true); ?>
                        <?php else : ?>
                            <?php _trans('new_product'); ?>
                        <?php endif; ?>

                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="family_id">
                                <?php _trans('family'); ?>
                            </label>

                            <select name="family_id" id="family_id" class="form-control simple-select">
                                <option value="0"><?php _trans('select_family'); ?></option>
                                <?php foreach ($families as $family) { ?>
                                    <option value="<?php echo $family->family_id; ?>"
                                        <?php check_select($this->mdl_products->form_value('family_id'), $family->family_id) ?>
                                    ><?php echo $family->family_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_sku">
                                <?php _trans('product_sku'); ?>
                            </label>

                            <input type="text" name="product_sku" id="product_sku" class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('product_sku', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="product_name">
                                <?php _trans('product_name'); ?>
                            </label>

                            <input type="text" name="product_name" id="product_name" class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('product_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="product_description">
                                <?php _trans('product_description'); ?>
                            </label>

                            <textarea name="product_description" id="product_description" class="form-control"
                                      rows="3"><?php echo $this->mdl_products->form_value('product_description', true); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_price">
                                <?php _trans('selling_advice_price'); ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="product_price" id="product_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_products->form_value('product_price')); ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_id">
                                <?php _trans('product_unit'); ?>
                            </label>

                            <select name="unit_id" id="unit_id" class="form-control simple-select">
                                <option value="0"><?php _trans('select_unit'); ?></option>
                                <?php foreach ($units as $unit) { ?>
                                    <option value="<?php echo $unit->unit_id; ?>"
                                        <?php check_select($this->mdl_products->form_value('unit_id'), $unit->unit_id); ?>
                                    ><?php echo $unit->unit_name . '/' . $unit->unit_name_plrl; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tax_rate_id">
                                <?php _trans('tax_rate'); ?>
                            </label>

                            <select name="tax_rate_id" id="tax_rate_id" class="form-control simple-select">
                                <option value="0"><?php _trans('none'); ?></option>
                                <?php foreach ($tax_rates as $tax_rate) { ?>
                                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                        <?php check_select($this->mdl_products->form_value('tax_rate_id'), $tax_rate->tax_rate_id); ?>>
                                        <?php echo $tax_rate->tax_rate_name
                                            . ' (' . format_amount($tax_rate->tax_rate_percent) . '%)'; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('distributors'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="product_distributors">
                                <?php _trans('distributor_name'); ?>
                            </label>


                                <select name="product_distributors[]" id="product_distributors" class="form-control simple-select" multiple >
                                    <option value="0"><?php _trans('select_distributor'); ?></option>
                                    <?php foreach ($distributors as $distributor) { ?>
                                        <option value="<?php echo $distributor->distributor_id; ?>"
                                            <?php
                                            if(!empty($product_distributors)){
                                                foreach ($product_distributors->product_distributors as $product_distributor) {
                                                    check_select($distributor->distributor_id, $product_distributor);
                                                }
                                            }

                                            ?>>
                                            <?php echo $distributor->distributor_name;?>
                                        </option>
                                    <?php } ?>
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="product_distributors_multiplier">
                                <?php _trans('multiplier'); ?>
                            </label>
                            <input type="text" name="product_distributors_multiplier" id="product_distributors_multiplier" class="form-control"
                                   value="<?php echo format_amount($this->mdl_products->form_value('product_distributors_multiplier')); ?>">

                        </div>

                        <div class="form-group">
                            <label for="product_distributors_purchase_price">
                                <?php _trans('purchase_price'); ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="product_distributors_purchase_price" id="product_distributors_purchase_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_products->form_value('product_distributors_purchase_price')); ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supplier -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('supplier'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="supplier_id">
                                <?php _trans('supplier_name'); ?>
                            </label>


                                <select name="supplier_id" id="supplier_id" class="form-control simple-select" >
                                    <option value="0"><?php _trans('select_supplier'); ?></option>
                                    <?php foreach ($suppliers as $supplier) { ?>
                                        <option value="<?php echo $supplier->supplier_id; ?>"
                                            <?php check_select($supplier->supplier_id, $this->mdl_products->form_value('supplier_id', true));?>>
                                            <?php echo $supplier->supplier_name;?>
                                        </option>
                                    <?php } ?>
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="supplier_multiplier">
                                <?php _trans('multiplier'); ?>
                            </label>
                            <input type="text" name="supplier_multiplier" id="supplier_multiplier" class="form-control"
                                   value="<?php echo format_amount($this->mdl_products->form_value('supplier_multiplier')); ?>">

                        </div>

                        <div class="form-group">
                            <label for="supplier_purchase_price">
                                <?php _trans('purchase_price'); ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="supplier_purchase_price" id="supplier_purchase_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_products->form_value('supplier_purchase_price')); ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>



                    </div>
                </div>




                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php _trans('invoice_sumex'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="product_tariff">
                                <?php _trans('product_tariff'); ?>
                            </label>

                            <input type="text" name="product_tariff" id="product_tariff" class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('product_tariff', true); ?>">
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</form>

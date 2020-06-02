<div class="table-responsive">
    <table id="item_table" class="items table table-condensed table-bordered no-margin">
        <thead style="display: none">
        <tr>
            <th></th>
            <th><?php _trans('item_product_name'); ?></th>
            <th><?php _trans('item_product_SKU'); ?></th>
            <th><?php _trans('quantity'); ?></th>
            <th><?php _trans('price'); ?></th>
            <th><?php _trans('item_discount'); ?></th>
            <th><?php _trans('tax_rate'); ?></th>
            <th><?php _trans('description'); ?></th>
            <th><?php _trans('product_unit'); ?></th>
            <th><?php _trans('subtotal'); ?></th>
            <th><?php _trans('discount'); ?></th>
            <th><?php _trans('tax'); ?></th>
            <th><?php _trans('total'); ?></th>
            <th></th>
        </tr>
        </thead>

        <tbody id="new_row" style="display: none;">
        <tr>
            <td rowspan="2" class="td-icon">
                <i class="fa fa-arrows cursor-move"></i>
                <?php if ($invoice->invoice_is_recurring) : ?>
                    <br/>
                    <i title="<?php echo trans('recurring') ?>"
                       class="js-item-recurrence-toggler cursor-pointer fa fa-calendar-o text-muted"></i>
                    <input type="hidden" name="item_is_recurring" value=""/>
                <?php endif; ?>
            </td>
            <td class="td-text">
                <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                <input type="hidden" name="item_id" value="">
                <input type="hidden" name="item_product_id" value="">
                <input type="hidden" name="item_task_id" class="item-task-id" value="">

                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('item_product_name'); ?></span>
                    <input type="text" name="item_name" class="input-sm form-control" value="">
                </div>

            </td>
            <td class="td-amount">
                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('item_product_SKU'); ?></span>
                    <input type="text" name="item_product_SKU" class="input-sm form-control amount"
                           value="" >
                </div>
            </td>
            <td class="td-amount td-quantity">
                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('quantity'); ?></span>
                    <input type="text" name="item_quantity" class="input-sm form-control amount" value="">
                </div>
            </td>
            <td class="td-amount">
                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('price'); ?></span>
                    <input type="text" name="item_price" class="input-sm form-control amount" value="">
                </div>
            </td>
            <td class="td-amount">
                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('item_discount'); ?></span>
                    <input type="text" name="item_discount_amount" class="input-sm form-control amount"
                           value="" data-toggle="tooltip" data-placement="bottom"
                           title="<?php echo get_setting('currency_symbol') . ' ' . trans('per_item'); ?>">
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('tax_rate'); ?></span>
                    <select name="item_tax_rate_id" class="form-control input-sm">
                        <option value="0"><?php _trans('none'); ?></option>
                        <?php foreach ($tax_rates as $tax_rate) { ?>
                            <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                <?php check_select(get_setting('default_item_tax_rate'), $tax_rate->tax_rate_id); ?>>
                                <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </td>
            <td class="td-icon text-right td-vert-middle"></td>
        </tr>
        <tr>
            <?php if ($invoice->sumex_id == ""): ?>
                <td class="td-textarea">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('description'); ?></span>
                        <textarea name="item_description" class="input-sm form-control"></textarea>
                    </div>
                </td>
            <?php else: ?>
                <td class="td-date">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('date'); ?></span>
                        <input type="text" name="item_date" class="input-sm form-control datepicker"
                               value="<?php echo format_date(@$item->item_date); ?>">
                    </div>
                </td>
            <?php endif; ?>
            <td class="td-amount">
                <div class="input-group">
                    <span class="input-group-addon"><?php _trans('product_unit'); ?></span>
                    <select name="item_product_unit_id" class="form-control input-sm">
                        <option value="0"><?php _trans('none'); ?></option>
                        <?php foreach ($units as $unit) { ?>
                            <option value="<?php echo $unit->unit_id; ?>">
                                <?php echo $unit->unit_name . "/" . $unit->unit_name_plrl; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </td>
            <td class="td-amount td-vert-middle">
                <span><?php _trans('subtotal'); ?></span><br/>
                <span name="subtotal" class="amount"></span>
            </td>
            <td class="td-amount td-vert-middle">
                <span><?php _trans('discount'); ?></span><br/>
                <span name="item_discount_total" class="amount"></span>
            </td>
            <td class="td-amount td-vert-middle">
                <span><?php _trans('tax'); ?></span><br/>
                <span name="item_tax_total" class="amount"></span>
            </td>
            <td class="td-amount td-vert-middle">
                <span><?php _trans('total'); ?></span><br/>
                <span name="item_total" class="amount"></span>
            </td>
        </tr>
        </tbody>

        <?php foreach ($items as $item) { ?>
            <tbody class="item">
                <tr>
                    <td rowspan="2" class="td-icon">
                        <i class="fa fa-arrows cursor-move"></i>
                        <?php
                        if ($invoice->invoice_is_recurring) :
                            if ($item->item_is_recurring == 1 || is_null($item->item_is_recurring)) {
                                $item_recurrence_state = '1';
                                $item_recurrence_class = 'fa-calendar-check-o text-success';
                            } else {
                                $item_recurrence_state = '0';
                                $item_recurrence_class = 'fa-calendar-o text-muted';
                            }
                            ?>
                            <br/>
                            <i title="<?php echo trans('recurring') ?>"
                               class="js-item-recurrence-toggler cursor-pointer fa <?php echo $item_recurrence_class ?>"></i>
                            <input type="hidden" name="item_is_recurring" value="<?php echo $item_recurrence_state ?>"/>
                        <?php endif; ?>
                    </td>

                    <td class="td-amount td-quantity">
                        <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                        <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                        <input type="hidden" name="item_task_id" class="item-task-id"
                               value="<?php if ($item->item_task_id) {
                                   echo $item->item_task_id;
                               } ?>">
                        <input type="hidden" name="item_product_id" value="<?php echo $item->item_product_id; ?>">

                        <!--<div class="input-group">
                            <span class="input-group-addon"><?php _trans('item_kg'); ?></span>
                            <input type="text" name="item_kg" class="input-sm form-control amount" value="">
                        </div>-->
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('item_product_name'); ?></span>
                            <input type="text" name="item_name" class="input-sm form-control"
                                   value="<?php _htmlsc($item->item_name); ?>">
                        </div>
                    </td>
                    <td class="td-amount">
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('item_product_SKU'); ?></span>
                            <input type="text" name="item_product_SKU" class="input-sm form-control amount"
                                   value="<?php echo $item->item_product_SKU; ?>" >
                        </div>
                    </td>
                    <td class="td-amount td-quantity">
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('quantity'); ?></span>
                            <input type="text" name="item_quantity" class="input-sm form-control amount"
                                   value="<?php echo format_amount($item->item_quantity); ?>">
                        </div>
                    </td>
                    <td class="td-amount">
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('price'); ?></span>
                            <input type="text" name="item_price" class="input-sm form-control amount"
                                   value="<?php echo format_amount($item->item_price); ?>">
                        </div>
                    </td>
                    <td class="td-amount">
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('item_discount'); ?></span>
                            <input type="text" name="item_discount_amount" class="input-sm form-control amount"
                                   value="<?php echo format_amount($invoice->invoice_discount_percent != 0 ? $invoice->invoice_discount_percent : $item->item_discount_amount); ?>"
                                   data-toggle="tooltip" data-placement="bottom"
                                 >
                            <input type="hidden" name="item_discount_amount" value="0">
                            <div class="input-group-addon">&percnt;</div>
                        </div>
                    </td>
                    <td class="td-amount">
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('tax_rate'); ?></span>
                            <select name="item_tax_rate_id" class="form-control input-sm">
                                <option value="0"><?php _trans('none'); ?></option>
                                <?php foreach ($tax_rates as $tax_rate) { ?>
                                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                        <?php check_select($item->item_tax_rate_id, $tax_rate->tax_rate_id); ?>>
                                        <?php echo format_amount($tax_rate->tax_rate_percent) . '% - ' . $tax_rate->tax_rate_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td class="td-icon text-right td-vert-middle">
                        <?php if ($invoice->is_read_only != 1): ?>
                            <a href="<?php echo site_url('invoices/delete_item/' . $invoice->invoice_id . '/' . $item->item_id); ?>"
                               title="<?php _trans('delete'); ?>">
                                <i class="fa fa-trash-o text-danger"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <?php if ($invoice->sumex_id == ""): ?>
                        <td class="td-textarea">
                            <div class="input-group">
                                <span class="input-group-addon"><?php _trans('description'); ?></span>
                                <textarea name="item_description"
                                          class="input-sm form-control"><?php echo htmlsc($item->item_description); ?></textarea>
                            </div>
                        </td>
                    <?php else: ?>
                        <td class="td-date">
                            <div class="input-group">
                                <span class="input-group-addon"><?php _trans('date'); ?></span>
                                <input type="text" name="item_date" class="input-sm form-control datepicker"
                                       value="<?php echo format_date($item->item_date); ?>">
                            </div>
                        </td>
                    <?php endif; ?>
                    <td class="td-amount">
                        <div class="input-group">
                            <span class="input-group-addon"><?php _trans('product_unit'); ?></span>
                            <select name="item_product_unit_id" class="form-control input-sm">
                                <option value="0"><?php _trans('none'); ?></option>
                                <?php foreach ($units as $unit) { ?>
                                    <option value="<?php echo $unit->unit_id; ?>"
                                        <?php check_select($item->item_product_unit_id, $unit->unit_id); ?>>
                                        <?php echo htmlsc($unit->unit_name) . "/" . htmlsc($unit->unit_name_plrl); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td class="td-amount td-vert-middle">
                        <span><?php _trans('subtotal'); ?></span><br/>
                        <span name="subtotal" class="amount">
                            <?php echo format_currency($item->item_subtotal , $currency ); ?>
                        </span>
                    </td>
                    <td class="td-amount td-vert-middle">
                        <span><?php _trans('discount'); ?></span><br/>
                        <span name="item_discount_total" class="amount">
                            <?php echo format_currency($item->item_subtotal / 100 * $invoice->invoice_discount_percent , $currency); ?>
                        </span>
                    </td>
                    <td class="td-amount td-vert-middle">
                        <span><?php _trans('tax'); ?></span><br/>
                        <span name="item_tax_total" class="amount">
                            <?php echo format_currency($item->item_tax_total - ($item->item_tax_total / 100 * $invoice->invoice_discount_percent),$currency); ?>
                        </span>
                    </td>
                    <td class="td-amount td-vert-middle">
                        <span><?php _trans('total'); ?></span><br/>
                        <span name="item_total" class="amount">
                            <?php echo format_currency($item->item_total - ($item->item_total / 100 * $invoice->invoice_discount_percent),$currency); ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        <?php } ?>

    </table>
</div>

<br>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="btn-group">
            <?php if ($invoice->is_read_only != 1) { ?>
                <a href="#" class="btn_add_row btn btn-sm btn-default">
                    <i class="fa fa-plus"></i> <?php _trans('add_new_row'); ?>
                </a>
                <?php
                if($this->session->userdata('user_type') == TYPE_ADMIN) { ?>
                <a href="#" class="btn_add_product btn btn-sm btn-default">
                    <i class="fa fa-database"></i>
                    <?php _trans('add_product'); ?>
                </a>
                <?php
                }
                ?>
                <a href="#" class="btn_add_task btn btn-sm btn-default">
                    <i class="fa fa-database"></i> <?php _trans('add_task'); ?>
                </a>
            <?php } ?>
        </div>
    </div>

    <div class="col-xs-12 visible-xs visible-sm"><br></div>

    <div class="col-xs-12 col-md-6 col-md-offset-2 col-lg-4 col-lg-offset-4">
        <table class="table table-bordered text-right">
            <tr>
                <td class="td-vert-middle"><?php _trans('discount'); ?></td>
                <td class="clearfix">
                    <div class="discount-field">
                        <div class="input-group input-group-sm">
                            <input id="invoice_discount_amount" name="invoice_discount_amount"
                                   class="discount-option form-control input-sm amount"
                                   placeholder="<?php echo format_amount($invoice->invoice_item_subtotal / 100 * $invoice->invoice_discount_percent); ?>" disabled>
                            <div class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></div>
                        </div>
                    </div>


                    <div class="discount-field">
                        <div class="input-group input-group-sm">
                            <input id="invoice_discount_percent" name="invoice_discount_percent"
                                   value="<?php echo format_amount($invoice->invoice_discount_percent != 0 ? $invoice->invoice_discount_percent : '',$currency); ?>"
                                   class="discount-option form-control input-sm amount">
                            <div class="input-group-addon">&percnt;</div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 40%;"><?php _trans('subtotal'); ?></td>
                <td style="width: 60%;"
                    class="amount"><?php echo format_currency($invoice->invoice_item_subtotal - ( $invoice->invoice_item_subtotal / 100 * $invoice->invoice_discount_percent),$currency); ?></td>
            </tr>
            <?php
            if ($offer != null)
            {
            ?>
            <tr>
                <td style="width: 40%;"><?php _trans('transport'); ?> - <?php echo $offer->offer_transport_selected_text;?></td>
                <td style="width: 60%;"
                    class="amount"><?php echo format_currency(($invoice->offer_transport + $invoice->offer_transport_tax),$currency); ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td><?php _trans('item_tax'); ?></td>
                <td class="amount"><?php echo format_currency($invoice->invoice_item_tax_total - ( $invoice->invoice_item_tax_total / 100 *$invoice->invoice_discount_percent),$currency); ?></td>
            </tr>


            <tr>
                <td><?php _trans('total'); ?></td>
                <td class="amount"><b><?php echo format_currency($invoice->invoice_total,$currency); ?></b></td>
            </tr>
            <tr>
                <td><?php _trans('paid'); ?></td>
<!--                --><?php //var_dump($invoice->invoice_paid);die; ?>
                <td class="amount"><b><?php echo format_currency($invoice->invoice_paid,$currency); ?></b></td>
            </tr>
            <tr>
                <td><b><?php _trans('balance'); ?></b></td>
                <td class="amount"><b><?php echo format_currency($invoice->invoice_balance,$currency); ?></b></td>
            </tr>
        </table>
    </div>

</div>

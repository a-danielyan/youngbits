<?php 
// ok all
?>
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
                </td>
                <td class="td-text">
                    <input type="hidden" name="offer_id" value="<?php echo $offer_id; ?>">
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
                <td class="td-quantity">
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
                <td class="td-textarea">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('description'); ?></span>
                        <textarea name="item_description" class="input-sm form-control"></textarea>
                    </div>
                </td>
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
                </td>
                <td class="td-amount td-item_kg">
                    <input type="hidden" name="offer_id" value="<?php echo $offer_id; ?>">
                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>" >
                    <input type="hidden" name="item_task_id" class="item-task-id"
                           value="<?php if ($item->item_task_id) {
                               echo $item->item_task_id;
                           } ?>">
                    <input type="hidden" name="item_product_id" 
                    value="<?php if ($item->item_product_id) {
                               echo $item->item_product_id;
                           } ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('item_product_name'); ?></span>
                        <input type="text" name="item_name" class="input-sm form-control"
                               value="<?php _htmlsc($item->item_name); ?>">
                    </div>
                </td>
                <td class="td-amount td-quantity">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('item_product_SKU'); ?></span>
                        <input type="text" name="item_product_SKU" class="input-sm form-control amount"
                               value="<?php echo $item->item_product_SKU; ?>" >
                    </div>
                </td>
                <td class="td-amount">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('quantity'); ?></span>
                        <input type="text" name="item_quantity" class="input-sm form-control amount"
                               value="<?php echo format_amount($item->item_quantity); ?>" >
                    </div>
                </td>
                <td class="td-amount">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('price'); ?></span>
                        <input type="text" name="item_price" class="input-sm form-control amount"
                               value="<?php echo format_amount($item->item_price); ?>" >
                    </div>
                </td>
                <td class="td-amount">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('item_discount'); ?></span>
                        <input type="text" name="item_discount_amount" class="input-sm form-control amount"
                               value="<?php echo format_amount($item->item_discount_amount); ?>"
                               data-toggle="tooltip" data-placement="bottom"
                               title="<?php echo get_setting('currency_symbol') . ' ' . trans('per_item'); ?>" >
                    </div>
                </td>
                <td class="td-amount">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('tax_rate'); ?></span>
                        <select name="item_tax_rate_id" class="form-control input-sm" >
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
                    <a href="<?php echo site_url('offers/delete_item/' . $offer->offer_id . '/' . $item->item_id); ?>"
                       title="<?php _trans('delete'); ?>">
                        <i class="fa fa-trash-o text-danger"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="td-textarea">
                    <div class="input-group">
                        <span class="input-group-addon"><?php _trans('description'); ?></span>
                        <textarea name="item_description"
                                  class="input-sm form-control">
                            <?php echo htmlsc($item->item_description); ?></textarea>
                    </div>
                </td>
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
                    <span name="item_subtotal" class="amount">
                        <?php echo format_currency($item->item_subtotal); ?>
                    </span>
                </td>
                <td class="td-amount td-vert-middle">
                    <span><?php _trans('discount'); ?></span><br/>
                    <span name="item_discount" class="amount">
                        <?php echo format_currency($item->item_discount); ?>
                    </span>
                </td>
                <td class="td-amount td-vert-middle">
                    <span><?php _trans('tax'); ?></span><br/>
                    <span name="item_tax_total" class="amount">
                        <?php echo format_currency($item->item_tax_total); ?>
                    </span>
                </td>
                <td class="td-amount td-vert-middle">
                    <span><?php _trans('total'); ?></span><br/>
                    <span name="item_total" class="amount">
                        <?php echo format_currency($item->item_total); ?>
                    </span>
                </td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</div>

<br>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="btn-group">
            <a href="" id="test" class="btn_add_row btn btn-sm btn-default">
                <i class="fa fa-plus"></i> <?php _trans('add_new_row'); ?>
            </a>
            <a href="#" class="btn_add_product btn btn-sm btn-default">
                <i class="fa fa-database"></i>
                <?php _trans('add_product'); ?>
            </a>
            <a href="#" class="btn_add_task btn btn-sm btn-default">
                <i class="fa fa-database"></i> <?php _trans('add_task'); ?>
            </a>
        </div>

        <div class="col-xs-12 col-md-12"><br></div>

        <hr/>

        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default no-margin">
                <div class="panel-heading">
                    <?php _trans('offer_terms'); ?>
                </div>
                <div class="panel-body">
                    <textarea id="offer_terms" name="offer_terms" class="form-control" rows="3"
                    ><?php _htmlsc($offer->offer_terms); ?></textarea>
                </div>
            </div>
            <div class="col-xs-12 visible-xs visible-sm"><br></div>
        </div>
    </div>

    <div class="col-xs-12 visible-xs visible-sm"><br></div>

    <div class="col-xs-12 col-md-6 col-md-offset-2 col-lg-4 col-lg-offset-2">
        <table class="table table-bordered text-right">
            <tr>
                <td style="width: 40%;"><?php _trans('subtotal'); ?></td>
                <td style="width: 60%;"
                    class="amount"><?php echo format_currency($offer->offer_item_subtotal); ?></td>
            </tr>
            <tr>
                <td><?php _trans('transport'); ?></td>
                <td class="amount"><?php echo format_currency($offer->offer_transport); ?></td>
            </tr>
            <tr>
                <td><?php _trans('transport_tax'); ?></td>
                <td class="amount"><?php echo format_currency($offer->offer_transport_tax); ?></td>
            </tr>
            <tr>
                <td><?php _trans('item_tax'); ?></td>
                <td class="amount"><?php echo format_currency($offer->offer_item_tax_total); ?></td>
            </tr>
            <tr>
                <td><?php _trans('offer_tax'); ?></td>
                <td>
                    <?php 
                        echo format_currency('0');
                     ?>
                </td>
            </tr>
            <tr>
                <td class="td-vert-middle"><?php _trans('discount'); ?></td>
                <td class="clearfix">
                    <div class="discount-field">
                        <div class="input-group input-group-sm">
                            <input id="offer_discount_amount" name="offer_discount_amount"
                                   class="discount-option form-control input-sm amount"
                                   value="<?php echo format_amount($offer->offer_discount_amount != 0 ? $offer->offer_discount_amount : ''); ?>" >
                            <div class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></div>
                        </div>
                    </div>
                    <div class="discount-field">
                        <div class="input-group input-group-sm">
                            <input id="offer_discount_percent" name="offer_discount_percent"
                                   value="<?php echo format_amount($offer->offer_discount_percent != 0 ? $offer->offer_discount_percent : ''); ?>"
                                   class="discount-option form-control input-sm amount" >
                            <div class="input-group-addon">&percnt;</div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?php _trans('total'); ?></td>
                <td class="amount"><b><?php echo format_currency($offer->offer_total); ?></b></td>
            </tr>
        </table>
    </div>
</div>

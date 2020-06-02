<div class="panel panel-default">
    <div class="panel-heading"><?php _trans('email_template_tags'); ?></div>
    <div class="panel-body">

        <p class="small"><?php _trans('email_template_tags_instructions'); ?></p>

        <div class="form-group">
            <label for="tags_client"><?php _trans('prospect'); ?></label>
            <select id="tags_client" class="tag-select form-control">
                <option value="{{{supplier_surname}}}">
                    <?php _trans('name'); ?>
                </option>
                <option value="{{{supplier_surname_contactperson}}}">
                    <?php _trans('client_surname'); ?>
                </option>
                <option value="{{{supplier_address_1}}}">
                    <?php _trans('address') . ' 1'; ?>
                </option>
                <option value="{{{supplier_address_2}}}">
                    <?php _trans('address') . ' 2'; ?>
                </option>
                <option value="{{{supplier_city}}}">
                    <?php _trans('city'); ?>
                </option>
                <option value="{{{supplier_state}}}">
                    <?php _trans('state'); ?>
                </option>
                <option value="{{{supplier_zip}}}">
                    <?php _trans('zip'); ?>
                </option>
                <option value="{{{supplier_country}}}">
                    <?php _trans('country'); ?>
                </option>
                <option value="{{{supplier_address_1_delivery}}}">
                    <?php _trans('supplier_address_1_delivery'); ?>
                </option>
                <option value="{{{supplier_address_2_delivery}}}">
                    <?php _trans('supplier_address_2_delivery'); ?>
                </option>
                <option value="{{{supplier_city_delivery}}}">
                    <?php _trans('supplier_city_delivery'); ?>
                </option>
                <option value="{{{supplier_state_delivery}}}">
                    <?php _trans('supplier_state_delivery'); ?>
                </option>
                <option value="{{{supplier_zip_delivery}}}">
                    <?php _trans('supplier_zip_delivery'); ?>
                </option>
                <option value="{{{supplier_country_delivery}}}">
                    <?php _trans('supplier_country_delivery'); ?>
                </option>
                <option value="{{{phone}}}">
                    <?php _trans('supplier_phone'); ?>
                </option>
                <option value="{{{fax}}}">
                    <?php _trans('fax'); ?>
                </option>
                <option value="{{{mobile}}}">
                    <?php _trans('mobile'); ?>
                </option>
                <option value="{{{email}}}">
                    <?php _trans('email'); ?>
                </option>
                <option value="{{{web}}}">
                    <?php _trans('web'); ?>
                </option>
                <option value="{{{supplier_vat_id}}}">
                    <?php _trans('vat_id'); ?>
                </option>
                <option value="{{{supplier_tax_code}}}">
                    <?php _trans('tax_code'); ?>
                </option>
                <option value="{{{supplier_avs}}}">
                    <?php _trans('avs'); ?>
                </option>
                <option value="{{{supplier_tax_code}}}">
                    <?php _trans('tax_code'); ?>
                </option>
                <option value="{{{supplier_insurednumber}}}">
                    <?php _trans('insurednumber'); ?>
                </option>
                <option value="{{{supplier_veka}}}">
                    <?php _trans('veka'); ?>
                </option>
                <option value="{{{supplier_birthdate}}}">
                    <?php _trans('birthdate'); ?>
                </option>
                <option value="{{{supplier_gender}}}">
                    <?php _trans('gender'); ?>
                </option>
                <option value="{{{supplier_email2}}}">
                    <?php _trans('email2'); ?>
                </option>
                <option value="{{{supplier_category}}}">
                    <?php _trans('category'); ?>
                </option>
                <option value="{{{supplier_function_contactperson}}}">
                    <?php _trans('supplier_function_contactperson'); ?>
                </option>
                <option value="{{{supplier_additional_information}}}">
                    <?php _trans('additional_information'); ?>
                </option>
                <option value="{{{supplier_responsible}}}">
                    <?php _trans('responsible'); ?>
                </option>
                <option value="{{{supplier_sector}}}">
                    <?php _trans('sector'); ?>
                </option>
                <option value="{{{supplier_email_sent}}}">
                    <?php _trans('email_sent'); ?>
                </option>
                <optgroup label="<?php _trans('custom_fields'); ?>">
                    <?php foreach ($custom_fields['ip_client_custom'] as $custom) { ?>
                        <option value="{{{<?php echo 'ip_cf_' . $custom->custom_field_id; ?>}}}">
                            <?php echo $custom->custom_field_label . ' (ID ' . $custom->custom_field_id . ')'; ?>
                        </option>
                    <?php } ?>
                </optgroup>
            </select>
        </div>

    </div>
</div>

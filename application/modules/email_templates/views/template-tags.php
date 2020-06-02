<div class="panel panel-default">
    <div class="panel-heading"><?php _trans('email_template_tags'); ?></div>
    <div class="panel-body">

        <p class="small"><?php _trans('email_template_tags_instructions'); ?></p>
        <div class="form-group">
            <label for="project_url_google_drive"><?php _trans('image'); ?></label>
            <input type="file" name="email_template_img">
            <div class="input-group">
                <input type="text" id="email_template_img_url" name="email_template_img_url" class="form-control"
                       value="No image" disabled>
                <span class="input-group-addon to-clipboard cursor-pointer"
                      data-clipboard-target="#email_template_img_url">
                                              <i class="fa fa-clipboard fa-fw"></i>
                                        </span>
            </div>
        </div>



        <div class="form-group">
            <label for="tags_client"><?php _trans('client'); ?></label>
            <select id="tags_client" class="tag-select form-control">
                <option value="{{{client_name}}}">
                    <?php _trans('client_name'); ?>
                </option>
                <option value="{{{client_surname}}}">
                    <?php _trans('client_surname'); ?>
                </option>
                <option value="{{{client_address_1}}}">
                    <?php _trans('address') . ' 1'; ?>
                </option>
                <option value="{{{client_address_2}}}">
                    <?php _trans('address') . ' 2'; ?>
                </option>
                <option value="{{{client_city}}}">
                    <?php _trans('city'); ?>
                </option>
                <option value="{{{client_state}}}">
                    <?php _trans('state'); ?>
                </option>
                <option value="{{{client_zip}}}">
                    <?php _trans('zip'); ?>
                </option>
                <option value="{{{client_country}}}">
                    <?php _trans('country'); ?>
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

        <div class="form-group">
            <label for="tags_user"><?php _trans('user'); ?></label>
            <select id="tags_user" class="tag-select form-control" name="tags_user">
                <option value="{{{user_name}}}">
                    <?php _trans('name'); ?>
                </option>
                <option value="{{{user_company}}}">
                    <?php _trans('company'); ?>
                </option>
                <option value="{{{user_address_1}}}">
                    <?php _trans('address') . ' 1'; ?>
                </option>
                <option value="{{{user_address_2}}}">
                    <?php _trans('address') . ' 2'; ?>
                </option>
                <option value="{{{user_city}}}">
                    <?php _trans('city'); ?>
                </option>
                <option value="{{{user_state}}}">
                    <?php _trans('state'); ?>
                </option>
                <option value="{{{user_zip}}}">
                    <?php _trans('zip'); ?>
                </option>
                <option value="{{{user_country}}}">
                    <?php _trans('country'); ?>
                </option>
                <optgroup label="<?php _trans('contact_information'); ?>">
                    <option value="{{{user_phone}}}">
                        <?php _trans('phone'); ?>
                    </option>
                    <option value="{{{user_fax}}}">
                        <?php _trans('fax'); ?>
                    </option>
                    <option value="{{{user_mobile}}}">
                        <?php _trans('mobile'); ?>
                    </option>
                    <option value="{{{user_email}}}">
                        <?php _trans('email'); ?>
                    </option>
                    <option value="{{{user_web}}}">
                        <?php _trans('web_address'); ?>
                    </option>
                </optgroup>
                <optgroup label="<?php _trans('sumex_information'); ?>">
                    <option value="{{{user_subscribernumber}}}">
                        <?php _trans('user_subscriber_number'); ?>
                    </option>
                    <option value="{{{user_iban}}}">
                        <?php _trans('user_iban'); ?>
                    </option>
                    <option value="{{{user_gln}}}">
                        <?php _trans('gln'); ?>
                    </option>
                    <option value="{{{user_rcc}}}">
                        <?php _trans('sumex_rcc'); ?>
                    </option>
                </optgroup>
                <optgroup label="<?php _trans('custom_fields'); ?>">
                    <?php foreach ($custom_fields['ip_user_custom'] as $custom) { ?>
                        <option value="{{{<?php echo 'ip_cf_' . $custom->custom_field_id; ?>}}}">
                            <?php echo $custom->custom_field_label . ' (ID ' . $custom->custom_field_id . ')'; ?>
                        </option>
                    <?php } ?>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="tags_client"><?php _trans('invoices'); ?></label>
            <select id="tags_client" class="tag-select form-control">
                <option value="{{{invoice_guest_url}}}">
                    <?php _trans('guest_url'); ?>
                </option>
                <option value="{{{invoice_number}}}">
                    <?php _trans('id'); ?>
                </option>
                <option value="{{{invoice_date_due}}}">
                    <?php _trans('due_date'); ?>
                </option>
                <option value="{{{invoice_date_created}}}">
                    <?php _trans('created'); ?>
                </option>
                <option value="{{{invoice_terms}}}">
                    <?php _trans('invoice_terms'); ?>
                </option>
                <option value="{{{invoice_total}}}">
                    <?php _trans('total'); ?>
                </option>
                <option value="{{{invoice_paid}}}">
                    <?php _trans('total_paid'); ?>
                </option>
                <option value="{{{invoice_balance}}}">
                    <?php _trans('balance'); ?>
                </option>
                <option value="{{{invoice_status}}}">
                    <?php _trans('status'); ?>
                </option>
                <optgroup label="<?php _trans('custom_fields'); ?>">
                    <?php foreach ($custom_fields['ip_invoice_custom'] as $custom) { ?>
                        <option value="{{{<?php echo 'ip_cf_' . $custom->custom_field_id; ?>}}}">
                            <?php echo $custom->custom_field_label . ' (ID ' . $custom->custom_field_id . ')'; ?>
                        </option>
                    <?php } ?>
                </optgroup>
            </select>
        </div>
        <?php
        if (USE_QUOTES) {
            ?>
            <div class="form-group">
                <label for="tags_client"><?php _trans('quotes'); ?></label>
                <select id="tags_client" class="tag-select form-control">
                    <option value="{{{quote_total}}}">
                        <?php _trans('total'); ?>
                    </option>
                    <option value="{{{quote_date_created}}}">
                        <?php _trans('quote_date'); ?>
                    </option>
                    <option value="{{{quote_date_expires}}}">
                        <?php _trans('expires'); ?>
                    </option>
                    <option value="{{{quote_number}}}">
                        <?php _trans('id'); ?>
                    </option>
                    <option value="{{{quote_guest_url}}}">
                        <?php _trans('guest_url'); ?>
                    </option>
                    <optgroup label="<?php _trans('custom_fields'); ?>">
                        <?php foreach ($custom_fields['ip_quote_custom'] as $custom) { ?>
                            <option value="{{{<?php echo 'ip_cf_' . $custom->custom_field_id; ?>}}}">
                                <?php echo $custom->custom_field_label . ' (ID ' . $custom->custom_field_id . ')'; ?>
                            </option>
                        <?php } ?>
                    </optgroup>
                </select>
            </div>
            <?php
        }
        ?>
        <?php
        if (USE_OFFERS) {
            ?>
            <div class="form-group">
                <label for="tags_client"><?php _trans('offers'); ?></label>
                <select id="tags_client" class="tag-select form-control">
                    <option value="{{{offer_guest_url}}}">
                        <?php _trans('guest_url'); ?>
                    </option>
                    <option value="{{{offer_number}}}">
                        <?php _trans('id'); ?>
                    </option>
                    <option value="{{{offer_due_date}}}">
                        <?php _trans('due_date'); ?>
                    </option>
                    <option value="{{{offer_date_created}}}">
                        <?php _trans('created'); ?>
                    </option>
                    <option value="{{{offer_terms}}}">
                        <?php _trans('offer_terms'); ?>
                    </option>
                </select>
            </div>
            <?php
        }
        ?>

        <div class="form-group">
            <label for="tags_client"><?php _trans('tickets'); ?></label>
            <select id="tags_client" class="tag-select form-control">
                <option value="{{{ticket_number}}}">
                    <?php _trans('ticket_number'); ?>
                </option>
                <option value="{{{ticket_name}}}">
                    <?php _trans('ticket_name'); ?>
                </option>
                <option value="{{{ticket_id}}}">
                    <?php _trans('ticket_id'); ?>
                </option>
                <option value="{{{ticket_description}}}">
                    <?php _trans('ticket_description'); ?>
                </option>
                <option value="{{{ticket_status}}}">
                    <?php _trans('status'); ?>
                </option>
                <option value="{{{ticket_assigned_user_name}}}">
                    <?php _trans('assign_to'); ?>
                </option>
                <option value="{{{ticket_created_user_name}}}">
                    <?php _trans('ticket_created_by'); ?>
                </option>
                <option value="{{{client_name}}}">
                    <?php _trans('client'); ?>
                </option>
                <option value="{{{project_name}}}">
                    <?php _trans('project_name'); ?>
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="tags_client"><?php _trans('invoice_sumex'); ?></label>
            <select id="tags_client" class="tag-select form-control">
                <option value="{{{sumex_reason}}}">
                    <?php _trans('reason'); ?>
                </option>
                <option value="{{{sumex_diagnosis}}}">
                    <?php _trans('invoice_sumex_diagnosis'); ?>
                </option>
                <option value="{{{sumex_observations}}}">
                    <?php _trans('sumex_observations'); ?>
                </option>
                <option value="{{{sumex_treatmentstart}}}">
                    <?php _trans('treatment') . ' ' . trans('start'); ?>
                </option>
                <option value="{{{sumex_treatmentend}}}">
                    <?php _trans('treatment') . ' ' . trans('end'); ?>
                </option>
                <option value="{{{sumex_casedate}}}">
                    <?php _trans('case_date'); ?>
                </option>
                <option value="{{{sumex_casenumber}}}">
                    <?php _trans('case_number'); ?>
                </option>
            </select>
        </div>


        <div class="form-group">
            <label for="tags_client"><?php _trans('prospect'); ?></label>
            <select id="tags_client" class="tag-select form-control">
                <option value="{{{lead_surname}}}">
                    <?php _trans('name'); ?>
                </option>
                <option value="{{{lead_surname_contactperson}}}">
                    <?php _trans('client_surname'); ?>
                </option>
                <option value="{{{lead_address_1}}}">
                    <?php _trans('address') . ' 1'; ?>
                </option>
                <option value="{{{lead_address_2}}}">
                    <?php _trans('address') . ' 2'; ?>
                </option>
                <option value="{{{lead_city}}}">
                    <?php _trans('city'); ?>
                </option>
                <option value="{{{lead_state}}}">
                    <?php _trans('state'); ?>
                </option>
                <option value="{{{lead_zip}}}">
                    <?php _trans('zip'); ?>
                </option>
                <option value="{{{lead_country}}}">
                    <?php _trans('country'); ?>
                </option>
                <option value="{{{lead_address_1_delivery}}}">
                    <?php _trans('lead_address_1_delivery'); ?>
                </option>
                <option value="{{{lead_address_2_delivery}}}">
                    <?php _trans('lead_address_2_delivery'); ?>
                </option>
                <option value="{{{lead_city_delivery}}}">
                    <?php _trans('lead_city_delivery'); ?>
                </option>
                <option value="{{{lead_state_delivery}}}">
                    <?php _trans('lead_state_delivery'); ?>
                </option>
                <option value="{{{lead_zip_delivery}}}">
                    <?php _trans('lead_zip_delivery'); ?>
                </option>
                <option value="{{{lead_country_delivery}}}">
                    <?php _trans('lead_country_delivery'); ?>
                </option>
                <option value="{{{phone}}}">
                    <?php _trans('lead_phone'); ?>
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
                <option value="{{{lead_vat_id}}}">
                    <?php _trans('vat_id'); ?>
                </option>
                <option value="{{{lead_tax_code}}}">
                    <?php _trans('tax_code'); ?>
                </option>
                <option value="{{{lead_avs}}}">
                    <?php _trans('avs'); ?>
                </option>
                <option value="{{{lead_tax_code}}}">
                    <?php _trans('tax_code'); ?>
                </option>
                <option value="{{{lead_insurednumber}}}">
                    <?php _trans('insurednumber'); ?>
                </option>
                <option value="{{{lead_veka}}}">
                    <?php _trans('veka'); ?>
                </option>
                <option value="{{{lead_birthdate}}}">
                    <?php _trans('birthdate'); ?>
                </option>
                <option value="{{{lead_gender}}}">
                    <?php _trans('gender'); ?>
                </option>
                <option value="{{{lead_email2}}}">
                    <?php _trans('email2'); ?>
                </option>
                <option value="{{{lead_category}}}">
                    <?php _trans('category'); ?>
                </option>
                <option value="{{{lead_function_contactperson}}}">
                    <?php _trans('lead_function_contactperson'); ?>
                </option>
                <option value="{{{lead_additional_information}}}">
                    <?php _trans('additional_information'); ?>
                </option>
                <option value="{{{lead_responsible}}}">
                    <?php _trans('responsible'); ?>
                </option>
                <option value="{{{lead_sector}}}">
                    <?php _trans('sector'); ?>
                </option>
                <option value="{{{lead_email_sent}}}">
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

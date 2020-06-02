<script>
    $().ready(function () {
        $('#btn-submit').click(function () {
            $('#form-settings').submit();
        });
        $("[name='settings[default_country]']").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('settings'); ?></h1>
    <?php $this->layout->load_view('layout/header_buttons', array('hide_cancel_button' => true)); ?>
</div>

<ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder">
    <li class="active">
        <a data-toggle="tab" href="#settings-general"><?php _trans('general'); ?></a>
    </li>
    <?php
    if (USE_OFFERS) {
    ?>
    <li>
        <a data-toggle="tab" href="#settings-offers"><?php _trans('offers'); ?></a>
    </li>
    <?php
    }
    ?>
    <li>
        <a data-toggle="tab" href="#settings-invoices"><?php _trans('invoices'); ?></a>
    </li>
    <?php
    if (USE_QUOTES) {
    ?>
    <li>
        <a data-toggle="tab" href="#settings-quotes"><?php _trans('quotes'); ?></a>
    </li>
    <?php
    }
    ?>
    <li>
        <a data-toggle="tab" href="#settings-taxes"><?php _trans('taxes'); ?></a>
    </li>
    <li>
        <a data-toggle="tab" href="#settings-email"><?php _trans('email'); ?></a>
    </li>
    <li>
        <a data-toggle="tab" href="#settings-online-payment"><?php echo lang('online_payment'); ?></a>
    </li>
    <li>
        <a data-toggle="tab" href="#settings-projects-tasks"><?php _trans('projects'); ?></a>
    </li>
    <li>
        <a data-toggle="tab" href="#settings-updates"><?php _trans('updates'); ?></a>
    </li>
</ul>

<form method="post" id="form-settings" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div class="tabbable tabs-below">

        <div class="tab-content">

            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <?php $this->layout->load_view('layout/alerts'); ?>
            </div>

            <div id="settings-general" class="tab-pane active">
                <?php $this->layout->load_view('settings/partial_settings_general'); ?>
            </div>
            <?php
            if (USE_OFFERS) {
            ?>
            <div id="settings-offers" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_offers'); ?>
            </div>
            <?php
        }
            ?>

            <div id="settings-invoices" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_invoices'); ?>
            </div>

            <div id="settings-quotes" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_quotes'); ?>
            </div>

            <div id="settings-taxes" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_taxes'); ?>
            </div>

            <div id="settings-email" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_email'); ?>
            </div>

            <div id="settings-online-payment" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_online_payment'); ?>
            </div>

            <div id="settings-projects-tasks" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_projects_tasks'); ?>
            </div>

            <div id="settings-updates" class="tab-pane">
                <?php $this->layout->load_view('settings/partial_settings_updates'); ?>
            </div>

        </div>

    </div>

</form>

<!-- Modal -->
<div id="addCompanyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="<?= site_url('settings/addCompany') ?>" enctype="multipart/form-data" method="post">
            <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                   value="<?php echo $this->security->get_csrf_hash() ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php _trans('add_new_company'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="c_name">
                            <?php _trans('c_name'); ?>
                        </label>
                        <input required name="name" id="c_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_company">
                            <?php _trans('c_company'); ?>
                        </label>
                        <input required name="company" id="c_company" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_image">
                            <?php _trans('c_image'); ?>
                        </label>
                        <input required type="file" accept="image/*" name="logo" id="c_image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_street_1">
                            <?php _trans('c_street_1'); ?>
                        </label>
                        <input required name="street_1" id="c_street_1" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_steet_2">
                            <?php _trans('c_steet_2'); ?>
                        </label>
                        <input name="street_2" id="c_steet_2" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_city">
                            <?php _trans('c_city'); ?>
                        </label>
                        <input required name="city" id="c_city" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_zip">
                            <?php _trans('c_zip'); ?>
                        </label>
                        <input required name="zip_code" id="c_zip" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_country">
                            <?php _trans('c_country'); ?>
                        </label>
                        <select required name="country_id" id="c_country" class="form-control">
                            <?php foreach ($countries as $key=>$val) { ?>
                                <option value="<?= $key ?>"><?= $val ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="c_vat_id">
                            <?php _trans('c_vat_id'); ?>
                        </label>
                        <input required name="vat_id" id="c_vat_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_taxes_code">
                            <?php _trans('c_taxes_code'); ?>
                        </label>
                        <input required name="taxes_code" id="c_taxes_code" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_iban">
                            <?php _trans('c_iban'); ?>
                        </label>
                        <input required name="iban" id="c_iban" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_phone">
                            <?php _trans('c_phone'); ?>
                        </label>
                        <input required name="phone" id="c_phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_fax">
                            <?php _trans('c_fax'); ?>
                        </label>
                        <input name="fax" id="c_fax" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_default_company">
                            <?php _trans('c_default_company'); ?>
                        </label>
                        <input type="checkbox" name="default_company" id="c_default_company" class="form-control">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php _trans('save'); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php _trans('close'); ?></button>
                </div>
            </div>
        </form>

    </div>
</div>


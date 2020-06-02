<form action="<?= site_url('companies/addCompany/') ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('add_new_company'); ?></h1>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="c_name">
                        <?php _trans('c_name'); ?>
                    </label>
                    <input required name="name" id="c_name" class="form-control">
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
                    <label for="c_street_2">
                        <?php _trans('c_street_2'); ?>
                    </label>
                    <input name="street_2" id="c_street_2" class="form-control">
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
                    <input name="vat_id" id="c_vat_id" class="form-control">
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
                    <label for="c_default_company">
                        <?php _trans('c_default_company'); ?>
                    </label>
                    <input value="1" type="checkbox" name="default_company" id="c_default_company" class="">
                </div>

                <div class="form-group">
                    <label>
                        <button class="btn btn-success"><?php _trans('save') ?></button>
                    </label>
                </div>
            </div>

        </div>

    </div>

</form>

<form action="<?= site_url('companies/editCompany/'.$company->id) ?>" method="post" name="companyForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar" class="headerbar-item">

        <h1 class="headerbar-title"><?php _trans('edit_company'); ?></h1>

        <a onclick="document.companyForm.submit()" class="btn btn-success btn-sm ajax-loader pull-right" id="btn_save_quote">
            <i class="fa fa-check"></i>
            <?php _trans('save'); ?>
        </a>
        <a href="<?= site_url('companies/') ?>" class="btn btn-default btn-sm pull-right" id="btn_save_quote">
            <?php _trans('cancel'); ?>
        </a>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2 text-right text-left-xs">
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="row">
                    <div class="form-group">
                        <label for="c_name">
                            <?php _trans('c_name'); ?>
                        </label>
                        <input name="name" value="<?= $company->name ?>" id="c_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <div class="company_logo_block">
                            <img width="150" src="<?= base_url('./uploads/' . $company->logo) ?>" alt="">
                        </div>
                        <label for="c_image">
                            <?php _trans('c_image'); ?>
                        </label>
                        <input type="file" accept="image/*" name="logo" id="c_image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_street_1">
                            <?php _trans('c_street_1'); ?>
                        </label>
                        <input name="street_1" id="c_street_1" value="<?= $company->street_1 ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_steet_2">
                            <?php _trans('c_street_2'); ?>
                        </label>
                        <input name="street_2" id="c_steet_2" value="<?= $company->street_2 ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_city">
                            <?php _trans('c_city'); ?>
                        </label>
                        <input name="city" id="c_city" value="<?= $company->city ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_zip">
                            <?php _trans('c_zip'); ?>
                        </label>
                        <input name="zip_code" value="<?= $company->city ?>" id="c_zip" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_country">
                            <?php _trans('c_country'); ?>
                        </label>
                        <select name="country_id" id="c_country" class="form-control">
                            <?php foreach ($countries as $key=>$val) { ?>
                                <option <?php if($key === $company->country_id){echo 'selected';} ?> value="<?= $key ?>"><?= $val ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="c_vat_id">
                            <?php _trans('c_vat_id'); ?>
                        </label>
                        <input name="vat_id" value="<?= $company->vat_id ?>" id="c_vat_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_iban">
                            <?php _trans('c_iban'); ?>
                        </label>
                        <input name="iban" id="c_iban" value="<?= $company->iban ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_phone">
                            <?php _trans('c_phone'); ?>
                        </label>
                        <input name="phone" id="c_phone" value="<?= $company->phone ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="c_default_company">
                            <?php _trans('c_default_company'); ?>
                        </label>
                        <input type="checkbox" <?= $company->default_company ? 'checked' : '' ?> value="1" name="default_company" id="c_default_company" class="">
                    </div>
                </div>
            </div>

        </div>

    </div>

</form>

<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
        <?php echo get_setting('custom_title', 'Spudu', true); ?>
        - <?php echo trans('offer'); ?> <?php echo $offer->offer_number; ?>
    </title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/core/js/legacy.min.js"></script>
    <![endif]-->

    <script src="<?php echo base_url(); ?>assets/core/js/dependencies.min.js"></script>
    <script>
    $(function () {
        $('#btn_accept_offer').click(function () {
            $.post("<?php echo site_url('guest/view/offer_accept/' . $offer_url_key); ?>", {
                    comment: $('#comment').val(),
                    transport: $('#transport:checked').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        window.location = "<?php echo site_url('guest/view/offer/' . $offer_url_key); ?>";
                    } else {
                        alert("<?php echo trans('loading_error'); ?>")
                    }
                });
        });
        $('#btn_decline_offer').click(function () {
            $.post("<?php echo site_url('guest/view/offer_decline/' . $offer_url_key); ?>", {
                    comment: $('#comment').val(),
                    transport: $('#transport:checked').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        window.location = "<?php echo site_url('guest/view/offer/' . $offer_url_key); ?>";
                    } else {
                        alert("<?php echo trans('loading_error'); ?>")
                    }
                });
        });
    });
    </script>
</head>
<body>

<div class="container">
    <div id="content">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div id="logo">
                <?php echo offer_logo(); ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-12 col-lg-12">
            <br /><br />  
        </div>
        <div class="webpreview-header">

            <h2><?php echo trans('offer'); ?>&nbsp;<?php echo $offer->offer_number; ?></h2>

            <div class="btn-group">
                <a href="<?php echo site_url('guest/view/generate_offer_pdf/' . $offer_url_key); ?>"
                   class="btn btn-primary">
                        <i class="fa fa-print"></i> <?php echo trans('download_pdf'); ?>
                    </a>
            </div>

        </div>

        <hr>

        <?php echo $this->layout->load_view('layout/alerts'); ?>

        <div class="col-xs-12 col-md-12 col-lg-12 no-padding">
            <iframe class="col-xs-12 col-md-12 col-lg-12" height="800" src="<?php echo site_url('guest/view/generate_offer_pdf/' . $offer_url_key); ?>"></iframe> 
        </div>

        <hr>

        <div class="row">

            <div class="col-xs-12 col-md-5 col-lg-4">
                
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h3><strong><?php echo trans('contact_info'); ?></strong></h3>
                </div>

                <br />
                <br />

                <div class="col-xs-12 col-md-12 col-lg-12">

                    <div><?php echo trans('contact_informations'); ?></div>
                    
                    <br />
                    <div><strong><?php echo trans('address'); ?></strong>:&nbsp;<?php echo trans('address_info'); ?></div>

                    <div><strong><?php echo trans('phone'); ?></strong>:&nbsp;<?php echo trans('phone_info'); ?></div>

                    <div><strong><?php echo trans('email'); ?></strong>:&nbsp;<?php echo trans('email_info'); ?></div>
                    
                    <div><strong><?php echo trans('fax'); ?></strong>:&nbsp;<?php echo trans('fax_info'); ?></div>
                </div>

            </div>
            <div class="col-xs-12 col-md-7 col-lg-8">

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h3><strong><?php echo trans('accept_or_reject_offer'); ?></strong></h3>
                </div>
                <br />
                <br />
<?php
                if ($offer->is_overdue)
                {
                    ?>
                    <div>
                        <label><?php echo trans('offer_due_date_reached'); ?></label>
                    </div>
                    <?php
                }
                else if ($offer->offer_status_id == 4) // accepted
                {
                    ?>
                    <div>
                        <label><?php echo trans('offer_is_accepted'); ?></label>
                    </div>
                    <?php
                }
                else if ($offer->offer_status_id == 5) // declined
                {
                    ?>
                    <div>
                        <label><?php echo trans('offer_is_declined'); ?></label>
                    </div>
                    <?php
                }
                else if ($offer->offer_status_id == 2 || $offer->offer_status_id == 3) // sent, viewed
                {
?>
                <form>
                    <div class="col-xs-12 col-md-12 col-lg-12 no-margin no-padding">
                        <div class="col-xs-12 col-md-12 col-lg-4 no-padding">
                            <div class="radio">
                                <label><?php echo trans('transport'); ?></label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 col-lg-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="transport" id="transport"
                                           value="Tailgate" checked>
                                    <?php echo trans('transport_tailgate'); ?>&nbsp;(<?php echo format_currency($offer->transport_tailgate); ?>)
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 col-lg-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="transport" id="transport"
                                           value="Without_tailgate">
                                    <?php echo trans('transport_without_tailgate'); ?>&nbsp;(<?php echo format_currency($offer->transport_without_tailgate); ?>)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12 col-lg-12 no-margin">
                        <div class="form-group">
                        <textarea name="comment" id="comment" rows="5"
                                  class="form-control taggable"
                                  placeholder="<?php echo trans('your_comment'); ?>"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <div class="col-xs-6 col-md-6 col-lg-6">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-danger" id="btn_decline_offer">
                                        <?php echo trans('reject_offer'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6 no-margin">
                                <div class="btn-group pull-right">
                                    <a href="#" class="btn btn-primary" id="btn_accept_offer">
                                        <?php echo trans('accept_offer'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                }
                ?>

            </div>

        </div>

    </div><!-- #content -->
</div>
<script defer src="<?php echo base_url(); ?>assets/core/js/scripts.min.js"></script>
<?php if (trans('cldr') != 'en') { ?>
    <script src="<?php echo base_url(); ?>assets/core/js/locales/bootstrap-datepicker.<?php _trans('cldr'); ?>.js"></script>
<?php } ?>
</body>
</html>

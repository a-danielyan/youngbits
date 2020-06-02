<!doctype html>

<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <title>
        <?php
        if (get_setting('custom_title') != '') {
            echo get_setting('custom_title');
        } else {
            echo 'Spudu';
        } ?>
    </title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <meta name="robots" content="NOINDEX,NOFOLLOW">

    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/core/img/favicon.png">

    <link href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'Spudu'); ?>/css/style.css"
          rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/core/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/core/css/loginPage.css" rel="stylesheet">

    <!--  Google fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>

<body>

<noscript>
    <div class="alert alert-danger no-margin"><?php _trans('please_enable_js'); ?></div>
</noscript>

<br>

<div class="container">

    <div id="password_reset" class="panel panel-default panel-body col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <?php if ($login_logo) { ?>
            <img src="<?php echo base_url(); ?>uploads/<?php echo $login_logo; ?>" class="login-logo img-responsive">
        <?php } else { ?>
            <h1><?php _trans('login'); ?></h1>
        <?php } ?>

        <div class="row"><?php $this->layout->load_view('layout/alerts'); ?></div>

        <h3><?php _trans('password_reset'); ?></h3>

        <br/>

        <p><?php _trans('password_reset_info'); ?></p>
        <div class="col-md login_form">
            <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

            <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                   value="<?php echo $this->security->get_csrf_hash() ?>">

            <div class="form-group ">
                <!--<span class="user_ico"></span>-->
                <input type="text" name="email" id="email" class="form-control"
                       placeholder="<?php _trans('login_email'); ?>" required autofocus>
            </div>

            <input type="hidden" name="btn_reset" value="true">

                <div class="form-group text-center">

                    <button type="submit" class="btn btn-danger loginButton ">
                        <?php _trans('reset_password'); ?>
                    </button>
                </div>

        </form>
        </div>
    </div>

</div>

</body>
</html>

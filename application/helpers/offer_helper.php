<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Spudu
 *
 * @author		Spudu Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2017 Spudu.com
 * @license		https://Spudu.com/license.txt
 * @link		https://Spudu.com
 */

/**
 * Returns the offer image
 *
 * @return string
 */
function offer_logo()
{
    $CI = &get_instance();

    if ($CI->mdl_settings->setting('offer_logo')) {
        return '<img src="' . base_url() . 'uploads/' . $CI->mdl_settings->setting('offer_logo') . '">';
    }

    return '';
}


/**
 * Returns the offer logo for PDF files
 *
 * @return string
 */
function offer_logo_pdf()
{
    $CI = &get_instance();

    if ($CI->mdl_settings->setting('offer_logo')) {
        return '<img src="' . getcwd() . '/uploads/' . $CI->mdl_settings->setting('offer_logo') . '" id="offer-logo">';
    }

    return '';
}

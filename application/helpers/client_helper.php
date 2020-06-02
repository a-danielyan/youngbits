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
 * @param object $client
 * @return string
 */
function format_client($client)
{
    if ($client->client_surname != "") {
        return $client->client_name;
    }

    return $client->client_name;
}

/**
 * @param object $lead
 * @return string
 */
function format_supplier($supplier)
{
    if ($supplier->supplier_surname != "") {
        return $supplier->supplier_name . " " . $supplier->supplier_surname;
    }

    return $supplier->supplier_name;
}
/**
 * @param object $lead
 * @return string
 */
function format_distributor($distributor)
{
    if ($distributor->distributor_surname != "") {
        return $distributor->distributor_name . " " . $distributor->distributor_surname;
    }

    return $distributor->distributor_name;
}
/**
 * @param object $lead
 * @return string
 */
function format_lead($lead)
{
    if ($lead->lead_surname != "") {
        return $lead->lead_name . " " . $lead->lead_surname;
    }

    return $lead->lead_name;
}
/**
 * @param object $target
 * @return string
 */
function format_target($target)
{
    if ($target->target_surname != "") {
        return $target->target_name . " " . $target->target_surname;
    }

    return $target->target_name;
}

/**
 * @param object $hr
 * @return string
 */
function format_hr($hr)
{
    if ($hr->hr_surname != "") {
        return $hr->hr_name . " " . $hr->hr_surname;
    }

    return $hr->hr_name;
}

/**
 * @param string $gender
 * @return string
 */
function format_gender($gender)
{
    if ($gender == 0) {
        return trans('gender_male');
    }

    if ($gender == 1) {
        return trans('gender_female');
    }

    return trans('gender_other');
}

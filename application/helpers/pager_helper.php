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
 * Returns a printable pagination
 *
 * @param $base_url
 * @param $model
 * @return string
 */
function pager($base_url, $model)
{
    $CI = &get_instance();

    $params = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    if (strlen($params) > 0)
    {
        $params = '?' . $params;
    }

    $pager = '<div class="model-pager btn-group btn-group-sm">';

    if (($previous_page = $CI->$model->previous_offset) >= 0) {
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/0' . $params . '" title="' . trans('first') . '"><i class="fa fa-fast-backward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/' . $CI->$model->previous_offset . $params . '" title="' . trans('prev') . '"><i class="fa fa-backward no-margin"></i></a>';
    } else {
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('first') . '"><i class="fa fa-fast-backward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('prev') . '"><i class="fa fa-backward no-margin"></i></a>';
    }

    if (($next_page = $CI->$model->next_offset) <= $CI->$model->last_offset) {
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/' . $CI->$model->next_offset . $params . '" title="' . trans('next') . '"><i class="fa fa-forward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/' . $CI->$model->last_offset . $params . '" title="' . trans('last') . '"><i class="fa fa-fast-forward no-margin"></i></a>';
    } else {
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('next') . '"><i class="fa fa-forward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('last') . '"><i class="fa fa-fast-forward no-margin"></i></a>';
    }

    $pager .= '</div>';

    return $pager;
}

function orderableTH($get, $currField, $table)
{
    $domain = explode('/', base_url());
    $domain = $domain[0];
    $url = explode('?', $_SERVER['REQUEST_URI']);
    $url = $url[0];
    $field = $currField;
    $type = 'desc';
    $class = '';

    if (isset($get['type'])) {
        if($field === $get['field']){
            if($get['type'] == 'desc'){
                $type = 'asc';
                $class = 'order_asc';
            }else{
                $class = 'order_desc';
            }
        }else{
            $class = 'order_passive';
        }
    }else{
        $class = 'order_passive';
    }

    echo 'href="' . $domain . $url . '?field=' . $field . '&' . 'type=' . $type . '&table=' . $table . '" class="'.$class.'"';

}


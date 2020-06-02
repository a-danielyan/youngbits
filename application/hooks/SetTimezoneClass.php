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
 * Class SetTimezoneClass
 */
class  SetTimezoneClass
{
    /**
     * Set UTC as the current timezone if no one was set in the PHP ini
     */
    public function setTimezone()
    {
        if (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
    }
}

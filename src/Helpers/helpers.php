<?php

/**
 * PHP version 7.4
 * 
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  CVS: <1.0>
 * @link     ""
 */

use Illuminate\Support\Str;

if (!function_exists('Coupon_asset')) {
    /**
     * Retrieves assets path
     *
     * @param string $path 
     * @param string $secure 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    function Coupon_asset($path, $secure = null)
    {
        return route('coupon.coupon_assets') . '?path=' . urlencode($path);
    }
}
if (!function_exists('Coupon_generator')) {
    /**
     * Generates coupon
     *
     * @param string $prefix 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    function Coupon_generator($prefix = null)
    {
        return Str::upper($prefix . Str::random(5));
    }
}
if (!function_exists('setTimeZone')) {
    /**
     * Sets timezone
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    function setTimeZone()
    {
        $timezone = config('coupon.timezone');
        date_default_timezone_set($timezone);
        return $timezone;
    }
}
if (!function_exists('Get_currency')) {
    /**
     * Sets timezone
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    function Get_currency()
    {
        $timezone = config('coupon.currency');
        foreach (config('coupon.currency_code') as $key => $currency) {
            if ($timezone == $key) {
                return $currency;
            }
        }
    }
}
if (!function_exists('pluralize')) {
    /**
     * Pluraize words
     *
     * @param string $key 
     * @param string $value 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    function pluralize($key, $value)
    {
        $string = Str::lower(Str::plural($key, $value));
        return $string;
    }
}

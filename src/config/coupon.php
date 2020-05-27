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
return [
    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | Here you can specify the coupon genrator timezone 
    |
    */

    'timezone' => 'Africa/Lagos',

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Here you can specify the coupon genrator currency 
    |
    */
    'currency' => 'NGN',

    /*
    |--------------------------------------------------------------------------
    | Currency Codes
    |--------------------------------------------------------------------------
    |
    | Here you can specify the coupon genrator currency codes 
    |
    */
    'currency_code' => [
        'NGN' => '&#8358;',
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
    ],
    /*
    |--------------------------------------------------------------------------
    | Error Messages
    |--------------------------------------------------------------------------
    |
    | Here you can specify the coupon genrator error messages 
    |
    */
    'error_msgs' => [
        'not_exist' => 'coupon does not exist',
        'not_valid' => 'coupon is not valid',
        'used' => 'coupon is already used by you',
        'exceeds' => 'coupon discount value is greater than amount',
    ]

];

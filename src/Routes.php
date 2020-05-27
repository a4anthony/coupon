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

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    ['prefix' => 'coupon'],
    function () {
        Route::get('/login', '\A4anthony\Coupon\Http\Controllers\Auth\LoginController@showLoginForm');
        Route::post('/login', '\A4anthony\Coupon\Http\Controllers\Auth\LoginController@login')->name('coupon.login');
        Route::get('coupon-assets', '\A4anthony\Coupon\Http\Controllers\CouponController@assets')->name('coupon.coupon_assets');
    }
);
Route::group(
    ['prefix' => 'coupon', 'middleware' => 'admin:admin'],
    function () {
        Route::post('/logout', '\A4anthony\Coupon\Http\Controllers\Auth\LoginController@logout')->name('coupon.logout');

        Route::get('/dashboard', '\A4anthony\Coupon\Http\Controllers\CouponController@index')->name('coupon.dashboard');
        Route::get('/generate', '\A4anthony\Coupon\Http\Controllers\CouponController@generate')->name('coupon.generate');
        Route::post('/generate', '\A4anthony\Coupon\Http\Controllers\CouponController@store')->name('coupon.store');
        Route::put('/generate', '\A4anthony\Coupon\Http\Controllers\CouponController@update')->name('coupon.update');
        Route::delete('/generate', '\A4anthony\Coupon\Http\Controllers\CouponController@destroy')->name('coupon.delete');
        
    }
);

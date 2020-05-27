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

use A4anthony\Coupon\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * CouponTableSeeder Seeder Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class CouponsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $timezone = setTimeZone();
        if (Coupon::count() == 0) {
            $coupon = new Coupon();
            $coupon->coupon_code = Coupon_generator('mxn');
            $coupon->created_by = 'admin@admin.com';
            $coupon->restricted_to = 'single';
            $coupon->prefix = 'mxn';
            $coupon->no_of_usage_int = null;
            $coupon->no_of_usage_unlimited = true;
            $coupon->discount_percentage = null;
            $coupon->discount_fixed_amount = 5000;
            $coupon->timezone = $timezone;
            $coupon->expiry = Carbon::now()->addDay(20)->addHour(12)->addMinute(23);
            $coupon->save();
           
            $coupon = new Coupon();
            $coupon->coupon_code = Coupon_generator('john');
            $coupon->created_by = 'admin@admin.com';
            $coupon->restricted_to = 'multiple';
            $coupon->prefix = 'john';
            $coupon->no_of_usage_int = 100;
            $coupon->no_of_usage_unlimited = false;
            $coupon->discount_percentage = 10;
            $coupon->discount_fixed_amount = null;
            $coupon->timezone = $timezone;
            $coupon->expiry = Carbon::now()->addDay(192)->addHour(2)->addMinute(2);
            $coupon->save();
       
            $coupon = new Coupon();
            $coupon->coupon_code = Coupon_generator('tony');
            $coupon->created_by = 'admin@admin.com';
            $coupon->restricted_to = 'multiple';
            $coupon->prefix = 'tony';
            $coupon->no_of_usage_int = 100;
            $coupon->no_of_usage_unlimited = false;
            $coupon->discount_percentage = 10;
            $coupon->discount_fixed_amount = null;
            $coupon->timezone = $timezone;
            $coupon->expiry = Carbon::now();
            $coupon->save();
          
            $coupon = new Coupon();
            $coupon->coupon_code = Coupon_generator('mike');
            $coupon->created_by = 'admin@admin.com';
            $coupon->restricted_to = 'single';
            $coupon->prefix = 'mike';
            $coupon->no_of_usage_int = 100;
            $coupon->no_of_usage_unlimited = false;
            $coupon->discount_percentage = 10;
            $coupon->discount_fixed_amount = null;
            $coupon->timezone = $timezone;
            $coupon->expiry = Carbon::now()->addDay(200)->addHour(10)->addMinute(43);
            $coupon->save();
           
            $coupon = new Coupon();
            $coupon->coupon_code = Coupon_generator('sum');
            $coupon->created_by = 'admin@admin.com';
            $coupon->restricted_to = 'single';
            $coupon->prefix = 'sum';
            $coupon->no_of_usage_int = null;
            $coupon->no_of_usage_unlimited = true;
            $coupon->discount_percentage = null;
            $coupon->discount_fixed_amount = 15000;
            $coupon->timezone = $timezone;
            $coupon->expiry = Carbon::now()->addMonth(2)->addHour(9)->addMinute(53);
            $coupon->save();
         
        }
    }
}

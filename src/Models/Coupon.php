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

namespace A4anthony\Coupon\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use A4anthony\Coupon\Models\Usage as ModelUsage;

/**
 * Coupon Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class Coupon extends Model
{
    protected $dates = ['expiry'];
    /**
     * Calculates days left in coupon validity
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function daysLeft()
    {
        $returnArr = [];
        setTimeZone();
        $start = Carbon::now();
        $end = $this->expiry;
        $absolute = false;
        $diffKeyArr = ['Months', 'Days', 'Hours', 'Minutes', 'Seconds'];
        foreach ($diffKeyArr as $key) {
            $diffKey = 'diffIn' . $key;
            $varKey = 'diff' . $key;
            $$varKey = $start->$diffKey($end, $absolute);
            if ($$varKey <= 0) {
                $$varKey = '';
            }
            if (($varKey == 'diffSeconds') && ($$varKey <= 0)) {
                return 'Invalid';
            }
            if (($$varKey != '') && ($key != 'Seconds') && ($key == 'Days')) {
                $returnArr[] =  $$varKey  . ' ' . pluralize($key, $start->$diffKey($end, $absolute));
            }
            if (($$varKey != '') && ($key == 'Minutes')) {
                if ($start->diffInDays($end, $absolute) == 0) {
                    $returnArr[] =  $$varKey  . ' ' . pluralize($key, $start->$diffKey($end, $absolute));
                }
            }
        }
        return implode(' ', $returnArr) . ' ' . ' left';
    }
    /**
     * Calculates times coupon has been been used
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function timesUsed()
    {
        return ModelUsage::where('coupon_code', $this->coupon_code)->count();
    }
    /**
     * Retrieves coupon
     *
     * @param string $coupon_code 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function find(string $coupon_code)
    {
        return $this->where('coupon_code', $coupon_code)->first();
    }
    /**
     * Vlidates coupon
     *
     * @param string $coupon_code 
     * @param string $customer_email 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function validate(string $coupon_code, string $customer_email)
    {
        setTimeZone();
        $this->coupon = $this->find($coupon_code);
        if ($this->coupon == null) {
            throw new Exception(config('coupon.error_msgs.not_exist'));
        }
        $start = Carbon::now();
        $end = $this->coupon->expiry;
        $check = $start->diffInSeconds($end, false);
        if ($check <= 0) {
            throw new Exception(config('coupon.error_msgs.not_valid'));
        }
        $this->couponUsage($coupon_code);
        if ($this->coupon->restricted_to == 'single') {
            $this->checkCustomer($coupon_code, $customer_email);
        }
        return 'coupon is still valid';
    }
    /**
     * Checks coupon usage
     *
     * @param string $coupon_code 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function couponUsage(string $coupon_code): void
    {
        $this->coupon = $this->find($coupon_code);
        $count = ModelUsage::where('coupon_code', $coupon_code)->count();
        if (($this->coupon->no_of_usage_int <= $count) && ($this->coupon->no_of_usage_unlimited == 0)) {
            throw new Exception(config('coupon.error_msgs.not_valid') . 'fgtrewert');
        }
        return;
    }
    /**
     * Check if user has already used coupon
     *
     * @param string $coupon_code 
     * @param string $customer_email 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function checkCustomer(string $coupon_code, string $customer_email)
    {
        if (ModelUsage::where([['coupon_code', $coupon_code], ['email', $customer_email]])->exists()) {
            throw new Exception(config('coupon.error_msgs.used'));
        }
    }
    /**
     * Gets discount from coupon
     *
     * @param string $coupon_code 
     * @param int    $amount 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getDiscount(string $coupon_code, int $amount)
    {
        $this->coupon = $this->find($coupon_code);
        if ($this->coupon->discount_percentage != null) {
            $discount = $amount * $this->coupon->discount_percnetage * 0.01;
        } elseif ($this->coupon->discount_fixed_amount != null) {
            $discount = $amount - $this->coupon->discount_fixed_amount;
        }
        if (($discount > $amount) || ($discount < 0)) {
            throw new Exception(config('coupon.error_msgs.exceeds'));
        }
        return $discount;
    }
    /**
     * Check coupon validity
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function validity()
    {
        $count = ModelUsage::where('coupon_code', $this->coupon_code)->count();
        if (($this->no_of_usage_int <= $count) && ($this->no_of_usage_unlimited == 0)) {
            return 'Invalid';
        }
        return $this->daysLeft();
    }
    /**
     * Updates coupon usage table
     *
     * @param string $coupon_code 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function exist(string $coupon_code)
    {
        if ($this->where('coupon_code', $coupon_code)->exists()) {
            return true;
        } else {
            return false;
        }
    }
}

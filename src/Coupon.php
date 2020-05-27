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

namespace A4anthony\Coupon;

use A4anthony\Coupon\Models\Coupon as ModelCoupon;
use A4anthony\Coupon\Models\Usage as ModelUsage;

/**
 * Coupon Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class Coupon
{
    /**
     * Class Construct
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct()
    {
        $this->coupon = app(ModelCoupon::class);
        $this->usage = app(ModelUsage::class);
    }
    /**
     * Welcome to Coupon
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function hello()
    {
        $text =  'Welcome to Coupon';
        return $text;
    }
    /**
     * Require routes file
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function routes()
    {
        include __DIR__ . '/routes.php';
    }
    /**
     * Checks coupon validity
     *
     * @param string $coupon_code 
     * @param string $customer_email  
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function validate(string $coupon_code, string $customer_email)
    {
        return $this->coupon->validate($coupon_code, $customer_email);
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
        return $this->coupon->getDiscount($coupon_code, $amount);
    }
    /**
     * Updates coupon usage table
     *
     * @param string $coupon_code 
     * @param string $customer_email 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function callback(string $coupon_code, string $customer_email)
    {
        return $this->usage->callback($coupon_code, $customer_email);
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
        return $this->coupon->exist($coupon_code);
    }
    /**
     * Deletes coupon
     *
     * @param string $coupon_code 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function delete(string $coupon_code)
    {
        $this->coupon = $this->coupon->find($coupon_code);
        $this->coupon->delete($coupon_code);
    }
}

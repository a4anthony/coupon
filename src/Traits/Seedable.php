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

namespace A4anthony\Coupon\Traits;

use CouponDummyDatabaseSeeder;

/**
 * Seedable Trait
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
trait Seedable
{
    /**
     * Runs database seeding
     *
     * @param string $class 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function seed($class)
    {
        if (!class_exists($class)) {
            include_once $this->seedersPath . $class . '.php';
        }
        with(new $class())->run();
    }
}

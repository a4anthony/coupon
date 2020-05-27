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

use Illuminate\Database\Seeder;
use A4anthony\Coupon\Traits\Seedable;

/**
 * CouponDummyDatabaseSeeder Seeder Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class CouponDummyDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedersPath = database_path('seeds') . '/';
        $this->seed('AdminsTableSeeder');
        $this->seed('CouponsTableSeeder');
    }
}

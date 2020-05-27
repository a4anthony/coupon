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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Usage Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class Usage extends Model
{
    protected $dates = ['date_used'];
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coupon_code', 'email',
    ];
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
        setTimeZone();
        $date_used = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timestamp;

        $this->create(
            [
                'coupon_code' => $coupon_code,
                'email' => $customer_email,
                'date_used' => $date_used,
            ]
        );
    }
}

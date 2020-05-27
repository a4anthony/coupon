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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateCouponTable Migration Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'coupons',
            function (Blueprint $table) {
                $table->id();
                $table->string('coupon_code')->unique();
                $table->string('created_by');
                $table->string('prefix');
                $table->string('restricted_to')->nullable();
                $table->integer('no_of_usage_int')->nullable();
                $table->boolean('no_of_usage_unlimited')->nullable();
                $table->integer('discount_percentage')->nullable();
                $table->integer('discount_fixed_amount')->nullable();
                $table->string('timezone')->default(NOW());
                $table->timestamp('expiry');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}

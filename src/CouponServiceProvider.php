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

use A4anthony\Coupon\Commands\CreateAdmin;
use A4anthony\Coupon\Commands\Install;
use Illuminate\Support\ServiceProvider;

/**
 * Coupon Service Provider
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class CouponServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'laravel-coupon',
            function () {
                return new Coupon;
            }
        );
        $this->app->singleton(
            'CouponGuard',
            function () {
                return config('auth.defaults.guard', 'web');
            }
        );
        $this->loadHelpers();
        $this->_registerPublishableResources();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    Install::class,
                    CreateAdmin::class
                ]
            );
        }
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'coupon');
    }

    /**
     * Get the services provided by the provider
     * 
     * @return array
     */
    public function provides()
    {
        return ['laravel-Coupon'];
    }
    /**
     * Load helpers file
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            include_once $filename;
        }
    }
    /**
     * Register publishable resources
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    private function _registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__) . '/';

        $publishable = [
            'seeds' => [
                "{$publishablePath}/src/DummyDatabase/seeds/" => database_path('seeds'),
                "{$publishablePath}/src/DummyDatabase/dummy_seeds/" => database_path('seeds'),
            ],
            'config' => [
                "{$publishablePath}/src/config/coupon.php" => config_path('coupon.php'),
            ],
            'middleware' => [
                "{$publishablePath}src/Http/Middleware/CouponAuthenticate.php" => base_path('app/Http/Middleware/CouponAuthenticate.php'),
            ],

        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}

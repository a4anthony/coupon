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

namespace A4anthony\Coupon\Http\Controllers;

use A4anthony\Coupon\Models\Coupon;
use A4anthony\Coupon\Facades\Coupon as FacadeCoupon;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\Flysystem\Util;

/**
 * Coupon Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class CouponController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Coupon Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles all actions related to the coupon generator system 
    | Its generates & updates coupons and it also retrives assets from directories 
    | to be displayed etc
    */

    /**
     * Displays dashboard
     *
     * @param \A4anthony\Coupon\Models\Coupon $coupon 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Coupon $coupon)
    {
        return view('coupon::dashboard', ['coupons' => $coupon->all()]);
    }
    /**
     * Displays coupon generate form
     *
     * @param \A4anthony\Coupon\Models\Coupon $coupon 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function generate(Coupon $coupon)
    {
        if (isset($_GET['code'])) {
            return view(
                'coupon::generate',
                ['coupon' => $coupon->find($_GET['code'])]
            );
        }
        return view('coupon::generate');
    }
    /**
     * Generates & store new coupon
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        $this->validator($request);
        $timezone = setTimeZone();
        $coupon = new Coupon();
        $coupon->coupon_code = $this->generateCoupon($request);
        $coupon->prefix = $request->prefix;
        $coupon->created_by = auth('admin')->user()->email;
        $coupon->restricted_to = $request->restrictions;
        $coupon->no_of_usage_int = $request->usage_amount;
        if ($request->usage_unlimited == 'on') {
            $coupon->no_of_usage_unlimited = true;
        }
        if ($request->discount_type == 'percent') {
            $coupon->discount_percentage = $request->discount;
            $coupon->discount_fixed_amount = null;
        } else {
            $coupon->discount_percentage = null;
            $coupon->discount_fixed_amount = $request->discount;
        }
        $expiryDate = Carbon::createFromFormat('Y-m-d H:iA', $request->expiry)->timestamp;
        $coupon->timezone = $timezone;
        $coupon->expiry = $expiryDate;
        $coupon->save();
        return redirect()->route('coupon.dashboard')->with('success', 'Coupon generated successfully');
    }
    /**
     * Updates coupon details
     *
     * @param \Illuminate\Http\Request        $request 
     * @param \A4anthony\Coupon\Models\Coupon $coupon 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->validator($request);
        $timezone = setTimeZone();
        $coupon = $coupon->where('coupon_code', $request->coupon_code);
        $coupon->update(
            [
                'created_by' => auth('admin')->user()->email,
                'restricted_to' => $request->restrictions,
                'no_of_usage_int' => $request->usage_amount,
                'no_of_usage_unlimited' => false
            ]
        );
        if ($request->usage_unlimited == 'on') {
            $coupon->update(
                [
                    'no_of_usage_unlimited' => true
                ]
            );
        }
        if ($request->discount_type == 'percent') {
            $coupon->update(
                [
                    'discount_percentage' => $request->discount,
                    'discount_fixed_amount' => null
                ]
            );
        } else {
            $coupon->update(
                [
                    'discount_percentage' => null,
                    'discount_fixed_amount' => $request->discount
                ]
            );
        }
        $expiryDate = Carbon::createFromFormat('Y-m-d H:iA', $request->expiry);
        $coupon->update(
            [
                'timezone' => $timezone,
                'expiry' => $expiryDate
            ]
        );
        return redirect()->route('coupon.dashboard')->with('success', 'Coupon updated successfully');;
    }
    /**
     * Deletes coupons
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function destroy(Request $request)
    {
        FacadeCoupon::delete($request->coupon_code);
        return redirect()->route('coupon.dashboard')->with('success', 'Coupon deleted successfully');;
    }
    /**
     * Validate coupon request
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function validator(Request $request)
    {
        request()->validate(
            [
                'prefix' => 'required',
                'restrictions' => 'required',
                'expiry' => 'required'
            ]
        );
        if (($request->usage_amount == null) && ($request->usage_unlimited == null)) {
            request()->validate(
                [
                    'usage' => 'required',
                ]
            );
        }
        if ($request->discount_type == 'percent') {
            request()->validate(
                [
                    'discount' => ['required', 'lte:100', 'gte:0'],
                ]
            );
        }
    }
    /**
     * Extracts assets from directory
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function assets(Request $request)
    {
        try {
            $path = dirname(__DIR__, 3) . '/Resources/assets/' . Util::normalizeRelativePath(urldecode($request->path));
        } catch (\LogicException $e) {
            abort(404);
        }
        //dd($path);
        if (File::exists($path)) {
            $mime = '';
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return $response;
        }
        abort(404);
    }
    /**
     * Coupon Generator
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function generateCoupon(Request $request)
    {
        $coupon = Coupon_generator($request->prefix);
        foreach (range(0, 1000) as $number) {
            if (!FacadeCoupon::exist($coupon)) {
                return $coupon;
            }
        }
    }
}

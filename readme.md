# Coupon Generator for Laravel 


<p align="center">
  <img src="https://github.com/a4anthony/coupon/blob/master/Resources/assets/images/add.png?raw=true" width="300"/>
  <img src="https://github.com/a4anthony/coupon/blob/master/Resources/assets/images/edit.png?raw=true" width="300" /> 
</p>

## Installation Steps
### 1. Require the package
After creating your new Laravel application you can include the coupon package with the following command:
```bash
composer require a4anthony/coupon
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

You will also want to update your website URL inside of the `APP_URL` variable inside the .env file:

```
APP_URL=http://localhost:8000
```
### 3. Install coupon generator
Lastly, we can install the coupon generator. You can do this either with or without dummy data.
The dummy data will include 1 admin account (if no users already exists) and 20 test coupons

To install the coupon generator without dummy simply run

```bash
php artisan coupon:install
```

If you prefer installing it with dummy run

```bash
php artisan coupon:install --with-dummy
```

And we're all good to go!

Start up a local development server with `php artisan serve` And, visit [http://localhost:8000/coupon](http://localhost:8000/coupon).

## Creating an Admin User

If you did go ahead with the dummy data, a user should have been created for you with the following login credentials:

>**email:** `admin@admin.com`   
>**password:** `password`

If you did not install the dummy data and you wish to create a new admin user you can pass the `--create` flag, like so:

```bash
php artisan coupon:admin your@email.com --create
```

And you will be prompted for the user's name and password.
### 4. Register custom guards for the coupon generator
Go to the the config folder and open the auth.php file. In the providers array, include the code below
```php
'admin' => [
'driver' => 'eloquent',
'model' => \A4anthony\Coupon\Models\Admin::class,
]
```

In the same file, in the guards array, include the code below
```php
'admin' => [
'redirectTo' => 'coupon.dashboard',
'driver' => 'session',
'provider' => 'admin',
],
```

### 5. Adjust the RedirectIfAuthenticated class to recognize custom guard
Go to app/Http/Middleware/RedirectIfAuthenticated.php and edit the handle() method to the code below:
```php
    public function handle($request, Closure $next, $guard = null)
{
    if (Auth::guard($guard)->check()) {
        if ($guard == "admin") {
            return redirect()->route('coupon.dashboard');
        }
        return redirect(RouteServiceProvider::HOME);
    }

    return $next($request);
}
```

### 6. Register the custom middleware class
app/Http/Middleware/RedirectIfAuthenticated.php and include the code below in the $routeMiddleware array
```
'admin' => \App\Http\Middleware\CouponAuthenticate::class 
```

## Configuring package
Package can configured in the config/coupon.php file. You can configure timezone, change currency and include currency symbol and also set your error messages.
```php
/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
|
| Here you can specify the coupon genrator timezone 
|
*/

'timezone' => 'Africa/Lagos',

/*
|--------------------------------------------------------------------------
| Currency
|--------------------------------------------------------------------------
|
| Here you can specify the coupon genrator currency 
|
*/
'currency' => 'NGN',

/*
|--------------------------------------------------------------------------
| Currency Codes
|--------------------------------------------------------------------------
|
| Here you can specify the coupon genrator currency codes 
|
*/
'currency_code' => [
    'NGN' => '&#8358;',
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
],
/*
|--------------------------------------------------------------------------
| Error Messages
|--------------------------------------------------------------------------
|
| Here you can specify the coupon genrator error messages 
|
*/
'error_msgs' => [
    'not_exist' => 'coupon does not exist',
    'not_valid' => 'coupon is not valid',
    'used' => 'coupon is already used by you',
    'exceeds' => 'coupon discount value is greater than amount',
]
```
## Usage
Include the package with:
```php
use A4anthony\Coupon\Facades\Coupon;
```
### 1. Validate coupon and get discount value
```php
$customer_email = 'johndoe@gmail.com';
$amount = 50000;
$discount = 0;//set discount default value
$coupon_code = 'ANTHONYQXGA4';
try {
    Coupon::validate($coupon_code, $customer_email);
    $discount = Coupon::getDiscount($coupon_code, $amount);
    echo 'Coupon accepted';
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
```
### 2. Callback on successful payment
```php
Coupon::callback($coupon_code, $customer_email);
```

ENJOY!!!

<p align="center">
  <img src="https://github.com/a4anthony/coupon/blob/master/Resources/assets/images/dashboard.png?raw=true"/> 
</p>

# Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

# License

[MIT](https://choosealicense.com/licenses/mit/)
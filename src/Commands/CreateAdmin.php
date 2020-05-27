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

namespace A4anthony\Coupon\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\InputOption;


/**
 * CreateAdmin Command Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:admin {email} {--create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user instance with access to the coupon generator dashboard';
    /**
     * Get user options
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    protected function getOptions()
    {
        return [
            ['create', null, InputOption::VALUE_NONE, 'Create a user', null],
        ];
    }
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get or create user
        $user = $this->getUser(
            $this->option('create')
        );

        // the user not returned
        if (!$user) {
            exit;
        }
        $user->save();
        $this->info('The user has been created successfully.');
    }
    /**
     * Get command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['email', InputOption::VALUE_REQUIRED, 'The email of the user.', null],
        ];
    }
    /**
     * Get or create user.
     *
     * @param bool $create 
     *
     * @return \App\User
     */
    protected function getUser($create = false)
    {
        $email = $this->argument('email');
        $model = "A4anthony\Coupon\Models\Admin";

        // If we need to create a new user go ahead and create it
        if ($create) {
            $name = $this->ask('Enter the admin name');
            $password = $this->secret('Enter admin password');
            $confirmPassword = $this->secret('Confirm Password');

            // Ask for email if there wasnt set one
            if (!$email) {
                $email = $this->ask('Enter the admin email');
            }

            // Passwords don't match
            if ($password != $confirmPassword) {
                $this->info("Passwords don't match");

                return;
            }

            $this->info('Creating admin account');

            return call_user_func(
                $model . '::create',
                [
                    'name'     => $name,
                    'email'    => $email,
                    'password' => Hash::make($password),
                ]
            );
        }

        return call_user_func($model . '::where', 'email', $email)->firstOrFail();
    }
}

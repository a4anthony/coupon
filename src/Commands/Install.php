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

use A4anthony\Coupon\CouponServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use A4anthony\Coupon\Traits\Seedable;

/**
 * Install Command Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/coupon/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     ""
 */
class Install extends Command
{
    use Seedable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:install {--force} {--with-dummy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Gets user options
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null],
            ['with-dummy', null, InputOption::VALUE_NONE, 'Install with dummy data', null],
        ];
    }
    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" ' . getcwd() . '/composer.phar';
        }
        return 'composer';
    }
    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem 
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Publishing assets, database, and config files');

        // Publish only relevant resources on install
        $tags = ['seeds', 'config', 'middleware'];

        $this->call('vendor:publish', ['--force' => true, '--provider' => CouponServiceProvider::class, '--tag' => $tags]);

        $this->info('Migrating the database tables into your application');

        $this->call('migrate', ['--force' => $this->option('force')]);

        $this->info('Dumping the autoloaded files and reloading all new files');

        $composer = $this->findComposer();

        $process = new Process([$composer . ' dump-autoload']);
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Adding routes to routes/web.php');
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'Coupon::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => 'coupon'], function () {\n    Coupon::routes();\n});\n"
            );
        }

        \Route::group(
            ['prefix' => 'admin', 'middleware' => 'auth:admin'],
            function () {
                \A4anthony\Coupon\Facades\Coupon::routes();
            }
        );

        $this->info('Seeding data into the database');

        if ($this->option('with-dummy')) {
            $this->info('Publishing dummy content');
            $tags = ['dummy_seeds', 'dummy_content', 'dummy_config', 'dummy_migrations'];
            //$this->call('vendor:publish', ['--provider' => VoyagerDummyServiceProvider::class, '--tag' => $tags]);
            $this->info('Migrating dummy tables');
            $this->call('migrate');

            $this->info('Seeding dummy data');
            $this->seed('CouponDummyDatabaseSeeder');
        } else {
            //$this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => ['config', 'voyager_avatar']]);
        }

        $this->info('Successfully installed a4anthony/coupon! Enjoy');
    }
}

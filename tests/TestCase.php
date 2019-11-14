<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Contracts\Console\Kernel;

use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function beLogged(): self
    {
        $this->withHeaders([
            'x-api-id' => env('ARQUIVEI_API_ID'),
            'x-api-key' => env('ARQUIVEI_API_KEY'),
        ]);

        return $this;
    }

    public function beJson(): self
    {
        $this->withHeaders([
            'content-type' => 'application/json',
            'accept' => 'application/json',
        ]);

        return $this;
    }


    public function createApplication()
    {
        return self::initialize();
    }

    private static $configurationApp = null;

    public static function initialize(){

        if(is_null(self::$configurationApp)){
            $app = require __DIR__.'/../bootstrap/app.php';

            $app->loadEnvironmentFrom('.env.testing');


            $app->make(Kernel::class)->bootstrap();

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            self::$configurationApp = $app;
            return $app;
        }

        return self::$configurationApp;
    }

    public function tearDown(): void
    {
        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
        }

        $this->setUpHasRun = false;

        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }

        if (class_exists('\Mockery')) {
            \Mockery::close();
        }

        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];
    }
}

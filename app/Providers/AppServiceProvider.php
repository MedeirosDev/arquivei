<?php

namespace App\Providers;

use App\Models\Settings;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadSettings();
    }

    private function loadSettings(): void
    {
        try {
            $settings = Settings::first();
            $settings = ($settings) ? $settings->toArray() : [];
            foreach ($settings as $key => $value) {
                Config::set("arquivei.{$key}", $value);
            }
        } catch (Exception $exception) { }
    }
}

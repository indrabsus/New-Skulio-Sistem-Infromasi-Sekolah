<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Config::set([
            'data' => Profile::where('npsn',20224125)->firstOrFail(),
            'public' => 'storage/app',
            'token' => 'b04e6a7e1f57392e54563f1f9bd3fa0ee796651c7c7c2e7f8e3a07fe484e0588'
        ]);

    }
}

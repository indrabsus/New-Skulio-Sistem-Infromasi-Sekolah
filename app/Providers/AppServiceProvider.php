<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Profile;
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
        Config::set([
            'data' => Profile::where('npsn',20224125)->firstOrFail(),
            'public' => 'storage/app',
            'token' => 'b04e6a7e1f57392e54563f1f9bd3fa0ee796651c7c7c2e7f8e3a07fe484e0588',
            'menu' => Menu::all(),
            'admin' => 'admin',
            'kurikulum' => 'admin, kurikulum',
            'humas' => 'admin, humas',
            'sarpras' => 'admin, sarpras',
            'mutu' => 'admin, mutu',
            'kesiswaan' => 'admin, kesiswaan',
            'kepsek' => 'admin, kepsek',
            'perpus' => 'admin, perpus',
            'konseling' => 'admin, konseling',
            'kasubag' => 'admin, kepsek, kasubag',
            'guru' => 'admin, kepsek, kurikulum, kesiswaan, humas, sarpras, mutu, perpus, konseling, guru, akl, bdp, rpl, otkp',
            'manajemen' => 'admin, kepsek, kurikulum, kesiswaan, humas, sarpras, mutu, perpus, konseling, akl, otkp, bdp, rpl',
            'kurkes' => 'admin, kurikulum, kesiswaan',
            'piket' => 'admin, piket',
            'student' => 'admin, student',
            'ppdb' => 'admin, ppdb'
        ]);

    }
}

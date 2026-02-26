<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use ConsoleTVs\Charts\Facades\Charts;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Charts', Charts::class);
    }

    public function boot(): void
    {
        //
    }
}
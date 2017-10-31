<?php

namespace CjwDBMD;

use Illuminate\Support\ServiceProvider;

class DatabaseMarkdownProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $view = realpath(__DIR__.'/src/view/vendor/mr-jiawen/database-markdown/index.blade.php');
        $this->publishes([$view => base_path('resources/views/vendor/mr-jiawen/database-markdown/index.blade.php')]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

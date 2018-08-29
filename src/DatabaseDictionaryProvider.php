<?php

namespace Jw\Database\Dictionary;

use Illuminate\Support\ServiceProvider;

class DatabaseDictionaryProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 加载配置文件
        $this->mergeConfigFrom(
            __DIR__.'/config/database_dictionary.php', 'database'
        );

        // 加载路由
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        //  加载视图
        $this->loadViewsFrom(__DIR__.'/views', 'database_dictionary');

        // 加载数据迁移
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

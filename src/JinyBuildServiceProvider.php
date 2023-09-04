<?php

namespace Jiny\Build;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

use Illuminate\Routing\Router;


class JinyBuildServiceProvider extends ServiceProvider
{
    private $package = "jinybuild";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // 설정파일 복사
        $this->publishes([
            __DIR__.'/../config/auth/setting.php' => config_path('jiny/build/setting.php'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/actions/' => resource_path('actions')
        ], 'build-actions');

        // 커멘드 명령
        if ($this->app->runningInConsole()) {
            $this->commands([
                /*
                \Jiny\Auth\Console\Commands\userCreate::class,
                \Jiny\Auth\Console\Commands\userPassword::class,
                \Jiny\Auth\Console\Commands\userAdmin::class,
                \Jiny\Auth\Console\Commands\userSuper::class
                */
            ]);
        }

        // 미들웨어
        /*
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin', IsAdmin::class);
        */

    }

    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {

        });

        // SocialiteManager 랩퍼
        /*
        $this->app->singleton(Factory::class, function ($app) {
            return new SocialiteManager($app);
        });
        */

    }

}

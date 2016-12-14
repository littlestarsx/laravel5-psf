<?php
/**
 * 服务提供者
 */
namespace Psf\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;


class ServiceProvider extends LaravelServiceProvider
{
    /**
     * 延迟加载
     *
     * @var boolean
     */
    protected $defer = true;

    /**
     * 启动服务提供者
     *
     * @return void
     */
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/config.php' => config_path('psf.php'),
            ], 'config');
        }
    }

    /**
     * 注册服务提供者
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'psf'
        );
        $this->app->singleton(['Psf\\Laravel\\Psf' => 'psf'], function(){
            $psf = new Psf();
            if (config('psf.app')) {
                $psf->env('app', config('psf.app'));
            }
            return $psf;
        });
    }

    /**
     * 提供的服务
     *
     * @return array
     */
    public function provides()
    {
        return ['psf', 'Psf\\Laravel\\Psf'];
    }
}
<?php

namespace Albertgpdev\InvisibleCaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class InvisibleCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->bootConfig();
        $this->app['validator']->extend('captcha', function ($attr, $val) {
            return $this->app['captcha']->verifyResponse($val, $this->app['request']->getClientIp());
        });
        $this->loadViewsFrom(__DIR__.'/views', 'albertgpdev-invisiblecaptcha');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('captcha', function ($app) {
            return new InvisibleCaptcha(
                $app['config']['captcha.public_key'],
                $app['config']['captcha.private_key']
            );
        });
        $this->app->afterResolving('blade.compiler', function () {
            $this->addBladeDirective($this->app['blade.compiler']);
        });
    }

    /**
     * Generates the boot Configuration
     *
     * @return void
     */
    protected function bootConfig()
    {
        $path = __DIR__.'/captcha.php';
        $this->mergeConfigFrom($path, 'captcha');
        if (function_exists('config_path')) {
            $this->publishes([$path => config_path('captcha.php')]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['captcha'];
    }

    /**
     * Extends Compiler implements CompilerInterface
     * @param BladeCompiler $blade
     * @return void
     */
    public function addBladeDirective(BladeCompiler $blade)
    {
        $blade->directive('captcha', function ($lang) {
            return "<?php echo app('captcha')->render({$lang}); ?>";
        });
    }
}

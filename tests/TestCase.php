<?php
namespace Albertgpdev\InvisibleCaptcha\Test;

use Albertgpdev\InvisibleCaptcha\InvisibleCaptchaServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return lasselehtinen\MyPackage\MyPackageServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [InvisibleCaptchaServiceProvider::class];
    }
    // /**
    //  * Load package alias
    //  * @param  \Illuminate\Foundation\Application $app
    //  * @return array
    //  */
    // protected function getPackageAliases($app)
    // {
    //     return [
    //         'MyPackage' => MyPackageFacade::class,
    //     ];
    // }
}
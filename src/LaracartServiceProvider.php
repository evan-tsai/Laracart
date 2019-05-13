<?php

namespace EvanTsai\Laracart;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaracartServiceProvider extends ServiceProvider
{
    protected $file;

    /**
     * Register services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->make('EvanTsai\Laracart\Controllers\CartController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->file = $this->app['files'];

        $this->publishPackages();

        if (!$this->app['cache']->store('file')->has('et-lc')) {
            $this->autoReg();
        }
    }

    protected function publishPackages()
    {
        $this->publishes([
            __DIR__ . '/config' => config_path(),
        ], 'configs');

        $this->publishes([
            __DIR__ . '/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/resources/assets' => resource_path('assets/vendor/Laracart'),
        ], 'assets');
    }

    protected function autoReg()
    {
        // Routes

        $routeFile = base_path('routes/web.php');
        $search = 'Laracart';

        if ($this->checkExist($routeFile, $search)) {
            $data = "\n// Laracart\nEvanTsai\Laracart\Routes::get();";
            $this->file->append($routeFile, $data);
        }

        // Mark as added
        $this->app['cache']->store('file')->rememberForever('et-lc', function () {
            return 'added';
        });
    }

    protected function checkExist($file, $search)
    {
        return $this->file->exists($file) && !Str::contains($this->file->get($file), $search);
    }
}

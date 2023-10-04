<?php

namespace Modules\Localidade\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Localidade\Repositories\BairroRepository;
use Modules\Localidade\Repositories\BairroRepositoryEloquent;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\CidadeRepositoryEloquent;
use Modules\Localidade\Repositories\EnderecoRepository;
use Modules\Localidade\Repositories\EnderecoRepositoryEloquent;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Repositories\EstadoRepositoryEloquent;
use Modules\Localidade\Repositories\LocalidadeRepository;
use Modules\Localidade\Repositories\LocalidadeRepositoryEloquent;
use Modules\Localidade\Repositories\LocalidadeViewRepository;
use Modules\Localidade\Repositories\LocalidadeViewRepositoryEloquent;
use Modules\Localidade\Repositories\PaisRepository;
use Modules\Localidade\Repositories\PaisRepositoryEloquent;
use Modules\Localidade\Repositories\TelefoneRepository;
use Modules\Localidade\Repositories\TelefoneRepositoryEloquent;
use Symfony\Component\Finder\Finder;

class LocalidadeServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Localidade\Http\Controllers';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands('\Modules\Localidade\Console');
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        \Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('Modules/Localidade/Http/api.php');
        });
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		$this->app->register(RepositoryServiceProvider::class);
    }

      /**
     * Register commands
     *
     * @param string $namespace
     */
    protected function registerCommands($namespace = '')
    {
        $finder = new Finder(); // from Symfony\Component\Finder;
        $finder->files()->name('*Command.php')->in(__DIR__ . '/../Console');

        $classes = [];
        foreach ($finder as $file) {
            $class = $namespace.'\\'.$file->getBasename('.php');
            array_push($classes, $class);
        }

        $this->commands($classes);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('localidade.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'localidade'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/localidade');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/localidade';
        }, \Config::get('view.paths')), [$sourcePath]), 'localidade');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/localidade');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'localidade');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'localidade');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

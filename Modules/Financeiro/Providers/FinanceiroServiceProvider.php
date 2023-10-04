<?php

namespace Modules\Financeiro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Symfony\Component\Finder\Finder;

class FinanceiroServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Modules\Financeiro\Http\Controllers';

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
    	$this->registerCommands('\Modules\Financeiro\Console');
    	$this->mapApiRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
			require base_path('Modules/Financeiro/Http/api.php');
		});
	}
    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('financeiro.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'financeiro'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/financeiro');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/financeiro';
        }, \Config::get('view.paths')), [$sourcePath]), 'financeiro');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/financeiro');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'financeiro');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'financeiro');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        // if (! app()->environment('production')) {
        //     app(Factory::class)->load(__DIR__ . '/../Database/factories');
        // }
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

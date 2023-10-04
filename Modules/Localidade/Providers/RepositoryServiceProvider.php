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
use Modules\Localidade\Repositories\PaisRepository;
use Modules\Localidade\Repositories\PaisRepositoryEloquent;
use Modules\Localidade\Repositories\TelefoneRepository;
use Modules\Localidade\Repositories\TelefoneRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->bind(
			EnderecoRepository::class,
			EnderecoRepositoryEloquent::class
		);
		$this->app->bind(
			PaisRepository::class,
			PaisRepositoryEloquent::class
		);
		$this->app->bind(
			EstadoRepository::class,
			EstadoRepositoryEloquent::class
		);
		$this->app->bind(
			CidadeRepository::class,
			CidadeRepositoryEloquent::class
		);
		$this->app->bind(
			BairroRepository::class,
			BairroRepositoryEloquent::class
		);
		$this->app->bind(
			TelefoneRepository::class,
			TelefoneRepositoryEloquent::class
		);
		$this->app->bind(
			LocalidadeRepository::class,
			LocalidadeRepositoryEloquent::class
		);
    }
}

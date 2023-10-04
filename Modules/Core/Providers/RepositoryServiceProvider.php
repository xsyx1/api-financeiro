<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Repositories\AnexoRepository;
use Modules\Core\Repositories\AnexoRepositoryEloquent;
use Modules\Core\Repositories\ApiAolRepository;
use Modules\Core\Repositories\ApiAolRepositoryEloquent;
use Modules\Core\Repositories\ApiFacilRepository;
use Modules\Core\Repositories\ApiFacilRepositoryEloquent;
use Modules\Core\Repositories\ConfigUploadArquivoRepository;
use Modules\Core\Repositories\ConfigUploadArquivoRepositoryEloquent;
use Modules\Core\Repositories\DashboardRepository;
use Modules\Core\Repositories\DashboardRepositoryEloquent;
use Modules\Core\Repositories\DeviceRepository;
use Modules\Core\Repositories\DeviceRepositoryEloquent;
use Modules\Core\Repositories\DigitalRepository;
use Modules\Core\Repositories\DigitalRepositoryEloquent;
use Modules\Core\Repositories\FilialFacilAcessRepository;
use Modules\Core\Repositories\FilialFacilAcessRepositoryEloquent;
use Modules\Core\Repositories\FilialRepository;
use Modules\Core\Repositories\FilialRepositoryEloquent;
use Modules\Core\Repositories\GatewayPagamentoRepository;
use Modules\Core\Repositories\GatewayPagamentoRepositoryEloquent;
use Modules\Core\Repositories\GrupoRepository;
use Modules\Core\Repositories\GrupoRepositoryEloquent;
use Modules\Core\Repositories\ModulosAtivoRepository;
use Modules\Core\Repositories\ModulosAtivoRepositoryEloquent;
use Modules\Core\Repositories\NewsletterRepository;
use Modules\Core\Repositories\NewsletterRepositoryEloquent;
use Modules\Core\Repositories\NotificacaoRepository;
use Modules\Core\Repositories\NotificacaoRepositoryEloquent;
use Modules\Core\Repositories\PessoaRepository;
use Modules\Core\Repositories\PessoaRepositoryEloquent;
use Modules\Core\Repositories\RotaAcessoRepository;
use Modules\Core\Repositories\RotaAcessoRepositoryEloquent;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Repositories\UserRepositoryEloquent;
use Modules\Localidade\Repositories\OperadoraTelefonicaRepository;
use Modules\Localidade\Repositories\OperadoraTelefonicaRepositoryEloquent;

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
			UserRepository::class,
			UserRepositoryEloquent::class
		);
		$this->app->bind(
			GrupoRepository::class,
			GrupoRepositoryEloquent::class
		);
		$this->app->bind(
			NewsletterRepository::class,
			NewsletterRepositoryEloquent::class
		);
		$this->app->bind(
			PessoaRepository::class,
			PessoaRepositoryEloquent::class
		);
		$this->app->bind(
			FilialRepository::class,
			FilialRepositoryEloquent::class
		);
		$this->app->bind(
			OperadoraTelefonicaRepository::class,
			OperadoraTelefonicaRepositoryEloquent::class
		);
		$this->app->bind(
			ConfigUploadArquivoRepository::class,
			ConfigUploadArquivoRepositoryEloquent::class
		);
		$this->app->bind(
			AnexoRepository::class,
			AnexoRepositoryEloquent::class
		);
		$this->app->bind(
			ModulosAtivoRepository::class,
			ModulosAtivoRepositoryEloquent::class
		);
		$this->app->bind(
			RotaAcessoRepository::class,
			RotaAcessoRepositoryEloquent::class
		);
		$this->app->bind(
			DeviceRepository::class,
			DeviceRepositoryEloquent::class
		);
		$this->app->bind(
			GatewayPagamentoRepository::class,
			GatewayPagamentoRepositoryEloquent::class
		);
		$this->app->bind(
			DashboardRepository::class,
			DashboardRepositoryEloquent::class
		);
		$this->app->bind(
			NotificacaoRepository::class,
			NotificacaoRepositoryEloquent::class
		);
		$this->app->bind(
			DigitalRepository::class,
			DigitalRepositoryEloquent::class
		);
		$this->app->bind(
			ApiFacilRepository::class,
			ApiFacilRepositoryEloquent::class
		);
		$this->app->bind(
			FilialFacilAcessRepository::class,
			FilialFacilAcessRepositoryEloquent::class
		);
		$this->app->bind(
			ApiAolRepository::class,
			ApiAolRepositoryEloquent::class
		);
		
	}
}

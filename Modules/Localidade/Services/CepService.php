<?php

namespace Modules\Localidade\Services;


use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\EnderecoRepository;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Repositories\LocalidadeRepository;
use Modules\Localidade\Transformers\CidadeTransformer;
use Modules\Localidade\Transformers\EstadoTransformer;
use App\Services\CacheService;
use App\Services\UtilService;

class CepService
{

	/**
	 * @var CidadeRepository
	 */
	private $cidadeRepository;
	/**
	 * @var EstadoRepository
	 */
	private $estadoRepository;
	/**
	 * @var LocalidadeRepository
	 */
	private $localidadeRepository;
	/**
	 * @var UtilService
	 */
	private $utilService;
	/**
	 * @var CacheService
	 */
	private $cacheService;
	/**
	 * @var GeoService
	 */
	private $geoService;
	/**
	 * @var EnderecoRepository
	 */
	private $enderecoRepository;

	public function __construct(
		CidadeRepository $cidadeRepository,
		EstadoRepository $estadoRepository,
		EnderecoRepository $enderecoRepository,
		GeoService $geoService,
		UtilService $utilService,
		CacheService $cacheService)
	{

		$this->cidadeRepository = $cidadeRepository;
		$this->estadoRepository = $estadoRepository;
		$this->utilService = $utilService;
		$this->cacheService = $cacheService;
		$this->geoService = $geoService;
		$this->enderecoRepository = $enderecoRepository;
	}

	public function requestCep($cep, $defaultValidate = false)
	{
		try {
			/*$localidade = $this->enderecoRepository->pesquisarByCep($cep);
			if(!is_null($localidade)){
				return $localidade;
			}*/

			$urlUri = 'https://viacep.com.br/ws/' . $cep . '/json/';
			$string = $this->utilService->curlFunctionProxy($urlUri);

			$json_file = json_decode($string, true);
			$json_file = (is_null($json_file)) ? [] : $json_file;

			if ($defaultValidate && (array_key_exists('erro', $json_file) || empty($json_file))) {
				$urlUri = 'https://viacep.com.br/ws/77020556/json/';
				$string = $this->utilService->curlFunctionProxy($urlUri);

				$json_file = json_decode($string, true);
			} else {
				if (is_null($json_file)) {
					throw new \Exception('CEP Inválido');
				}
				if (array_key_exists('erro', $json_file)) {
					throw new \Exception('CEP Inválido');
				}
			}

			$estado = $this->estadoRepository->skipPresenter(true)->findWhere([
				['uf', 'ilike', $json_file['uf']]
			])->first();
			\DB::beginTransaction();
			$cidade = $this->cidadeRepository->skipPresenter(true)->findWhere([
				['estado_id', '=', $estado->id],
				['nome', 'ilike', $json_file['localidade']]
			])->first();
			if (is_null($cidade)) {
				$cidade = $this->cidadeRepository->skipPresenter(true)->create([
					'nome' => $json_file['localidade'],
					'estado_id' => $estado->id,
					'cod_ibje' => $json_file['ibge'],
					'capital' => false,
				]);
			}
			\DB::commit();
			return ['data' => [
				'cep' => $cep,
				'estado_id' => $estado->id,
				'cidade_id' => $cidade->id,
				'cidade_nome' => $cidade->nome,
				'estado_nome' => $cidade->estado->nome,
				'cidade' => $this->cidadeRepository->skipPresenter(false)->find($cidade->id),
				'logradouro' => empty($json_file['logradouro']) ? null : $json_file['logradouro']
			]];
		} catch (\Exception $e) {
			\DB::rollback();
			return $e->getMessage() . 'linha: ' . $e->getLine();
		}
	}

	public function requestCepByGeoLocation($lat, $lon)
	{
		/*$localidade = $this->localidadeRepository->pesquisarByCep($cep);
		if(!is_null($localidade)){
			return $localidade;
		}*/

		$urlUri = "http://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lon&format=json";
		$string = $this->utilService->curlFunctionProxy($urlUri);
		$json_file = json_decode($string, true);
		if (array_key_exists('error', $json_file)) {
			throw new \Exception('CEP Inválido');
		}

		$estado = $this->estadoRepository->skipPresenter(false)->findWhere([
			['uf', 'ilike', $json_file['address']['state']]
		])->first();

		try {
			\DB::beginTransaction();
			$cidade = $this->cidadeRepository->skipPresenter(false)->findWhere([
				['estado_id', '=', $estado->id],
				['titulo', 'ilike', $json_file['address']['city']]
			])->first();
			if (is_null($cidade)) {
				$cidade = $this->cidadeRepository->skipPresenter(true)->create([
					'titulo' => $json_file['address']['city'],
					'estado_id' => $estado->id,
					'capital' => false,
				]);
			}
			\DB::commit();
			return ['data' => [
				'cep' => null,
				'estado_id' => $estado->id,
				'cidade_id' => $cidade->id,
				'cidade_nome' => $cidade->nome,
				'estado_nome' => $cidade->estado->nome,
				'cidade' => $this->cidadeRepository->skipPresenter(false)->find($cidade->id),
			]];
		} catch (\Exception $e) {
			\DB::rollback();
			return $e->getMessage();
		}


	}

	public function requestIp()
	{
		//$ip = $_SERVER["REMOTE_ADDR"];
		$ip = "181.222.178.20";
		$urlUri = "http://ip-api.com/json/$ip";
		if ($this->cacheService->has($ip)) {
			return $this->cacheService->get($ip);
		}
		$location = json_decode($this->utilService->curlFunctionProxy($urlUri), true);
		$this->cacheService->put($ip, $location, 1440);
		return $location;
	}


}
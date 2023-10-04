<?php

namespace Modules\Localidade\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Localidade\Repositories\BairroRepository;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Repositories\LocalidadeRepository;
use Modules\Localidade\Services\BairroService;
use Modules\Localidade\Services\CepService;
use Modules\Localidade\Services\GeoService;
use App\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

class LocalidadeController extends BaseController
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
	 * @var GeoService
	 */
	private $geoService;
	/**
	 * @var CepService
	 */
	private $cepService;
	/**
	 * @var BairroService
	 */
	private $bairroService;

	public function __construct(
		CidadeRepository $cidadeRepository,
		EstadoRepository $estadoRepository,
		BairroService $bairroService,
		GeoService $geoService,
		CepService $cepService)
	{

		$this->cidadeRepository = $cidadeRepository;
		$this->estadoRepository = $estadoRepository;
		$this->geoService = $geoService;
		$this->cepService = $cepService;
		$this->bairroService = $bairroService;
	}

	/**
	 * @return array
	 */
	public function getValidator($id = null)
	{
		return [];
	}

	public function selectBairros($cidadeId)
	{
		try {
			return $this->bairroService->getDefaultRepository()->orderBy('nome')->findWhere(['cidade_id' => $cidadeId]);
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function selectBairrosByPesquisa($cidadeId, $bairro)
	{
		try {
			return $this->bairroService->pesquisar($cidadeId, $bairro);
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function selectCidades($estadoId)
	{
		try {
			$estados = explode(',', $estadoId);
			return $this->cidadeRepository->orderBy('nome')->findWhereIn('estado_id', $estados);
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function selectCidadesPesquisa($estadoId)
	{
		try {
			$cidade = $this->getRequest()->get('cidade');
			$estados = explode(',', $estadoId);
			return $this->cidadeRepository->scopeQuery(function ($query) use ($cidade) {
				return $query->where('nome', 'ilike', '%'.$cidade.'%')->limit(25);
			})->orderBy('nome')->findWhereIn('estado_id', $estados);
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function selectCidadeByTexto($estadoId, $cidade)
	{
		try {
			return $this->cidadeRepository->scopeQuery(function ($query) use ($cidade) {
				return $query
					->where('cidades.nome', 'ilike', '%' . $cidade . '%');
			})->orderBy('nome')->findWhere(['estado_id' => $estadoId]);
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function selectEstados()
	{
		try {
			/*return $this->estadoRepository->scopeQuery(function ($query){
				return $query
					->join('tb_cidade','tb_estado.id','=','tb_cidade.id_tb_estado')
					->join('tb_bairro','tb_cidade.id','=','tb_bairro.id_tb_cidade')
					->join('tb_endereco','tb_bairro.id','=','tb_endereco.id_tb_bairro')
					->join('tb_rotina_agendamento', 'tb_endereco.id', 'tb_rotina_agendamento.id_tb_endereco')
					->where('tb_rotina_agendamento.ativo_app',true)
					->raw('now() between saude.tb_rotina_agendamento.data_inicio_rotina and saude.tb_rotina_agendamento.data_fim_rotina')
					->select([\DB::raw('DISTINCT public.tb_estado.*')]);
			})->all();*/
			return $this->estadoRepository->orderBy('nome')->all();
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function getSinglePosition($cidade, $endereco, $estado)
	{
		$status = $this->geoService->getSinglePosition($cidade, $endereco, $estado);

		if (!$status) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, 'Local não encontrada');
		} else {
			return $status;
		}
	}

	public function localidadeByCep($cep)
	{
		try {
			return $this->cepService->requestCep($cep);
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function pesquisarCidade($consulta)
	{
		try {
			return $this->cidadeRepository->scopeQuery(function ($query) use ($consulta) {
				return $query
					->where('cidades.nome', 'ilike', '%' . $consulta. '%');
				})->orderBy('nome')->all();			
		} catch (ModelNotFoundException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (RepositoryException $e) {
			return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		} catch (\Exception $e) {
			return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

}

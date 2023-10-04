<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Services\AuthService;
use Modules\Financeiro\Criteria\CentroCustoCriteria;
use Modules\Financeiro\Services\CentroCustoService;
use Modules\Financeiro\Http\Requests\CentroCustoRequest;
use App\Criteria\OrderCriteria;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Prettus\Repository\Exceptions\RepositoryException;

class CentroCustoController extends BaseController implements ICustomController
{

    /**
     * @var  CentroCustoCriteria
     */
    private $centrocustoCriteria;

    /**
     * @var  CentroCustoService
     */
    private $centrocustoService;

    public function __construct(CentroCustoService $centrocustoService, CentroCustoCriteria $centrocustoCriteria)
    {
        parent::__construct($centrocustoService->getDefaultRepository(), $centrocustoCriteria);
        $this->centrocustoCriteria = $centrocustoCriteria;
        $this->centrocustoService = $centrocustoService;
    }

    public function getValidator($id = null)
    {
        return (new CentroCustoRequest());
    }

    public function getFilhos($id)
    {
        return $this->centrocustoService->getFilhos($id);
    }

    public function destroy($id)
    {
        return $this->centrocustoService->destroy($id);
    }
    public function index(Request $request)
    {
        try {
            $paginacao = $request->get('totalitems', self::$paginationCount);
            if ($paginacao > 100) {
                $paginacao = 100;
            }
            return $this->centrocustoService
                ->getDefaultRepository()
                ->resetScope()
                ->scopeQuery(function ($query) {
                    return $query
                        ->where('financeiro.centro_custos.filial_id', AuthService::getFilialId());
                })
                ->pushCriteria(new centrocustoCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate($paginacao);
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
}

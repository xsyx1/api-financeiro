<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Services\AuthService;
use Modules\Financeiro\Criteria\ContaFinanceiroCriteria;
use Modules\Financeiro\Services\ContaFinanceiroService;
use Modules\Financeiro\Http\Requests\ContaFinanceiroRequest;
use App\Criteria\OrderCriteria;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Prettus\Repository\Exceptions\RepositoryException;

class ContaFinanceiroController extends BaseController implements ICustomController
{

    /**
     * @var  ContaFinanceiroCriteria
     */
    private $contafinanceiroCriteria;

    /**
     * @var  ContaFinanceiroService
     */
    private $contafinanceiroService;

    public function __construct(ContaFinanceiroService $contafinanceiroService, ContaFinanceiroCriteria $contafinanceiroCriteria)
    {
        parent::__construct($contafinanceiroService->getDefaultRepository(), $contafinanceiroCriteria);
        $this->contafinanceiroCriteria = $contafinanceiroCriteria;
        $this->contafinanceiroService = $contafinanceiroService;
    }

    public function getValidator($id = null)
    {
        return (new ContaFinanceiroRequest())->rules($id);
    }

    public function store(ContaFinanceiroRequest $request)
    {
        return $this->contafinanceiroService->store($request->getOnlyDataFields());
    }

    public function update(ContaFinanceiroRequest $request, $id)
    {
        return $this->contafinanceiroService->update($request->getOnlyDataFields(), $id);
    }
    public function index(Request $request)
    {
        try {
            $paginacao = $request->get('totalitems');
            if ($paginacao > 100) {
                $paginacao = 100;
            }
            return $this->contafinanceiroService
                ->getDefaultRepository()
                ->resetScope()
                ->scopeQuery(function ($query) {
                    return $query
                        ->where('financeiro.conta_financeiros.filial_id', AuthService::getFilialId());
                })
                ->pushCriteria(new contafinanceiroCriteria($request))
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

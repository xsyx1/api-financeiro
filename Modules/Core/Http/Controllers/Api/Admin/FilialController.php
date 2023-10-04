<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Criteria\FilialCriteria;
use Modules\Core\Services\FilialService;
use Modules\Core\Http\Requests\FilialRequest;
use Modules\Core\Services\AuthService;
use Modules\Core\Services\UserService;
use App\Criteria\OrderCriteria;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Prettus\Repository\Exceptions\RepositoryException;

class FilialController extends BaseController implements ICustomController
{
    private $filialCriteria;
    private $filialService;

    public function __construct(
        FilialService $filialService,
        FilialCriteria $filialCriteria
    ) {
        parent::__construct($filialService->getDefaultRepository(), $filialCriteria);
        $this->filialCriteria = $filialCriteria;
        $this->filialService = $filialService;
    }
    public function index(Request $request)
    {
        $filial = AuthService::getFilial();
        $user = AuthService::getUser();
        try {
            $paginacao = $request->get('totalitems', self::$paginationCount);
            if ($paginacao > 20) {
                $paginacao = 20;
            }
            if ($user->is_admin) {
                return $this->filialService
                    ->getDefaultRepository()
                    ->resetScope()
                    ->pushCriteria(new FilialCriteria($request))
                    ->pushCriteria(new OrderCriteria($request))
                    ->paginate($paginacao);
            }
            if ($user->grupos[0]->id != 5) {
                throw new \Exception('Acesso Restrito ha Representantes!');
            }
            $filialId = $filial->id;
            return $this->filialService
                ->getDefaultRepository()
                ->resetScope()
                ->scopeQuery(function ($query) use ($filialId) {
                    return $query->where('core.filiais.parent_id', $filialId)
                        ->orWhere('core.filiais.id', $filialId)
                        ->select('core.filiais.*');
                })
                ->pushCriteria(new FilialCriteria($request))
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
    public function getValidator()
    {
        return new FilialRequest();
    }

    public function store(FilialRequest $request)
    {
        return $this->filialService->create($request->getOnlyDataFields());
    }

    public function update(FilialRequest $request, $id)
    {
        return $this->filialService->update($request->getOnlyDataFields(), $id);
    }

    public function pesquisar($query)
    {
        return $this->filialService->pesquisar($query);
    }
    public function filiaisSelect()
    {
        try {
            return ['data' => $this->filialService
                ->getDefaultRepository()
                ->resetScope()
                ->scopeQuery(function ($query) {
                    return $query
                        ->leftjoin('core.pessoas', 'core.filiais.pessoa_id', '=', 'core.pessoas.id')
                        ->selectRaw('core.filiais.id, core.pessoas.nome');
                })
                ->skipPresenter(true)
                ->all()];
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

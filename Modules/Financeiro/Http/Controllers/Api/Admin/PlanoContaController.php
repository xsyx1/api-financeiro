<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Services\AuthService;
use Modules\Financeiro\Criteria\PlanoContaCriteria;
use Modules\Financeiro\Services\PlanoContaService;
use Modules\Financeiro\Http\Requests\PlanoContaRequest;
use App\Criteria\OrderCriteria;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Prettus\Repository\Exceptions\RepositoryException;

class PlanoContaController extends BaseController implements ICustomController
{

    /**
     * @var  PlanoContaCriteria
     */
    private $planocontaCriteria;

    /**
     * @var  PlanoContaService
     */
    private $planocontaService;

    public function __construct(PlanoContaService $planocontaService, PlanoContaCriteria $planocontaCriteria)
    {
        parent::__construct($planocontaService->getDefaultRepository(), $planocontaCriteria);
        $this->planocontaCriteria = $planocontaCriteria;
        $this->planocontaService = $planocontaService;
    }

    public function getValidator($id = null)
    {
        return new PlanoContaRequest();
    }

    public function getFilhos($id)
    {
        return $this->planocontaService->getFilhos($id);
    }

    public function destroy($id)
    {
        return $this->planocontaService->destroy($id);
    }

    public function enviarTeste()
    {
        $to = 'diuliano0@gmail.com';
        $subject = 'teste mais';
        \Mail::send('modules.saude.email.agendamento-realizado.teste', [], function ($message) use ($to, $subject) {
            $message->to($to)
                ->subject($subject);
            return $message;
        });
        dd('foi enviado');
    }

    public function index(Request $request)
    {
        try {
            $paginacao = $request->get('totalitems', self::$paginationCount);
            if ($paginacao > 100) {
                $paginacao = 100;
            }
            return $this->planocontaService
                ->getDefaultRepository()
                ->resetScope()
                ->scopeQuery(function ($query) {
                    return $query
                        ->where('financeiro.plano_contas.filial_id', AuthService::getFilialId());
                })
                ->pushCriteria(new PlanoContaCriteria($request))
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

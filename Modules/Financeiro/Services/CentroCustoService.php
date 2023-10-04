<?php

namespace Modules\Financeiro\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Financeiro\Repositories\CentroCustoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class CentroCustoService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  CentroCustoRepository
     */
    private $centrocustoRepository;

    public function __construct(CentroCustoRepository $centrocustoRepository)
    {
        $this->centrocustoRepository = $centrocustoRepository;
    }

    public function getDefaultRepository()
    {
        return $this->centrocustoRepository;
    }

    /**
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getFilhos($id)
    {
        try {
            return $this->getDefaultRepository()->scopeQuery(function ($query) {
                return $query->limit(15);
            });
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

    public function destroy($id)
    {
        try {
            \DB::beginTransaction();
            $planoconta = $this->getDefaultRepository()->skipPresenter(true)->find($id);
            if ($planoconta->filhos->count() > 0)
                throw new \Exception('Centro de custo já possui filhos');
            $planoconta->delete();
            \DB::commit();
            return self::responseSuccess(self::$HTTP_CODE_OK, self::$MSG_REGISTRO_EXCLUIDO);
        } catch (ModelNotFoundException | RepositoryException $e) {
            \DB::rollBack();
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            \DB::rollBack();
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function checkTipoPai($parentId, $tipo)
    {
        $centrocusto = $this->getDefaultRepository()->find($parentId);
        return $centrocusto['data']['tipo'] == $tipo;
    }
}

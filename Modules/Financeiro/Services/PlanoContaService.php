<?php

namespace Modules\Financeiro\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Financeiro\Repositories\PlanoContaRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class PlanoContaService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  PlanoContaRepository
     */
    private $planocontaRepository;

    public function __construct(PlanoContaRepository $planocontaRepository)
    {
        $this->planocontaRepository = $planocontaRepository;
    }

    public function getDefaultRepository()
    {
        return $this->planocontaRepository;
    }

    public function getFilhos($id)
    {
        try {
            return $this->getDefaultRepository()->scopeQuery(function ($query) {
                return $query->limit(15);
            })->findWhere([
                'parent_id' => $id
            ]);
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
            $planoconta = $this->getDefaultRepository()->skipPresenter(true)->find($id);
            if ($planoconta->filhos->count() > 0)
                throw new \Exception('Plano de contas já possui filhos');
            $planoconta->delete();
            return self::responseSuccess(self::$HTTP_CODE_OK, self::$MSG_REGISTRO_EXCLUIDO);
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

    public function checkTipoPai($parentId, $tipo)
    {

        if (is_null($parentId) || empty($parentId))
            return true;
        $planoconta = $this->getDefaultRepository()->find($parentId);
        return $planoconta['data']['tipo'] == $tipo;
    }
}

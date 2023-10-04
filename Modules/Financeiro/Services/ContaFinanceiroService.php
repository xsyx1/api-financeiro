<?php

namespace Modules\Financeiro\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Services\DBService;
use Modules\Financeiro\Repositories\ContaFinanceiroRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class ContaFinanceiroService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  ContaFinanceiroRepository
     */
    private $contafinanceiroRepository;
    /**
     * @var InformacaoBancariaService
     */
    private $informacaoBancariaService;

    public function __construct(
        ContaFinanceiroRepository $contafinanceiroRepository,
        InformacaoBancariaService $informacaoBancariaService
    ) {
        $this->contafinanceiroRepository = $contafinanceiroRepository;
        $this->informacaoBancariaService = $informacaoBancariaService;
    }

    public function getDefaultRepository()
    {
        return $this->contafinanceiroRepository;
    }

    public function store($getOnlyDataFields)
    {
        try {
            DBService::beginTransaction();
            $contaFinanceiro = $this->getDefaultRepository()->skipPresenter(true)->create($getOnlyDataFields);
            $this->save_or_create_informacao_bancaria($getOnlyDataFields, $contaFinanceiro);
            $contaFinanceiro->save();
            DBService::commit();
            return self::transformerData($contaFinanceiro, $this->getDefaultRepository()->presenter());
        } catch (ModelNotFoundException | RepositoryException $e) {
            DBService::rollBack();
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            DBService::rollBack();
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function update($getOnlyDataFields, $id)
    {
        try {
            DBService::beginTransaction();
            $contaFinanceiro = $this->getDefaultRepository()->skipPresenter(true)->update($getOnlyDataFields, $id);
            $this->save_or_create_informacao_bancaria($getOnlyDataFields, $contaFinanceiro);
            DBService::commit();
            return self::transformerData($contaFinanceiro, $this->getDefaultRepository()->presenter());
        } catch (ModelNotFoundException | RepositoryException $e) {
            DBService::rollBack();
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            DBService::rollBack();
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    private function save_or_create_informacao_bancaria($data, &$contaFinanceiro)
    {
        if (!isset($data['informacao_bancaria']) or is_null($data['informacao_bancaria'])) {
            return;
        }
        if (is_null($contaFinanceiro->informacao_bancaria)) {
            $contaFinanceiro->informacao_bancaria()->create($data['informacao_bancaria']);
            return;
        }
        $contaFinanceiro->informacao_bancaria->fill($data['informacao_bancaria'])->save();
    }
}

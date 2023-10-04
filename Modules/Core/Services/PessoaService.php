<?php

/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 09/02/2018
 * Time: 17:01
 */

namespace Modules\Core\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Presenters\PessoaPresenter;
use Modules\Core\Repositories\FilialRepository;
use Modules\Core\Repositories\PessoaRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;

class PessoaService extends BaseService implements IService
{
    use ResponseActions;
    /**
     * @var PessoaRepository
     */
    private $pessoaRepository;

    private $path;
    /**
     * @var FilialRepository
     */
    private $filialRepository;

    public function __construct(
        FilialRepository $filialRepository,
        PessoaRepository $pessoaRepository
    ) {
        $this->pessoaRepository = $pessoaRepository;
        $this->filialRepository = $filialRepository;
    }
    public function getDefaultRepository()
    {
        return $this->pessoaRepository;
    }
    public function cpf_cnpj($string)
    {
        try {
            $cpf_cnpj = remove_ponto_cpf_cnpj($string);
            return $this->pessoaRepository->resetScope()->skipPresenter(true)->findByField('core.pessoas.cpf_cnpj', $cpf_cnpj);
        } catch (ModelNotFoundException | RepositoryException $e) {
            DB::rollBack();
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
    public function pesquisar_cpf_cnpj($string)
    {
        try {
            $pessoa = $this->cpf_cnpj($string)->first();
            if (!isset($pessoa)) {
                return null;
            }
            return self::transformerData($pessoa, PessoaPresenter::class);
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

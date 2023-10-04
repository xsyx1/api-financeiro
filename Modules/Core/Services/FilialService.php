<?php

namespace Modules\Core\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Models\ModulosAtivo;
use Modules\Core\Presenters\FilialPresenter;
use Modules\Core\Repositories\AnexoRepository;
use Modules\Core\Repositories\FilialRepository;
use Modules\Localidade\Services\EnderecoService;
use Modules\Localidade\Services\TelefoneService;
use Modules\Saude\Services\RepresentanteService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Http\Request;
use Modules\Core\Enuns\FilialTipoEnum;
use Modules\Core\Models\User;
use Modules\Financeiro\Enuns\Banco;
use App\Services\GatewayPagarMe;
use Illuminate\Support\Facades\DB;

class FilialService extends BaseService implements IService
{
    use ResponseActions;
    /**
     * @var FilialRepository
     */
    private $filialRepository;
    /**
     * @var Request
     */
    private $request;

    public function __construct(
        FilialRepository $filialRepository,
        Request $request
    ) {
        $this->filialRepository = $filialRepository;
        $this->request = $request;
    }

    public function getDefaultRepository()
    {
        return $this->filialRepository;
    }

    public function getFilial(int $id = null, bool $presenter = false)
    {
        if (is_null($id))
            return $this->getDefaultRepository()->skipPresenter($presenter)->first();

        return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);
    }

    private function getUser()
    {
        return $this->request->user();
    }

    public function pesquisar($string)
    {
        try {
            return $this->getDefaultRepository()->scopeQuery(function ($query) use ($string) {
                return $query
                    ->join('core.pessoas', 'core.pessoas.id', '=', 'core.filiais.pessoa_id')
                    ->where(function ($query) use ($string) {
                        return $query->orWhere('core.pessoas.nome', 'ilike', '%' . $string . '%')
                            ->orWhere('core.pessoas.cpf_cnpj', 'ilike', '%' . $string . '%');
                    })
                    ->select([DB::raw('DISTINCT filiais.*')])
                    ->limit(25);
            })->all();
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

    public function pegarFilialMedbrasil()
    {
        $filialMedbrasil = $this->getDefaultRepository()
            ->skipPresenter(true)
            ->resetScope()
            ->findByField('default', true)
            ->first();

        return $filialMedbrasil;
    }
}

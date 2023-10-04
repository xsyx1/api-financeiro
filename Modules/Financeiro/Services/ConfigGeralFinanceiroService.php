<?php

namespace Modules\Financeiro\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Financeiro\Repositories\ConfigGeralFinanceiroRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class ConfigGeralFinanceiroService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  ConfigGeralFinanceiroRepository
     */
    private $configgeralfinanceiroRepository;

    public function __construct(ConfigGeralFinanceiroRepository $configgeralfinanceiroRepository)
    {
        $this->configgeralfinanceiroRepository = $configgeralfinanceiroRepository;
    }

    public function getDefaultRepository()
    {
        return $this->configgeralfinanceiroRepository;
    }

    public function configuracao()
    {
        try {
            return $this->getDefaultRepository()->firstOrCreate();
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

    public function updateConfiguracao($data)
    {
        try {
            $item = $this->getDefaultRepository()->firstOrCreate();
            return $this->getDefaultRepository()->update($data, $item['data']['id']);
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

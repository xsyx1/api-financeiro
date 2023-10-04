<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Modules\Core\Criteria\FilialCriteria;
use Modules\Core\Http\Requests\FilialRequest;
use Modules\Core\Services\FilialService;
use App\Http\Controllers\BaseController;

class CoreController extends BaseController
{
    private $filialService;

    public function __construct(FilialService $filialService, FilialCriteria $filialCriteria)
    {
        parent::__construct($filialService->getDefaultRepository(), $filialCriteria);
        $this->filialService = $filialService;
    }

    public function getValidator($id = null)
    {
        return [];
    }

    public function filial()
    {
        return $this->filialService->getFilial();
    }
}

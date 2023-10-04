<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria\OrderCriteria;
use App\Interfaces\ICustomController;
use App\Traits\DefaultActions;
use App\Traits\ResponseActions;

abstract class BaseController extends Controller implements ICustomController
{

    use ResponseActions, DefaultActions;

    protected static $paginationCount = 8;

    protected $defaultRepository;
    /**
     * @var
     */
    private $defaultCriteria;

    /**
     * @var string
     */
    private $defaultOrder;

    public function __construct($defaultRepository, $defaultCriteria, $defaultOrder = OrderCriteria::class)
    {
        $this->defaultRepository = $defaultRepository;
        $this->defaultCriteria = $defaultCriteria;
        $this->defaultOrder = $defaultOrder;
    }




    private $pathFile = null;

    /**
     * @return mixed
     */
    public function getDefaultCriteria()
    {
        return $this->defaultCriteria;
    }

    /**
     * @param mixed $defaultCriteria
     */
    public function setDefaultCriteria($defaultCriteria)
    {
        $this->defaultCriteria = $defaultCriteria;
    }

    protected function getUserId()
    {
        $user = app(Request::class)->user();
        if (isset($user->id)) {
            return $user->id;
        }
        return null;
    }

    /*
    * get User
     * */
    protected function getUser()
    {
        return app(Request::class)->user();
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return app(Request::class);
    }

    /**
     * @return null
     */
    protected function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * @param null $pathFile
     */
    protected function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;
    }
}

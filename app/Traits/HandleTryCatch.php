<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;

trait HandleTryCatch
{
    use ResponseActions;
    
    public function handleException(\Exception $e)
    {
        return self::responseError(
            self::$HTTP_CODE_BAD_REQUEST,
            null,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
    }

    public function handleNotFound(ModelNotFoundException | RepositoryException $e)
    {
        return self::responseError(
            self::$HTTP_CODE_NOT_FOUND,
            null,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
    }

    public function handleTryCatch(\Closure $callback, $dbtranstion = false)
    {
        try {
            $dbtranstion??DB::beginTransaction();
            $retorno = $callback();
            $dbtranstion??DB::commit();
            return $retorno;
        } catch (ModelNotFoundException | RepositoryException $e) {
            $dbtranstion??DB::rollBack();
            return $this->handleNotFound($e);
        } catch (\Exception $e) {
            $dbtranstion??DB::rollBack();
            return $this->handleException($e);
        }
    }
}

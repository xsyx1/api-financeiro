<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\User;
use Modules\Core\Presenters\UserPresenter;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent
 * @package namespace Modules\Core\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
		static::scopeQuery(function ($builder) {
			return $builder
				->join('user_filiais' ,'users.id', '=','user_filiais.user_id')
				->whereIn('user_filiais.filial_id', [\Modules\Core\Services\AuthService::getFilialId()])
				->select([DB::raw('DISTINCT users.*')]);
		});
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return UserPresenter::class;
    }

	public function temAcessoRotina(int $userId, $rotina)
	{
		$user = $this->model->find($userId);
		return $user->grupos->every(function ($grupo, $key) use ($rotina){
			if($grupo->permissoes->count() == 0){
				return false;
			}
			return $grupo->permissoes->contains('id_rotina',$rotina);
		});
	}

	public function ativarDesativar(int $id)
	{
		$grupo = $this->model->find($id);
		$grupo->fg_ativo = !$grupo->fg_ativo;
		$grupo->save();
	}
}

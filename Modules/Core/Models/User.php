<?php

namespace Modules\Core\Models;

use Closure;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Modules\Core\Traits\InsertFilialTrait;
use Modules\Esterilizacao\Models\Operador;
use Modules\Esterilizacao\Models\Requerente;
use Modules\Saude\Models\Atendente;
use Modules\Saude\Models\Beneficiario;
use Modules\Saude\Models\PrestadorServico;
use Modules\Saude\Models\Representante;
use OwenIt\Auditing\Contracts\UserResolver;
use App\Notifications\PasswordReset;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use OwenIt\Auditing\Contracts\Auditable as IAuditable;

class User extends Authenticatable implements Transformable
{
	use Notifiable, HasApiTokens, TransformableTrait, InsertFilialTrait;

	protected $fillable = [
		'username',
		'password',
		'email',
		'img',
		'nome',
		'cpf',
		'status',
		'acesso_filhos',
	];

	protected $casts = [
		'status' => 'integer',
	];

	public function findForPassport($username)
	{
		$return = $this->where('username', $username)->first();
		if(is_null($return)){
			return false;
		}

		return $return;
	}

	public  function setPasswordAttribute($value){
		$this->attributes['password'] = bcrypt($value);
	}

	public function filiais(){
		return $this->belongsToMany(Filial::class, 'user_filiais', 'user_id', 'filial_id');
	}
	public function beneficiarios(){
		return $this->hasMany(Beneficiario::class, 'user_id');
	}
	public function prestadores_servico(){
		return $this->hasMany(PrestadorServico::class,  'user_id');
	}

}

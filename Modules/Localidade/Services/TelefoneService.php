<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 30/07/2018
 * Time: 09:54
 */

namespace Modules\Localidade\Services;


use Modules\Core\Models\Pessoa;
use Modules\Localidade\Repositories\TelefoneRepository;
use App\Interfaces\IService;
use App\Services\BaseService;

class TelefoneService extends BaseService implements IService
{

	/**
	 * @var TelefoneRepository
	 */
	private $telefoneRepository;

	public function __construct(
		TelefoneRepository $telefoneRepository
	)
	{
		$this->telefoneRepository = $telefoneRepository;
	}

	public function getDefaultRepository()
	{
		return $this->telefoneRepository;
	}

	public function create($data, $status = true){
		return $this->getDefaultRepository()->skipPresenter($status)->create($data);
	}

	public function update($id, $data, $status = true){
		return $this->getDefaultRepository()->skipPresenter($status)->update($data, $id);
	}

	public static function salvarTelefone($data, &$filial){
		$filial->pessoa->telefones->whereNotIn('id', array_column($data['pessoa']['telefones'], 'id'))->each(function ($item){
			$item->delete();
		});
		array_map(function ($item) use ($filial){
			if(!isset($item['id'])){
				$filial->pessoa->telefones()->create($item);
			}else{
				$telefone = $filial->pessoa->telefones->where('id', $item['id'])->first();
				$telefone->fill($item)->save();
			}
		}, $data['pessoa']['telefones']);
	}

}
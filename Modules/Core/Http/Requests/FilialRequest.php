<?php

namespace Modules\Core\Http\Requests;

use Modules\Core\Rules\CnpjCpfRole;
use Modules\Core\Services\FilialService;
use Modules\Core\Traits\FilableEndereco;
use Modules\Core\Traits\FilablePessoa;
use Modules\Core\Traits\FilableTelefone;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class FilialRequest extends BaseRequest implements ICustomRequest
{
	use FilablePessoa, FilableEndereco, FilableTelefone;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules($id = null)
	{
		$id = $this->getIdentificador('filial');
		$filial = [];
		if($id)
			$filial = app(FilialService::class)->getFilial($id);

		return array_merge([
			'anexo' => 'nullable',
			'valor_repasse' => 'numeric|nullable',
			'cobra_convenio' => 'boolean|nullable',
			'cobra_particular' => 'boolean|nullable',
			'nome_conta' => 'required|string|min:3|max:255|unique:filiais,nome_conta'. (($id) ? ',' . $id : ''),
			'pessoa' => 'array',
			'pessoa.nome' => 'required|string|min:3|max:255',
			'pessoa.razao_social' => 'nullable|required_if:tipo,1|string|min:3|max:255',
			'pessoa.cpf_cnpj' => [
				'required',
				'unique:pessoas,cpf_cnpj' . (($id) ? ',' . $filial['data']['pessoa_id'] : ''),
				'string',
				new CnpjCpfRole()
			],
		],
		self::rulesEnderecoExtended('pessoa.'),
		self::rulesTelefoneExtended('pessoa.'));
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	public function getOnlyFields()
	{
		return array_merge([
			'anexo',
			'nome_conta',
			'valor_acrescimo',
			'modulos_ativos',
			'valor_repasse',
			'cobra_convenio',
			'cobra_particular',
			'cobra_particular',
			'dia_recebimento_cartao',
			'parent_id',
			'informacao_bancaria'
			], self::$pessoaFields, self::injectKeyDependence('pessoa.', self::$enderecoFields), self::injectKeyDependence('pessoa.', self::$telefoneFields));
	}

}

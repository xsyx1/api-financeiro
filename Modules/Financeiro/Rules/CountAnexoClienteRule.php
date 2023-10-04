<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Core\Services\ConfigUploadArquivoService;
use Modules\Financeiro\Services\ClienteService;

class CountAnexoClienteRule implements Rule
{
	/**
	 * @var ClienteService
	 */
	private $service;

	/**
	 * @var ConfigUploadArquivoService
	 */
	private $config;

	/**
	 * @var
	 */
	private $id;

	/**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {

		$this->service = app(ClienteService::class);
		$this->config = app(ConfigUploadArquivoService::class);
		$this->id = $id;
	}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$cliente = $this->service->getDefaultRepository()->skipPresenter(true)->find($this->id);
		$config = $this->config->getConfig();
		return $cliente->anexo->count() < $config->quantidade_maxima_arquivo;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Numero de anexos excedidos;';
    }
}

<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Core\Services\UserService;

class UserFilialRole implements Rule
{
	/**
	 * @var
	 */
	private $nome_conta;

	/**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($nome_conta)
    {
		$this->nome_conta = $nome_conta;
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
		/** @var UserService $userService */
		$userService = app(UserService::class);
		return $userService->checkFilial($value, $this->nome_conta);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Usuario não pertence a essa conta";
    }
}

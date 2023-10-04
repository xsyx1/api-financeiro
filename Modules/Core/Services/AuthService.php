<?php

/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 12/6/2018
 * Time: 1:46 PM
 */

namespace Modules\Core\Services;


use Illuminate\Http\Request;
use Modules\Core\Enuns\PerfilGrupo;
use Modules\Core\Models\Filial;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class AuthService extends BaseService
{
	use ResponseActions;
	/**
	 * @var UserService
	 */
	private $userService;
	/**
	 * @var Request
	 */
	private $request;
	
	private static $staticIV = '5678901234501234';

	function __construct(UserService $userService, Request $request)
	{
		$this->userService = $userService;
		$this->request = $request;
	}

	public function getDefaultRepository()
	{
		return null;
	}

	public function setContextSession($username, $nome_conta)
	{

		/** @var Filial $filial */
		$filial = $this->userService->getFilialByUser($username, $nome_conta);

		//$teste = \Crypt::decrypt($teste);
		return Crypt::encrypt($filial->toArray());
	}

	public static function getFilialId()
	{
		if (!isset(self::getFilialContext()['id'])){
            return [];
        }

		return self::getFilialContext()['id'];
	}

	public static function getFilial()
	{
		return Filial::find(self::getFilialContext()['id']);
	}

	private static function getFilialContext()
	{

		/** @var Request $request */
		$request = self::getRequest();
		return $request->context_user;
	}

	public static function getRequest()
	{
		return app(Request::class);
	}

	public static function isAdmin()
	{
		return self::getUser()->is_admin;
	}

	public static function getUser()
	{
		return self::getRequest()->user();
	}

	public static function getUserId()
	{
		$user = self::getRequest()->user();
		if (isset($user->id)) {
			return $user->id;
		}
		return null;
	}
	public static function getClient()
	{
		return self::getRequest()->user()->token()->client;
	}

	public static function secretDay()
	{
		return Carbon::now()->format('Y-m-d') . env('APP_KEY');
	}

	public static function getEncryptFilial()
	{
		$filialDefault = Filial::where('default', true)->get();
		return md5(Carbon::now()->format('Y-m-d') . $filialDefault[0]->nome_conta . env('APP_KEY'));
	}

	public static function encryptApiFinanceiro()
	{
		return openssl_encrypt(
			self::getEncryptKeyDay(),
			'aes-256-cbc',
			self::getEncryptFilial(),
			0,
			self::$staticIV
		);
	}

	public static function getEncryptKeyDay()
	{
		return openssl_encrypt(
			self::secretDay(),
			'aes-256-cfb',
			self::getEncryptFilial(),
			0,
			self::$staticIV
		);
	}

	public static function decryptApiFinanceiro($Encryption)
	{
		$encryptionDay = openssl_decrypt(
			$Encryption,
			'aes-256-cbc',
			self::getEncryptFilial(),
			0,
			self::$staticIV
		);

		return openssl_decrypt(
			$encryptionDay,
			'aes-256-cfb',
			self::getEncryptFilial(),
			0,
			self::$staticIV
		);
	}

	public static function verifyApiFinanceiro($Encryption): bool
	{
		$decrypt = self::decryptApiFinanceiro($Encryption);
		if ($decrypt != self::secretDay()) {
			return false;
		}
		return true;
	}
}

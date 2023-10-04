<?php

namespace App\Traits;


trait ResponseActions
{

    public static $MSG_REGISTRO_EXCLUIDO = 'Registro excluído com sucesso.';
    public static $MSG_REGISTRO_ALTERADO = 'Registro alterado com sucesso.';
    public static $MSG_REGISTRO_RESTAURADO = 'Registro restaurado com sucesso.';

    public static $HTTP_CODE_OK = [
        'status' => 200,
        'code' => 'HTTP_CODE_OK',
        'description' => 'OK'
    ];

    public static $HTTP_CODE_CREATED = [
        'status' => 201,
        'code' => 'HTTP_CODE_CREATED',
        'description' => 'Registro Criado'
    ];

    public static $HTTP_CODE_MOVED_PERMANENTLY = [
        'status' => 301,
        'code' => 'HTTP_CODE_MOVED_PERMANENTLY',
        'description' => 'Acesso Indisponível no momento'
    ];

    public static $HTTP_CODE_BAD_REQUEST = [
        'status' => 400,
        'code' => 'HTTP_CODE_BAD_REQUEST',
        'description' => 'Requisição não pode ser processada'
    ];

    public static $HTTP_CODE_UNAUTHORIED = [
        'status' => 401,
        'code' => 'HTTP_CODE_UNAUTHORIED',
        'description' => 'Credenciais não Autorizadas'
    ];

    public static $HTTP_CODE_NOT_FOUND = [
        'status' => 404,
        'code' => 'HTTP_CODE_NOT_FOUND',
        'description' => 'Registro não encontrado'
    ];

    protected static function responseSuccess(array $statusCode, string $message = null)
    {

        return  response()->json([
            "success" => [
                "status_code" =>  $statusCode['status'],
                "code" => $statusCode['code'],
                "description" => $message
            ]
        ], $statusCode['status']);
    }

    protected static function responseError(
        array $statusCode,
        string $description = null,
        string $message = null,
        string $arquivo = null,
        string $linha = null
    ) {
        return response()->json([
            "error" => [
                "status_code" =>  $statusCode['status'],
                "code" => $statusCode['code'],
                "description" => $description?? $statusCode['description'],
                "message" => $message,
                'arquivo' => $arquivo,
                'linha' => $linha
            ]
        ], $statusCode['status']);
    }
}

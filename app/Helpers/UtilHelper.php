<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DummyFunction()
    {
    }

    if (!function_exists('mask')) {

        /**
         * say hello
         *
         * @param string $name
         * @return string
         */
        function mask($val, $mask)
        {
            $maskared = '';
            $k = 0;
            for ($i = 0; $i <= strlen($mask) - 1; $i++) {
                if ($mask[$i] == '#') {
                    if (isset($val[$k])) {
                        $maskared .= $val[$k++];
                    }
                } else {
                    if (isset($mask[$i])) {
                        $maskared .= $mask[$i];
                    }
                }
            }
            return $maskared;
        }
    }

    if (!function_exists('check_vencido')) {

        /**
         * say hello
         *
         * @param string $name
         * @return string
         */
        function check_vencido($data_vencimento, $carencia = 0)
        {
            if (!\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data_vencimento)
                ->isPast()) {
                return false;
            }


            $data_vencimento = date_create($data_vencimento)->format('Y-m-d H:i:s');
            $dias_vencidos = \Carbon\Carbon::now()
                ->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data_vencimento));
            if ($dias_vencidos <= $carencia) {
                return false;
            }

            return true;
        }
    }

    if (!function_exists('csv_to_array')) {

        function csv_to_array($filename = '', $delimiter = ',')
        {
            if (!file_exists($filename) || !is_readable($filename)) {
                return false;
            }
            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                }
                fclose($handle);
            }
            return $data;
        }
    }

    if (!function_exists('validar_cnpj')) {

        function validar_cnpj($cnpj)
        {
            $cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj);
            // Valida tamanho
            if (strlen($cnpj) != 14) {
                return false;
            }
            $soma = 0;
            // Valida primeiro dígito verificador
            for ($index = 0, $auxiliar = 5, $soma = 0; $index < 12; $index++) {
                $soma += $cnpj[$index] * $auxiliar;
                $auxiliar = ($auxiliar == 2) ? 9 : $auxiliar - 1;
            }
            $resto = $soma % 11;
            if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
                return false;
            }
            // Valida segundo dígito verificador
            for ($index = 0, $auxiliar = 6, $soma = 0; $index < 13; $index++) {
                $soma += $cnpj[$index] * $auxiliar;
                $auxiliar = ($auxiliar == 2) ? 9 : $auxiliar - 1;
            }
            $resto = $soma % 11;
            return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
        }
    }

    if (!function_exists('sanitize_string')) {
        function sanitizeString($str)
        {
            $str = preg_replace('/[áàãâä]/ui', 'a', $str);
            $str = preg_replace('/[éèêë]/ui', 'e', $str);
            $str = preg_replace('/[íìîï]/ui', 'i', $str);
            $str = preg_replace('/[óòõôö]/ui', 'o', $str);
            $str = preg_replace('/[úùûü]/ui', 'u', $str);
            $str = preg_replace('/[ç]/ui', 'c', $str);
            // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
            $str = preg_replace('/[^a-z0-9]/i', '_', $str);
            $str = preg_replace('/_+/', '-', $str); // ideia do Bacco :)
            return $str;
        }
    }

    if (!function_exists('remove_ponto_cpf_cnpj')) {
        function remove_ponto_cpf_cnpj($str)
        {
            return preg_replace('([\.\-\/])', '', $str);
        }
    }

    if (!function_exists('insert_filial')) {
        function insertFilial($query)
        {
            if (in_array('filial_id', $query->getFillable())) {
                if (is_null($query->filial_id)) {
                    if (
                        !is_null(\Modules\Core\Services\AuthService::getFilialId())
                        && !empty(\Modules\Core\Services\AuthService::getFilialId())
                    ) {
                        $query->filial_id = \Modules\Core\Services\AuthService::getFilialId();
                    }
                }
            }
            return $query;
        }
    }

    if (!function_exists('check_filial')) {
        function checkFilial($query, $filable)
        {
            if (in_array('filial_id', $filable->getFillable())) {
                return $query
                    ->whereIn(
                        $filable->getTable() . '.filial_id',
                        [\Modules\Core\Services\AuthService::getFilialId()]
                    );
            }

            return $query;
        }
    }


    if (!function_exists('array_remove_null')) {
        function array_remove_null($item)
        {
            if (!is_array($item)) {
                return $item;
            }

            return collect($item)
                ->reject(function ($item) {
                    if ($item instanceof \Illuminate\Support\Carbon) {
                        return false;
                    }

                    if (is_numeric($item)) {
                        return is_null($item);
                    }

                    return is_null($item) || (($item == 0) ? false : empty($item));
                })
                ->flatMap(function ($item, $key) {


                    return is_numeric($key)
                        ? [array_remove_null($item)]
                        : [$key => array_remove_null($item)];
                })
                ->toArray();
        }
    }



    if (!function_exists('validar_cpf')) {

        function validar_cpf($cpf)
        {
            // Verifica se um número foi informado
            if (empty($cpf)) {
                return false;
            }

            // Elimina possivel mascara
            $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);;
            $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

            // Verifica se o numero de digitos informados é igual a 11
            if (strlen($cpf) != 11) {
                return false;
            } else if (
                $cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999'
            ) {
                return false;
                // Calcula os digitos verificadores para verificar se o
                // CPF é válido
            } else {
                for ($index = 0, $auxiliar = 10, $soma = 0; $index < 9; $index++, $auxiliar--) {
                    $soma += $cpf[$index] * $auxiliar;
                }
                $resto = $soma % 11;
                if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto)) {
                    return false;
                }
                // Calcula e confere segundo dígito verificador
                for ($index = 0, $auxiliar = 11, $soma = 0; $index < 10; $index++, $auxiliar--) {
                    $soma += $cpf[$index] * $auxiliar;
                }
                $resto = $soma % 11;
                return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
            }
        }
    }

    if (!function_exists('transformer_data')) {
        /**
         * @param $data
         * @param $classPresenter
         */
        function transformer_data($data, $classPresenter)
        {
            return app($classPresenter)->present($data);
        }
    }



    if (!function_exists('milliseconds')) {
        /**
         * @param $data
         * @param $classPresenter
         */
        function milliseconds()
        {
            $mt = explode(' ', microtime());
            return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
        }
    }

    if (!function_exists('get_ip_address')) {

        /**
         * @param $data
         * @param $classTransformer
         */
        function get_ip_address()
        {
            return env('APP_URL');
        }
    }

    if (!function_exists('isset_or_null_response')) {
        /**
         * @param $data
         * @param $classTransformer
         */
        function isset_or_null_response($item, $field)
        {
            return (isset($item[$field]) && !is_null($item[$field])) ? $item[$field] : null;
        }
    }


if (!function_exists('moneyToFloat')) {
    /**
     * Converte reais para float.
     *
     * @param string $str
     * @return string
     */
    function moneyToFloat($value)
    {
        if (!$value) return 0;

        $source = array('.', ',');
        $replace = array('', '.');
        return str_replace($source, $replace, $value);
    }
}


    if (!function_exists('floatToMoney')) {
        /**
         * Transforma float do banco em reais.
         *
         * @param string $str
         * @return string
         */
        function floatToMoney($value)
        {
            return number_format($value, 2, '.');
        }
    }
}

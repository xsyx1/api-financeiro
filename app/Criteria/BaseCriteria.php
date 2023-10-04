<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 *
 * -----------------------------------------------------------------------------------------------------------
 * Class criada para fazer consultas na API passando JSON como filtros
 *------------------------------------------------------------------------------------------------------------
 *
 *
 * Para fazer consultas utilize a estruturas descria abaixo:
 *
 * Ex: url teste: http://localhost:8000/api/v1/front/plano/consulta?consulta=
 *                  {"filtro": {"tabela_preco.estados.uf":"TO","tabela_preco.cidades.titulo":"Palmas"}}
 *
 * Condicional {=}:
 *    Ex:
 *    http://localhost:8000/api/v1/front/plano/consulta?consulta={"filtro":{"tabela_preco.estados.uf":"TO","tabela_preco.cidades.titulo":"Palmas"}}
 *
 * Condicional {Between}:
 *    Ex:
 *    http://localhost:8000/api/v1/front/plano/consulta?consulta={"filtro":{"plano.created_at":"19/01/2017;20/01/2017",}}
 *
 * Condicional {In}:
 *    Ex:
 *    http://localhost:8000/api/v1/front/plano/consulta?consulta={"filtro":{"plano.tipo":"anunciante;imobiliaria;qimob-erp"}}
 *
 * Class BaseCriteria
 * @package App\Criteria
 */
abstract class BaseCriteria implements CriteriaInterface
{

    const FILTRO_NAME = 'filtro';

    const GET_HTTP_CONSULTA = "consulta";

    /**
     * Definir os campos a ser filtrado e a condicional.
     *
     * Exemplo:
     *  [
     *    'estados.uf'        => '=',
     *    'cidades.titulo'    => '=',
     *    'planos.created_at' => 'between'
     *  ]
     * @var array
     */
    protected $filterCriteria = [];

    /**
     * Definir os campos a ser filtrado e a condicional.
     *
     * Exemplo:
     * [
     * [
     * 'elements'=>[
     * 'anuncios.qtde_dormitorio',
     * 'anuncios.qtde_dormitoario_minimo',
     * 'anuncios.qtde_dormitoario_maximo',
     * ],
     * 'condition'=>'in'
     * ]
     * ]
     * @var array
     */
    protected $filterCriteriaOr = null;

    protected $defaultTable = [];

    /**
     * @var Request
     */
    protected $request;

    protected $whereArray;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->whereArray = json_decode($this->request->get(self::GET_HTTP_CONSULTA), true);
        // dd($this->whereArray = json_decode($this->request->get(self::GET_HTTP_CONSULTA), true));
    }

    /**
     * @param $whereArray
     * @return bool
     */
    public function defaultValidate($whereArray)
    {
        if (is_null($whereArray)) {
            return true;
        }

        if (!array_key_exists(self::FILTRO_NAME, $whereArray)) {
            return true;
        }

        return false;
    }

    /**
     * Apply criteria in query repository
     *
     * @param       Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     *
     * url teste: http://localhost:8000/api/v1/front/plano/consulta?filtro={"tabela_preco.estados.uf": "TO", "tabela_preco.cidades.titulo" : "Palmas"}
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $this->defaultTable = array_merge($this->defaultTable, [$model->getTable() . '.*']);
        if ($this->request->get('lixeira')) {
            $model = $model->onlyTrashed();
        }
        if ($this->defaultValidate($this->whereArray)) {
            return $model;
        }
        $model = $model->select($this->defaultTable);
        $this->whereArray[self::FILTRO_NAME] = array_filter((array)$this->whereArray[self::FILTRO_NAME], function ($valor) {
            return $valor !== null;
        });
        $this->builder($model, $this->whereArray[self::FILTRO_NAME], $this->filterCriteria);
        if (!is_null($this->filterCriteriaOr)) {
            $this->builderGroup($model, $this->whereArray[self::FILTRO_NAME], $this->filterCriteriaOr);
        }
        return $model;
    }
    /**
     *
     * @param $model
     * @param array $array
     * @param $fields
     * @return mixed
     * @throws \Exception
     */
    protected function builder(&$model, array $array, $fields)
    {

        foreach ($array as $key => $value) {
            $table = explode('.', $key);
            $contExplode = count($table);
            if (!is_array($table)) {
                continue;
            }

            if ($contExplode < 2 || $contExplode > 3) {
                continue;
            }
            $coluna = last($table);
            unset($table[$contExplode - 1]);
            if (!$this->schemaValidate(implode('.', $table), $coluna)) {
                continue;
            }

            if (!array_key_exists($key, $fields)) {
                continue;
            }
            $this->BuilderConditions($model, $key, $value, $fields[$key]);
        }
    }

    /**
     *
     * @param $model
     * @param array $array
     * @param $fields
     * @return mixed
     * @throws \Exception
     */
    protected function builder2(&$model, array $array, $fields)
    {

        foreach ($array as $key => $value) {
            $table = explode('.', $key);
            $contExplode = count($table);
            if (!is_array($table)) {
                continue;
            }
            if ($contExplode < 2 || $contExplode > 3) {
                continue;
            }
            $coluna = last($table);
            unset($table[$contExplode - 1]);
            if (!$this->schemaValidate(implode('.', $table), $coluna)) {
                continue;
            }

            if (!array_key_exists($key, $fields)) {
                continue;
            }
            $this->BuilderConditions($model, $key, $value, $fields[$key]);
        }
        return $model;
    }

    /**
     *
     * @param $model
     * @param array $array
     * @param $fields
     * @return mixed
     * @throws \Exception
     */
    protected function builderGroup(&$model, array $array, $conditions)
    {
        $model->where(function ($query) use ($array, $conditions) {
            foreach ($conditions as $fields) {
                foreach ($array as $key => $value) {
                    $table = explode('.', $key);
                    if (count($table) != 2) {
                        continue;
                    }

                    if (!$this->schemaValidate($table[0], $table[1])) {
                        continue;
                    }

                    if (!in_array($key, $fields['elements'])) {
                        continue;
                    }
                    $query->where(function ($query) use ($fields, $value) {
                        foreach ($fields['elements'] as $row) {
                            $query->orWhere(function ($query) use ($row, $value, $fields) {
                                $this->BuilderConditions($query, $row, $value, $fields['condition']);
                            });
                        }
                    });
                }
            }
        });
    }

    private function BuilderConditions($query, $row, $value, $condition)
    {
        if (is_null($value) && $condition != '=') {
            return $query;
        }
        switch ($condition) {
            case '=':
                $query->where($row, '=', $value);
                break;
            case 'like':
                $query->where($row, 'like', "%" . $value . "%");
                break;
            case 'ilike':
                $query->where($row, 'ilike', "%" . $value . "%");
                break;
            case '>':
                $query->where($row, '>', $value);
                break;
            case '<':
                $query->where($row, '<', $value);
                break;
            case '>=':
                $query->where($row, '>=', $value);
                break;
            case '<=':
                $query->where($row, '<=', $value);
                break;
            case '<>':
                $query->where($row, '<>', $value);
                break;
            case 'between':
                $data = explode(';', $value);
                if (!preg_match("/null/i", $data[0])) {
                    if (count($data) == 2) {
                        $query->whereBetween(
                            $row,
                            [$data[0], (preg_match("/null/i", $data[1])) ? 5000000000000 : $data[1]]
                        );
                    }
                }
                break;
            case 'in':
                $data = explode(';', $value);
                if (count($data) > 1) {
                    $aux = last($data);
                    if (empty($aux)) {
                        array_pop($data);
                    }

                    $query->where(function ($query) use ($row, $data, $aux) {
                        $query->whereIn($row, $data);
                        if (empty($aux)) {
                            $query->orWhere(function ($query) use ($row, $data) {
                                $query->where($row, '>', last($data));
                            });
                        }
                    });
                } else {
                    $query->where(function ($query) use ($row, $data) {
                        $query->whereIn($row, $data);
                    });
                }
                break;
            default:
                break;
        }
        return $query;
    }


    /**
     * @param $table
     * @param $column
     * @return bool
     */

    protected function schemaValidate($table, $column)
    {
        return Schema::hasColumn($table, $column);
    }

    /**
     * @param $model
     * @param $field
     * @param $order
     */
    protected function builderOrderBy($model, $field, $order)
    {
        return $model->orderBy($field, $order);
    }
}

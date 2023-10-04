<?php


namespace App\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormaPgtoCriteria
 * @package namespace App\Criteria;
 */
class MensagemFinanceiroCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'mensagem_financeiros.user_id'=>'=',
        'mensagem_financeiros.assunto'=>'like'
    ];
}

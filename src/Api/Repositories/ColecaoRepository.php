<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:50
 */

namespace Api\Repositories;

use Api\Entities\Colecao;
use Doctrine\ORM\EntityRepository;

class ColecaoRepository extends EntityRepository
{
    public function save(Colecao $colecao)
    {
        $this->getEntityManager()->persist($colecao);
        $this->getEntityManager()->flush($colecao);
    }
}
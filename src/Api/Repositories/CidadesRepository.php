<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Cidades;
use Doctrine\ORM\EntityRepository;

/**
 * Class CidadesRepository
 * @package Api\Repositories
 */
class CidadesRepository extends EntityRepository
{
    /**
     * @param Cidades $cidades
     */
    public function save(Cidades $cidades)
    {
        $this->_em->persist($cidades);
        $this->_em->flush($cidades);
    }
}
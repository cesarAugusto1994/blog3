<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Grupo;
use Doctrine\ORM\EntityRepository;

/**
 * Class GrupoRepository
 * @package Api\Repositories
 */
class GrupoRepository extends EntityRepository
{
    /**
     * @param Grupo $grupo
     */
    public function save(Grupo $grupo)
    {
        $this->_em->persist($grupo);
        $this->_em->flush($grupo);
    }
}
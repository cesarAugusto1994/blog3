<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 14:30
 */

namespace Api\Repositories;

use Api\Entities\Tipo;
use Doctrine\ORM\EntityRepository;

/**
 * Class TipoRepository
 * @package Api\Repositories
 */
class TipoRepository extends EntityRepository
{
    /**
     * @param Tipo $tipo
     */
    public function save(Tipo $tipo)
    {
        $this->getEntityManager()->persist($tipo);
        $this->getEntityManager()->flush($tipo);
    }
}
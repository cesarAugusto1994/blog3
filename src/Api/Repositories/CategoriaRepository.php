<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:50
 */

namespace Api\Repositories;

use Api\Entities\Categoria;
use Doctrine\ORM\EntityRepository;

/**
 * Class CategoriaRepository
 * @package Api\Repositories
 */
class CategoriaRepository extends EntityRepository
{
    /**
     * @param Categoria $categoria
     */
    public function save(Categoria $categoria)
    {
        $this->getEntityManager()->persist($categoria);
        $this->getEntityManager()->flush($categoria);
    }
}
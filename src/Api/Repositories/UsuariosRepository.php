<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 01/08/16
 * Time: 10:05
 */

namespace Api\Repositories;

use Api\Entities\Usuarios;
use Doctrine\ORM\EntityRepository;

/**
 * Class UsuariosRepository
 * @package Api\Repositories
 */
class UsuariosRepository extends EntityRepository
{
    /**
     * @param Usuarios $usuarios
     */
    public function save(Usuarios $usuarios)
    {
        $this->getEntityManager()->persist($usuarios);
        $this->getEntityManager()->flush($usuarios);
    }
}
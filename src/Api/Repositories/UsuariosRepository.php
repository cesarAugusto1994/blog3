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
use Doctrine\ORM\Internal\Hydration\ArrayHydrator;
use Doctrine\ORM\Query;

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

    /**
     * @param $login
     * @param $email
     */
    public function getUser($login, $email)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('u')
            ->from('Api\Controllers\Usuarios', 'u')
            ->where($qb->expr()->orX(
               $qb->expr()->eq('u.login', ':login'),
               $qb->expr()->eq('u.email', ':email')
            ))->setParameters(['login' => $login, 'email' => $email]);

        $query = $qb->getQuery();
        $result = $query->getResult(Query::HYDRATE_ARRAY);
    }
}
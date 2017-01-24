<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/08/16
 * Time: 14:38
 */

namespace Api\Repositories;

use Api\Entities\Tags;
use Doctrine\ORM\EntityRepository;

/**
 * Class Tags
 * @package Api\Repositories
 */
class TagsRepository extends EntityRepository
{
    /**
     * @param Tags $tags
     */
    public function save(Tags $tags)
    {
        $this->getEntityManager()->persist($tags);
        $this->getEntityManager()->flush($tags);
    }
    
    /**
     * @param string $nome
     * @return array
     */
    public function findByName($nome)
    {
        return $this->createQueryBuilder('t')
            ->where('t.nome LIKE :nome')
            ->setParameter(':nome', $nome)
            ->getQuery()->getResult();
    }
    
    /**
     * @param Tags $tags
     */
    public function remove(Tags $tags)
    {
        $this->getEntityManager()->remove($tags);
        $this->getEntityManager()->flush($tags);
    }

    /**
     * @return array
     */
    public function findByPostsAtivos()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->innerJoin('t.posts', 'p', \Doctrine\ORM\Query\Expr\Join::ON, 't.post_id = p.id')
            ->where('p.ativo = :ativo')
            ->setParameter('ativo', true)
            ->getQuery()->getResult();
    }
    
}
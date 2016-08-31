<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 01/08/16
 * Time: 10:04
 */

namespace Api\Repositories;

use Api\Entities\Posts;
use Doctrine\ORM\EntityRepository;

/**
 * Class PostsRepository
 * @package Api\Repositories
 */
class PostsRepository extends EntityRepository
{
    public function save(Posts $posts)
    {
        $this->getEntityManager()->persist($posts);
        $this->getEntityManager()->flush($posts);
    }

    /**
     * @return array
     */
    public function getMonthHistory()
    {
        return $this->createQueryBuilder('p')
            ->select('p.year, p.month')
            ->where('p.ativo = 1')
            ->groupBy('p.year, p.month')
            ->getQuery()->getResult();
    }
    
    /**
     * @param string $search
     * @return array
     */
    public function search($search)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.titulo LIKE :titulo')
            ->orWhere('p.descricao LIKE :titulo')
            ->andWhere('p.ativo = :ativo')
            ->setParameter(':titulo', '%'.$search.'%')
            ->setParameter(':ativo', true)
            ->orderBy('p.cadastro', 'DESC')
            ->getQuery()->getResult();
    }
    
    /**
     * @return array
     */
    public function getMostRecents()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ativo = :ativo')
            ->setParameter(':ativo', true)
            ->orderBy('p.cadastro', 'DESC')
            ->setMaxResults(5)
            ->getQuery()->getResult();
    }
}
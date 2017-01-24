<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 01/08/16
 * Time: 10:04
 */

namespace Api\Repositories;

use Api\Entities\Posts;
use Api\Entities\Usuarios;
use App\Controllers\PaginationInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class PostsRepository
 * @package Api\Repositories
 */
class PostsRepository extends EntityRepository implements PaginationInterface
{
    /**
     * @param int $offset
     * @param int $max
     * @return array
     */
    public function getAll($offset = 0, $max = 5)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.ativo = :ativo')
            ->setParameter(':ativo', true)
            ->orderBy('p.cadastro', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($max)
            ->getQuery()
            ->useResultCache(true)
            ->setResultCacheLifetime(1000)
            ->getResult();
    }
    
    /**
     * @param Usuarios $autor
     * @param int $offset
     * @param int $max
     * @return array
     */
    public function findByAutor(Usuarios $autor, $offset = 0, $max = 5)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.usuario = :usuario')
            ->setParameter('usuario', $autor)
            ->andWhere('p.ativo = :ativo')
            ->setParameter(':ativo', true)
            ->orderBy('p.cadastro', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($max)
            ->getQuery()->getResult();
    }
    
    /**
     * @param Posts $posts
     */
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
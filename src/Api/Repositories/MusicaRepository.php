<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:38
 */

namespace Api\Repositories;

use Api\Entities\Musica;
use Doctrine\ORM\EntityRepository;

class MusicaRepository extends EntityRepository
{
    /**
     * @param Musica $musica
     */
    public function save(Musica $musica)
    {
        $this->getEntityManager()->persist($musica);
        $this->getEntityManager()->flush($musica);
    }
    
    /**
     * @param string $search
     * @return array
     */
    public function search($search)
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.nome LIKE :search')
            ->orWhere('m.letra LIKE :search')
            ->andWhere('m.ativo = :ativo')
            ->setParameter(':search', '%'.$search.'%')
            ->setParameter(':ativo', true)
            ->getQuery()->getResult();
    }
}
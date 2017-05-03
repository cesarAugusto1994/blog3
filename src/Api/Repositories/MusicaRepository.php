<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:38
 */

namespace Api\Repositories;

use Api\Entities\Categoria;
use Api\Entities\Colecao;
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
     * @param $search
     * @param null $categoria
     * @param null $colecao
     * @param null $tom
     * @return array
     */
    public function search($search, $categoria = null, $colecao = null, $tom = null)
    {
        $query = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.nome LIKE :search')
            ->orWhere('m.letra LIKE :search')
            ->orWhere('m.numero LIKE :search');

        if ($categoria) {
            $query->andWhere('m.categoria = :categoria');
            $query->setParameter('categoria', $categoria);
        }

        if ($colecao) {
            $query->innerJoin(Categoria::class, 'cat', 'WITH', 'cat.id = m.categoria');
            $query->andWhere('cat.colecao = :colecao');
            $query->setParameter('colecao', $colecao);
        }

        if ($tom) {
            $query->andWhere('m.tom = :tom');
            $query->setParameter('tom', $tom);
        }

        $query->andWhere('m.ativo = :ativo')
            ->setParameter(':search', '%'.$search.'%')
            ->setParameter(':ativo', true);

        return $query->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getMusicas()
    {
        $query = $this->createQueryBuilder('m');
        $query->select('m');
        $query->innerJoin(Categoria::class, 'cat', 'WITH', 'cat.id = m.categoria');
        $query->where('m.apenasAnexos = :apenas');
        $query->where('cat.apenasAnexos = :apenas');
        $query->setParameter('apenas', false);
        $query->orderBy('m.numero');
        $query->addOrderBy('cat.nome');

        return $query->getQuery()->getResult();
    }
}
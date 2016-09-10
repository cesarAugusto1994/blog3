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
    public function save(Musica $musica)
    {
        $this->getEntityManager()->persist($musica);
        $this->getEntityManager()->flush($musica);
    }
}
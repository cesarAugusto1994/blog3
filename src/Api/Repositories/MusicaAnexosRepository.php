<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:52
 */

namespace Api\Repositories;

use Api\Entities\MusicaAnexos;
use Doctrine\ORM\EntityRepository;

/**
 * Class MusicaAnexosRepository
 * @package Api\Repositories
 */
class MusicaAnexosRepository extends EntityRepository
{
    /**
     * @param MusicaAnexos $musicaAnexos
     */
    public function save(MusicaAnexos $musicaAnexos)
    {
        $this->getEntityManager()->persist($musicaAnexos);
        $this->getEntityManager()->flush($musicaAnexos);
    }
}
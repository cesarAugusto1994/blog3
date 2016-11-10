<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:50
 */

namespace Api\Repositories;

use Api\Entities\Album;
use Doctrine\ORM\EntityRepository;

/**
 * Class AlbumRepository
 * @package Api\Repositories
 */
class AlbumRepository extends EntityRepository
{
    /**
     * @param Album $album
     */
    public function save(Album $album)
    {
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush($album);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 16/09/16
 * Time: 11:37
 */

namespace Api\Repositories;


use Api\Entities\MusicaTags;
use Doctrine\ORM\EntityRepository;

class MusicaTagsRepository extends EntityRepository
{
    public function save(MusicaTags $musicaTags)
    {
        $this->getEntityManager()->persist($musicaTags);
        $this->getEntityManager()->flush($musicaTags);
    }
}
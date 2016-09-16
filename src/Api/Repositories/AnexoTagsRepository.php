<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 16/09/16
 * Time: 15:35
 */

namespace Api\Repositories;


use Api\Entities\AnexoTags;
use Doctrine\ORM\EntityRepository;

class AnexoTagsRepository extends EntityRepository
{
    public function save(AnexoTags $anexoTags)
    {
        $this->getEntityManager()->persist($anexoTags);
        $this->getEntityManager()->flush($anexoTags);
    }
}
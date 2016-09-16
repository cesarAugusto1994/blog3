<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 16/09/16
 * Time: 11:36
 */

namespace Api\Repositories;


use Api\Entities\Tag;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function save(Tag $tag) 
    {
        $this->getEntityManager()->persist($tag);
        $this->getEntityManager()->flush($tag);
    }
    
    
}
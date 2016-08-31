<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 11:27
 */

namespace App\Repositories;

use App\Entities\Menu;
use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function save(Menu $menu)
    {
        $this->getEntityManager()->persist($menu);
        $this->getEntityManager()->flush($menu);
    }
}
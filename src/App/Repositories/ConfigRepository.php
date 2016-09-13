<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 10:19
 */

namespace App\Repositories;

use App\Entities\Config;
use Doctrine\ORM\EntityRepository;

/**
 * Class ConfigRepository
 * @package App\Repositories
 */
class ConfigRepository extends EntityRepository
{
    /**
     * @param Config $config
     */
    public function save(Config $config)
    {
        $this->getEntityManager()->persist($config);
        $this->getEntityManager()->flush($config);
    }
}
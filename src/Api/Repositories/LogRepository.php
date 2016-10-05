<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/10/16
 * Time: 16:29
 */

namespace Api\Repositories;

use Api\Entities\Log;
use Doctrine\ORM\EntityRepository;

/**
 * Class LogRepository
 * @package Api\Repositories
 */
class LogRepository extends EntityRepository
{
    /**
     * @param Log $log
     */
    public function save(Log $log)
    {
        $this->_em->persist($log);
        $this->_em->flush($log);
    }
}
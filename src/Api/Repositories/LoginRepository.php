<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Login;
use Doctrine\ORM\EntityRepository;

/**
 * Class LoginRepository
 * @package Api\Repositories
 */
class LoginRepository extends EntityRepository
{
    /**
     * @param Login $login
     */
    public function save(Login $login)
    {
        $this->_em->persist($login);
        $this->_em->flush($login);
    }
}
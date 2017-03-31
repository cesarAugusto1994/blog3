<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/07/16
 * Time: 15:23
 */

namespace Api\Repositories;

use Doctrine\ORM\EntityRepository;
use Api\Entities\EmailConfirmacao;

/**
 * Class EmailConfirmacaoRepository
 * @package Api\Repositories
 */
class EmailConfirmacaoRepository extends EntityRepository
{
    /**
     * @param EmailConfirmacao $email
     */
    public function save(EmailConfirmacao $email)
    {
        $this->getEntityManager()->persist($email);
        $this->getEntityManager()->flush($email);
    }
}
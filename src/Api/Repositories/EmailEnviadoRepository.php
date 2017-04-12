<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\EmailEnviado;
use Doctrine\ORM\EntityRepository;

/**
 * Class EmailEnviadoRepository
 * @package Api\Repositories
 */
class EmailEnviadoRepository extends EntityRepository
{
    /**
     * @param EmailEnviado $emailEnviado
     */
    public function save(EmailEnviado $emailEnviado)
    {
        $this->_em->persist($emailEnviado);
        $this->_em->flush($emailEnviado);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:50
 */

namespace Api\Repositories;

use Api\Entities\Notificacao;
use Doctrine\ORM\EntityRepository;

/**
 * Class NotificacaoRepository
 * @package Api\Repositories
 */
class NotificacaoRepository extends EntityRepository
{
    /**
     * @param Notificacao $notificacao
     */
    public function save(Notificacao $notificacao)
    {
        $this->getEntityManager()->persist($notificacao);
        $this->getEntityManager()->flush($notificacao);
    }
}
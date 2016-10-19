<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/10/16
 * Time: 16:29
 */

namespace Api\Repositories;

use Api\Entities\Comentarios;
use Api\Entities\Log;
use Doctrine\ORM\EntityRepository;

/**
 * Class LogRepository
 * @package Api\Repositories
 */
class ComentariosRepository extends EntityRepository
{
    /**
     * @param Comentarios $comentarios
     */
    public function save(Comentarios $comentarios)
    {
        $this->_em->persist($comentarios);
        $this->_em->flush($comentarios);
    }
    
    /**
     * @param Comentarios $comentarios
     */
    public function remove(Comentarios $comentarios)
    {
        $this->getEntityManager()->remove($comentarios);
        $this->getEntityManager()->flush($comentarios);
    }
}
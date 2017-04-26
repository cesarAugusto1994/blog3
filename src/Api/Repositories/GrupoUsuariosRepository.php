<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Grupo;
use Api\Entities\GrupoMusicas;
use Api\Entities\GrupoUsuarios;
use Doctrine\ORM\EntityRepository;

/**
 * Class GrupoUsuariosRepository
 * @package Api\Repositories
 */
class GrupoUsuariosRepository extends EntityRepository
{
    /**
     * @param GrupoUsuarios $grupoUsuarios
     */
    public function save(GrupoUsuarios $grupoUsuarios)
    {
        $this->_em->persist($grupoUsuarios);
        $this->_em->flush($grupoUsuarios);
    }

    /**
     * @param GrupoUsuarios $grupoUsuarios
     */
    public function remove(GrupoUsuarios $grupoUsuarios)
    {
        $this->_em->remove($grupoUsuarios);
        $this->_em->flush($grupoUsuarios);
    }
}
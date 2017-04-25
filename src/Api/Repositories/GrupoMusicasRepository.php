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
use Doctrine\ORM\EntityRepository;

/**
 * Class GrupoMusicasRepository
 * @package Api\Repositories
 */
class GrupoMusicasRepository extends EntityRepository
{
    /**
     * @param GrupoMusicas $grupoMusicas
     */
    public function save(GrupoMusicas $grupoMusicas)
    {
        $this->_em->persist($grupoMusicas);
        $this->_em->flush($grupoMusicas);
    }
}
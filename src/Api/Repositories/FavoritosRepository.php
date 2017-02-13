<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 31/01/17
 * Time: 16:08
 */

namespace Api\Repositories;

use Api\Entities\Favoritos;
use Doctrine\ORM\EntityRepository;

/**
 * Class FavoritosRepository
 * @package Api\Repositories
 */
class FavoritosRepository extends EntityRepository
{
    /**
     * @param Favoritos $favoritos
     */
    public function save(Favoritos $favoritos)
    {
        $this->_em->persist($favoritos);
        $this->_em->flush($favoritos);
    }

    /**
     * @param Favoritos $favoritos
     */
    public function remove(Favoritos $favoritos)
    {
        $this->_em->remove($favoritos);
        $this->_em->flush($favoritos);
    }
}
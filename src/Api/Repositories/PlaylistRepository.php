<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Grupo;
use Api\Entities\Playlist;
use Doctrine\ORM\EntityRepository;

/**
 * Class PlaylistRepository
 * @package Api\Repositories
 */
class PlaylistRepository extends EntityRepository
{
    /**
     * @param Playlist $playlist
     */
    public function save(Playlist $playlist)
    {
        $this->_em->persist($playlist);
        $this->_em->flush($playlist);
    }

    /**
     * @param Playlist $playlist
     */
    public function remove(Playlist $playlist)
    {
        $this->_em->remove($playlist);
        $this->_em->flush($playlist);
    }
}
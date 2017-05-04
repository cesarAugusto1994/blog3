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
use Api\Entities\PlaylistMusicas;
use Doctrine\ORM\EntityRepository;

/**
 * Class PlaylistMusicasRepository
 * @package Api\Repositories
 */
class PlaylistMusicasRepository extends EntityRepository
{
    /**
     * @param PlaylistMusicas $playlistMusicas
     */
    public function save(PlaylistMusicas $playlistMusicas)
    {
        $this->_em->persist($playlistMusicas);
        $this->_em->flush($playlistMusicas);
    }

    /**
     * @param PlaylistMusicas $playlistMusicas
     */
    public function remove(PlaylistMusicas $playlistMusicas)
    {
        $this->_em->remove($playlistMusicas);
        $this->_em->flush($playlistMusicas);
    }
}
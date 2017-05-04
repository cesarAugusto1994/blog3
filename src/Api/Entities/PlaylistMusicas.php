<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 04/05/17
 * Time: 16:16
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Grupo
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\PlaylistMusicasRepository")
 * @ORM\Table(name="playlist_musicas")
 */
class PlaylistMusicas
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Playlist")
     * @ORM\JoinColumn(referencedColumnName="id", name="playlist_id")
     * @var Playlist
     */
    private $playlist;

    /**
     * @ORM\ManyToOne(targetEntity="Musica")
     * @ORM\JoinColumn(referencedColumnName="id", name="musica_id")
     * @var Musica
     */
    private $musica;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\Column(name="cadastro", type="datetime")
     * @var \DateTime
     */
    private $cadastro;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuarios $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * @param Playlist $playlist
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;
    }

    /**
     * @return mixed
     */
    public function getMusica()
    {
        return $this->musica;
    }

    /**
     * @param mixed $musica
     */
    public function setMusica($musica)
    {
        $this->musica = $musica;
    }

    /**
     * @return \DateTime
     */
    public function getCadastro()
    {
        return $this->cadastro;
    }

    /**
     * @param \DateTime $cadastro
     */
    public function setCadastro($cadastro)
    {
        $this->cadastro = $cadastro;
    }
}
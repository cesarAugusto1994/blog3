<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 17:26
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GrupoMusicas
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\GrupoMusicasRepository")
 * @ORM\Table(name="grupo_musicas")
 */
class GrupoMusicas
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Grupo")
     * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
     * @var Musica
     */
    private $grupo;

    /**
     * @ORM\ManyToOne(targetEntity="Musica")
     * @ORM\JoinColumn(name="musica_id", referencedColumnName="id")
     * @var Musica
     */
    private $musica;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Musica
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param Musica $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @return Musica
     */
    public function getMusica()
    {
        return $this->musica;
    }

    /**
     * @param Musica $musica
     */
    public function setMusica($musica)
    {
        $this->musica = $musica;
    }

}
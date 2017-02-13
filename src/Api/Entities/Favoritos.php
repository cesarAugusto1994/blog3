<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 31/01/17
 * Time: 15:29
 */

namespace Api\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Favoritos
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\FavoritosRepository")
 * @ORM\Table(name="favoritos")
 */
class Favoritos implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Musica")
     * @ORM\JoinColumn(referencedColumnName="id", name="musica_id")
     * @var Musica
     */
    private $musica;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(referencedColumnName="id", name="usuario_id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\Column(name="cadastro", type="datetime")
     * @var \DateTime
     */
    private $cadastro;

    /**
     * Musica constructor.
     */
    public function __construct()
    {
        $this->musica = new ArrayCollection();
        $this->usuario = new ArrayCollection();
    }

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

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "musica" => $this->musica,
            "usuario" => $this->usuario,
        ];
    }
}
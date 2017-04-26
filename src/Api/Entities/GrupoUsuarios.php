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
 * Class GrupoUsuarios
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\GrupoUsuariosRepository")
 * @ORM\Table(name="grupo_usuarios")
 */
class GrupoUsuarios
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
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $usuario;

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



}
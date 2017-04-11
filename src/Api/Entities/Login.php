<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 10:00
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Login
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\LoginRepository")
 * @ORM\Table(name="login")
 */
class Login
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\Column(name="data_hora", type="datetime")
     * @var \DateTime
     */
    private $data_hora;

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
     * @return \DateTime
     */
    public function getDataHora()
    {
        return $this->data_hora;
    }

    /**
     * @param \DateTime $data_hora
     */
    public function setDataHora($data_hora)
    {
        $this->data_hora = $data_hora;
    }
}
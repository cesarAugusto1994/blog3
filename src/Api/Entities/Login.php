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
     * @ORM\Column(name="data_login", type="datetime")
     * @var \DateTime
     */
    private $dataLogin;

    /**
     * @ORM\Column(name="data_logout", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $dataLogout;

    /**
     * @ORM\Column(name="sessao", type="string", length=50)
     * @var string
     */
    private $sessao;

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
    public function getDataLogin()
    {
        return $this->dataLogin;
    }

    /**
     * @param \DateTime $dataLogin
     */
    public function setDataLogin($dataLogin)
    {
        $this->dataLogin = $dataLogin;
    }

    /**
     * @return \DateTime
     */
    public function getDataLogout()
    {
        return $this->dataLogout;
    }

    /**
     * @param \DateTime $dataLogout
     */
    public function setDataLogout($dataLogout)
    {
        $this->dataLogout = $dataLogout;
    }

    /**
     * @return string
     */
    public function getSessao()
    {
        return $this->sessao;
    }

    /**
     * @param string $sessao
     */
    public function setSessao($sessao)
    {
        $this->sessao = $sessao;
    }
}
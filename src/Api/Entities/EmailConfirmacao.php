<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 31/03/17
 * Time: 11:19
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EmailConfirmacao
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\EmailConfirmacaoRepository")
 * @ORM\Table(name="email_confirmacao")
 */
class EmailConfirmacao
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
     * @ORM\JoinColumn(referencedColumnName="id", name="usuario_id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\Column(name="token", type="string", length=50)
     * @var string
     */
    private $token;

    /**
     * @ORM\Column(name="gerado_em", type="datetime")
     * @var \DateTime
     */
    private $geradoEm;

    /**
     * @ORM\Column(name="ativo_em", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $ativoEm;

    /**
     * @ORM\Column(name="validade", type="datetime")
     * @var \DateTime
     */
    private $validade;

    /**
     * @ORM\ManyToOne(targetEntity="StatusEmail")
     * @ORM\JoinColumn(referencedColumnName="id", name="status_id")
     * @var StatusEmail
     */
    private $status;

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
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getGeradoEm()
    {
        return $this->geradoEm;
    }

    /**
     * @param \DateTime $geradoEm
     */
    public function setGeradoEm($geradoEm)
    {
        $this->geradoEm = $geradoEm;
    }

    /**
     * @return \DateTime
     */
    public function getAtivoEm()
    {
        return $this->ativoEm;
    }

    /**
     * @param \DateTime $ativoEm
     */
    public function setAtivoEm($ativoEm)
    {
        $this->ativoEm = $ativoEm;
    }

    /**
     * @return mixed
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * @param mixed $validade
     */
    public function setValidade($validade)
    {
        $this->validade = $validade;
    }

    /**
     * @return StatusEmail
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param StatusEmail $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
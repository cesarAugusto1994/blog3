<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/05/17
 * Time: 16:59
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Notificacao
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\NotificacaoRepository")
 * @ORM\Table(name="notificacao")
 * @ORM\Cache(usage="READ_WRITE")
 */
class Notificacao
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
     * @ORM\Column(name="mensagem", type="text")
     * @var string
     */
    private $mensagem;

    /**
     * @ORM\Column(name="visualizada", type="boolean")
     * @var boolean
     */
    private $visualizada;

    /**
     * @ORM\Column(name="data_hora", type="datetime")
     * @var \DateTime
     */
    private $dataHora;

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
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return bool
     */
    public function isVisualizada()
    {
        return $this->visualizada;
    }

    /**
     * @param bool $visualizada
     */
    public function setVisualizada($visualizada)
    {
        $this->visualizada = $visualizada;
    }

    /**
     * @return \DateTime
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * @param \DateTime $dataHora
     */
    public function setDataHora($dataHora)
    {
        $this->dataHora = $dataHora;
    }
}
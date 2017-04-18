<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 12/04/17
 * Time: 11:18
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EmailEnviado
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\EmailEnviadoRepository")
 * @ORM\Table(name="emails_enviados")
 */
class EmailEnviado
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
     * @ORM\Column(name="data_hora", type="datetime")
     * @var \DateTime
     */
    private $data_hora;

    /**
     * @ORM\Column(name="tipo", type="string")
     * @var string
     */
    private $tipo;

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

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
}
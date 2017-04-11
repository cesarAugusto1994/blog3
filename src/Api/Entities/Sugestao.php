<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:30
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Sugestao
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\SugestaoRepository")
 * @ORM\Table(name="sugestao")
 */
class Sugestao
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
     * @ORM\Column(name="mensagem", type="string")
     * @var string
     */
    private $mensagem;

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
}
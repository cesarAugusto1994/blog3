<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 06/10/16
 * Time: 14:48
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comentarios
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\ComentariosRepository")
 * @ORM\Table(name="comentarios")
 */
class Comentarios implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\Column(name="comentario", type="text")
     * @var string
     */
    private $comentario;
    
    /**
     * @ORM\ManyToOne(targetEntity="Musica", inversedBy="Comentarios")
     * @ORM\JoinColumn(name="musica_id", referencedColumnName="id")
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
     * @ORM\Column(name="ativo", type="boolean")
     * @var boolean
     */
    private $ativo;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }
    
    /**
     * @param string $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
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
     * @return boolean
     */
    public function isAtivo()
    {
        return $this->ativo;
    }
    
    /**
     * @param boolean $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "comentario" => $this->comentario,
            "usuario" => $this->usuario,
            "cadastro" => $this->cadastro->format('d/m/Y H:i:s')
        ];
    }
}
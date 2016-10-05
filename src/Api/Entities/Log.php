<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/10/16
 * Time: 16:11
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Log
 * @package App\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\LogRepository")
 * @ORM\Table(name="log")
 */
class Log
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\Column(name="mensagem", type="string")
     * @var string
     */
    private $mensagem;
    
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
}
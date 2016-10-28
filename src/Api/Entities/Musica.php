<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:33
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Musica
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\MusicaRepository")
 * @ORM\Table(name="musica")
 */
class Musica implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(name="numero", type="integer", nullable=true, options={"default:0"})
     * @var string
     */
    private $numero;
    
    /**
     * @ORM\Column(name="nome", type="string")
     * @var string
     */
    private $nome;
    
    /**
     * @ORM\Column(name="tom", type="string")
     * @var string
     */
    private $tom;
    
    /**
     * @ORM\Column(name="letra", type="text", nullable=true)
     * @var string
     */
    private $letra;
    
    /**
     * @ORM\Column(name="letra_original", type="text", nullable=true)
     * @var string
     */
    private $letraOriginal;
    
    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="Musica")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * @var Categoria
     */
    private $categoria;
    
    /**
     * @ORM\OneToMany(targetEntity="MusicaTags", mappedBy="musica")
     * @var MusicaTags
     */
    private $musicaTags;
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity="Comentarios", mappedBy="Musica")
     * @var Comentarios
     */
    private $comentarios;
    
    /**
     * @ORM\Column(name="cadastro", type="datetime")
     * @var \DateTime
     */
    private $cadastro;

    /**
     * @ORM\Column(name="novo", type="boolean")
     * @var boolean
     */
    private $novo;
    
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
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    /**
     * @param int $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
    
    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    
    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    /**
     * @return string
     */
    public function getTom()
    {
        return $this->tom;
    }
    
    /**
     * @param string $tom
     */
    public function setTom($tom)
    {
        $this->tom = $tom;
    }
    
    /**
     * @return string
     */
    public function getLetra()
    {
        return $this->letra;
    }
    
    /**
     * @param string $letra
     */
    public function setLetra($letra)
    {
        $this->letra = $letra;
    }
    
    /**
     * @return string
     */
    public function getLetraOriginal()
    {
        return $this->letraOriginal;
    }
    
    /**
     * @param string $letraOriginal
     */
    public function setLetraOriginal($letraOriginal)
    {
        $this->letraOriginal = $letraOriginal;
    }
    
    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    /**
     * @param Categoria $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getMusicaTag()
    {
        return $this->musicaTags;
    }

    /**
     * @param mixed $musicaTags
     */
    public function setMusicaTag($musicaTags)
    {
        $this->musicaTags = $musicaTags;
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
    public function isNovo()
    {
        return $this->novo;
    }

    /**
     * @param boolean $novo
     */
    public function setNovo($novo)
    {
        $this->novo = $novo;
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

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "ativo" => $this->ativo
        ];
    }
}
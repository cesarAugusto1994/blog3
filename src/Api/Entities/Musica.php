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
class Musica
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(name="numero", type="integer")
     * @var integer
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
     * @ORM\Column(name="letra", type="text")
     * @var string
     */
    private $letra;
    
    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="Musica")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * @var Categoria
     */
    private $categoria;
    
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
}
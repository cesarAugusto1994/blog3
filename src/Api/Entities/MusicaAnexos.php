<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:46
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MusicaAnexos
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\MusicaAnexosRepository")
 * @ORM\Table(name="musica_anexos")
 */
class MusicaAnexos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(name="nome", type="string")
     * @var string
     */
    private $nome;
    
    /**
     * @ORM\ManyToOne(targetEntity="Musica", inversedBy="MusicaAnexos")
     * @ORM\JoinColumn(name="musica_id", referencedColumnName="id")
     * @var Musica
     */
    private $musica;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tipo", inversedBy="MusicaAnexos")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     * @var Tipo
     */
    private $tipo;
    
    /**
     * @ORM\Column(name="link", type="text")
     * @var string
     */
    private $link;
    
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
     * @return Musica
     */
    public function getMusica()
    {
        return $this->musica;
    }
    
    /**
     * @param Musica $musica
     */
    public function setMusica($musica)
    {
        $this->musica = $musica;
    }
    
    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    
    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
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
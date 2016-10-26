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
class MusicaAnexos implements \JsonSerializable
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
     * @ORM\OneToMany(targetEntity="AnexoTags", mappedBy="anexo")
     * @var AnexoTags
     */
    private $anexoTags;
    
    /**
     * @ORM\Column(name="link_externo", type="smallint")
     * @var int
     */
    private $linkExterno;
    
    /**
     * @ORM\Column(name="link", type="text", nullable=true)
     * @var string
     */
    private $link;

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
     * @return AnexoTags
     */
    public function getAnexoTags()
    {
        return $this->anexoTags;
    }
    
    /**
     * @param AnexoTags $anexoTags
     */
    public function setAnexoTags($anexoTags)
    {
        $this->anexoTags = $anexoTags;
    }
    
    /**
     * @return int
     */
    public function isExterno()
    {
        return $this->linkExterno;
    }
    
    /**
     * @param int $linkExterno
     */
    public function setLinkExterno($linkExterno)
    {
        $this->linkExterno = $linkExterno;
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
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    /**
     * @param mixed $usuario
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

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "tipo" => $this->tipo,
            "isExterno" => $this->linkExterno,
            "link" => $this->link,
            "cadastro" => $this->cadastro->format(DATE_RFC822)
        ];
    }
}
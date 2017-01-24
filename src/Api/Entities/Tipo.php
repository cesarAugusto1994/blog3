<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 13:37
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tipo
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="")
 * @ORM\Table(name="tipo_anexo")
 */
class Tipo implements \JsonSerializable
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
     * @ORM\Column(name="imagem", type="string", nullable=true)
     * @var string
     */
    private $imagem;
    
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
     * @return string
     */
    public function getImagem()
    {
        return $this->imagem;
    }
    
    /**
     * @param string $imagem
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
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
            "nome" => $this->nome
        ];
    }
}
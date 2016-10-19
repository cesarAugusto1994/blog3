<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:15
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Colecao
 * @package Api\Entities
 * @ORM\Table(name="colecao")
 * @ORM\Entity(repositoryClass="Api\Repositories\ColecaoRepository")
 * @ORM\Cache(usage="READ_WRITE")
 */
class Colecao
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(name="nome", type="string")
     * @var string
     */
    private $nome;
    
    /**
     * @ORM\Column(name="descricao", type="string")
     * @var string
     */
    private $descricao;
    
    /**
     * @ORM\Column(name="imagem", type="text", nullable=true)
     * @var string
     */
    private $imagem;
    
    /**
     * @ORM\Column(name="ativo", type="smallint")
     * @var int
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
    public function getDescricao()
    {
        return $this->descricao;
    }
    
    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    
    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->imagem;
    }
    
    /**
     * @param mixed $imagem
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }
    
    /**
     * @return int
     */
    public function isAtivo()
    {
        return $this->ativo;
    }
    
    /**
     * @param int $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }
}
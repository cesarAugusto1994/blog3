<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 15:18
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Widgets
 * @package App\Entities
 * @ORM\Entity(repositoryClass="App\Repositories\WidgetsRepository")
 * @ORM\Table(name="widgets")
 */
class Widgets
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\Column(name="nome", type="string")
     * @var string
     */
    private $nome;
    
    /**
     * @ORM\Column(name="decricao", type="string", nullable=true)
     * @var string
     */
    private $decricao;
    
    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     * @var string
     */
    private $url;
    
    /**
     * @ORM\Column(name="imagem", type="string")
     * @var string
     */
    private $imagem;
    
    /**
     * @ORM\Column(name="role", type="string")
     * @var string
     */
    private $role;
    
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
    public function getDecricao()
    {
        return $this->decricao;
    }
    
    /**
     * @param string $decricao
     */
    public function setDecricao($decricao)
    {
        $this->decricao = $decricao;
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
    
    /**
     * @return int
     */
    public function getAtivo()
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
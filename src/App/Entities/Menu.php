<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 11:20
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Menu
 * @package App\Entities
 * @ORM\Entity(repositoryClass="App\Repositories\MenuRepository")
 * @ORM\Table(name="menu")
 */
class Menu implements \JsonSerializable
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
     * @ORM\Column(name="descricao", type="string")
     * @var string
     */
    private $descricao;

    /**
     * @ORM\Column(name="url", type="string")
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(name="icon", type="string")
     * @var string
     */
    private $icon;

    /**
     * @ORM\Column(name="requer_previlegio", type="boolean")
     * @var boolean
     */
    private $previlegioRequerido;

    /**
     * @ORM\Column(name="cadastro", type="datetime")
     * @var \DateTime
     */
    private $cadastro;

    /**
     * @ORM\Column(name="ativo", type="smallint")
     * @var integer
     */
    private $ativo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getCadastro()
    {
        return $this->cadastro;
    }

    /**
     * @param mixed $cadastro
     */
    public function setCadastro($cadastro)
    {
        $this->cadastro = $cadastro;
    }

    /**
     * @return mixed
     */
    public function isAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return boolean
     */
    public function isPrevilegioRequerido()
    {
        return $this->previlegioRequerido;
    }

    /**
     * @param boolean $previlegioRequerido
     */
    public function setPrevilegioRequerido($previlegioRequerido)
    {
        $this->previlegioRequerido = $previlegioRequerido;
    }
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "descricao" => $this->descricao,
            "url" => $this->url,
            "icon" => $this->icon,
        ];
    }
}
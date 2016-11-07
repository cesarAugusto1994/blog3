<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 01/08/16
 * Time: 09:46
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Usuarios
 * @package Api\Entities
 * @ORM\Table(name="usuarios")
 * @ORM\Entity(repositoryClass="Api\Repositories\UsuariosRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Usuarios implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="nome", type="string", length=60, nullable=false)
     * @var string
     */
    private $nome;

    /**
     * @ORM\Column(name="email", type="string", unique=true, length=90, nullable=false)
     * @var string
     */
    private $email;
    
    /**
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(name="avatar", type="string", nullable=true)
     * @var string
     */
    private $avatar;

    /**
     * @ORM\Column(name="roles", type="string", length=60, nullable=false)
     * @var string
     */
    private $roles;
    
    /**
     * @ORM\OneToMany(targetEntity="Posts", mappedBy="Usuario")
     * @var Posts
     */
    private $posts;

    /**
     * @ORM\Column(name="cadastro", type="datetime")
     * @var \DateTime
     */
    private $cadastro;

    /**
     * @ORM\Column(name="ativo", type="smallint", options={"default":0})
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
    
    /**
     * @return Posts
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
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

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "avatar" => $this->avatar
        ];
    }
}
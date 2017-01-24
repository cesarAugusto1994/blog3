<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/08/16
 * Time: 14:33
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tags
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\TagsRepository")
 * @ORM\Table(name="tags")
 */
class Tags
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Posts")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * @var Posts
     */
    private $post;
    
    /**
     * @ORM\Column(name="nome", type="string")
     * @var string
     */
    private $nome;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }
    
    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
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
}
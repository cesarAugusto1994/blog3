<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 01/08/16
 * Time: 11:41
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class LinksPosts
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\LinksRepository")
 * @ORM\Table(name="posts_links")
 */
class LinksPosts
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
     * @ORM\Column(name="titulo", type="string")
     * @var string
     */
    private $titulo;

    /**
     * @ORM\Column(name="url", type="string")
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(name="media", type="string")
     * @var string
     */
    private $media;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Posts
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Posts $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
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
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param string $media
     */
    public function setMedia($media)    
    {
        $this->media = $media;
    }
}
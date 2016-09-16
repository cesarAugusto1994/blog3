<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 16/09/16
 * Time: 11:26
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MusicaTags
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\MusicaTagsRepository")
 * @ORM\Table(name="musica_tags")
 */
class MusicaTags
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Musica")
     * @ORM\JoinColumn(name="musica_id", referencedColumnName="id")
     * @var Musica
     */
    private $musica;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * @var Posts
     */
    private $tag;
    
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
    public function getMusica()
    {
        return $this->musica;
    }
    
    /**
     * @param Posts $musica
     */
    public function setMusica($musica)
    {
        $this->musica = $musica;
    }
    
    /**
     * @return Posts
     */
    public function getTag()
    {
        return $this->tag;
    }
    
    /**
     * @param Posts $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 16/09/16
 * Time: 14:58
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AnexoTags
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\AnexoTagsRepository")
 * @ORM\Table(name="anexo_tags")
 */
class AnexoTags
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="MusicaAnexos")
     * @ORM\JoinColumn(name="anexo_id", referencedColumnName="id")
     * @var MusicaAnexos
     */
    private $anexo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * @var Tag
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
     * @return MusicaAnexos
     */
    public function getAnexo()
    {
        return $this->anexo;
    }
    
    /**
     * @param MusicaAnexos $anexo
     */
    public function setAnexo($anexo)
    {
        $this->anexo = $anexo;
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
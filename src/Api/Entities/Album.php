<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/11/16
 * Time: 09:10
 */

namespace Api\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Album
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\AlbumRepository")
 * @ORM\Table(name="album")
 */
class Album implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(name="label", type="string")
     * @var string
     */
    private $label;
    
    /**
     * @ORM\Column(name="imagem", type="string")
     * @var string
     */
    private $imagem;
    
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
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "label" => $this->label,
            "imagem" => $this->imagem
        ];
    }
}
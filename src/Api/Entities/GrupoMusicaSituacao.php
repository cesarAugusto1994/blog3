<?php

/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/05/17
 * Time: 10:06
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Situacao
 * @package Api\Entities
 * @ORM\Entity()
 * @ORM\Table(name="grupo_musica_situacao")
 */
class GrupoMusicaSituacao
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
}
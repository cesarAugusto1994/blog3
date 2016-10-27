<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 10:17
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Config
 * @package App\Entities
 * @ORM\Entity(repositoryClass="App\Repositories\ConfigRepository")
 * @ORM\Table(name="config")
 */
class Config
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
     * @ORM\Column(name="subtitulo", type="string", nullable=true)
     * @var string
     */
    private $subtitulo;
    
    /**
     * @ORM\Column(name="background", type="string", nullable=true)
     * @var string
     */
    private $background;
    
    /**
     * @ORM\Column(name="envia_email", type="boolean", nullable=true)
     * @var boolean
     */
    private $enviaEmail;
    
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
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }
    
    /**
     * @param string $subtitulo
     */
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;
    }
    
    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }
    
    /**
     * @param string $background
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }
    
    /**
     * @return boolean
     */
    public function isEnviaEmail()
    {
        return $this->enviaEmail;
    }
    
    /**
     * @param boolean $enviaEmail
     */
    public function setEnviaEmail($enviaEmail)
    {
        $this->enviaEmail = $enviaEmail;
    }
}
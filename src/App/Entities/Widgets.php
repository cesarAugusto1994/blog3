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
     * @ORM\Column(name="ativo", type="smallint")
     * @var integer
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
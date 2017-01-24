<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/11/16
 * Time: 09:05
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cantor
 * @package Api\Entities
 * @ORM\Entity()
 * @ORM\Table(name="cantor")
 */
class Cantor implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 31/03/17
 * Time: 11:19
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EmailConfirmacao
 * @package Api\Entities
 * @ORM\Entity()
 * @ORM\Table(name="status_email")
 */
class StatusEmail
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="nome", length=25)
     * @var string
     */
    private $nome;

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
}
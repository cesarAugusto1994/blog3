<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:19
 */

namespace Api\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Categoria
 * @package Api\Entities
 * @ORM\Table(name="categoria", options={"collate":"utf8_general_ci", "charset":"utf8"})
 * @ORM\Entity(repositoryClass="Api\Repositories\CategoriaRepository")
 */
class Categoria implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Colecao")
     * @ORM\JoinColumn(name="colecao_id", referencedColumnName="id")
     * @var Colecao
     */
    private $colecao;

    /**
     * @ORM\Column(name="nome", type="string")
     * @var string
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="Musica", mappedBy="categoria")
     * @var Musica
     */
    private $musicas;

    /**
     * @ORM\Column(name="ativo", type="smallint")
     * @var int
     */
    private $ativo;

    /**
     * Categoria constructor.
     */
    public function __construct()
    {
        $this->musicas = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Colecao
     */
    public function getColecao()
    {
        return $this->colecao;
    }

    /**
     * @param Colecao $colecao
     */
    public function setColecao($colecao)
    {
        $this->colecao = $colecao;
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
    public function isAtivo()
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

    /**
     * @return int
     */
    public function getCountMusicas()
    {
       return count($this->musicas);
    }
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "qtde_musicas" => $this->getCountMusicas(),
            "colecao" => $this->colecao,
            "ativo" => $this->ativo
        ];
    }
}
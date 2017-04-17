<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 17/04/17
 * Time: 13:56
 */

namespace Api\Entities;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class SugestaoResposta
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\SugestaoRespostaRepository")
 * @ORM\Table(name="sugestao_resposta")
 */
class SugestaoResposta implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Sugestao")
     * @ORM\JoinColumn(name="sugestao_id", referencedColumnName="id")
     * @var string
     */
    private $sugestao;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\Column(name="mensagem", type="string")
     * @var string
     */
    private $mensagem;

    /**
     * @ORM\Column(name="enviada_em", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $enviadaEm;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuarios $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return \DateTime
     */
    public function getEnviadaEm()
    {
        return $this->enviadaEm;
    }

    /**
     * @param \DateTime $enviadaEm
     */
    public function setEnviadaEm($enviadaEm)
    {
        $this->enviadaEm = $enviadaEm;
    }

    /**
     * @return string
     */
    public function getSugestao()
    {
        return $this->sugestao;
    }

    /**
     * @param string $sugestao
     */
    public function setSugestao($sugestao)
    {
        $this->sugestao = $sugestao;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "mensagem" => $this->mensagem,
            "usuario" => $this->usuario->getId(),
        ];
    }
}
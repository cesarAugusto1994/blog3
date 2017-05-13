<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 13/05/17
 * Time: 09:10
 */

namespace Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AnexoDownload
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\AnexoDownloadRepository")
 * @ORM\Table(name="anexo_downloads")
 */
class AnexoDownload
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="MusicaAnexos")
     * @ORM\JoinColumn(name="anexo_id", referencedColumnName="id")
     * @var MusicaAnexos
     */
    private $anexo;

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
}
<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/07/16
 * Time: 14:58
 */

namespace Api\Entities;

use Api\Entities\Usuarios;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class EmailConfirmation
 * @package Api\Entities
 * @ORM\Entity(repositoryClass="Api\Repositories\EmailConfirmationRepository")
 * @ORM\Table(name="email_confirmation")
 */
class EmailConfirmacao
{
    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Usuarios
     */
    private $user;

    /**
     * @ORM\Column(name="email", type="string", length=80)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="uuid", type="string", length=50)
     * @var string
     */
    private $uuid;

    /**
     * @ORM\Column(name="created", type="datetime")
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(name="confirmed", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $confirmed;

    /**
     * @ORM\Column(name="status", type="smallint")
     * @var integer
     */
    private $status;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param \DateTime $confirmed
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}

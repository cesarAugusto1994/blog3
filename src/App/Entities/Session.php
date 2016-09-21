<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 21/09/16
 * Time: 11:32
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Session
 * @package App\Entities
 * @ORM\Entity()
 * @ORM\Table(name="session")
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="session_id", type="string")
     * @var string
     */
    private $session;

    /**
     * @ORM\Column(name="session_value", type="text")
     * @var string
     */
    private $value;

    /**
     * @ORM\Column(name="session_lifetime", type="string")
     * @var string
     */
    private $lifetime;

    /**
     * @ORM\Column(name="session_time", type="integer")
     * @var int
     */
    private $time;

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
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param string $lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }
}
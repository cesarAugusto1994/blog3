<?php

/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/07/16
 * Time: 13:08
 */

namespace Api\Services;

use Silex\Application;
use Swift_Message;

/**
 * Class Email
 * @package Api\Services
 */
class Email extends Swift_Message
{
    private $email;
    private $from;
    private $subject;
    private $body;

    /**
     * EmailService constructor.
     * @param null|string $subject
     * @param null|string $from
     * @param null|string $body
     */
    public function __construct($subject, $from, $body)
    {
        parent::__construct($subject);
        $this->subject = $subject;
        $this->from = $from;
        $this->body = $body;
    }

    /**
     * @param string $email
     * @param Application $app
     */
    public function send($email, Application $app)
    {
        $message = $this->newInstance()
            ->setSubject($this->subject)
            ->setFrom($this->from)
            ->setTo($email)
            ->setBody($this->body)
            ->setContentType('text/html');
        
        $app['mailer']->send($message);
    }
}
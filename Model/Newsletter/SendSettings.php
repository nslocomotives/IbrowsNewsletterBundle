<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

use Symfony\Component\Validator\Constraints as Assert;

class SendSettings implements SendSettingsInerface
{
	/**
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $username;
	/**
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $password;
	/**
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $host;
	/**
	 * @Assert\Range(
	 * 		min = "1",
     *  	max = "65535",
     *  	groups={"newsletter"}
     *  )
	 */
	protected $port;
	/**
	 * @Assert\Range(
	 * 		min = "1",
     *  	max = "100",
     *  	groups={"newsletter"}
     *  )
	 */
	protected $interval;
	/**
	 * @Assert\DateTime(groups={"newsletter"})
	 */
	protected $starttime;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
        return $this;
    }

    public function getStarttime()
    {
        return $this->starttime;
    }

    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
        return $this;
    }
}

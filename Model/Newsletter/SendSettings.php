<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

use Symfony\Component\Validator\Constraints as Assert;

class SendSettings implements SendSettingsInterface
{
	/**
     * @var string
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $username;

    /**
     * @var string
     */
    protected $password;

	/**
     * @var string
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $host;

	/**
     * @var int
	 * @Assert\NotNull(groups={"newsletter"})
	 * @Assert\Range(
	 * 		min = "1",
     *  	max = "65535",
     *  	groups={"newsletter"}
     *  )
	 */
	protected $port;

	/**
     * @var int
	 * @Assert\NotNull(groups={"newsletter"})
	 * @Assert\Range(
	 * 		min = "1",
     *  	max = "100",
     *  	groups={"newsletter"}
     *  )
	 */
	protected $interval;

	/**
     * @var \DateTime
	 * @Assert\DateTime(groups={"newsletter"})
	 */
	protected $starttime;

	/**
     * @var string
	 * @Assert\Choice(
	 * 		choices={"ssl","tls"},
	 * 		groups={"newsletter"}
	 * )
	 */
	protected $encryption;

	/**
     * @var string
	 * @Assert\Choice(
	 * 		choices={"plain","login", "cram-md5"},
	 * 		groups={"newsletter"}
	 * )
	 */
	protected $authMode;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this|SendSettingsInterface
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
    		if (is_resource($this->password)) {
    			$handle = $this->password;
    			$content = '';
    			while (!feof($handle)) {
    				$content .= fread($handle, 8192);
    			}
    			$this->password = $content;
    			return $content;
    		}
    		
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this|SendSettingsInterface
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this|SendSettingsInterface
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return $this|SendSettingsInterface
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return $this|SendSettingsInterface
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * @param \DateTime $starttime
     * @return $this|SendSettingsInterface
     */
    public function setStarttime(\DateTime $starttime = null)
    {
        $this->starttime = $starttime;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * @param string $encryption
     * @return SendSettingsInterface
     */
    public function setEncryption($encryption)
    {
        $this->encryption = $encryption;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthMode()
    {
        return $this->authMode;
    }

    /**
     * @param string $authMode
     * @return SendSettingsInterface
     */
    public function setAuthMode($authMode)
    {
        $this->authMode = $authMode;
        return $this;
    }
}

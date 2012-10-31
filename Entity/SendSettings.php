<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\SendSettings as BaseSendSettings;
use Doctrine\ORM\Mapping as ORM;

class SendSettings extends BaseSendSettings
{
	/**
	 * @ORM\Column(type="string")
	 */
	protected $transport;
    
	/**
	 * @ORM\Column(type="string")
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $host;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $port;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $interval;
}

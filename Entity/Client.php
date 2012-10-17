<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ibrows\Bundle\NewsletterBundle\Model\Client as AbstractClient;

class Client extends AbstractClient
{
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
	protected $name;
}

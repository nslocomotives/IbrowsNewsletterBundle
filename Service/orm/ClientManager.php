<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Symfony\Component\Serializer\Exception\UnsupportedException;

use Doctrine\DBAL\DriverManager;
use Ibrows\Bundle\NewsletterBundle\Model\Client;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Ibrows\Bundle\NewsletterBundle\Model\ClientManager as BaseClientManager;

class ClientManager extends BaseClientManager
{
	private $doctrine;
	private $connection;
	private $clientClass;
	private $newsletterClass;
	private $subscriberClass;

	public function __construct(Registry $doctrine, $clientClass, $newsletterClass, $subscriberClass, $connection = null)
	{
		$this->doctrine = $doctrine;
		$this->clientClass = $clientClass;
		$this->newsletterClass = $newsletterClass;
		$this->subscriberClass = $subscriberClass;
		$this->connection = $connection;
	}

	public function get($name = null)
	{
		$name = $this->canonicalizeName($name);
		return new $this->clientClass($this->getManager($name), $name, $this->newsletterClass);
	}
	
	private function getManager($name)
	{
		if ($name === parent::DEFAULT_NAME)
			return $this->doctrine->getManager();
		
		throw new UnsupportedException('Only the default client is supported as of now.');
	}
	
}

<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

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

	public function create($name)
	{
		$name = $this->canonicalizeName($name);
		// get default connection
		$connection = $this->doctrine->getConnection();
		
		$params = $connection->getParams();
		unset($params['dbname']);
		
		$tmpConnection = DriverManager::getConnection($params);
		$name = $tmpConnection->getDatabasePlatform()->quoteSingleIdentifier($name);
		
		$error = false;
		try {
			$tmpConnection->getSchemaManager()->createDatabase($name);
		} catch (\Exception $e) {
			var_dump($e); die();
		}
		
		$tmpConnection->close();
	}
	
	public function get($name = null)
	{
		$name = $this->canonicalizeName($name);
		return new Client($this->getManager($name), $this->newsletterClass);
	}
	
	private function getManager($name)
	{
		return $this->doctrine->getManager();
	}
	
}

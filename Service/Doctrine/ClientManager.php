<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\Doctrine;

use Doctrine\DBAL\DriverManager;
use Ibrows\Bundle\NewsletterBundle\Model\Client;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Ibrows\Bundle\NewsletterBundle\Model\ClientManager as BaseClientManager;

class ClientManager extends BaseClientManager
{
	private $doctrine;
	private $connection;

	public function __construct(Registry $doctrine, $connection = null)
	{
		$this->doctrine = $doctrine;
		$this->connection = $connection;
	}

	public function createClient($name)
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
	
	public function getClient($name = null)
	{
		$name = $this->canonicalizeName($name);
		return new Client($this->doctrine->getEntityManager($name));
	}
	
}

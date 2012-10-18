<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Symfony\Component\Serializer\Exception\UnsupportedException;

use Doctrine\DBAL\DriverManager;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Ibrows\Bundle\NewsletterBundle\Model\MandantManager as BaseMandantManager;

class MandantManager extends BaseMandantManager
{
	private $doctrine;
	private $connection;
	private $mandantClass;
	private $newsletterClass;
	private $subscriberClass;

	public function __construct(Registry $doctrine, $mandantClass, $newsletterClass, $subscriberClass, $connection = null)
	{
		$this->doctrine = $doctrine;
		$this->mandantClass = $mandantClass;
		$this->newsletterClass = $newsletterClass;
		$this->subscriberClass = $subscriberClass;
		$this->connection = $connection;
	}

	public function get($name = null)
	{
		$canonicalizeName = $this->canonicalizeName($name);
        $manager = $this->getManager($canonicalizeName);
        
        $mandantClass = $this->mandantClass;
		return new $mandantClass($manager, $canonicalizeName, $this->newsletterClass);
	}
	
	private function getManager($name)
	{
		if($name !== self::DEFAULT_NAME){
            throw new \InvalidArgumentException("Manager $name not supported");
        }
        
		return $this->doctrine->getManager();
	}
}

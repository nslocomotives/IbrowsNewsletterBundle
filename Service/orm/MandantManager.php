<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\Mandant\Mandant;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantManager as BaseMandantManager;
use Ibrows\Bundle\NewsletterBundle\Service\BlockManager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\DriverManager;

class MandantManager extends BaseMandantManager
{
	private $doctrine;
	private $connection;
	private $mandantClass;
	private $newsletterClass;
	private $subscriberClass;

	public function __construct(
        Registry $doctrine, 
        $mandantClass, 
        $newsletterClass, 
        $subscriberClass, 
        $connection = null
    ){
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

<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Security\UserProvider\MandantDoctrineUserProvider;

use Ibrows\Bundle\NewsletterBundle\Model\Mandant\Mandant;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantManager as BaseMandantManager;
use Ibrows\Bundle\NewsletterBundle\Service\BlockManager;
use Doctrine\Bundle\DoctrineBundle\Registry;

class MandantManager extends BaseMandantManager
{
	private $doctrine;
    private $blockManager;
	private $connection;
	private $mandantClass;
	private $newsletterClass;
	private $subscriberClass;
	private $userClass;

	public function __construct(
        Registry $doctrine, 
        BlockManager $blockManager,
        $mandantClass, 
        $newsletterClass, 
        $subscriberClass,
		$userClass
    ){
		$this->doctrine = $doctrine;
        $this->blockManager = $blockManager;
		$this->mandantClass = $mandantClass;
		$this->newsletterClass = $newsletterClass;
		$this->subscriberClass = $subscriberClass;
		$this->userClass = $userClass;
	}

	public function get($name)
	{
        $manager = $this->getManager($name);
        $mandantClass = $this->mandantClass;
        
        
		return new $mandantClass();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Ibrows\Bundle\NewsletterBundle\Model\Mandant.MandantManagerInterface::getUserProvider()
	 */
	public function getUserProvider($name)
	{
		$manager = $this->getManager($name);
		$repository = $manager->getRepository($this->mandantClass);
		
		return new MandantDoctrineUserProvider($repository, $this->userClass);
	}
	
	/**
	 * 
	 * @param string $name
	 * @return \Doctrine\Common\Persistence\ObjectManager
	 * @throws \InvalidArgumentException
	 */
	private function getManager($name)
	{
		if($name !== self::DEFAULT_NAME){
            throw new \InvalidArgumentException("Manager $name not supported");
        }
        
		return $this->doctrine->getManager();
	}
}

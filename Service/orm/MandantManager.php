<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Ibrows\Bundle\NewsletterBundle\Service\orm\NewsletterManager;
use Ibrows\Bundle\NewsletterBundle\Service\orm\MandantUserProvider;
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
	
	private $newsletterManager;
	private $userProvider;

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
        $repository = $manager->getRepository($this->mandantClass);
        
		return $repository->findOneBy(array('name' => $name));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Ibrows\Bundle\NewsletterBundle\Model\Mandant.MandantManagerInterface::getUserProvider()
	 */
	public function getUserProvider($name)
	{
		if ($this->userProvider === null) {
			$manager = $this->getManager($name);
			$repository = $manager->getRepository($this->userClass);
			$this->userProvider = new MandantUserProvider($repository);
		}
		
		return $this->userProvider;
	}
	
	public function getNewsletterManager($name)
	{
		if ($this->newsletterManager === null) {
			$manager = $this->getManager($name);
			$repository = $manager->getRepository($this->newsletterClass);
			$this->newsletterManager = new NewsletterManager($repository);
		}
		
		return $this->newsletterManager;
	}
	
	public function persistNewsletter($name, NewsletterInterface $newsletter)
	{
		$manager = $this->getManager($name);
		$manager->persist($newsletter);
		$manager->flush();
		
		return $newsletter;
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

<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Ibrows\Bundle\NewsletterBundle\Service\orm\NewsletterManager;
use Ibrows\Bundle\NewsletterBundle\Service\orm\MandantUserProvider;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\Mandant;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantManager as BaseMandantManager;
use Ibrows\Bundle\NewsletterBundle\Service\BlockManager;
use Doctrine\Bundle\DoctrineBundle\Registry;

class MandantManager extends BaseMandantManager
{
	protected $doctrine;
	protected $connection;
	protected $mandantClass;
	protected $newsletterClass;
	protected $subscriberClass;
	protected $designClass;
	protected $userClass;
	
	protected $newsletterManager;
	protected $designManager;
	protected $userProvider;

	public function __construct(
        Registry $doctrine,
        $mandantClass, 
        $newsletterClass, 
        $subscriberClass,
		$designClass,
		$userClass
    ){
		$this->doctrine = $doctrine;
		$this->mandantClass = $mandantClass;
		$this->newsletterClass = $newsletterClass;
		$this->subscriberClass = $subscriberClass;
		$this->designClass = $designClass;
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
	
	public function getDesignManager($name)
	{
		if ($this->designManager === null) {
			$manager = $this->getManager($name);
			$repository = $manager->getRepository($this->designClass);
			$this->designManager = new DesignManager($repository);
		}
	
		return $this->designManager;
	}
	
	public function persistNewsletter($name, NewsletterInterface $newsletter)
	{
		$manager = $this->getManager($name);
		$newsletter->setMandant($this->get($name));
		$manager->persist($newsletter);
		$manager->flush();
		
		return $newsletter;
	}
	
	public function persistDesign($name, DesignInterface $design)
	{
		$manager = $this->getManager($name);
		$design->setMandant($this->get($name));
		$manager->persist($design);
		$manager->flush();
		
		return $design;
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

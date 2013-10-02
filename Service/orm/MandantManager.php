<?php

namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Service\ClassManager;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Service\orm\NewsletterManager;
use Ibrows\Bundle\NewsletterBundle\Service\orm\MandantUserProvider;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\Mandant;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantManager as BaseMandantManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignManagerInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterManagerInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberManagerInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Statistic\StatisticManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class MandantManager extends BaseMandantManager
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * @var array
     */
    protected $mandants;

    /**
     * @var string
     */
    protected $mandantClass;

    /**
     * @var string
     */
    protected $newsletterClass;

    /**
     * @var string
     */
    protected $subscriberClass;

    /**
     * @var string
     */
    protected $designClass;

    /**
     * @var string
     */
    protected $userClass;

    /**
     * @var string
     */
    protected $readLogClass;

    /**
     * @var string
     */
    protected $sendLogClass;

    /**
     * @var string
     */
    protected $unsubscribeLogClass;

    /**
     * @var NewsletterManagerInterface
     */
    protected $newsletterManager;

    /**
     * @var DesignManagerInterface
     */
    protected $designManager;

    /**
     * @var SubscriberManagerInterface
     */
    protected $subscriberManager;

    /**
     * @var StatisticManagerInterface
     */
    protected $statisticManager;

    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * @param Registry $doctrine
     * @param ClassManager $classManager
     * @param array $mandants
     */
    public function __construct(
        Registry $doctrine,
	    ClassManager $classManager,
		array $mandants
    ){
		$this->doctrine = $doctrine;
		$this->mandants = $mandants;
		$this->mandantClass = $classManager->getModel('mandant');
		$this->newsletterClass = $classManager->getModel('newsletter');
		$this->subscriberClass = $classManager->getModel('subscriber');
		$this->designClass = $classManager->getModel('design');
		$this->userClass = $classManager->getModel('user');
		$this->readLogClass = $classManager->getModel('readlog');
		$this->sendLogClass = $classManager->getModel('sendlog');
		$this->unsubscribeLogClass = $classManager->getModel('unsubscribelog');
	}

    /**
     * @param string $name
     * @return object
     */
    public function get($name)
	{
        $manager = $this->getObjectManager($name);
        $repository = $manager->getRepository($this->mandantClass);
		return $repository->findOneBy(array('name' => $name));
	}

    /**
     * @return array
     */
    public function getMandants()
	{
		return $this->mandants;
	}

    /**
     * @var string $name
     * @return MandantUserProvider|UserProviderInterface
     * @see Ibrows\Bundle\NewsletterBundle\Model\Mandant.MandantManagerInterface::getUserProvider()
     */
	public function getUserProvider($name)
	{
		if ($this->userProvider === null) {
			$manager = $this->getObjectManager($name);
			$repository = $manager->getRepository($this->userClass);
			$this->userProvider = new MandantUserProvider($repository);
		}
		
		return $this->userProvider;
	}

    /**
     * @param string $name
     * @return SubscriberManagerInterface|SubscriberManager
     */
    public function getSubscriberManager($name)
	{
		if ($this->subscriberManager === null) {
			$manager = $this->getObjectManager($name);
			$repository = $manager->getRepository($this->subscriberClass);
			$this->subscriberManager = new SubscriberManager($repository);
		}
		
		return $this->subscriberManager;
	}

    /**
     * @param string $name
     * @return NewsletterManagerInterface|NewsletterManager
     */
    public function getNewsletterManager($name)
	{
		if ($this->newsletterManager === null) {
			$manager = $this->getObjectManager($name);
			$repository = $manager->getRepository($this->newsletterClass);
			$this->newsletterManager = new NewsletterManager($repository);
		}
		
		return $this->newsletterManager;
	}

    /**
     * @param string $name
     * @return DesignManagerInterface|DesignManager
     */
    public function getDesignManager($name)
	{
		if ($this->designManager === null) {
			$manager = $this->getObjectManager($name);
			$repository = $manager->getRepository($this->designClass);
			$this->designManager = new DesignManager($repository);
		}
	
		return $this->designManager;
	}

    /**
     * @param string $name
     * @return StatisticManagerInterface|StatisticManager
     */
    public function getStatisticManager($name)
	{
	    if ($this->statisticManager === null) {
	        $manager = $this->getObjectManager($name);
	        $this->statisticManager = new StatisticManager(
	                $manager, 
	                $name, 
	                $this->readLogClass, 
	                $this->sendLogClass, 
	                $this->unsubscribeLogClass
	         );
	    }
	
	    return $this->statisticManager;
	}

    /**
     * @param string $name
     * @param NewsletterInterface $newsletter
     * @return NewsletterInterface|null
     */
    public function persistNewsletter($name, NewsletterInterface $newsletter)
	{
		$manager = $this->getObjectManager($name);
		$newsletter->setMandant($this->get($name));
		$manager->persist($newsletter);
		$manager->flush();
		
		return $newsletter;
	}
	
	public function persistDesign($name, DesignInterface $design)
	{
		$manager = $this->getObjectManager($name);
		$design->setMandant($this->get($name));
		$manager->persist($design);
		$manager->flush();
		
		return $design;
	}
	
	/**
	 * 
	 * @param string $name
	 * @return ObjectManager
	 * @throws \InvalidArgumentException
	 */
	public function getObjectManager($name)
	{
        if(!$name){
            throw new \InvalidArgumentException("No mandant given. Did you forget to set the mandant on the current authenticated user?");
        }

		if(!array_key_exists($name, $this->mandants)){
            throw new \InvalidArgumentException('Mandant "'. $name .'" does not exist. Did you forget to enable it in the IbrowsNewsletter config?');
        }
        
		return $this->doctrine->getManager($name);
	}
}

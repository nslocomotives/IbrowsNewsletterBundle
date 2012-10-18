<?php
namespace Ibrows\Bundle\NewsletterBundle\Model;
use Doctrine\Common\Persistence\ObjectManager;

class Client implements ClientInterface
{
	private $om;
	private $newsletterClass;
	private $name;
	
	public function __construct(ObjectManager $om, $newsletterClass)
	{
		$this->om = $om;
		$this->newsletterClass = $newsletterClass;
		$this->name = $om->getConnection()->getDatabase();
	}
	
	public function setName($name)
	{
		// ?
		$this->name = $name;
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getNewsletters()
	{
		return $this->om->getRepository($this->newsletterClass)->findAll();
	}
	
	public function getNewsletter($id)
	{
		return $this->om->getRepository($this->newsletterClass)->find($id);
	}
	
	public function createNewsletter()
	{
		return new $this->newsletterClass();
	}
	
	public function persist(NewsletterInterface $newsletter)
	{
		$this->om->persist($newsletter);
		$this->om->flush();
	}
}

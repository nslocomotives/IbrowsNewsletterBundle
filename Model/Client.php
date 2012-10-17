<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

use Doctrine\ORM\EntityManager;

class Client implements ClientInterface
{
	private $em;
	private $name;
	
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->name = $em->getConnection()->getDatabase();
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
	
}

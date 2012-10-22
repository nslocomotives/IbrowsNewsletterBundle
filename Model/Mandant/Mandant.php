<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Service\BlockManager;

use Doctrine\Common\Persistence\ObjectManager;

class Mandant implements MandantInterface
{
	private $name;
	
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getNewsletters()
	{
	}
	
    public function getBlocks()
    {
    }
}

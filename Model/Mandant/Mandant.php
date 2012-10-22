<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Doctrine\Common\Persistence\ObjectManager;

class Mandant implements MandantInterface
{
	protected $name;
	protected $blocks;
	protected $newsletters;
	
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
		return $this->newsletters;
	}
	
    public function getBlocks()
    {
		return $this->blocks;
    }
}

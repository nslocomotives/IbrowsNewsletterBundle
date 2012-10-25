<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Doctrine\Common\Persistence\ObjectManager;

abstract class Mandant implements MandantInterface
{
	protected $name;
	protected $rendererName;
	protected $blocks;
	protected $designs;
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
    
    public function getRendererName()
    {
        return $this->rendererName;
    }
	
	public function getNewsletters()
	{
		return $this->newsletters;
	}
	
    public function getBlocks()
    {
		return $this->blocks;
    }
    
    public function getDesigns()
    {
        return $this->designs;
    }
}

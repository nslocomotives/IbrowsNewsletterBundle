<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Mandant implements MandantInterface
{
	protected $name;
    protected $hash;
	protected $rendererName;

	protected $blocks;
	protected $designs;
	protected $newsletters;
    protected $subscribers;
    protected $subscriberGroups;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->designs = new ArrayCollection();
        $this->newsletters = new ArrayCollection();
        $this->subscribers = new ArrayCollection();
        $this->subscriberGroups = new ArrayCollection();
        $this->hash = $this->generateHash();
    }

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}

    public function getHash()
    {
        return $this->hash;
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

    public function getSubscribers()
    {
        return $this->subscribers;
    }

    public function getSubscriberGroups()
    {
        return $this->subscriberGroups;
    }

    protected function generateHash()
    {
        return sha1(uniqid().time());
    }
}

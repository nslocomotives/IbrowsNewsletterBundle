<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

class TemplateManager
{
	private $mandants;
	private $newsletters;
	
	public function __construct(array $mandants, array $newsletters)
	{
		$this->mandants = $mandants;
		$this->newsletters = $newsletters;
	}
	
	public function getNewsletter($name)
	{
		if(!key_exists($name, $this->newsletters)) {
			throw new \InvalidArgumentException("The newsletter-view with name $name can not be found.");
		}
		
		return $this->newsletters[$name];
	}
    
    public function getMandant($name)
	{
		if(!key_exists($name, $this->mandants)) {
			throw new \InvalidArgumentException("The mandant-view with name $name can not be found.");
		}
		
		return $this->mandants[$name];
	}
}

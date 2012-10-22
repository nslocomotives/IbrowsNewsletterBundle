<?php
namespace Ibrows\Bundle\NewsletterBundle\Model\Design;

class DesignManager
{
	protected $class;
	
	public function __construct($class)
	{
		$this->class = $class;
	}
	
	public function create()
	{
		return new $this->class();
	}
}

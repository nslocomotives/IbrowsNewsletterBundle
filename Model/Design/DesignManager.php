<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Design;

abstract class DesignManager
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @param string $class
     */
    public function __construct($class)
	{
		$this->class = $class;
	}

    /**
     * @return DesignInterface
     */
    public function create()
	{
		return new $this->class();
	}
}

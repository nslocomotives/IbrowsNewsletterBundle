<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

class BlockRendererManager
{
    protected $renderers;
    
    public function __construct(array $renderers = array())
    {
        $this->renderers = $renderers;
    }
    
    public function getRenderer($name)
	{
		if(!key_exists($name, $this->renderers)){
			throw new \InvalidArgumentException("The renderer class $name can not be found.");
		}
		
		return $this->renderers[$name];
	}
}
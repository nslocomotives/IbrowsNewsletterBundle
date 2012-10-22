<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

class BlockCompositionManager
{
    protected $compositions;
    
    public function __construct(array $compositions = array())
    {
        $this->compositions = $compositions;
    }
    
    public function getComposition($name)
	{
		if(!key_exists($name, $this->compositions)){
			throw new \InvalidArgumentException("The composition class $name can not be found.");
		}
		
		return $this->compositions[$name];
	}
}
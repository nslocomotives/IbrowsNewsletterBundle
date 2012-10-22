<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

class BlockProviderManager
{
    protected $providers;
    
    public function __construct(array $providers = array())
    {
        $this->providers = $providers;
    }
    
    public function getProvider($name)
	{
		if(!key_exists($name, $this->providers)){
			throw new \InvalidArgumentException("The provider class $name can not be found.");
		}
		
		return $this->providers[$name];
	}
}
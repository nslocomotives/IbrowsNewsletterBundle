<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

use Ibrows\Bundle\NewsletterBundle\Renderer\RendererInterface;

class RendererManager
{
	protected $renderers = array();
    
    /**
     * @param string $name
     * @param RendererInterface $renderer
     * @return RendererManager
     */
    public function addRenderer($name, RendererInterface $renderer)
    {
        $this->renderers[$name] = $renderer;
        return $this;
    }
    
    /**
     * @param string $name
     * @return RendererInterface
     * @throws \InvalidArgumentException
     */
	public function get($name)
	{
		if(!key_exists($name, $this->renderers)){
			throw new \InvalidArgumentException("The renderer service '$name' can not be found.");
		}
		
		return $this->renderers[$name];
	}
}

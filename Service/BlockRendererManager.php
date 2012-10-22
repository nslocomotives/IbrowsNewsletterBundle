<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

use Ibrows\Bundle\NewsletterBundle\Block\Renderer\RendererInterface;

class BlockRendererManager
{
	protected $blockRenderers = array();
    
    /**
     * @param string $name
     * @param RendererInterface $renderer
     * @return BlockRendererManager
     */
    public function addBlockRenderer($name, RendererInterface $renderer)
    {
        $this->blockRenderers[$name] = $renderer;
        return $this;
    }
    
    /**
     * @param string $name
     * @return RendererInterface
     * @throws \InvalidArgumentException
     */
	public function get($name)
	{
		if(!key_exists($name, $this->blockRenderers)){
			throw new \InvalidArgumentException("The block-renderer service $name can not be found.");
		}
		
		return $this->blockRenderers[$name];
	}
}

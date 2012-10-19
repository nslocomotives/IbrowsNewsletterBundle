<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

class BlockManager
{
    protected $blocks = array();
    
    /**
     * @param array $blocks
     */
    public function __construct(array $blocks)
    {
        $this->blocks = $blocks;
    }
    
    /** 
     * @param string $name
     * @return BlockInterface
     * @throws \InvalidArgumentException
     */
    public function getBlock($name)
    {
        if(!key_exists($name, $this->blocks)){
			throw new \InvalidArgumentException("The model class $name can not be found.");
		}
        
        $blockClassName = $this->blocks[$name];
        return new $blockClassName();
    }
}
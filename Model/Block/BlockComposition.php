<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class BlockComposition implements BlockCompositionInterface
{
    protected $blocks;
    
    public function __construct(array $blocks = array())
    {
        $this->blocks = new ArrayCollection();
        
        foreach($blocks as $block){
            $this->addBlock($block);
        }
    }
    
    /**
     * @param BlockInterface $block
     * @return BlockComposition
     */
    public function addBlock(BlockInterface $block)
    {
        $this->blocks->add($block);
        return $this;
    }
    
    /** 
     * @param BlockInterface $block
     * @return BlockComposition
     */
    public function removeBlock(BlockInterface $block)
    {
        $this->blocks->remove($block);
        return $this;
    }
    
    /**
     * @return Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}
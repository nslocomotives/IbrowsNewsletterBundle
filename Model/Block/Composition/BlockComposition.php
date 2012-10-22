<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block\Composition;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

abstract class BlockComposition implements BlockCompositionInterface
{
    protected $rendererFactory;
    protected $blocks;
    
    public function __construct(RendererFactory $rendererFactory, array $blocks = array())
    {
        $this->rendererFactory = $rendererFactory;
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
    
    public function render()
    {
        $content = $this->startRender();
        
        /* @var $block BlockInterface */
        foreach($this->blocks as $block){
            $content .= $this->startBlockRender($block);
            $content .= $this->blockRender($block);
            $content .= $this->endBlockRender($block);
        }
        
        return $content.$this->endRender();
    }
    
    protected function startBlockRender(BlockInterface $block)
    {
        return '';
    }
    
    protected function endBlockRender(BlockInterface $block)
    {
        return '';
    }
    
    protected function blockRender(BlockInterface $block)
    {
        $providerName = $block->getProviderName();
        $renderer = $this->rendererFactory->getRenderer($providerName);
        return $renderer->render($block);
    }
    
    protected function startRender()
    {
        return '';
    }
    
    protected function endRender()
    {
        return '';
    }
}
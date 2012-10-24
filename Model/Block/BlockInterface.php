<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

use Ibrows\Bundle\NewsletterBundle\Renderer\RenderableInterface;

interface BlockInterface extends RenderableInterface
{
    public function getId();
    public function getPosition();
    
    public function getProviderName();
    public function getProviderOptions();
    
    public function addBlock(BlockInterface $block);
    public function removeBlock(BlockInterface $block);
    public function getBlocks();
}
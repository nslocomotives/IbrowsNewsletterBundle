<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block\Renderer;

class NullRenderer implements RendererInterface
{    
    public function render(BlockInterface $block)
    {
        return $block->getContent();
    }
}
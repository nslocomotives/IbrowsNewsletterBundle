<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Renderer;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

class NullRenderer implements RendererInterface
{    
    public function render(BlockInterface $block)
    {
        return $block->getContent();
    }
}
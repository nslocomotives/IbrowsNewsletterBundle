<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer;

class NullRenderer implements RendererInterface
{    
    public function render(RendereableInterface $element)
    {
        return $block->getContent();
    }
}
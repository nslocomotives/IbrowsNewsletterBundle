<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block\Renderer;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

interface RendererInterface
{
    public function render(BlockInterface $block);
}
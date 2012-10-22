<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

class ImageProvider extends AbstractProvider
{
    public function getBlockDisplayContent(BlockInterface $block)
    {
        return '<img src="'. $block->getContent() .'" />';
    }
}
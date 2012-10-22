<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

abstract class AbstractProvider implements ProviderInterface
{
    public function getBlockDisplayContent(BlockInterface $block)
    {
        
    }
    
    public function getBlockEditContent(BlockInterface $block)
    {
        
    }
}
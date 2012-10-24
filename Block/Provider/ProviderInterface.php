<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Service\BlockProviderManager;

interface ProviderInterface
{
    public function setBlockProviderManager(BlockProviderManager $blockProviderManager);
    public function initParentBlock(BlockInterface $parentBlock);
    
    public function getBlockDisplayContent(BlockInterface $block);
    public function getBlockEditContent(BlockInterface $block);
}
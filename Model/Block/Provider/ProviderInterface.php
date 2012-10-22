<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

interface ProviderInterface
{
    public function getBlockDisplayContent(BlockInterface $block);
    public function getBlockEditContent(BlockInterface $block);
}
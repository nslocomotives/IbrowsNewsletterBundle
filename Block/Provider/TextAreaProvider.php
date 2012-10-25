<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

class TextAreaProvider extends AbstractProvider
{
    public function getBlockEditContent(BlockInterface $block)
    {
        return '<textarea style="width:100%;" name="block['. $block->getId() .']" class="tinymce" data-block-id="'. $block->getId() .'"></textarea>';
    }
}
<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

class TextAreaAndImageProvider extends AbstractProvider
{
    protected function getStartBlockDisplayContent(BlockInterface $block)
    {
        return '<table style="border:1px solid black;"><tr>';
    }
    
    protected function getEndBlockDisplayContent(BlockInterface $block)
    {
        return '</tr></table>';
    }
    
    protected function getPreBlockDisplayContent(BlockInterface $block)
    {
        return '<td style="border:1px solid black;">';
    }
    
    protected function getPostBlockDisplayContent(BlockInterface $block)
    {
        return '</td>';
    }
}
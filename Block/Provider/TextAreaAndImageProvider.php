<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Entity\Block;

class TextAreaAndImageProvider extends AbstractProvider
{
    public function initParentBlock(BlockInterface $parentBlock)
    {
        $textAreaBlock = new Block();
        $textAreaBlock->setName($rootBlock->getProviderOption('textarea.name'));
        $textAreaBlock->setProviderName('ibrows_newsletter.block.provider.textarea');
        $textAreaBlock->setPosition(1);
        
        $imageBlock = new Block();
        $imageBlock->setName($rootBlock->getProviderOption('image.name'));
        $textAreaBlock->setProviderName('ibrows_newsletter.block.provider.image');
        $textAreaBlock->setPosition(2);
        
        $rootBlock->addBlocks(array($textAreaBlock, $imageBlock));
    }
    
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
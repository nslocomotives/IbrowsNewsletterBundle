<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Entity\Block;

class TextAreaAndImageProvider extends AbstractProvider
{    
    public function getOptionKeys()
    {
        return array(
            'textWidth' => array(
                'required' => true
            ),
            'imageWidth' => array(
                'required' => true
            )
        );
    }
    
    public function initialize(BlockInterface $block)
    {
        $textAreaBlock = new Block();
        $textAreaBlock->setName($block->getProviderOption('textarea.name'));
        $textAreaBlock->setProviderName('ibrows_newsletter.block.provider.textarea');
        $textAreaBlock->setPosition(1);
        
        $imageBlock = new Block();
        $imageBlock->setName($block->getProviderOption('image.name'));
        $textAreaBlock->setProviderName('ibrows_newsletter.block.provider.image');
        $textAreaBlock->setPosition(2);
        
        $block->addBlocks(array($textAreaBlock, $imageBlock));
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
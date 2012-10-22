<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

interface BlockInterface
{
    public function getName();
    public function getContent();
    public function getPosition();
    
    public function getProviderName();
    public function getProviderOptions();
    
    public function addBlock(BlockInterface $block);
    public function removeBlock(BlockInterface $block);
    public function getBlocks();
}
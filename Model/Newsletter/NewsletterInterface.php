<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

interface NewsletterInterface
{
    public function getName();
    public function getCreatedAt();
	public function getMandant();
	public function getSubject();
	public function getSenderMail();
	public function getSenderName();
	public function getReturnMail();
    
    public function getId();
    public function getSubscribers();
    
    public function getBlocks();
    public function addBlock(BlockInterface $block);
    public function removeBlock(BlockInterface $block);
    
    public function getDesign();
}

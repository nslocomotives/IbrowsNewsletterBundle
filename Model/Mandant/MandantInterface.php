<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\GroupInterface;

use Doctrine\Common\Collections\Collection;

interface MandantInterface
{
    /**
     * @return NewsletterInterface[]
     */
	public function getNewsletters();
    
    /**
     * @return BlockInterface[]
     */
    public function getBlocks();
    
    /**
     * @return DesignInterface[]
     */
    public function getDesigns();
    
    /**
     * @return string
     */
    public function getRendererName();
    
    public function getSendSettings();
    
    /**
     * @return string
     */
    public function getName();

    /**
     * @return SubscriberInterface[]
     */
    public function getSubscribers();

    /**
     * @return GroupInterface[]
     */
    public function getSubscriberGroups();

    /**
     * @return string
     */
    public function getHash();
}

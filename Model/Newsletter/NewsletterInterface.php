<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\SendSettingsInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantInterface;
use Doctrine\Common\Collections\Collection;

interface NewsletterInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return MandantInterface
     */
    public function getMandant();

    /**
     * @param MandantInterface $mandant
     * @return NewsletterInterface
     */
    public function setMandant(MandantInterface $mandant);

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getSenderMail();

    /**
     * @return string
     */
    public function getSenderName();

    /**
     * @return string
     */
    public function getReturnMail();

    /**
     * @return string
     */
    public function getHash();
    
    /**
     * @return SubscriberInterface[]
     */
    public function getSubscribers();

    /**
     * @return SendSettingsInterface[]
     */
    public function getSendSettings();

    /**
     * @param SendSettingsInterface $settings
     * @return NewsletterInterface
     */
    public function setSendSettings(SendSettingsInterface $settings);

    /**
     * @return BlockInterface[]|Collection
     */
    public function getBlocks();

    /**
     * @param BlockInterface $block
     * @return NewsletterInterface
     */
    public function addBlock(BlockInterface $block);

    /**
     * @param BlockInterface $block
     * @return NewsletterInterface
     */
    public function removeBlock(BlockInterface $block);

    /**
     * @return DesignInterface
     */
    public function getDesign();
}

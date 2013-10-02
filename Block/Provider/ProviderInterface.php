<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Service\BlockProviderManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getOptionKeys();

    /**
     * @param BlockProviderManager $blockProviderManager
     * @return ProviderInterface
     */
    public function setBlockProviderManager(BlockProviderManager $blockProviderManager);

    /**
     * @param BlockInterface $block
     * @param $blockClassName
     * @return ProviderInterface
     */
    public function initialize(BlockInterface $block, $blockClassName);

    /**
     * @param BlockInterface $block
     * @param mixed $update
     * @return ProviderInterface
     */
    public function updateBlock(BlockInterface $block, $update);

    /**
     * @param BlockInterface $block
     * @return ProviderInterface
     */
    public function updateClonedBlock(BlockInterface $block);

    /**
     * @param BlockInterface $block
     * @return ProviderInterface
     */
    public function getBlockDisplayContent(BlockInterface $block);

    /**
     * @param BlockInterface $block
     * @return ProviderInterface
     */
    public function getBlockEditContent(BlockInterface $block);
}
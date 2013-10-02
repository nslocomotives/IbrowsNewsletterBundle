<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Renderer\RenderableInterface;

interface BlockInterface extends RenderableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @param int
     * @return BlockInterface
     */
    public function setPosition($position);

    /**
     * @return string
     */
    public function getProviderName();

    /**
     * @param string $providerName
     * @return BlockInterface
     */
    public function setProviderName($providerName);

    /**
     * @return array
     */
    public function getProviderOptions();

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getProviderOption($key, $default = null);

    /**
     * @param array $options
     * @return BlockInterface
     */
    public function setProviderOptions(array $options);

    /**
     * @param string $key
     * @param mixed $value
     * @return BlockInterface
     */
    public function setProviderOption($key, $value);

    /**
     * @param BlockInterface $block
     * @return BlockInterface
     */
    public function setParentBlock(BlockInterface $block = null);

    /**
     * @return BlockInterface
     */
    public function getParentBlock();

    /**
     * @return boolean
     */
    public function isCompound();

    /**
     * @param BlockInterface $block
     * @return BlockInterface
     */
    public function addBlock(BlockInterface $block);

    /**
     * @param BlockInterface $block
     * @return BlockInterface
     */
    public function removeBlock(BlockInterface $block);

    /**
     * @return BlockInterface[]
     */
    public function getBlocks();

    /**
     * @param BlockInterface[] $blocks
     * @return BlockInterface
     */
    public function setBlocks(array $blocks);

    /**
     * @param BlockInterface[] $blocks
     * @return mixed
     */
    public function addBlocks(array $blocks);

    /**
     * @param string $content
     * @return BlockInterface
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return NewsletterInterface
     */
    public function getNewsletter();

    /**
     * @param NewsletterInterface $newsletter
     * @return BlockInterface
     */
    public function setNewsletter(NewsletterInterface $newsletter = null);
}
<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

abstract class Block implements BlockInterface
{
    protected $name;
    protected $content;
    protected $providerName;
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param type $name
     * @return Block
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @param string $content
     * @return Block
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }
    
    /**
     * @param string $providerName
     * @return Block
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;
        return $this;
    }
}
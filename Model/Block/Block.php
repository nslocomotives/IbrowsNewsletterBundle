<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

class Block implements BlockInterface
{
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
     * @param type $content
     * @return Block
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}
<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Doctrine\Common\Collections\Collection;

interface MandantInterface
{
    /**
     * @return Collection
     */
	public function getNewsletters();
    
    /**
     * @return Collection
     */
    public function getBlocks();
    
    /**
     * @return Collection
     */
    public function getDesigns();
    
    /**
     * @return string
     */
    public function getRendererName();
    
    /**
     * @return string
     */
    public function getName();
}

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
     * @param integer $id
     * @return NewsletterInterface
     */
	public function getNewsletter($id);
    
    /**
     * @return MandantInterface
     */
	public function createNewsletter();
    
    /**
     * @return Collection
     */
    public function getBlocks();
}

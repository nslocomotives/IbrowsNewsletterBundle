<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity\Block;

use Ibrows\Bundle\NewsletterBundle\Model\Block\Block as AbstractBlock;

use Doctrine\ORM\Mapping as ORM;


abstract class AbstractBlock extends AbstractBlock
{
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
	protected $name;
    
    /**
	 * @var string
	 * 
	 * @ORM\Column(type="text")
	 */
	protected $content;
}

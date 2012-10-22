<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Block\Block as BaseBlock;

use Doctrine\ORM\Mapping as ORM;

class Block extends BaseBlock
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
    
    /**
	 * @var integer
	 * 
	 * @ORM\Column(type="integer")
	 */
	protected $position;
    
    /**
	 * @var string
	 * 
	 * @ORM\Column(type="text")
	 */
	protected $providerName;
    
    /**
	 * @var array
	 * 
	 * @ORM\Column(type="array")
	 */
	protected $providerOptions = array();
}
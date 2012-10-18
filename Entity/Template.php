<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Template\Template as AbstractTemplate;

use Doctrine\ORM\Mapping as ORM;

class Template extends AbstractTemplate
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

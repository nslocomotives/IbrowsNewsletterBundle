<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ibrows\Bundle\NewsletterBundle\Model\Template\Template as AbstractTemplate;

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

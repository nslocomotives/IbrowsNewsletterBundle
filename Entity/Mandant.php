<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Mandant\Mandant as AbstractMandant;

use Doctrine\ORM\Mapping as ORM;

class Mandant extends AbstractMandant
{
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
	protected $name;
}

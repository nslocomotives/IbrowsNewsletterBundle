<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant as AbstractMandant;

class Mandant extends AbstractMandant
{
	/**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
	protected $name;
}

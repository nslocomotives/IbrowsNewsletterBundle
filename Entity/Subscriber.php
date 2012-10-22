<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\Subscriber as AbstractSubscriber;

use Doctrine\ORM\Mapping as ORM;

class Subscriber extends AbstractSubscriber
{
    /**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
    protected $locale;
    
    /**
	 * @var string
	 * 
	 * @ORM\Column(type="string")
	 */
    protected $email;
}

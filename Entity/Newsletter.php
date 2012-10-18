<?php
namespace Ibrows\Bundle\NewsletterBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter as AbstractNewsletter;

class Newsletter extends AbstractNewsletter
{
	/**
	 * @ORM\Column(type="string")
	 */
	protected $subject;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $sender_mail;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $sender_name;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $return_mail;
}

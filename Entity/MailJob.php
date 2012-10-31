<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob as BaseMailJob;
use Doctrine\ORM\Mapping as ORM;

class MailJob extends BaseMailJob
{
	/**
	 * @ORM\Column(type="string")
	 */
	protected $subject;
	/**
	 * @ORM\Column(type="string", name ="sender_name")
	 */
	protected $senderName;
	/**
	 * @ORM\Column(type="string", name ="sender_mail")
	 */
	protected $senderMail;
	/**
	 * @ORM\Column(type="string", name ="return_mail")
	 */
	protected $returnMail;
	
	/**
	 * @ORM\Column(type="string", name ="to_mail")
	 */
	protected $toMail;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $body;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $error;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $status;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $scheduled;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $completed;
}

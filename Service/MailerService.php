<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob;

class MailerService
{
	protected $mailer;
	
	public function __construct($mailer)
	{
		$this->mailer = $mailer;
	}
	
	public function send(MailJob $job)
	{
		$message = \Swift_Message::newInstance()
			->setSubject($job->getSubject())
			->setFrom($job->getSenderMail(), $job->getSenderName())
			->setReturnPath($job->getReturnMail())
			->setTo($job->getToMail())
			->setBody($job->getBody())
		;
		
		$this->mailer->setHost($job->getHost());
		$this->mailer->setPort($job->getPort());
		$this->mailer->setUsername($job->getUsername());
		$this->mailer->setPassword($job->getPassword());
		
		$this->mailer->send($message);
	}
	
}

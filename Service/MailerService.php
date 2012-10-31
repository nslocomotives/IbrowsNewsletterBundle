<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob;

class MailerService
{
	protected $mailer;
	protected $transport;
	
	public function __construct($mailer, $transport)
	{
		$this->mailer = $mailer;
		$this->transport = $transport;
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
		
		$this->transport->setHost($job->getHost());
		$this->transport->setPort($job->getPort());
		$this->transport->setUsername($job->getUsername());
		$this->transport->setPassword($job->getPassword());
		
		$this->mailer->newInstance($this->transport)->send($message);
	}
	
}

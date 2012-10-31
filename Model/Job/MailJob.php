<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Job;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

class MailJob extends AbstractJob
{
	protected $subject;
	protected $senderName;
	protected $senderMail;
	protected $returnMail;

	protected $toMail;
	protected $body;

	public function __construct(NewsletterInterface $newsletter)
	{
		parent::__construct();
		
		$this->subject = $newsletter->getSubject();
		$this->senderName = $newsletter->getSenderName();
		$this->senderMail = $newsletter->getSenderMail();
		$this->returnMail = $newsletter->getReturnMail();
	}

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getSenderName()
    {
        return $this->senderName;
    }

    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
        return $this;
    }

    public function getSenderMail()
    {
        return $this->senderMail;
    }

    public function setSenderMail($senderMail)
    {
        $this->senderMail = $senderMail;
        return $this;
    }

    public function getReturnMail()
    {
        return $this->returnMail;
    }

    public function setReturnMail($returnMail)
    {
        $this->returnMail = $returnMail;
        return $this;
    }

    public function getToMail()
    {
        return $this->toMail;
    }

    public function setToMail($toMail)
    {
        $this->toMail = $toMail;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}

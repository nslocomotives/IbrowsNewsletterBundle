<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Job;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\SendSettingsInerface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

class MailJob extends AbstractJob
{
	protected $subject;
	protected $senderName;
	protected $senderMail;
	protected $returnMail;

	protected $toMail;
	protected $body;
	
	protected $transport;
	protected $username;
	protected $password;
	protected $host;
	protected $port;

	public function __construct(NewsletterInterface $newsletter, SendSettingsInerface $sendSettings)
	{
		parent::__construct();
		
		$this->setSubject($newsletter->getSubject());
		$this->setSenderName($newsletter->getSenderName());
		$this->setSenderMail($newsletter->getSenderMail());
		$this->setReturnMail($newsletter->getReturnMail());
		
		$this->setTransport($sendSettings->getTransport());
		$this->setUsername($sendSettings->getUsername());
		$this->setPassword($sendSettings->getPassword());
		$this->setHost($sendSettings->getHost());
		$this->setPort($sendSettings->getPort());
		
		$this->setNewsletterId($newsletter->getId());
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

    public function getTransport()
    {
        return $this->transport;
    }

    public function setTransport($transport)
    {
        $this->transport = $transport;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }
}

<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

class Newsletter implements NewsletterInterface
{
	protected $subject;
	protected $senderMail;
	protected $senderName;
	protected $returnMail;

	public function getSubject()
	{
	    return $this->subject;
	}

	public function setSubject($subject)
	{
	    $this->subject = $subject;
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

	public function getSenderName()
	{
	    return $this->senderName;
	}

	public function setSenderName($senderName)
	{
	    $this->senderName = $senderName;
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
}

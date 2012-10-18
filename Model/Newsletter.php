<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

class Newsletter implements NewsletterInterface
{
	protected $subject;
	protected $sender_mail;
	protected $sender_name;
	protected $return_mail;

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
	    return $this->sender_mail;
	}

	public function setSenderMail($sender_mail)
	{
	    $this->sender_mail = $sender_mail;
	    return $this;
	}

	public function getSenderName()
	{
	    return $this->sender_name;
	}

	public function setSenderName($sender_name)
	{
	    $this->sender_name = $sender_name;
	    return $this;
	}

	public function getReturnMail()
	{
	    return $this->return_mail;
	}

	public function setReturnMail($return_mail)
	{
	    $this->return_mail = $return_mail;
	    return $this;
	}
}

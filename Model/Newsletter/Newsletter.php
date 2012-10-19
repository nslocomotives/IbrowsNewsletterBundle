<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

class Newsletter implements NewsletterInterface
{
    protected $id;
	protected $subject;
	protected $senderMail;
	protected $senderName;
	protected $returnMail;

    /**
     * @return integer
     */
	public function getId()
	{
	    return $this->id;
	}
    
    /**
     * @return string
     */
	public function getSubject()
	{
	    return $this->subject;
	}

    /**
     * @param string $subject
     * @return Newsletter
     */
	public function setSubject($subject)
	{
	    $this->subject = $subject;
	    return $this;
	}

    /**
     * @return string
     */
	public function getSenderMail()
	{
	    return $this->senderMail;
	}

    /**
     * @param string $senderMail
     * @return Newsletter
     */
	public function setSenderMail($senderMail)
	{
	    $this->senderMail = $senderMail;
	    return $this;
	}

    /**
     * @return string
     */
	public function getSenderName()
	{
	    return $this->senderName;
	}

    /**
     * @param string $senderName
     * @return Newsletter
     */
	public function setSenderName($senderName)
	{
	    $this->senderName = $senderName;
	    return $this;
	}

    /**
     * @return string
     */
	public function getReturnMail()
	{
	    return $this->returnMail;
	}

    /**
     * @param type $returnMail
     * @return Newsletter
     */
	public function setReturnMail($returnMail)
	{
	    $this->returnMail = $returnMail;
	    return $this;
	}
}

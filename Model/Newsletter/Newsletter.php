<?php
namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

use Symfony\Component\Validator\Constraints as Assert;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;

use Doctrine\Common\Collections\ArrayCollection;

class Newsletter implements NewsletterInterface
{
	protected $id;
	/**
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $subject;
	/**
	 * @Assert\Email(groups={"newsletter"})
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $senderMail;
	/**
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $senderName;
	/**
	 * @Assert\Email(groups={"newsletter"})
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $returnMail;
    protected $subscribers;
    
    public function __construct()
    {
        $this->subscribers = new ArrayCollection();
    }
    
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
    
    public function getSubscribers()
    {
        return $this->subscribers;
    }
    
    public function removeSubscriber(SubscriberInterface $subscriber)
    {
        $this->subscribers->remove($subscriber);
        return $this;
    }
    
    public function addSubscriber(SubscriberInterface $subscriber)
    {
        $this->subscribers->add($subscriber);
        return $this;
    }
}

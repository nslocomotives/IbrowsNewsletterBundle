<?php
namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantInterface;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

class Newsletter implements NewsletterInterface
{
	protected $id;
	protected $mandant;
	protected $subscribers;
	protected $blocks;
	
	/**
     * @var string $subject
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $subject;
    
    /**
     * @var string $name
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $name;
    
	/**
     * @var string $senderMail
	 * @Assert\Email(groups={"newsletter"})
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $senderMail;
    
	/**
     * @var string $senderName
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $senderName;
    
	/**
     * @var string $returnMail
	 * @Assert\Email(groups={"newsletter"})
	 * @Assert\NotBlank(groups={"newsletter"})
	 */
	protected $returnMail;
    
    /**
     * @var \DateTime $createdAt
     * @Assert\NotNull(groups={"newsletter"})
     */
    protected $createdAt;

	public function __construct()
	{
		$this->subscribers = new ArrayCollection();
		$this->blocks = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Newsletter
	 */
	public function setName($name)
	{
		$this->name = $name;
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

	/**
	 * @return Collection
	 */
	public function getSubscribers()
	{
		return $this->subscribers;
	}

	/**
	 * @param SubscriberInterface $subscriber
	 * @return Newsletter
	 */
	public function removeSubscriber(SubscriberInterface $subscriber)
	{
        $subscriber->removeNewsletter($this);
		$this->subscribers->remove($subscriber);
		return $this;
	}

	/**
	 * @param SubscriberInterface $subscriber
	 * @return Newsletter
	 */
	public function addSubscriber(SubscriberInterface $subscriber)
	{
        $subscriber->addNewsletter($this);
		$this->subscribers->add($subscriber);
		return $this;
	}

    /**
     * @return MandantInterface
     */
	public function getMandant()
	{
		return $this->mandant;
	}

    /**
     * @param \DateTime $dateTime
     * @return Newsletter
     */
    public function setCreatedAt(\DateTime $dateTime)
    {
        $this->createdAt = $dateTime;
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @return Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
    
    /**
     * @param BlockInterface $block
     * @return Newsletter
     */
    public function addBlock(BlockInterface $block)
    {
        $block->setNewsletter($this);
        $this->blocks->add($block);
        return $this;
    }
    
    /**
     * @param BlockInterface $block
     * @return Newsletter
     */
    public function removeBlock(BlockInterface $block)
    {
        $block->setNewsletter(null);
        $this->blocks->remove($block);
        return $this;
    }
}

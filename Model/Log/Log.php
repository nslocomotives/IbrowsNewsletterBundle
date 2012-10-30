<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Log;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;

abstract class Log implements LogInterface
{
    protected $id;

    protected $newsletterId;
    protected $subscriberId = null;

    protected $createdAt;
    protected $message;

    public function __construct(){
        $this->createdAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNewsletterId()
    {
        return $this->newsletterId;
    }

    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setNewsletterId($newsletterId)
    {
        $this->newsletterId = (int)$newsletterId;
        return $this;
    }

    public function setSubscriberId($subscriberId)
    {
        $this->subscriberId = (int)$subscriberId;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getType()
    {
        $className = get_class($this);
        $explode = explode("\\", $className);
        $reverse = array_reverse($explode);

        return isset($reverse[0]) ? $reverse[0] : null;
    }
}
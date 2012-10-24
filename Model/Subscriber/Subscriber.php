<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Subscriber implements SubscriberInterface
{
    protected $locale;
    protected $email;
    
    protected $newsletters;
    
    public function __construct()
    {
        $this->newsletters = new ArrayCollection();
    }
    
    public function __toString()
    {
    		return $this->email;
    }
    
    public function getLocale()
    {
        return $this->locale;
    }
    
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getNewsletters()
    {
        return $this->newsletters;
    }
    
    public function addNewsletter(NewsletterInterface $newsletter)
    {
        $this->newsletters->add($newsletter);
        return $this;
    }
    
    public function removeNewsletter(NewsletterInterface $newsletter)
    {
        $this->newsletters->remove($newsletter);
        return $this;
    }
}

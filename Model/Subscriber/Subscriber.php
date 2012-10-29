<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Subscriber implements SubscriberInterface
{
    protected $id;
    
    protected $locale;
    protected $email;
    protected $hash;
    
    protected $gender;
    protected $title;
    
    protected $lastname;
    protected $firstname;
    protected $companyname;

    protected $newsletters;
    
    protected static $genders = array(
        self::GENDER_FEMALE => self::GENDER_FEMALE,
        self::GENDER_MALE => self::GENDER_MALE,
        self::GENDER_COMPANY => self::GENDER_COMPANY
    );
    
    protected static $titles = array(
        self::TITLE_FORMAL => self::TITLE_FORMAL,
        self::TITLE_INFORMAL => self::TITLE_INFORMAL
    );
    
    public function __construct()
    {
        $this->newsletters = new ArrayCollection();
        $this->hash = $this->generateHash();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
        return $this->email;
    }
    
    public function isFemale()
    {
        return $this->getGender() == self::$genders[self::GENDER_FEMALE];
    }
    
    public function isMale()
    {
        return $this->getGender() == self::$genders[self::GENDER_MALE];
    }
    
    public function isCompany()
    {
        return $this->getGender() == self::$genders[self::GENDER_COMPANY];
    }
    
    public function isFormalTitle()
    {
        return $this->getTitle() == self::$genders[self::TITLE_FORMAL];
    }
    
    public function isInformalTitle()
    {
        return $this->getTitle() == self::$genders[self::TITLE_INFORMAL];
    }
    
    public function getGender()
    {
        return $this->gender;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getHash()
    {
        return $this->hash;
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
        $this->newsletters->removeElement($newsletter);
        return $this;
    }
    
    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    public function getCompanyname()
    {
        return $this->companyname;
    }
    
    protected function generateHash()
    {
        return sha1(uniqid().time());
    }
}

<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

interface SubscriberInterface
{
    public function getLocale();
    public function setLocale($locale);
    public function getEmail();
    public function setEmail($email);
    
    public function isFemale();
    public function isMale();
    public function isCompany();
    
    public function isFormalTitle();
    public function isInformalTitle();
    
    public function getGender();
    public function setGender($gender);
    public function getTitle();
    public function setTitle($title);
    
    public function getFirstname();
    public function setFirstname($firstname);
    public function getLastname();
    public function setLastname($lastname);
    public function getCompanyname();
    public function setCompanyname($companyname);
    
    public function getNewsletters();
    public function addNewsletter(NewsletterInterface $newsletter);
    public function removeNewsletter(NewsletterInterface $newsletter);
    
    public function getId();
    public function __toString();
    
    public function getGroups();
    public function addGroup(GroupInterface $group);
    public function removeGroup(GroupInterface $group);
    
    public function getHash();
    
    const
        GENDER_MALE = 'male',
        GENDER_FEMALE = 'female',
        GENDER_COMPANY = 'company',
        TITLE_FORMAL = 'formal',
        TITLE_INFORMAL = 'informal'
    ;
}

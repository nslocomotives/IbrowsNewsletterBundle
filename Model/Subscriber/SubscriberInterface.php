<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

interface SubscriberInterface
{
    public function getLocale();
    public function getEmail();
    
    public function isFemale();
    public function isMale();
    public function isCompany();
    
    public function isFormalTitle();
    public function isInformalTitle();
    
    public function getNewsletters();
    public function addNewsletter(NewsletterInterface $newsletter);
    public function removeNewsletter(NewsletterInterface $newsletter);
    
    public function getId();
    public function __toString();
    
    const
        GENDER_MALE = 'male',
        GENDER_FEMALE = 'female',
        GENDER_COMPANY = 'company',
        TITLE_FORMAL = 'formal',
        TITLE_INFORMAL = 'informal'
    ;
}

<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

interface SubscriberInterface
{
    public function getLocale();
    public function getEmail();
    public function getNewsletters();
    public function addNewsletter(NewsletterInterface $newsletter);
    public function removeNewsletter(NewsletterInterface $newsletter);
    public function __toString();
}

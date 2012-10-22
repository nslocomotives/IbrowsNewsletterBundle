<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

interface SubscriberInterface
{
    public function getLocale();
    public function getEmail();
}

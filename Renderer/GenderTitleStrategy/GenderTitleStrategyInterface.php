<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer\GenderTitleStrategy;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;

interface GenderTitleStrategyInterface
{ 
    /**
     * @param SubscriberInterface $subscriber
     * @return string
     */
    public function getGenderTitle(SubscriberInterface $subscriber);    
}
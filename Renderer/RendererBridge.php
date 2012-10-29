<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Renderer\GenderTitleStrategy\GenderTitleStrategyInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Symfony\Component\Routing\RouterInterface;

class RendererBridge
{
    protected $router;
    protected $genderTitleStrategy;
    
    public function __construct(
        RouterInterface $router,
        GenderTitleStrategyInterface $genderTitleStrategy
    ){
        $this->router = $router;
        $this->genderTitleStrategy = $genderTitleStrategy;
    }
    
    public function getNow($format = 'd.m.Y')
    {
        $now = new \DateTime();
        return $now->format($format);
    }
    
    public function getUnsubscribeLink(NewsletterInterface $newsletter, SubscriberInterface $subscriber)
    {
        return $this->router->generate(
            'ibrows_newsletter_unsubscribe', 
            array(
                'newsletterHash' => $newsletter->getHash(), 
                'subscriberHash' => $subscriber->getHash()
            ),
            true
        );
    }
    
    public function getGenderTitle(SubscriberInterface $subscriber)
    {
        return $this->genderTitleStrategy->getGenderTitle($subscriber);
    }
}
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
    
    public function getNow(SubscriberInterface $subscriber, $format = 'd.m.Y')
    {
        $currentLocale = setlocale(LC_TIME, 0);
        setlocale(LC_TIME, $subscriber->getLocale());
        $now = strftime($format);
        setlocale(LC_TIME, $currentLocale);
        return $now;
    }
    
    public function getUnsubscribeLink(NewsletterInterface $newsletter, SubscriberInterface $subscriber)
    {
        return $this->router->generate(
            'ibrows_newsletter_unsubscribe', 
            array(
                'newsletter' => $newsletter->getHash(), 
                'subscriber' => $subscriber->getHash()
            ), 
            true
        );
    }
    
    public function getGenderTitle(SubscriberInterface $subscriber)
    {
        return $this->genderTitleStrategy->getGenderTitle($subscriber);
    }
}
<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer\Bridge;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Renderer\GenderTitleStrategy\GenderTitleStrategyInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

use Symfony\Component\Routing\RouterInterface;

class RendererBridge
{
    protected $router;
    protected $genderTitleStrategy;

    /**
     * @param RouterInterface $router
     * @param GenderTitleStrategyInterface $genderTitleStrategy
     */
    public function __construct(
        RouterInterface $router,
        GenderTitleStrategyInterface $genderTitleStrategy
    ){
        $this->router = $router;
        $this->genderTitleStrategy = $genderTitleStrategy;
    }

    /**
     * @param string $format
     * @return string
     */
    public function now($format = 'd.m.Y')
    {
        $now = new \DateTime();
        return $now->format($format);
    }

    /**
     * @param NewsletterInterface $newsletter
     * @param SubscriberInterface $subscriber
     * @return string
     */
    public function unsubscribelink(NewsletterInterface $newsletter, SubscriberInterface $subscriber)
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

    /**
     * @param SubscriberInterface $subscriber
     * @return string
     */
    public function gendertitle(SubscriberInterface $subscriber)
    {
        return $this->genderTitleStrategy->getGenderTitle($subscriber);
    }
}
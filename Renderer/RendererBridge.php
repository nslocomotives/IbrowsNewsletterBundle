<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

use Symfony\Component\Translation\TranslatorInterface;

class RendererBridge
{
    protected $translator;
    protected $router;
    
    public function __construct(TranslatorInterface $translator, RouterInterface $router)
    {
        $this->translator = $translator;
        $this->router = $router;
    }
    
    public function getNow()
    {
        
    }
    
    public function getUnsubscribeLink(SubscriberInterface $subscriber)
    {
        return '<a href="">unsubscribe</a>';
    }
    
    public function getTitle(SubscriberInterface $subscriber)
    {
        return 'i dont know your title';
    }
}
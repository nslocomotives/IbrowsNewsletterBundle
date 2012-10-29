<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer\GenderTitleStrategy;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;

use Symfony\Component\Translation\TranslatorInterface;

class GenderTitleTranslatorStrategy implements GenderTitleStrategyInterface
{
    protected $translator;
    protected $translationDomain;
    protected $translationParameters;
    
    public function __construct(
        TranslatorInterface $translator, 
        $translationDomain,
        array $translationParameters = array()
    ){
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
        $this->translationParameters = $translationParameters;
    }
    
    /**
     * @todo Define Translations Parameters
     * @param SubscriberInterface $subscriber
     * @return string
     */
    public function getGenderTitle(SubscriberInterface $subscriber)
    {
        $parameters = array();
        foreach($this->translationParameters as $key => $methodName){
            $parameters['%subscriber.'.$key.'%'] = 
                $subscriber->$methodName();
        }
        
        return 
            $this->translator->trans(
                'newsletter.gendertitle.'.$subscriber->getGender().'.'.$subscriber->getTitle(), 
                $parameters,
                $this->translationDomain,
                $subscriber->getLocale()
            );
    }
}
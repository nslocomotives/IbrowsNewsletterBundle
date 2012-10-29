<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer\GenderTitleStrategy;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;

use Symfony\Component\Translation\TranslatorInterface;

class GenderTitleTranslatorStrategy implements GenderTitleStrategyInterface
{
    public function __construct(TranslatorInterface $translator, $translationDomain)
    {
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
    }
    
    /**
     * @todo Define Translations Parameters
     * @param SubscriberInterface $subscriber
     * @return string
     */
    public function getGenderTitle(SubscriberInterface $subscriber)
    {
        return 
            $this->translator->trans(
                'newsletter.gendertitle.'.$subscriber->getGender().'.'.$subscriber->getTitle(), 
                array(
                    
                ),
                $this->translationDomain,
                $subscriber->getLocale()
            );
    }
}
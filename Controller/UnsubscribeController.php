<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/unsubscribe")
 */
class UnsubscribeController extends AbstractController
{
    /**
     * @Route("/do/{newsletterHash}/{subscriberHash}", name="ibrows_newsletter_unsubscribe")
     */
    public function unsubscribeAction($newsletterHash, $subscriberHash)
    {
        $newsletter = $this->getNewsletterByHash($newsletterHash);
        $subscriber = $this->getSubscriberByHash($newsletter, $subscriberHash);

        $groupClass = $this->getClassManager()->getModel('group');

        $formtype = $this->getClassManager()->getForm('unsubscribe');
        $form = $this->createForm(new $formtype($this->getMandantName(), $groupClass), $subscriber);

        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
            $form->bind($request);

            if($form->isValid()){
                $this->setNewsletter($newsletter);
            }
        }

        return $this->render($this->getTemplateManager()->getNewsletter('unsubscribe'), array(
            'form' => $form->createView(),
            'subscriber' => $subscriber,
            'newsletter' => $newsletter
        ));
    }
}

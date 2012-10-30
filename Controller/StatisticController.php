<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/statistic")
 */
class StatisticController extends AbstractHashMandantController
{
    const TRANSPARENT_GIF = 'R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

    /**
     * @Route("/log/read/{mandantHash}/{newsletterHash}/{subscriberHash}", name="ibrows_newsletter_statistic_log_read")
     */
    public function logreadAction($mandantHash, $newsletterHash, $subscriberHash)
    {
        $this->setMandantNameByHash($mandantHash);

        // if no context is set, its live --> log
        if(!$this->getRequest()->get('context')){

        }

        return new Response(base64_decode(self::TRANSPARENT_GIF), 200, array(
            'Content-Type' => 'image/gif'
        ));
    }
}
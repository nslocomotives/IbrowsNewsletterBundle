<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/statistic")
 */
class StatisticController extends AbstractController
{
    /**
     * @Route("/log/{newsletterHash}/{subscriberHash}", name="ibrows_newsletter_statistic_log")
     */
    public function logAction($newsletterHash, $subscriberHash)
    {

    }
}
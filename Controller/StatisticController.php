<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Model\Log\LogInterface;

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

        $newsletter = $this->getNewsletterByHash($newsletterHash);
        $subscriber = $this->getSubscriberByHash($newsletter, $subscriberHash);

        // if no context is set, its live --> log
        if(!$this->getRequest()->query->get('context')){
            $this->addNewsletterReadLog($newsletter, $subscriber, "Newsletter read: logged by ".__METHOD__);
        }

        return new Response(base64_decode(self::TRANSPARENT_GIF), 200, array(
            'Content-Type' => 'image/gif'
        ));
    }

    /**
     * @Route("/show/{newsletterId}", name="ibrows_newsletter_statistic_show")
     */
    public function showAction($newsletterId)
    {
        $newsletter = $this->getNewsletterById($newsletterId);

        $objectManager = $this->getObjectManager();

        $sentlogs = $objectManager->getRepository($this->getClassManager()->getModel('sentlog'))->findBy(array(
            'newsletterId' => $newsletter->getId()
        ));

        $readlogs = $objectManager->getRepository($this->getClassManager()->getModel('readlog'))->findBy(array(
            'newsletterId' => $newsletter->getId()
        ));

        $jobs = $objectManager->getRepository($this->getClassManager()->getModel('mailjob'))->findBy(
            array(
                'newsletterId' => $newsletter->getId()
            ),
            array(
                'status' => 'ASC'
            )
        );

        $foundSubscriberIds = array();
        $filteredReadlogs = array_filter($readlogs, function($readlog)use(&$foundSubscriberIds){
            $subscriberId = $readlog->getSubscriberId();
            if(!in_array($subscriberId, $foundSubscriberIds)){
                $foundSubscriberIds[] = $subscriberId;
                return true;
            }
            return false;
        });

        $readAmount = count($filteredReadlogs);
        $unreadAmount = count($sentlogs)-$readAmount;

        $jobData = array();
        foreach($jobs as $job){
            $status = $job->getStatus();
            if(!isset($jobData[$status])){
                $jobData[$status] = 0;
            }
            $jobData[$status]++;
        }

        return $this->render($this->getTemplateManager()->getStatistic('show'), array(
            'newsletter' => $newsletter,
            'read' => $readAmount,
            'unread' => $unreadAmount,
            'jobs' => $jobData
        ));
    }
}
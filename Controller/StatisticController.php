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

        $jobPie = array();
        foreach($jobs as $job){
            $status = $job->getStatus();
            if(!isset($jobPie[$status])){
                $jobPie[$status] = 0;
            }
            $jobPie[$status]++;
        }

        $jobStati = array_keys($jobPie);

        $jobsSortedByCompleted = $jobs;
        usort($jobsSortedByCompleted, function($a, $b){
            $dateA = $a->getCompleted() ?: $a->getCreated();
            $dateB = $b->getCompleted() ?: $b->getCreated();
            return $dateA > $dateB;
        });

        $jobLine = array();
        $jobWalkLine = array();
        foreach($jobsSortedByCompleted as $job){

            $dateTime = $job->getCompleted() ?: $job->getCreated();
            $date = $dateTime->format('d.m.Y H:i:s');

            foreach($jobStati as $jobStatus){
                if(!isset($jobWalkLine[$jobStatus])){
                    $jobWalkLine[$jobStatus] = 0;
                }

                if(!isset($jobLine[$date])){
                    $jobLine[$date] = array();
                }

                if($job->getStatus() == $jobStatus){
                    $jobLine[$date][$jobStatus] = ++$jobWalkLine[$jobStatus];
                }else{
                    $jobLine[$date][$jobStatus] = $jobWalkLine[$jobStatus];
                }
            }
        }

        return $this->render($this->getTemplateManager()->getStatistic('show'), array(
            'newsletter' => $newsletter,
            'read' => $readAmount,
            'unread' => $unreadAmount,
            'jobPie' => $jobPie,
            'jobLine' => $jobLine,
            'jobStati' => $jobStati
        ));
    }
}
<?php

namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Ibrows\Bundle\NewsletterBundle\Model\Statistic\StatisticManager as BaseStatisticManager;

class StatisticManager extends BaseStatisticManager
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     */
    protected $readLogRepository;

    /**
     * @var ObjectRepository
     */
    protected $sendLogRepository;

    /**
     * @var ObjectRepository
     */
    protected $unsubscribeLogRepository;

    /**
     * @param ObjectManager $manager
     * @param string $mandantName
     * @param string $readLogClass
     * @param string $sendLogClass
     * @param string $unsubscribeLogClass
     */
    public function __construct(
        ObjectManager $manager,
	    $mandantName,
        $readLogClass, 
        $sendLogClass,
        $unsubscribeLogClass
    )
	{
	    $this->manager = $manager;
		$this->readLogRepository = $manager->getRepository($readLogClass);
		$this->sendLogRepository = $manager->getRepository($sendLogClass);
		$this->unsubscribeLogRepository = $manager->getRepository($unsubscribeLogClass);
		
		parent::__construct(
            $mandantName,
	        $readLogClass, 
	        $sendLogClass,
	        $unsubscribeLogClass
        );
	}

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getUnsubscribeLogs(array $criteria = null, array $orderBy = array(), $limit = null, $offset = null)
	{
	    if ($criteria === null){
	        $criteria = array('mandantName' => $this->mandantName);
	        return $this->unsubscribeLogRepository->findBy($criteria);
	    }
	    
	    $criteria['mandantName'] = $this->mandantName;
	    return $this->unsubscribeLogRepository->findBy($criteria, $orderBy, $limit, $offset);
	}

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getReadLogs(array $criteria = null, array $orderBy = array(), $limit = null, $offset = null)
	{
	     if ($criteria === null){
	        $criteria = array('mandantName' => $this->mandantName);
	        return $this->readLogRepository->findBy($criteria);
	    }

	    $criteria['mandantName'] = $this->mandantName;
	    return $this->readLogRepository->findBy($criteria, $orderBy, $limit, $offset);
	}

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getSendLogs(array $criteria = null, array $orderBy = array(), $limit = null, $offset = null)
	{
	    if ($criteria === null){
	        $criteria = array('mandantName' => $this->mandantName);
	        return $this->sendLogRepository->findBy($criteria);
	    }

	    $criteria['mandantName'] = $this->mandantName;
	    return $this->sendLogRepository->findBy($criteria, $orderBy, $limit, $offset);
	}

    /**
     * @param NewsletterInterface $newsletter
     * @param SubscriberInterface $subscriber
     * @param string $message
     */
    public function addNewsletterReadLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    $log = $this->createNewsletterReadLog($newsletter, $subscriber, $message);
	    $this->manager->persist($log);
	    $this->manager->flush();
	}

    /**
     * @param NewsletterInterface $newsletter
     * @param SubscriberInterface $subscriber
     * @param string $message
     */
    public function addNewsletterSendLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    $log = $this->createNewsletterSendLog($newsletter, $subscriber, $message);
	    $this->manager->persist($log);
	    $this->manager->flush();
	}

    /**
     * @param NewsletterInterface $newsletter
     * @param SubscriberInterface $subscriber
     * @param string $message
     */
    public function addNewsletterUnsubscribeLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    $log = $this->createNewsletterUnsubscribeLog($newsletter, $subscriber, $message);
	    $this->manager->persist($log);
	    $this->manager->flush();
	}
}

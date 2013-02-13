<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Ibrows\Bundle\NewsletterBundle\Model\Statistic\StatisticManager as BaseStatisticManager;

class StatisticManager extends BaseStatisticManager
{
    protected $manager;
	protected $readLogRepository;
	protected $sendLogRepository;
	protected $unsubscribeLogRepository;
	
	public function __construct(
        ObjectManager $manager,
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
	        $readLogClass, 
	        $sendLogClass,
	        $unsubscribeLogClass
        );
	}
	
	public function getUnsubscribeLogs(array $criteria = null, array $orderBy = array(), $limit = null, $offset = null)
	{
	    if ($criteria === null){
	        return $this->unsubscribeLogRepository->findAll();
	    }
	    
	    return $this->unsubscribeLogRepository->findBy($criteria, $orderBy, $limit, $offset);
	}
	
	public function getReadLogs(array $criteria = null, array $orderBy = array(), $limit = null, $offset = null)
	{
	     if ($criteria === null){
	        return $this->readLogRepository->findAll();
	    }
	    
	    return $this->readLogRepository->findBy($criteria, $orderBy, $limit, $offset);
	}
	
	public function getSendLogs(array $criteria = null, array $orderBy = array(), $limit = null, $offset = null)
	{
	    if ($criteria === null){
	        return $this->sendLogRepository->findAll();
	    }
	     
	    return $this->sendLogRepository->findBy($criteria, $orderBy, $limit, $offset);
	}
	
	public function addNewsletterReadLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    $log = $this->createNewsletterReadLog($newsletter, $subscriber, $message);
	    $this->manager->persist($log);
	}
	
	public function addNewsletterSendLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    $log = $this->createNewsletterSendLog($newsletter, $subscriber, $message);
	    $this->manager->persist($log);
	}
	
	public function addNewsletterUnsubscribeLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    $log = $this->createNewsletterUnsubscribeLog($newsletter, $subscriber, $message);
	    $this->manager->persist($log);
	}
}

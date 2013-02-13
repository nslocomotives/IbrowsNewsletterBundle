<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Statistic;

abstract class StatisticManager implements StatisticManagerInterface
{
	protected $readLogClass;
	protected $sendLogClass;
	protected $unsubscribeLogClass;
	
	public function __construct($readLogClass, $sendLogClass, $unsubscribeLogClass)
	{
		$this->readLogClass = $readLogClass;
		$this->sendLogClass = $sendLogClass;
		$this->unsubscribeLogClass = $unsubscribeLogClass;
	}
	
	protected function createNewsletterReadLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    return $this->createNewsletterLog($this->readLogClass, $newsletter, $subscriber, $message);
	}
	
	protected function createNewsletterSendLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    return $this->createNewsletterLog($this->sendLogClass, $newsletter, $subscriber, $message);
	}
	
	protected function createNewsletterUnsubscribeLog(NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    return $this->createNewsletterLog($this->unsubscribeLogClass, $newsletter, $subscriber, $message);
	}
	
	protected function createNewsletterLog($className, NewsletterInterface $newsletter, SubscriberInterface $subscriber, $message)
	{
	    /* @var LogInterface $log */
	    $log = new $className();
	    
	    $log
        	    ->setNewsletterId($newsletter->getId())
        	    ->setSubscriberId($subscriber->getId())
        	    ->setSubscriberEmail($subscriber->getEmail())
        	    ->setMessage($message)
	    ;
	    
	    if($subscriber instanceof SubscriberGenderTitleInterface){
	        $log
        	        ->setSubscriberCompanyname($subscriber->getCompanyname())
        	        ->setSubscriberFirstname($subscriber->getFirstname())
        	        ->setSubscriberGender($subscriber->getGender())
        	        ->setSubscriberLastname($subscriber->getLastname())
        	        ->setSubscriberTitle($subscriber->getTitle())
	        ;
	    }
	    
	    if($subscriber instanceof SubscriberLocaleInterface){
	        $log
	            ->setSubscriberLocale($subscriber->getLocale())
	        ;
	    }
	    
	    return $log;
	}
}

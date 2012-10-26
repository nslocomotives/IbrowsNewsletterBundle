<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Doctrine\Common\Persistence\ObjectRepository;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberManager as BaseSubscriberManager;

class SubscriberManager extends BaseSubscriberManager
{
	protected $repository;
	
	public function __construct(ObjectRepository $repository)
	{
		$this->repository = $repository;
		parent::__construct($repository->getClassName());
	}
	
	public function get($id)
	{
		return $this->repository->find($id);
	}
}

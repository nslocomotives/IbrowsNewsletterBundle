<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Doctrine\Common\Persistence\ObjectRepository;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignManager as BaseDesignManager;

class DesignManager extends BaseDesignManager
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

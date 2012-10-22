<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\DesignManager as BaseDesignManager;

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

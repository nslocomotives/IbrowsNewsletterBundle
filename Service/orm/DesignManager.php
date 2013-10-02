<?php

namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Doctrine\Common\Persistence\ObjectRepository;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignManager as BaseDesignManager;
use Ibrows\Bundle\NewsletterBundle\Model\Design\DesignInterface;

class DesignManager extends BaseDesignManager
{
    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @param ObjectRepository $repository
     */
    public function __construct(ObjectRepository $repository)
	{
		$this->repository = $repository;
		parent::__construct($repository->getClassName());
	}

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return DesignInterface[]
     */
    public function findBy(array $criteria, array $orderBy = array(), $limit = null, $offset = null)
	{
	    return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
	}

    /**
     * @param array $criteria
     * @return DesignInterface
     */
    public function findOneBy(array $criteria)
	{
	    return $this->repository->findOneBy($criteria);
	}

    /**
     * @param int $id
     * @return DesignInterface
     */
    public function get($id)
	{
		return $this->repository->find($id);
	}
}

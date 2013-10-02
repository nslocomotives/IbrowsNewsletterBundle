<?php

namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterManagerInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterManager as BaseNewsletterManager;

class NewsletterManager extends BaseNewsletterManager
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
     * @param int $id
     * @return object
     */
    public function get($id)
	{
		return $this->repository->find($id);
	}

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = array(), $limit = null, $offset = null)
	{
	    return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
	}

    /**
     * @param array $criteria
     * @return object
     */
    public function findOneBy(array $criteria)
	{
	    return $this->repository->findOneBy($criteria);
	}

    /**
     * @param $hash
     * @return object
     */
    public function getByHash($hash)
    {
        return $this->repository->findOneBy(array(
            'hash' => $hash
        ));
    }
}

<?php
namespace Ibrows\Bundle\NewsletterBundle\Service\orm;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterManagerInterface;

use Doctrine\Common\Persistence\ObjectRepository;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterManager as BaseNewsletterManager;

class NewsletterManager extends BaseNewsletterManager
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
    
    public function getByHash($hash)
    {
        return $this->repository->findOneBy(array(
            'hash' => $hash
        ));
    }

}

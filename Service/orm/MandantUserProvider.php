<?php
namespace Ibrows\Bundle\NewsletterBundle\Security\UserProvider;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Doctrine\Common\Persistence\ObjectRepository;

use Symfony\Component\Security\Core\User\UserProviderInterface;

class MandantDoctrineUserProvider implements UserProviderInterface
{
	protected $repository;
	protected $class;
	
	public function __construct(ObjectRepository $repository, $userclass)
	{
		$this->repository = $repository;
		$this->class = $userclass;
	}

	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Security\Core\User.UserProviderInterface::loadUserByUsername()
	 */
	public function loadUserByUsername(string $username)
	{
		$user = $this->repository->findOneBy(array('username' => $username));
		if ($user === null)
			throw new UsernameNotFoundException("The user with username $username does not exist.");
			
		return $user;
	}

	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Security\Core\User.UserProviderInterface::refreshUser()
	 */
	public function refreshUser(UserInterface $user)
	{
		// TODO: Auto-generated method stub

	}

	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Security\Core\User.UserProviderInterface::supportsClass()
	 */
	public function supportsClass(string $class)
	{
		return $class === $this->class;
	}

}

<?php

namespace Ibrows\Bundle\NewsletterBundle\Security\Authentication;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;

use FOS\UserBundle\Model\UserInterface;

use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantManager;
use Ibrows\Bundle\NewsletterBundle\Security\Token\MandantUsernamePasswordToken;

class MandantAuthenticationProvider implements AuthenticationProviderInterface
{
	protected $mandantManager;
	
	public function __construct(MandantManager $mandantManager)
	{
		$this->mandantManager = $mandantManager;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Security\Core\Authentication.AuthenticationManagerInterface::authenticate()
	 */
	public function authenticate(TokenInterface $token)
	{
		$userProvider = $this->mandantManager->getUserProvider($token->getMandant());
		$user = $userProvider->loadUserByUsername($token->getUsername());
		
		$this->checkAuthentication($user, $token);
		
		return new MandantUsernamePasswordToken(
				$user, 
				$token->getCredentials(), 
				$token->getMandant(), 
				$token->getProviderKey(),
				$token->getRoles()
		);
	}

	/**
	 * Does additional checks on the user and token (like validating the
	 * credentials).
	 *
	 * @param UserInterface         $user  The retrieved UserInterface instance
	 * @param UsernamePasswordToken $token The UsernamePasswordToken token to be authenticated
	 *
	 * @throws AuthenticationException if the credentials could not be validated
	 */
	protected function checkAuthentication(UserInterface $user, UsernamePasswordToken $token)
	{
		$currentUser = $token->getUser();
		if ($currentUser instanceof UserInterface) {
			if ($currentUser->getPassword() !== $user->getPassword()) {
				throw new BadCredentialsException('The credentials were changed from another session.');
			}
		} else {
			if ("" === ($presentedPassword = $token->getCredentials())) {
				throw new BadCredentialsException('The presented password cannot be empty.');
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Security\Core\Authentication\Provider.AuthenticationProviderInterface::supports()
	 */
	public function supports(TokenInterface $token)
	{
		return $token instanceof MandantUsernamePasswordToken;
	}

}

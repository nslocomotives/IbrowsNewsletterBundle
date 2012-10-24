<?php

namespace Ibrows\Bundle\NewsletterBundle\Security\Firewall;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Firewall\UsernamePasswordFormAuthenticationListener;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;
use Symfony\Component\Security\Http\HttpUtils;

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

use Ibrows\Bundle\NewsletterBundle\Security\Token\MandantUsernamePasswordToken;

class MandantFormAuthenticationListener extends AbstractAuthenticationListener
{
	protected $csrfProvider;
	
	/**
	 * {@inheritdoc}
	 */
	public function __construct(
			SecurityContextInterface $securityContext, 
			AuthenticationManagerInterface $authenticationManager, 
			SessionAuthenticationStrategyInterface $sessionStrategy, 
			HttpUtils $httpUtils, $providerKey, 
			AuthenticationSuccessHandlerInterface $successHandler, 
			AuthenticationFailureHandlerInterface $failureHandler, 
			array $options = array(), 
			LoggerInterface $logger = null, 
			EventDispatcherInterface $dispatcher = null, 
			CsrfProviderInterface $csrfProvider = null)
	{
		parent::__construct(
				$securityContext, 
				$authenticationManager, 
				$sessionStrategy, 
				$httpUtils, 
				$providerKey, 
				$successHandler, 
				$failureHandler, 
				array_merge(array(
					'username_parameter' => '_username',
					'password_parameter' => '_password',
					'mandant_parameter' => '_mandant',
					'csrf_parameter'     => '_csrf_token',
					'intention'          => 'authenticate',
					'post_only'          => true,
				), $options), 
				$logger, 
				$dispatcher
		);
	
		$this->csrfProvider = $csrfProvider;
	}

	
	/**
	 * {@inheritdoc}
	 */
	public function attemptAuthentication(Request $request)
	{
		if ($this->options['post_only'] && 'post' !== strtolower($request->getMethod())) {
			if (null !== $this->logger) {
				$this->logger->debug(sprintf('Authentication method not supported: %s.', $request->getMethod()));
			}

			return null;
		}

		if (null !== $this->csrfProvider) {
			$csrfToken = $request->get($this->options['csrf_parameter'], null, true);

			if (false === $this->csrfProvider->isCsrfTokenValid($this->options['intention'], $csrfToken)) {
				throw new InvalidCsrfTokenException('Invalid CSRF token.');
			}
		}

		$username = trim($request->get($this->options['username_parameter'], null, true));
		$password = $request->get($this->options['password_parameter'], null, true);
		$mandant = trim($request->get($this->options['mandant_parameter'], null, true));

		$request->getSession()->set(MandantUsernamePasswordToken::LAST_USERNAME, $username);
		$request->getSession()->set(MandantUsernamePasswordToken::LAST_MANDANT, $mandant);
		
		return $this->authenticationManager->authenticate(
				new MandantUsernamePasswordToken($username, $password, $mandant, $this->providerKey)
		);
	}

}

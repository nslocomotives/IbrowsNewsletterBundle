<?php
namespace Ibrows\Bundle\NewsletterBundle\Security\Token;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MandantUsernamePasswordToken extends UsernamePasswordToken
{
	const LAST_USERNAME = SecurityContextInterface::LAST_USERNAME;
	const LAST_MANDANT = '_security.last_mandant';
	
	protected $mandant;
	
	public function __construct($user, $credentials, $mandant, $providerKey, array $roles = array())
	{
		$this->mandant = $mandant;
		
		parent::__construct($user, $credentials, $providerKey, $roles);
	}
	
	public function getMandant()
	{
		return $this->mandant;
	}
	
	public function serialize()
	{
		return serialize(array($this->mandant, parent::serialize()));
	}
	
	public function unserialize($str)
	{
		list($this->mandant, $parentStr) = unserialize($str);
		parent::unserialize($parentStr);
	}
}

<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

interface MandantManagerInterface
{
	/**
	 * 
	 * @param unknown_type $name
	 */
	public function get($name);
	/**
	 * 
	 * @param string $name
	 * @return \Symfony\Component\Security\Core\User\UserProviderInterface
	 */
	public function getUserProvider($name);
}

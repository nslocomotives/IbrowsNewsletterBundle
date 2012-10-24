<?php

namespace Ibrows\Bundle\NewsletterBundle\Security;

use Symfony\Component\DependencyInjection\DefinitionDecorator;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\FormLoginFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class MandantAuthenticationFactory extends FormLoginFactory
{
	
	/**
	 * @param ContainerBuilder $container
	 * @param unknown_type $id
	 * @param unknown_type $config
	 * @param unknown_type $userProviderId
	 * @return string
	 */
	protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId) {
		$providerId = 'security.authentication.provider.newsletter.'.$id;
		$container
				->setDefinition($providerId, new DefinitionDecorator('ibrows_newsletter.security.authentication.provider'))
		;
		
		return $providerId;
	}

	protected function getListenerId()
	{
		return 'ibrows_newsletter.security.authentication.listener';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory.SecurityFactoryInterface::getKey()
	 */
	public function getKey()
	{
		return 'ibrows_newsletter';
	}

	public function addConfiguration(NodeDefinition $builder)
	{
		parent::addConfiguration($builder);
	}

}
